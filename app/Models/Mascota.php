<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $table = 'mascotas';
    public $timestamps = false;

    protected $fillable = [
        'cliente_id', 'nombre_mascota', 'especie', 'raza',
        'edad_aproximada', 'imagen', 'descripcion', 'estado_adopcion'
    ];
}