<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    /** @use HasFactory<\Database\Factories\InformeFactory> */
    use HasFactory;

    protected $table = 'informes';
    protected $fillable = [
        'id_terna',
        'nombre_archivo',
        'descripcion',

    ];

    public function terna()
    {
        return $this->belongsTo(User::class, 'id_terna');
    }
    
}
