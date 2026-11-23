<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'mascota_id',
        'fecha_cita',
        'tipo_servicio',
        'estado',
    ];
}