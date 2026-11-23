<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacunacion extends Model
{
    protected $table = 'vacunaciones';

    protected $fillable = [
        'cliente_id', 'nombre_mascota', 'vacuna_aplicada',
        'fecha_aplicacion', 'proxima_vacuna', 'observaciones', 'registrado_por'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}