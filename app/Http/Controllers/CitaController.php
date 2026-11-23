<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function agendar(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Inicia sesión o regístrate para confirmar tu cita en Animapp.');
        }

        $request->validate([
            'servicio' => 'required|string|max:100',
            'nombre_mascota' => 'required|string|max:100',
            'tipo_mascota' => 'required|string|max:50',
            'especificar_mascota' => 'nullable|string|max:50',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => ['required', 'date_format:H:i', 'after_or_equal:08:00', 'before_or_equal:18:00'],
        ], [
            'servicio.required' => 'Selecciona un servicio para la cita.',
            'nombre_mascota.required' => 'Ingresa el nombre de tu mascota.',
            'fecha.required' => 'Selecciona la fecha deseada.',
            'fecha.after_or_equal' => 'La fecha de la cita no puede ser anterior a hoy.',
            'hora.required' => 'Selecciona la hora preferida.',
            'hora.after_or_equal' => 'El horario de atención inicia a las 08:00 a.m.',
            'hora.before_or_equal' => 'El horario de atención finaliza a las 06:00 p.m.',
        ]);

        $especieFinal = $request->tipo_mascota === 'otro'
            ? ($request->especificar_mascota ?: 'Otro')
            : $request->tipo_mascota;

        $mascota = Mascota::firstOrCreate(
            [
                'cliente_id' => Auth::id(),
                'nombre_mascota' => $request->nombre_mascota,
            ],
            [
                'especie' => $especieFinal,
                'raza' => 'Mestizo',
                'edad_aproximada' => 'No especificada',
                'estado_adopcion' => 'Adoptado',
            ]
        );

        Cita::create([
            'cliente_id' => Auth::id(),
            'mascota_id' => $mascota->id,
            'fecha_cita' => $request->fecha . ' ' . $request->hora . ':00',
            'tipo_servicio' => $request->servicio,
            'estado' => 'Pendiente',
        ]);

        return back()->with('success', '¡Cita agendada con éxito para ' . $mascota->nombre_mascota . ' (' . $request->servicio . ') el ' . $request->fecha . ' a las ' . $request->hora . '!');
    }
}