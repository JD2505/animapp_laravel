<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Producto;
use App\Models\Reporte;
use App\Models\User;
use App\Models\Vacunacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestionController extends Controller
{
    // Vista dashboard Veterinario
    public function dashboardVeterinario()
    {
        $clientes = User::where('rol', 'cliente')->get();
        $vacunaciones = Vacunacion::with('cliente')->orderBy('id', 'desc')->get();
        $reportes = Reporte::with(['cliente', 'autor'])->orderBy('id', 'desc')->get();
        $mascotas = Mascota::orderBy('id', 'desc')->get();
        $productos = Producto::orderBy('id', 'desc')->get();

        return view('dashboards.veterinario.veterinario', compact(
            'clientes', 'vacunaciones', 'reportes', 'mascotas', 'productos'
        ));
    }

    // Vista dashboard Auxiliar
    public function dashboardAuxiliar()
    {
        $clientes = User::where('rol', 'cliente')->get();
        $vacunaciones = Vacunacion::with('cliente')->orderBy('id', 'desc')->get();
        $reportes = Reporte::with(['cliente', 'autor'])->orderBy('id', 'desc')->get();
        $mascotas = Mascota::orderBy('id', 'desc')->get();
        $productos = Producto::orderBy('id', 'desc')->get();

        return view('dashboards.auxiliar.auxiliar', compact(
            'clientes', 'vacunaciones', 'reportes', 'mascotas', 'productos'
        ));
    }

    // 1. Registrar Vacunación
    public function guardarVacunacion(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:usuarios,id',
            'nombre_mascota' => 'required|string|max:100',
            'vacuna_aplicada' => 'required|string|max:150',
            'fecha_aplicacion' => 'required|date',
            'proxima_vacuna' => 'nullable|date|after_or_equal:fecha_aplicacion',
            'observaciones' => 'nullable|string',
        ]);

        Vacunacion::create([
            'cliente_id' => $request->cliente_id,
            'nombre_mascota' => $request->nombre_mascota,
            'vacuna_aplicada' => $request->vacuna_aplicada,
            'fecha_aplicacion' => $request->fecha_aplicacion,
            'proxima_vacuna' => $request->proxima_vacuna,
            'observaciones' => $request->observaciones,
            'registrado_por' => Auth::id(),
        ]);

        return back()->with('success', 'Registro de vacunación guardado y notificado al cliente.');
    }

    // 2. Editar Vacunación
    public function editarVacunacion(Request $request, int $id)
    {
        $request->validate([
            'vacuna_aplicada' => 'required|string|max:150',
            'fecha_aplicacion' => 'required|date',
            'proxima_vacuna' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $vacuna = Vacunacion::findOrFail($id);
        $vacuna->update($request->only([
            'vacuna_aplicada', 'fecha_aplicacion', 'proxima_vacuna', 'observaciones'
        ]));

        return back()->with('success', 'Esquema de vacunación actualizado correctamente.');
    }

    // 3. Crear Reporte
    public function guardarReporte(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:usuarios,id',
            'titulo' => 'required|string|max:150',
            'tipo_reporte' => 'required|string|max:80',
            'descripcion' => 'required|string',
        ]);

        Reporte::create([
            'cliente_id' => $request->cliente_id,
            'titulo' => $request->titulo,
            'tipo_reporte' => $request->tipo_reporte,
            'descripcion' => $request->descripcion,
            'autor_id' => Auth::id(),
        ]);

        return back()->with('success', 'Reporte creado y guardado en la base de datos.');
    }

    // 4. Agregar Mascota en Adopción
    public function guardarMascota(Request $request)
    {
        $request->validate([
            'nombre_mascota' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'raza' => 'required|string|max:80',
            'edad_aproximada' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('img/mascotas'), $nombreArchivo);
            $rutaImagen = 'img/mascotas/' . $nombreArchivo;
        }

        Mascota::create([
            'cliente_id' => null,
            'nombre_mascota' => $request->nombre_mascota,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'edad_aproximada' => $request->edad_aproximada,
            'imagen' => $rutaImagen,
            'descripcion' => $request->descripcion,
            'estado_adopcion' => 'Disponible',
        ]);

        return back()->with('success', 'Mascota agregada al catálogo de adopción.');
    }

    // 5. Agregar Producto a la Tienda
    public function guardarProducto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'categoria' => 'required|string|max:80',
            'precio' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:1',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('img/productos'), $nombreArchivo);
            $rutaImagen = 'img/productos/' . $nombreArchivo;
        }

        Producto::create([
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'imagen' => $rutaImagen,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock_actual' => $request->stock_actual,
            'stock_minimo' => $request->stock_minimo,
        ]);

        return back()->with('success', 'Producto guardado en el inventario de la tienda.');
    }
}