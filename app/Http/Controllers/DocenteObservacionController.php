<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Informe;
use App\Models\Revision;
use App\Models\Terna;
use App\Mail\CorreccionMail;
use App\Mail\InformeAprobadoMail;

class DocenteObservacionController extends Controller
{
    public function create(Request $request, $alumno_id = null)
    {
        $alumno = null;
        $pdfNombre = null;
        $revisiones = null;
        $revisionesPorVersion = null;
        $docenteYaAprobo = false;
        
        if ($alumno_id) {
            $alumno = User::findOrFail($alumno_id);
            $numero_cuenta = $alumno->numero_cuenta;
            
            // Obtener el último archivo del alumno
            $carpeta = 'informes';
            $archivosAlumno = collect(Storage::files($carpeta))
                ->filter(fn($file) => str_starts_with(basename($file), $numero_cuenta . '_'))
                ->sortByDesc(function($file) {
                    $nombre = basename($file, '.pdf');
                    $partes = explode('_', $nombre);
                    return isset($partes[1]) ? (int)$partes[1] : 0;
                })
                ->values();
            
            $pdfNombre = $archivosAlumno->first() ? basename($archivosAlumno->first()) : null;
            
            // Verificar si el docente ya ha aprobado este informe
            if ($pdfNombre) {
                $docenteYaAprobo = Revision::where('id_user', Auth::id())
                    ->where('nombre_archivo', $pdfNombre)
                    ->where('estado_revision', 'Aprobado')
                    ->exists();
            }
            
            // Obtener TODAS las revisiones del alumno
            $todasRevisiones = Revision::with('user')
                ->where('nombre_archivo', 'like', $numero_cuenta . '_%')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // 1. Revisiones para el archivo actual (para la sección de comentarios)
            $revisiones = $todasRevisiones->where('nombre_archivo', $pdfNombre);
            
            // 2. Agrupación por versión para el historial
            $revisionesPorVersion = $todasRevisiones->groupBy('nombre_archivo')->map(function($revisionesGrupo) {
                return [
                    'nombre_archivo' => $revisionesGrupo->first()->nombre_archivo,
                    'revisiones' => $revisionesGrupo,
                    'version' => $this->extraerVersion($revisionesGrupo->first()->nombre_archivo)
                ];
            })->sortByDesc('version');
        }
        
        return view('Docentes.ObservacionInforme.create', compact(
            'alumno',
            'pdfNombre',
            'revisiones',          // Para la sección de comentarios actuales
            'revisionesPorVersion',  // Para el historial por versión
            'docenteYaAprobo'      // Para deshabilitar los botones si ya aprobó
        ));
    }

    private function extraerVersion($nombreArchivo)
    {
        $partes = explode('_', $nombreArchivo);
        return isset($partes[1]) ? (int)str_replace('.pdf', '', $partes[1]) : 0;
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'alumno_id' => 'required|exists:users,id',
            'comentario' => 'required|string',
            'numero_pagina' => 'required|integer|min:1',
            'estado_revision' => 'required|in:Pendiente de Aprobación,Aprobado',
            'nombre_archivo' => 'required|string',
        ]);
        
        // Crear una nueva revisión
        $revision = new Revision([
            'id_user' => Auth::id(), // ID del docente que hace el comentario
            'comentario' => $request->comentario,
            'numero_pagina' => $request->numero_pagina,
            'estado_revision' => $request->estado_revision,
            'nombre_archivo' => $request->nombre_archivo, // Guardamos el nombre del archivo para relacionarlo
        ]);
        
        $revision->save();
        
        // Obtener información del alumno y docente
        $alumno = User::findOrFail($request->alumno_id);
        $docente = Auth::user();
        
        // Enviar correo de notificación al alumno sobre la corrección
        Mail::to($alumno->email)->queue(new CorreccionMail($alumno, $docente, $revision, $request->nombre_archivo));
        
        // Verificar si todos los docentes han aprobado el informe
        if ($request->estado_revision === 'Aprobado') {
            $this->verificarAprobacionCompleta($alumno, $request->nombre_archivo);
        }
        
        // Verificar si es una petición AJAX
        if ($request->ajax() || $request->wantsJson()) {
            // Cargar la relación user para poder acceder a ella en el frontend
            $revision->load('user');
            
            return response()->json([
                'success' => true,
                'message' => 'Comentario guardado correctamente y notificación enviada al alumno',
                'revision' => $revision
            ]);
        }
        
        // Para solicitudes tradicionales (no AJAX), redirigir con mensaje de éxito
        if ($request->estado_revision === 'Aprobado') {
            return redirect()->route('docente.observacion.create', ['alumno_id' => $request->alumno_id])
                ->with('success', 'Informe aprobado correctamente y notificación enviada al alumno');
        }
        
        // Respuesta normal para peticiones no-AJAX (por si acaso)
        return redirect()->route('docente.observacion.create', ['alumno_id' => $request->alumno_id])
            ->with('success', 'Comentario guardado correctamente y notificación enviada al alumno');
    }
    
    /**
     * Verifica si todos los docentes han aprobado el informe y envía notificación al alumno
     */
    private function verificarAprobacionCompleta(User $alumno, string $nombreArchivo)
    {
        // Obtener la terna del alumno
        $terna = $alumno->ternas()->first();
        
        if (!$terna) {
            return; // El alumno no tiene terna asignada
        }
        
        // Obtener todos los docentes de la terna
        $docentes = User::whereHas('role', function ($query) {
            $query->where('nombre_role', 'docente');
        })->whereHas('ternas', function ($query) use ($terna) {
            $query->where('terna.id', $terna->id);
        })->get();
        
        // Verificar si todos los docentes han aprobado el informe
        $todosAprobaron = true;
        
        foreach ($docentes as $docente) {
            // Buscar la última revisión de este docente para este archivo
            $ultimaRevision = Revision::where('id_user', $docente->id)
                ->where('nombre_archivo', $nombreArchivo)
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Si algún docente no ha aprobado o no ha revisado, no se cumple la condición
            if (!$ultimaRevision || $ultimaRevision->estado_revision !== 'Aprobado') {
                $todosAprobaron = false;
                break;
            }
        }
        
        // Si todos los docentes han aprobado, enviar correo al alumno
        if ($todosAprobaron) {
            // Buscar o crear el registro del informe
            $informe = Informe::firstOrCreate(
                ['nombre_archivo' => $nombreArchivo],
                ['id_terna' => $terna->id, 'descripcion' => 'Informe aprobado por todos los docentes']
            );
            
            // Enviar correo de notificación al alumno
            Mail::to($alumno->email)->queue(new InformeAprobadoMail($alumno, $informe, $docentes));
        }
    }
    
    public function verPdf($nombreArchivo)
    {
        // Verificar que el archivo exista en la carpeta informes
        $path = storage_path('app/informes/' . $nombreArchivo);
        
        // Si no existe en la primera ubicación, verificar en la carpeta private/informes
        if (!file_exists($path)) {
            $path = storage_path('app/private/informes/' . $nombreArchivo);
        }

        // Verificar que el archivo exista
        if (!file_exists($path)) {
            abort(404, 'Archivo no encontrado');
        }

        // Retornar el archivo para mostrarlo en el navegador
        return response()->file($path);
    }
}
