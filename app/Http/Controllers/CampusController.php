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

  
    public function store(Request $request)
    {
       $validated = $request->validate([
        'codigo_campus'=> ['string', 'max:8'],
        'nombre'=> ['string', 'max:100'],
       ]);

       Campus::create($validated);

       return redirect()->route('campus.index')->with('success','Campus agregado correctamente');
    }
    
    public function show(Request $request)
    {
               
    }
}
