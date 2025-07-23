<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    /** @use HasFactory<\Database\Factories\RevisionFactory> */
    use HasFactory;

    protected $table = 'revisiones';
    protected $fillable = [
        'id_user',
        'comentario',
        'numero_pagina',
        'estado_revision',
        'nombre_archivo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
