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

class GestionarAdminsController extends Controller
{
     public function index()
    {
        // Obtiene admins de BD y los manda a la vista con compact
        $admins = User::where('role', 'admin')->get();
        return view ('Administrador.GestionarAdmins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
       
    }

  
    public function store(Request $request)
    {
        // Validación de datos
       $request->validate([
            'numero_cuenta' => ['required', 'string', 'max:13', 'unique:users,numero_cuenta'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'facultad' => ['required', 'string', 'max:50'],
            'campus' => ['required', 'string', 'max:50'],
        ]);

        // Creación del nuevo admin
        User::create([
            'numero_cuenta' => $request->numero_cuenta,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Forzamos el role a 'docente'
            'facultad' => $request->facultad,
            'campus' => $request->campus,
        ]);

        return redirect()->route('GestionarAdmins.index')->with('success', 'Admin creado exitosamente.');
    }


     public function show(Request $request)
    {

    }


}