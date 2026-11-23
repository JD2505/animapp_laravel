<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'rol',
        'archivo_soporte',
        'estado_cuenta',
    ];

    protected $hidden = [
        'password',
    ];
}
