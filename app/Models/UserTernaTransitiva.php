<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTernaTransitiva extends Model
{
    //
    use HasFactory;

    protected $table = 'user_terna_transitiva';
    protected $fillable = [
        'id_user',
        'id_terna',

    ];
}
