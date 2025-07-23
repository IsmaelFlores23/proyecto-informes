<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DocenteObservacionController extends Controller
{
    public function create(Request $request, $alumno_id = null)
    {
        // Si $alumno_id está presente, cargar información del alumno
        $alumno = null;
        if ($alumno_id) {
            $alumno = User::findOrFail($alumno_id);
        }
        
        return view('Docentes.ObservacionInforme.create', compact('alumno'));
    }

    public function store(Request $request)
    {
        // Aquí implementarás la lógica para guardar la observación
        
        return redirect()->route('docente.alumnos.index')
            ->with('success', 'Observación guardada correctamente');
    }
}
