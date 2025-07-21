<?php

namespace App\Http\Controllers;

use App\Models\Informacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener el usuario alumno autenticado
        $alumno = Auth::user();
        
        // Obtener la terna del alumno
        $terna = $alumno->ternas()->first(); // Usa la relacion que ya habiamos definiddo en el modelo
        
        if ($terna) {
            // Obtener los docentes de esta terna
            $docentes = $terna->users()->whereHas('role', function($query) {
                $query->where('nombre_role', 'docente');
            })->get();
        } else {
            $docentes = collect(); // Colección vacía si no hay terna, por ende no asigna nada
        }
        
        return view('Alumno.informacion_terna.index', compact('docentes'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Informacion $informacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Informacion $informacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informacion $informacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informacion $informacion)
    {
        //
    }
}