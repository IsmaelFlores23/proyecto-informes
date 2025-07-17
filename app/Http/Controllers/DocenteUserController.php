<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class DocenteUserController extends Controller
{
     public function index()
    {
        // return view ('Administrador.VerDocentes.show');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
       
    }

  
    public function store(Request $request)
    {
       
    }
    
     public function show($id)
    {
        // Cambiamos la consulta para usar la relación con roles
        $docente = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'docente');
        })->findOrFail($id);
        
        // Aquí agregar lógica para obtener ternas asignadas
        return view('Administrador.VerDocentes.show', compact('docente'));
    }
}
