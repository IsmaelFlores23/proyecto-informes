<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Informe;
use App\Models\Revision;

class DocenteObservacionController extends Controller
{
    public function create(Request $request, $alumno_id = null)
    {
        $alumno = null;
        $pdfNombre = null;
        $revisiones = null;
        $revisionesPorVersion = null;
        
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
            'revisionesPorVersion'  // Para el historial por versión
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
        
        return redirect()->route('docente.observacion.create', ['alumno_id' => $request->alumno_id])
            ->with('success', 'Comentario guardado correctamente');
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
