<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    //

    protected $table = 'historial';
    protected $fillable = [
        'fecha_actualizada',
        'id_informe',
    ];
}
