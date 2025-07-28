<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Campus;
use App\Models\Facultad;
use App\Mail\TernaAsignadaMail;

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
        // Obtenemos el campus del administrador autenticado
        $adminCampus = Auth::user()->id_campus;
        
        $usuariosEnTernas = DB::table('user_terna_transitiva')->pluck('id_user')->toArray();

        // Obtener usuarios con role 'alumno' del mismo campus que el administrador
        $alumnos = User::whereHas('role', function ($query) {
            $query->where('nombre_role', 'alumno');
        })
        ->whereNotIn('id', $usuariosEnTernas)
        ->where('id_campus', $adminCampus)
        ->get();
        
        // Obtener solo usuarios con role 'docente' del mismo campus que el administrador
        $docentes = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'docente');
        })
        ->where('id_campus', $adminCampus)
        ->get();
    
        // Obtener todas las ternas existentes con sus usuarios
        // Primero obtenemos los IDs de los usuarios en ternas que pertenecen al campus del admin
        $usuariosCampus = User::where('id_campus', $adminCampus)->pluck('id')->toArray();
        
        // Luego obtenemos las ternas que tienen al menos un usuario del campus del admin
        $ternasIds = DB::table('user_terna_transitiva')
            ->whereIn('id_user', $usuariosCampus)
            ->pluck('id_terna')
            ->unique()
            ->toArray();
            
        $ternas = \App\Models\Terna::whereIn('id', $ternasIds)->get();
    
        // Obtener los campus y las facultades
        $campus = Campus::all();
        $facultades = Facultad::all();

        // enviar datos a la vista
        return view ('Administrador.AsignarTerna.create', compact('alumnos', 'docentes', 'ternas', 'campus', 'facultades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados por el formulario
        $request->validate([
            'estudiante' => 'required|exists:users,id',
            'docente1' => 'required|exists:users,id',
            'docente2' => 'required|exists:users,id',
            'docente3' => 'required|exists:users,id',
            'docente4' => 'nullable|exists:users,id',
        ]);
        
        // Crear una nueva terna
        $terna = \App\Models\Terna::create([
            'estado_terna' => 'Pendiente'
        ]);
        
        // Asignar el estudiante a la terna
        \App\Models\UserTernaTransitiva::create([
            'id_user' => $request->estudiante,
            'id_terna' => $terna->id
        ]);
        
        // Asignar los docentes a la terna
        \App\Models\UserTernaTransitiva::create([
            'id_user' => $request->docente1,
            'id_terna' => $terna->id
        ]);
        
        \App\Models\UserTernaTransitiva::create([
            'id_user' => $request->docente2,
            'id_terna' => $terna->id
        ]);
        
        \App\Models\UserTernaTransitiva::create([
            'id_user' => $request->docente3,
            'id_terna' => $terna->id
        ]);
        
        // Asignar el docente opcional si se proporcionó
        if ($request->docente4) {
            \App\Models\UserTernaTransitiva::create([
                'id_user' => $request->docente4,
                'id_terna' => $terna->id
            ]);
        }
        
        // Obtener los usuarios para enviar correos
        $estudiante = User::find($request->estudiante);
        $docentes = User::whereIn('id', [
            $request->docente1,
            $request->docente2,
            $request->docente3,
            $request->docente4
        ])->when($request->docente4 === null, function($query) {
            $query->whereNotNull('id');
        })->get();
        
        // Preparar datos para los correos
        $miembrosEstudiante = [
            'docentes' => $docentes
        ];
        
        $miembrosDocente = [
            'estudiante' => $estudiante,
            'docentes' => $docentes
        ];
        
        // Enviar correo al estudiante
        Mail::to($estudiante->email)
            ->queue(new TernaAsignadaMail($estudiante, $terna, true, $miembrosEstudiante));
        
        // Enviar correos a los docentes
        foreach ($docentes as $docente) {
            Mail::to($docente->email)
                ->queue(new TernaAsignadaMail($docente, $terna, false, $miembrosDocente));
        }
        
        return redirect()->route('AsignarTerna.create')
            ->with('success', 'Terna asignada correctamente y notificaciones enviadas.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $terna = \App\Models\Terna::findOrFail($id);
        
        // Eliminar primero los informes asociados a esta terna
        \App\Models\Informe::where('id_terna', $id)->delete();
        
        // Eliminar las relaciones en la tabla pivote
        \App\Models\UserTernaTransitiva::where('id_terna', $id)->delete();
        
        // Eliminar la terna
        $terna->delete();
        
        return redirect()->route('AsignarTerna.create')
            ->with('success', 'Terna eliminada correctamente.');
    }

    public function update(Request $request, $id)
{
    // Solo validamos docentes, el estudiante no se edita
    $request->validate([
        'docente1' => 'required|exists:users,id',
        'docente2' => 'required|exists:users,id',
        'docente3' => 'required|exists:users,id',
        'docente4' => 'nullable|exists:users,id',
    ]);

    $terna = \App\Models\Terna::findOrFail($id);

    // Eliminar solo los docentes asociados, conservamos el estudiante
    $docentes = User::whereHas('role', function ($query) {
        $query->where('nombre_role', 'docente');
    })->pluck('id')->toArray();

    // Eliminar solo relaciones con usuarios que son docentes
    \App\Models\UserTernaTransitiva::where('id_terna', $id)
        ->whereIn('id_user', $docentes)
        ->delete();

    // Reasignar los docentes
    \App\Models\UserTernaTransitiva::create([
        'id_user' => $request->docente1,
        'id_terna' => $terna->id
    ]);

    \App\Models\UserTernaTransitiva::create([
        'id_user' => $request->docente2,
        'id_terna' => $terna->id
    ]);

    \App\Models\UserTernaTransitiva::create([
        'id_user' => $request->docente3,
        'id_terna' => $terna->id
    ]);

    if ($request->docente4) {
        \App\Models\UserTernaTransitiva::create([
            'id_user' => $request->docente4,
            'id_terna' => $terna->id
        ]);
    }

    return redirect()->route('AsignarTerna.create')
        ->with('success', 'Terna actualizada correctamente.');
}



}
