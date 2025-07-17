<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terna extends Model
{
    //
    protected $table = 'terna';
    protected $fillable = [
        'estado_terna'
    ];
    
    /**
     * Obtiene los usuarios que pertenecen a esta terna.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_terna_transitiva', 'id_terna', 'id_user');
    }
}
