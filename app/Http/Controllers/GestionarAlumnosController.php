<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class GestionarAlumnosController extends Controller
{
     public function index()
    {
        
        $alumnos = User::where('role', 'alumno')->get();
        // Devuelve la vista con los datos de los docentes
        return view ('Administrador.GestionarAlumnos.index', compact('alumnos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
       
    }

  
    public function store(Request $request)
    {
         $request->validate([
            'numero_cuenta' => ['required', 'string', 'max:13', 'unique:users,numero_cuenta'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'facultad' => ['required', 'string', 'max:50'],
            'campus' => ['required', 'string', 'max:50'],
        ]);

        User::create([
            'numero_cuenta' => $request->numero_cuenta,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumno', // Forzamos el role a 'docente'
            'facultad' => $request->facultad,
            'campus' => $request->campus,
        ]);

        return redirect()->route('GestionarAlumnos.index')->with('success', 'Docente creado exitosamente.');
    }

     public function show(Request $request)
    {
        
    }

    public function destroy($id)
    {
        $Gestionaralumno = User::findOrFail($id);
        $Gestionaralumno->delete();
        return redirect()->route('GestionarAlumnos.index')->with('success', 'Docente eliminado correctamente');
    }

    
}