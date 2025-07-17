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
use App\Models\Role;
use App\Models\Campus;
use App\Models\Facultad;

class GestionarAlumnosController extends Controller
{
     public function index()
    {
        // Cambiamos la consulta para usar la relación con roles
        $alumnos = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'alumno');
        })->get();
        
        // Cargamos los campus y facultades para los selectores
        $campus = Campus::all();
        $facultades = Facultad::all();
        
        // Devuelve la vista con los datos de los alumnos, campus y facultades
        return view ('Administrador.GestionarAlumnos.index', compact('alumnos', 'campus', 'facultades'));
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
            'id_facultad' => ['required', 'exists:facultad,id'],
            'id_campus' => ['required', 'exists:campus,id'],
        ]);

        // Buscar el ID del rol alumno
        $role = Role::where('nombre_role', 'alumno')->first();
        
        if (!$role) {
            return redirect()->back()->with('error', 'El rol de alumno no existe en el sistema.');
        }

        User::create([
            'numero_cuenta' => $request->numero_cuenta,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $role->id,
            'id_facultad' => $request->id_facultad,
            'id_campus' => $request->id_campus,
        ]);

        return redirect()->route('GestionarAlumnos.index')->with('success', 'Alumno creado exitosamente.');
    }

     public function show(Request $request)
    {
        
    }

    public function destroy($id)
    {
        $Gestionaralumno = User::findOrFail($id);
        $Gestionaralumno->delete();
        return redirect()->route('GestionarAlumnos.index')->with('success', 'Alumno eliminado correctamente');
    }

    
}