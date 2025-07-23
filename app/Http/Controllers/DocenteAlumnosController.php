<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Terna;
use App\Models\Role;
use App\Models\Revision;

class DocenteAlumnosController extends Controller
{
    public function index()
    {
        // Obtener el docente autenticado
        $docente = Auth::user();

        // obtener las terna a las que pertenece el docente
        $ternas = $docente->ternas;

        //obtener los alumnos de esas ternas
        $alumnos = collect();

        foreach ($ternas as $terna) {
            // Obtener usuarios con rol 'alumno' de esta terna
            $alumnosTerna = $terna->users()
                ->whereHas('role', function($query) {
                    $query->where('nombre_role', 'alumno');
                })
                ->with(['facultad', 'campus']) // Eager loading para evitar consultas N+1
                ->get();

            // Eliminar duplicados si un alumno está en múltiples ternas
            $alumnosTerna = $alumnosTerna->unique('id');
            
            $alumnos = $alumnos->concat($alumnosTerna);
        }

        // Por ahora solo mostraremos la vista sin implementar la funcionalidad
        return view('Docentes.Alumnos.index', compact('alumnos'));
    }
    
    public function show($id)
    {
        // Verificar que el alumno pertenece a una terna del docente autenticado
        $docente = Auth::user();
        $ternas = $docente->ternas;
        
        // Buscar el alumno
        $alumno = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'alumno');
        })->findOrFail($id);
        
        // Verificar que el alumno pertenece a alguna terna del docente
        $alumnoEnTerna = false;
        $ternaAlumno = null;
        $docentes = [];
        
        foreach ($ternas as $terna) {
            if ($terna->users()->where('users.id', $alumno->id)->exists()) {
                $alumnoEnTerna = true;
                $ternaAlumno = $terna;
                
                // Obtener los docentes asociados a la terna
                $docentes = $terna->users()->whereHas('role', function($query) {
                    $query->where('nombre_role', 'docente');
                })->get();
                
                break;
            }
        }
        
        if (!$alumnoEnTerna) {
            return redirect()->route('docente.alumnos.index')
                ->with('error', 'No tienes acceso a este alumno');
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
        
        // Obtener el estado de aprobación de cada docente para el último informe
        $estadosAprobacion = [];
        if ($nombreArchivo) {
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
        }
        
        // Verificar si todos los docentes han aprobado el informe
        $todosAprobaron = false;
        if (!empty($estadosAprobacion)) {
            $todosAprobaron = collect($estadosAprobacion)->every(function ($item) {
                return $item['estado'] === 'Aprobado';
            });
        }
        
        return view('Docentes.Alumnos.show', compact(
            'alumno', 
            'ternaAlumno', 
            'docentes', 
            'ultimoInforme', 
            'estadosAprobacion',
            'todosAprobaron'
        ));
    }
}
