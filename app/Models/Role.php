<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'nombre_role'
    ];
    
    /**
     * Obtiene los usuarios que tienen este rol.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
}