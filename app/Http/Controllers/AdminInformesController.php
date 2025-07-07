<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class AdminInformesController extends Controller
{
    public function index()
    {
                return view ('Administrador.VerInformes.index');
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
        // Validar los datos enviados por el formulario
       
    }


        public function verTodosLosInformes($numero_cuenta)
    {
        $carpeta = 'informes';

        // Obtener todos los archivos que empiezan con el número de cuenta
        $archivos = collect(Storage::disk('local')->files($carpeta))
            ->filter(fn($archivo) => str_starts_with(basename($archivo), $numero_cuenta . '_'))
            ->sortBy(function($archivo) {
                $nombre = basename($archivo, '.pdf');
                $partes = explode('_', $nombre);
                return isset($partes[1]) ? (int)$partes[1] : 0;
            })
            ->values();

        return view('Administrador/VerInformes.index', [
            'numero_cuenta' => $numero_cuenta,
            'archivos' => $archivos,
        ]);
    }
    /**
     * Display the specified resource.
     */
    // public function show(Informe $informe)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Informe $informe)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Informe $informe)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Informe $informe)
    // {
    //     //
    // }
}
