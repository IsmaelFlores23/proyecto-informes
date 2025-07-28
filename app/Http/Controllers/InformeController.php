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
        // Validar los datos enviados por el formulario
        $request->validate([
            'ruta_informe' => 'required|file|mimes:pdf|max:50048', // Solo PDFs de hasta 50MB
            'descripcion' => 'required|string|max:1000',
        ], [
            'ruta_informe.mimes' => 'El archivo debe ser un PDF.',
            'ruta_informe.max' => 'El archivo no debe exceder los 50MB.',
            'descripcion.required' => 'La descripción es obligatoria.',
        ]);

        // Obtener numero de cuenta del usuario autenticado
        $numero_cuenta = Auth::user()->numero_cuenta;
    
        // Obtener la terna del usuario actual (alumno)
        $terna = Auth::user()->ternas()->first();
    
        if (!$terna) {
            return redirect()->route('subirInforme.create')
                ->with('error', 'No tienes una terna asignada. Contacta al administrador.');
        }
        
        // Define Carpeta de destino para guardar el archivo
        $carpeta = 'informes';
        
        // Buscar todos los archivos ya subidos en esa carpeta
        $archivos = Storage::files($carpeta);
        
        // Inicializar número de versión del archivo
        $version = 1;
        $archivoAnterior = null;
        
        // Contar cuántos archivos anteriores ha subido este estudiante
        foreach ($archivos as $archivo) {
            if (str_starts_with(basename($archivo), $numero_cuenta . '_')) {
                // Guardar el archivo anterior para eliminarlo después
                $archivoAnterior = $archivo;
                
                // Extraer la versión del nombre del archivo
                $nombreActual = basename($archivo, '.pdf');
                $partesNombre = explode('_', $nombreActual);
                if (isset($partesNombre[1])) {
                    $version = (int)$partesNombre[1] + 1;
                }
            }
        }
        
        // Construir nombre del archivo
        $nombreArchivo = $numero_cuenta . '_' . $version . '.pdf';
        
        // Si existe un archivo anterior, eliminarlo
        if ($archivoAnterior) {
            Storage::delete($archivoAnterior);
        }
        
        // Guardar el archivo en la carpeta definida con el nombre generado
        $ruta = $request->file('ruta_informe')->storeAs($carpeta, $nombreArchivo);
        
        // Buscar si ya existe un informe para esta terna
        $informeExistente = Informe::where('id_terna', $terna->id)->first();
        
        if ($informeExistente) {
            // Actualizar el informe existente
            $informeExistente->update([
                'nombre_archivo' => $nombreArchivo,
                'descripcion' => $request->input('descripcion')
            ]);
        } else {
            // Crear un nuevo informe
            Informe::create([
                'id_terna' => $terna->id,
                'nombre_archivo' => $nombreArchivo,
                'descripcion' => $request->input('descripcion')
            ]);
        }
        
        // Obtener el alumno actual
        $alumno = Auth::user();
        
        // Obtener los docentes asignados a la terna del alumno
        $docentes = $terna->users()->whereHas('role', function($query) {
            $query->where('nombre_role', 'docente');
        })->get();
        
        // Enviar correo a cada docente asignado
        foreach ($docentes as $docente) {
            \Illuminate\Support\Facades\Mail::to($docente->email)
                ->queue(new \App\Mail\InformeSubidoMail(
                    $alumno, 
                    $docente, 
                    $nombreArchivo, 
                    $request->input('descripcion')
                ));
        }
        
        // Redirigir al formulario con un mensaje de éxito
        return redirect()->route('observarInforme.index')
            ->with('success', 'Informe subido correctamente (Versión ' . $version . ').');
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
