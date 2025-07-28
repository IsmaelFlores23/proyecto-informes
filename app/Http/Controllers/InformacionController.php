<?php

namespace App\Http\Controllers;

use App\Models\Informacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Revision;
use Illuminate\Support\Facades\Storage;

class InformacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
{
    $alumno = Auth::user();
    $numeroCuenta = $alumno->numero_cuenta;

    // Obtener la terna del alumno (solo la primera que encuentre)
    $terna = $alumno->ternas()->first();

    if (!$terna) {
        // Si no tiene terna asignada, pasar array vacío para no romper la vista
        $docentes = collect();
        $ultimoInforme = null;
    } else {
        // Obtener los docentes de la terna
        $docentes = $terna->users()->whereHas('role', function($query) {
            $query->where('nombre_role', 'docente');
        })->get();

        // Obtener los archivos de informes del alumno en almacenamiento
        $carpeta = 'informes';
        $archivos = collect(Storage::files($carpeta))
            ->filter(fn($archivo) => str_starts_with(basename($archivo), $numeroCuenta . '_'))
            ->sortByDesc(function($archivo) {
                // Ordenar para obtener el archivo más reciente
                $nombre = basename($archivo, '.pdf');
                $partes = explode('_', $nombre);
                return isset($partes[1]) ? (int)$partes[1] : 0;
            })->values();

        $ultimoInforme = $archivos->first();

        // Para cada docente, obtener su última revisión para este archivo
        foreach ($docentes as $docente) {
            $ultimaRevision = Revision::where('id_user', $docente->id)
                ->where('nombre_archivo', basename($ultimoInforme))
                ->orderBy('created_at', 'desc')
                ->first();
            // Adjuntar la revisión al docente para la vista
            $docente->ultimaRevision = $ultimaRevision;
        }
    }

    return view('Alumno.informacion_terna.index', compact('docentes', 'ultimoInforme'));
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