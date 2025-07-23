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
        // Si $alumno_id está presente, cargar información del alumno
        $alumno = null;
        $ultimoPdf = null;
        $pdfNombre = null;
        $revisiones = null;
        
        if ($alumno_id) {
            $alumno = User::findOrFail($alumno_id);
            
            // Obtener el número de cuenta del alumno
            $numero_cuenta = $alumno->numero_cuenta;
            
            // Buscar el informe más reciente del alumno
            $carpeta = 'informes';
            
            $archivosAlumno = collect(Storage::files($carpeta))
                ->filter(fn($file) => str_starts_with(basename($file), $numero_cuenta . '_'))
                ->sortByDesc(function($file) {
                    $nombre = basename($file, '.pdf');
                    $partes = explode('_', $nombre);
                    return isset($partes[1]) ? (int)$partes[1] : 0;
                })
                ->values();
            
            $ultimoPdf = $archivosAlumno->first();
            $pdfNombre = $ultimoPdf ? basename($ultimoPdf) : null;
            
            // Obtener todas las revisiones hechas por docentes
            // Filtramos por el nombre del archivo PDF que estamos viendo
            // Esto asegura que solo veamos comentarios relacionados con este informe
            $revisiones = Revision::with('user')
                ->whereHas('user', function($query) {
                    $query->where('id_role', function($subquery) {
                        $subquery->select('id')
                               ->from('roles')
                               ->where('nombre_role', 'docente');
                    });
                })
                ->where('nombre_archivo', $pdfNombre)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('Docentes.ObservacionInforme.create', compact('alumno', 'ultimoPdf', 'pdfNombre', 'revisiones'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'alumno_id' => 'required|exists:users,id',
            'comentario' => 'required|string',
            'numero_pagina' => 'required|integer|min:1',
            'estado_revision' => 'required|in:Informe Cargado,Pendiente de Aprobación,Aprobado',
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
