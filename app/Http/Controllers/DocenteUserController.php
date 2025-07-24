<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Revision;

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
        
        // Obtener todas las ternas a las que pertenece el docente
        $ternas = $docente->ternas()->with(['users' => function($query) {
            // Cargar los usuarios con sus roles para poder filtrarlos después
            $query->with('role');
        }])->get();
        
        // Obtener la última revisión realizada por el docente
        $ultimaRevision = Revision::where('id_user', $docente->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        return view('Administrador.VerDocentes.show', compact('docente', 'ternas', 'ultimaRevision'));
    }
}
