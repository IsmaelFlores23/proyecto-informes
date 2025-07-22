<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Terna;

class DocenteAlumnosController extends Controller
{
    public function index()
    {
        // Por ahora solo mostraremos la vista sin implementar la funcionalidad
        return view('Docentes.Alumnos.index');
    }
}
