<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\SolicitudAdopcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdopcionController extends Controller
{
    public function solicitar(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para solicitar una adopción.');
        }

        $request->validate([
            'mascota_id' => 'nullable|integer',
            'nombre_mascota' => 'required|string|max:100',
            'documento_identidad' => 'required|string|max:30',
            'telefono_contacto' => 'required|string|max:30',
            // 4 Requisitos Básicos Excluyentes
            'req_documento' => 'required|in:Si,No',
            'req_domicilio' => 'required|in:Si,No',
            'req_visita' => 'required|in:Si,No',
            'req_contrato' => 'required|in:Si,No',
            // 6 Categorías de la Matriz (1 a 5 pts cada una = 30 pts)
            'c1_entorno' => 'required|integer|min:1|max:5',
            'c2_familia' => 'required|integer|min:1|max:5',
            'c3_tiempo' => 'required|integer|min:1|max:5',
            'c4_economica' => 'required|integer|min:1|max:5',
            'c5_experiencia' => 'required|integer|min:1|max:5',
            'c6_otras_mascotas' => 'required|integer|min:1|max:5',
        ]);

        // Si viene de una mascota de referencia sin ID aún en BD, la creamos o buscamos
        $mascotaId =$request->mascota_id;
        if (empty($mascotaId)) {$mascota = Mascota::firstOrCreate(
                ['nombre_mascota' => $request->nombre_mascota],
                [
                    'especie' => 'Mascota',
                    'raza' => 'Mestizo',
                    'edad_aproximada' => 'No especificada',
                    'estado_adopcion' => 'Disponible',
                ]
            );
            $mascotaId =$mascota->id;
        }

        $existe = SolicitudAdopcion::where('cliente_id', Auth::id())
            ->where('mascota_id', $mascotaId)
            ->whereIn('estado_adopcion', ['Pendiente', 'Aprobada'])
            ->exists();

        if ($existe) {
            return back()->with('info', 'Ya tienes una solicitud registrada para ' . $request->nombre_mascota . '.');
        }

        $cumpleBasicos = ($request->req_documento === 'Si')
            && ($request->req_domicilio === 'Si')
            && ($request->req_visita === 'Si')
            && ($request->req_contrato === 'Si');

        $puntaje = (int)$request->c1_entorno
                 + (int) $request->c2_familia
                 + (int) $request->c3_tiempo
                 + (int) $request->c4_economica
                 + (int) $request->c5_experiencia
                 + (int) $request->c6_otras_mascotas;

        if (!$cumpleBasicos || $puntaje < 18) {$resultado = 'NO APROBADO';
        } elseif ($puntaje >= 25) {$resultado = 'APROBADO';
        } else {
            $resultado = 'APROBADO CON CONDICIONES';
        }

        $detalle = "Doc: {$request->documento_identidad} \vert{} Tel: {$request->telefono_contacto} | "
                 . "Requisitos Básicos: " . ($cumpleBasicos ? 'Cumple 4/4' : 'Incumple requisito excluyente') . " || "
                 . "1.Entorno: {$request->c1_entorno}/5, 2.Familia: {$request->c2_familia}/5, "
                 . "3.Tiempo: {$request->c3_tiempo}/5, 4.Económica: {$request->c4_economica}/5, "
                 . "5.Experiencia: {$request->c5_experiencia}/5, 6.Otras Mascotas: {$request->c6_otras_mascotas}/5";

        SolicitudAdopcion::create([
            'cliente_id' => Auth::id(),
            'mascota_id' => $mascotaId,
            'puntaje' => $puntaje,
            'resultado_evaluacion' => $resultado,
            'respuestas_detalle' => $detalle,
            'estado_adopcion' => 'Pendiente',
        ]);

        Mascota::where('id', $mascotaId)->update(['estado_adopcion' => 'En Proceso']);

        return back()->with('success', "Evaluación registrada: {$puntaje}/30 puntos — Dictamen preliminar: {$resultado}. El administrador programará tu visita de verificación.");
    }

    public function resolverSolicitud(Request $request, int$id)
    {
        $request->validate([
            'decision' => 'required|in:Aprobada,Rechazada',
            'fecha_visita' => 'nullable|date',
            'observaciones_visita' => 'nullable|string|max:255',
        ]);

        $solicitud = SolicitudAdopcion::findOrFail($id);
        $solicitud->estado_adopcion =$request->decision;
        $solicitud->fecha_visita =$request->fecha_visita;
        $solicitud->observaciones_visita =$request->observaciones_visita;
        $solicitud->encargado_visita_id = Auth::id();$solicitud->save();

        if ($request->decision === 'Aprobada') {
            Mascota::where('id', $solicitud->mascota_id)->update([
                'estado_adopcion' => 'Adoptado',
                'cliente_id' => $solicitud->cliente_id,
            ]);
        } else {
            Mascota::where('id', $solicitud->mascota_id)->update([
                'estado_adopcion' => 'Disponible',
            ]);
        }

        return back()->with('success', "La solicitud de adopción fue marcada como {$request->decision}.");
    }
}