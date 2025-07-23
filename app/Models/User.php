<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'numero_cuenta',
        'telefono',
        'email',
        'password',
        'id_role',
        'id_campus',
        'id_facultad',
        /*'nombre_facultad',
        'nombre_campus',*/
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Métodos helper para verificar roles
    public function isAdmin()
    {
        return $this->role()->first()->nombre_role === 'admin';
    }

    public function isDocente()
    {
        return $this->role()->first()->nombre_role === 'docente';
    }

    public function isAlumno()
    {
        return $this->role()->first()->nombre_role === 'alumno';
    }
    
    // Relaciones con otros modelos
    
    /**
     * Obtiene el rol del usuario.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    
    /**
     * Obtiene el campus del usuario.
     */
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'id_campus');
    }
    
    /**
     * Obtiene la facultad del usuario.
     */
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }
    
    /**
     * Obtiene las revisiones realizadas por el usuario.
     */
    public function revisiones()
    {
        return $this->hasMany(Revision::class, 'id_user');
    }
    
    /**
     * Obtiene las ternas a las que pertenece el usuario.
     */
    public function ternas()
    {
        return $this->belongsToMany(Terna::class, 'user_terna_transitiva', 'id_user', 'id_terna');
    }
}
