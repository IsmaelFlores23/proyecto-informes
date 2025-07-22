<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteHistorialController extends Controller
{
    public function index()
    {
        // Por ahora solo mostraremos la vista sin implementar la funcionalidad
        return view('Docentes.Historial.index');
    }
}
