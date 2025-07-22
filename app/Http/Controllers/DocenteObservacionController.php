<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteObservacionController extends Controller
{
    public function create()
    {
        // Por ahora solo mostraremos la vista sin implementar la funcionalidad
        return view('Docentes.ObservacionInforme.create');
    }

    public function store(Request $request)
    {
        // Aquí se implementará la lógica para guardar la observación
        // Por ahora solo redireccionamos a la vista de alumnos
        return redirect()->route('docente.alumnos.index')->with('success', 'Observación guardada correctamente');
    }
}
