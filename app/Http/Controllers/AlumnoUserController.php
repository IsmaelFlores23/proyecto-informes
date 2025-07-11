<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

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
        $alumno = User::where('role', 'alumno')->findOrFail($id);
        // Aquí agregar lógica para obtener terna, informes, etc.
        return view('Administrador.VerAlumnos.show', compact('alumno'));
    }


}
