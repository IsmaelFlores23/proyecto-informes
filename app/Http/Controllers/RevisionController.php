<?php

namespace App\Http\Controllers;

use App\Models\Revision;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RevisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        //
        $numero_cuenta = Auth::user()->numero_cuenta;
        $carpeta = 'informes'; // según tu storage

        $archivosUsuario = collect(Storage::files($carpeta))
            ->filter(fn($file) => str_starts_with(basename($file), $numero_cuenta . '_'))
            ->sortByDesc(function($file) {
                $nombre = basename($file, '.pdf');
                $partes = explode('_', $nombre);
                return isset($partes[1]) ? (int)$partes[1] : 0;
            })
            ->values();

        $ultimoPdf = $archivosUsuario->first();
        $pdfNombre = $ultimoPdf ? basename($ultimoPdf) : null;

        $estadoInforme = null;
    
        // Obtener todas las revisiones hechas por docentes para este informe
        $revisiones = null;
        if ($pdfNombre) {
            $revisiones = Revision::with('user')
                ->whereHas('user', function($query) {
                    $query->where('id_role', function($subquery) {
                        $subquery->select('id')
                               ->from('roles')
                               ->where('nombre_role', 'docente');
                    });
                })
                ->where('nombre_archivo', $pdfNombre)
                ->orderBy('created_at', 'desc')
                ->get();
        }
       
        $totalAprobados = 0;
        $tieneComentarios = false;
        
        if ($revisiones) {
            $totalAprobados = $revisiones->where('estado_revision', 'Aprobado')->count();
            $totalDocentes = 3; // ajusta si son más o menos

            // Saber si hay al menos un comentario no vacío
            $tieneComentarios = $revisiones->whereNotNull('comentario')->where('comentario', '!=', '')->count() > 0;

            // Calcular estado final:
            if ($totalAprobados == $totalDocentes) {
                $estadoInforme = 'aprobado';
            } elseif ($tieneComentarios) {
                $estadoInforme = 'pendiente';
            } else {
                $estadoInforme = 'corregido';
            }
        }
            
    

        return view('Alumno.observar_informe.index', [
        'ultimoPdf' => $ultimoPdf ? Storage::url($ultimoPdf) : null,
        'pdfNombre' => $pdfNombre,
        'revisiones' => $revisiones,
        'estadoInforme' => $estadoInforme,
        ]);
    }


    public function verPdf($nombreArchivo)
    {
        $numero_cuenta = Auth::user()->numero_cuenta;

        // Validar que el archivo realmente pertenece al usuario
        if (!str_starts_with($nombreArchivo, $numero_cuenta . '_')) {
            abort(403, 'No autorizado');
        }

        // Ruta correcta al archivo (ya no hay doble 'private')
        $path = storage_path('app/private/informes/' . $nombreArchivo);

        // Verificar que el archivo exista
        if (!file_exists($path)) {
            abort(404, 'Archivo no encontrado');
        }

        // Retornar el archivo para mostrarlo en el navegador
        return response()->file($path);
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
    public function show(Revision $revision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revision $revision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Revision $revision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revision $revision)
    {
        //
    }
}
