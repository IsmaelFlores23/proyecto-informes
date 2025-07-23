<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Hash;
use App\Models\User;


class GestionarUsuariosController extends Controller
{
    public function index()
    {
        // Trae todos los registros de la tabla 'users'
        $usuarios = User::all(); 
        return view('Administrador.GestionarUsuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados por el formulario

        // Validacion de datos ingresados por formulario de AGREGAR USUARIOS
        $request->validate([
            'numero_cuenta' => ['required','string','max:13'],
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email',
            'telefono' => ['required', 'string', 'max:13'],
            'password' => 'required|string|min:6',
            'role' => ['required', 'string', 'max:12'],
            'facultad' => ['required', 'string', 'max:50'],
            'campus' => ['required', 'string', 'max:50'],
        ]);

        // Buscar el ID del rol seleccionado
        $role = \App\Models\Role::where('nombre_role', $request->role)->first();
        
        if (!$role) {
            return redirect()->back()->with('error', 'El rol seleccionado no existe.');
        }

        //TABLA USERS
        User::create([
            'numero_cuenta' => $request->numero_cuenta,
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'id_role' => $role->id,
            'id_campus' => $request->campus,
            'id_facultad' => $request->facultad,
        ]);

        return redirect()->route('GestionarUsuarios.index')->with('success', 'Usuario creado correctamente.');
    }



}
