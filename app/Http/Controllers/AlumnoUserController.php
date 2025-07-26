<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Revision;

class AlumnoUserController extends Controller
{
     public function index()
    {
        // return view ('Administrador.VerAlumnos.show');
    }

   
    public function create()
    {
       
       
    }

    public function store(Request $request)
    {
       
    }

    public function show($id)
    {
        // Cambiamos la consulta para usar la relación con roles
        $alumno = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'alumno');
        })->findOrFail($id);
        
        // Obtener la terna del alumno
        $terna = $alumno->ternas()->first();
        
        // Obtener los docentes asociados a la terna si existe
        $docentes = [];
        if ($terna) {
            $docentes = $terna->users()->whereHas('role', function($query) {
                $query->where('nombre_role', 'docente');
            })->get();
        }
        
        // Buscar el informe del alumno
        $carpeta = 'informes';
        $numero_cuenta = $alumno->numero_cuenta;
        
        // Obtener todos los archivos que empiezan con el número de cuenta del alumno
        $archivos = collect(Storage::files($carpeta))
            ->filter(fn($archivo) => str_starts_with(basename($archivo), $numero_cuenta . '_'))
            ->sortByDesc(function($archivo) {
                $nombre = basename($archivo, '.pdf');
                $partes = explode('_', $nombre);
                return isset($partes[1]) ? (int)$partes[1] : 0;
            })
            ->values();
        
        // Obtener el último informe subido (el más reciente)
        $ultimoInforme = $archivos->first();
        $nombreArchivo = $ultimoInforme ? basename($ultimoInforme) : null;
        
        // Obtener la fecha del último informe desde la base de datos
        $fechaUltimoInforme = null;
        if ($terna && $ultimoInforme) {
            $informe = \App\Models\Informe::where('id_terna', $terna->id)
                ->where('nombre_archivo', basename($ultimoInforme))
                ->first();
            
            if ($informe) {
                $fechaUltimoInforme = $informe->created_at;
            }
        }
        
        // Obtener el estado de aprobación de cada docente para el último informe
        $estadosAprobacion = [];
        $todosAprobaron = false;
        
        if ($nombreArchivo && !empty($docentes)) {
            foreach ($docentes as $docente) {
                // Buscar la última revisión de este docente para este archivo
                $ultimaRevision = Revision::where('id_user', $docente->id)
                    ->where('nombre_archivo', $nombreArchivo)
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                $estadosAprobacion[$docente->id] = [
                    'docente' => $docente,
                    'estado' => $ultimaRevision ? $ultimaRevision->estado_revision : 'Sin revisión',
                    'fecha' => $ultimaRevision ? $ultimaRevision->created_at : null
                ];
            }
            
            // Verificar si todos los docentes han aprobado el informe
            if (!empty($estadosAprobacion)) {
                $todosAprobaron = collect($estadosAprobacion)->every(function ($item) {
                    return $item['estado'] === 'Aprobado';
                });
            }
        }
        
        return view('Administrador.VerAlumnos.show', compact(
            'alumno', 
            'terna', 
            'docentes', 
            'ultimoInforme', 
            'fechaUltimoInforme',
            'estadosAprobacion',
            'todosAprobaron'
        ));
    }

    /**
     * Muestra el PDF del informe para administradores
     */
    public function verPdfAdmin($nombreArchivo)
    {
        // Verificar primero en la carpeta informes
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
