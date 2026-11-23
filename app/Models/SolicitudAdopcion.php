<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudAdopcion extends Model
{
    protected $table = 'solicitudes_adopcion';
    public $timestamps = false;

    protected $fillable = [
        'cliente_id', 'mascota_id', 'puntaje', 'resultado_evaluacion',
        'respuestas_detalle', 'estado_adopcion', 'fecha_visita',
        'encargado_visita_id', 'observaciones_visita'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }
}