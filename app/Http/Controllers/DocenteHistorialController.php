<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DocenteHistorialController extends Controller
{
    public function index(Request $request, $alumno_id = null)
    {
        // Aquí implementarás la lógica para mostrar el historial de revisiones
        // Si $alumno_id está presente, filtrar por ese alumno específico
        
        return view('Docentes.Historial.index', ['alumno_id' => $alumno_id]);
    }
}
