<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class InformeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view ('Alumno.subir_informe.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //   // Validar entrada
        $request->validate([
            'ruta_informe' => 'required|file|mimes:pdf|max:50048', // Solo PDFs de hasta 2MB
            'descripcion' => 'required|string|max:1000',
        ]);

        // Obtener numero de cuenta del usuario autenticado
        // $numero_cuenta = Auth()->User()->numero_cuenta;
        $numero_cuenta = Auth::user()->numero_cuenta;

        //Obtener ID del usuario autenticado
        $user_id = Auth::id();

        // Carpeta de destino
        $carpeta = 'private/informes';

        // Buscar archivos ya existentes para esa cédula
        $archivos = Storage::files($carpeta);
        $version = 1;

        foreach ($archivos as $archivo) {
            if (str_starts_with(basename($archivo), $numero_cuenta . '_')) {
                $version++;
            }
        }

        // Construir nombre del archivo
        $nombreArchivo = $numero_cuenta . '_' . $version . '.pdf';

        // Guardar archivo
        $ruta = $request->file('ruta_informe')->storeAs($carpeta, $nombreArchivo);

        // Guardar en la base de datos
        Informe::create([
            'fk_estudiante' => $user_id,
            'ruta_informe' => $ruta,
            'descripcion' => $request->input('descripcion')
        ]);

        return redirect()->route('subirInforme.create')->with('success', 'Informe subido correctamente.');



    }

    /**
     * Display the specified resource.
     */
    public function show(Informe $informe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Informe $informe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informe $informe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informe $informe)
    {
        //
    }
}
