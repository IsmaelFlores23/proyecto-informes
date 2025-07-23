<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Terna;
use App\Models\Role;

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
}
