<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $table = 'historias_clinicas';
    public $timestamps = false;

    protected $fillable = [
        'cita_id', 'mascota_id', 'veterinario_id', 'diagnostico', 'tratamiento', 'vacunas_aplicadas', 'estado_historia'
    ];
}