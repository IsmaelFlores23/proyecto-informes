<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Informe;

class DocenteObservacionController extends Controller
{
    public function create(Request $request, $alumno_id = null)
    {
        // Si $alumno_id está presente, cargar información del alumno
        $alumno = null;
        $ultimoPdf = null;
        $pdfNombre = null;
        
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
        }
        
        return view('Docentes.ObservacionInforme.create', compact('alumno', 'ultimoPdf', 'pdfNombre'));
    }

    public function store(Request $request)
    {
        // Aquí implementarás la lógica para guardar la observación
        
        return redirect()->route('docente.alumnos.index')
            ->with('success', 'Observación guardada correctamente');
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
