<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    /** @use HasFactory<\Database\Factories\InformeFactory> */
    use HasFactory;

    protected $fillable = [
        'fk_estudiante',
        'ruta_informe',
        'descripcion',
        'fecha_informe',
        'estado'

    ];
    
}
