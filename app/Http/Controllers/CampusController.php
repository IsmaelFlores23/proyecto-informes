<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Campus;

class CampusController extends Controller
{
     public function index()
    {
      $campuses = Campus::all();
      return view ('Administrador.Campus.index', compact('campuses'));
    }

   
    public function create()
    {
       
       
    }

    public function edit(Campus $campus)
    {
      $campuses = Campus::all();
      return view('Administrador.Campus.index', compact('campuses'))->with('editando', $campus);
    }

    public function update(Request $request, Campus $campus)
    {
      $validated = $request->validate([
        'nombre' => ['required', 'string', 'max:100'],
    ]);

    $campus->update($validated);

    return redirect()->route('campus.index')->with('success', 'Campus actualizado correctamente');
    }

  
    public function store(Request $request)
    {
       $validated = $request->validate([
        'nombre'=> ['required', 'string', 'max:100'],
       ]);

       Campus::create($validated);

       return redirect()->route('campus.index')->with('success','Campus agregado correctamente');
    }
    
    public function show(Request $request)
    {
               
    }

    public function destroy(Campus $campus)
    {
        $campus->delete();
        return redirect()->route('campus.index')->with('success', 'Campus eliminado correctamente');
    }
}
