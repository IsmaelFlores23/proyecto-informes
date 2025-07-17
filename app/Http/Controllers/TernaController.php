<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class TernaController extends Controller
{
     public function index()
    {
        // $alumnos = User::where('role', 'alumno')->get();
        // $docentes = User::where('role', 'docente')->get();
        //         return view ('Administrador.AsignarTerna.create', compact('alumnos', 'docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //obtener usuarios con role 'alumno'
        // $alumnos = User::where('role', 'alumno')->get();
        $alumnos = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'alumno');
        })->get();

        // Obtener solo usuarios con role 'docente'
        // $docentes = User::where('role', 'docente')->get();
        $docentes = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'docente');
        })->get();

        // enviar datos a la vista
        return view ('Administrador.AsignarTerna.create', compact('alumnos', 'docentes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados por el formulario
       
    }

   
}
