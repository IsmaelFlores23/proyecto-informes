<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Revision;
use Illuminate\Support\Facades\Storage;

class DocenteHistorialController extends Controller
{
    public function index(Request $request, $alumno_id = null)
    {
        // Si no hay alumno_id, redirigir a la lista de alumnos
        if (!$alumno_id) {
            return redirect()->route('docente.alumnos.index');
        }
        
        // Obtener información del alumno
        $alumno = User::findOrFail($alumno_id);
        $numero_cuenta = $alumno->numero_cuenta;
        
        // Obtener todos los nombres de archivos que comienzan con el número de cuenta
        // para buscar revisiones relacionadas
        $carpeta = 'informes';
        $archivos = collect(Storage::files($carpeta))
            ->filter(fn($archivo) => str_starts_with(basename($archivo), $numero_cuenta . '_'))
            ->map(fn($archivo) => basename($archivo))
            ->toArray();
        
        // Buscar todas las revisiones que tengan nombres de archivo que comiencen con el número de cuenta
        $revisiones = Revision::with('user')
            ->where(function($query) use ($numero_cuenta) {
                $query->whereRaw("nombre_archivo LIKE '{$numero_cuenta}_%'");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Agrupar revisiones por nombre de archivo para mostrar a qué versión pertenecen
        $revisionesPorArchivo = $revisiones->groupBy('nombre_archivo');
        
        return view('Docentes.Historial.index', [
            'alumno' => $alumno,
            'revisionesPorArchivo' => $revisionesPorArchivo
        ]);
    }
}
