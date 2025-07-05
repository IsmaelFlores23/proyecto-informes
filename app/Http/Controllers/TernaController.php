<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TernaController extends Controller
{
     public function index()
    {
                return view ('Administrador.AsignarTerna.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view ('Administrador.AsignarTerna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados por el formulario
       
    }

   
}
