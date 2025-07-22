<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Facultad;

class FacultadController extends Controller
{
     public function index()
    {
      $facultades = Facultad::all();
      return view ('Administrador.Facultades.index', compact('facultades'));
    }

   
    public function create()
    {
       
       
    }

    public function edit(Facultad $facultad)
    {
      $facultades = Facultad::all();
      return view('Administrador.Facultades.index', compact('facultades'))->with('editando', $facultad);
    }

    public function update(Request $request, Facultad $facultad)
    {
      $validated = $request->validate([
        'nombre' => ['required', 'string', 'max:100'],
        'codigo_facultad' => ['required', 'string', 'max:100'],
    ]);

    $facultad->update($validated);

    return redirect()->route('facultad.index')->with('success', 'Facultad actualizada correctamente');
    }
  
    public function store(Request $request)
    {
      $validated = $request->validate([
        'nombre'=> ['required', 'string', 'max:100'],
        'codigo_facultad' => ['required', 'string', 'max:100'],
       ]);

       Facultad::create($validated);

       return redirect()->route('facultad.index')->with('success','Facultad agregada correctamente');
    }

     public function show(Request $request)
    {
               
    }

     public function destroy(Facultad $facultad)
    {
        $facultad->delete();
        return redirect()->route('facultad.index')->with('success', 'Facultad eliminada correctamente');
    }

}
