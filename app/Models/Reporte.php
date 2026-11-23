<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';

    protected $fillable = [
        'cliente_id', 'titulo', 'tipo_reporte', 'descripcion', 'autor_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }
}