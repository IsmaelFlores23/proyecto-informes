<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Role;
use App\Models\Campus;
use App\Models\Facultad;
use App\Mail\CredencialesMail;

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
            'telefono' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
            'id_facultad' => ['required', 'exists:facultad,id'],
            'id_campus' => ['required', 'exists:campus,id'],
        ]);

        // Buscar el ID del rol alumno
        $role = Role::where('nombre_role', 'alumno')->first();
        
        if (!$role) {
            return redirect()->back()->with('error', 'El rol de alumno no existe en el sistema.');
        }

        //Guardar Contrasena en texto plano para enviar por correo
        $passwordPlano = $request->password;

        $user = User::create([
            'numero_cuenta' => $request->numero_cuenta,
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'pais_telefono' => $request->pais_telefono,
            'password' => Hash::make($request->password),
            'id_role' => $role->id,
            'id_facultad' => $request->id_facultad,
            'id_campus' => $request->id_campus,
        ]);

        //Enviar correo
        //Enviar correo de forma asíncrona
        Mail::to($user->email)->queue(new CredencialesMail($user->name, $user->numero_cuenta, $passwordPlano, $user->email));

        return redirect()->route('AsignarTerna.create')->with('success', 'Alumno creado exitosamente.');
    }

    public function edit($id)
    {
        $editando = User::findOrFail($id);
        $alumnos = User::whereHas('role', function ($query){
            $query->where('nombre_role', 'alumno');
        })->get();

        $facultades = Facultad::all();
        $campus = Campus::all();
        $abrirModalEdicion = true;

        return view('Administrador.GestionarAlumnos.index', compact('editando', 'alumnos', 'facultades','campus', 'abrirModalEdicion'));
    }


    public function update(Request $request, $id)
    {
        $alumno = User::findOrFail($id);

        $request->validate([
            'numero_cuenta' => ['required', 'string', 'max:13', 'unique:users,numero_cuenta,' . $id],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'telefono' => ['required', 'string', 'max:20'],
            'id_facultad' => ['required', 'exists:facultad,id'],
            'id_campus' => ['required', 'exists:campus,id'],
        ]);

        $alumno->numero_cuenta = $request->numero_cuenta;
        $alumno->name = $request->name;
        $alumno->email = $request->email;
        $alumno->telefono = $request->telefono;
        $alumno->pais_telefono = $request->pais_telefono;


        // Actualiza la contraseña solo si se llenó el campo
    if ($request->filled('password')) {
        $alumno->password = Hash::make($request->password);
    }

    $alumno->id_facultad = $request->id_facultad;
    $alumno->id_campus = $request->id_campus;
    $alumno->save();

    return redirect()->route('GestionarAlumnos.index')->with('success', 'Alumno actualizado exitosamente.');
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