<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Producto;
use App\Models\Reporte;
use App\Models\SolicitudAdopcion;
use App\Models\User;
use App\Models\Vacunacion;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $pendientesAprobacion = User::where('estado_cuenta', 'pendiente_aprobacion')->count();
        $faltantesInventario = Producto::whereColumn('stock_actual', '<=', 'stock_minimo')->count();
        $totalProductos = Producto::count();
        $mascotasAdopcion = Mascota::where('estado_adopcion', 'Disponible')->count();

        $usuariosPendientes = User::where('estado_cuenta', 'pendiente_aprobacion')->get();
        $listaUsuarios = User::orderBy('id', 'desc')->take(15)->get();
        $clientes = User::where('rol', 'cliente')->get();
        $productosBajos = Producto::whereColumn('stock_actual', '<=', 'stock_minimo')->get();
        $productos = Producto::orderBy('id', 'desc')->get();
        $mascotas = Mascota::orderBy('id', 'desc')->get();
        $vacunaciones = Vacunacion::with('cliente')->orderBy('id', 'desc')->get();
        $reportes = Reporte::with(['cliente', 'autor'])->orderBy('id', 'desc')->get();
        $solicitudesAdopcion = SolicitudAdopcion::with(['cliente', 'mascota'])->orderBy('id', 'desc')->get();

        return view('dashboards.admin.administrador', compact(
            'totalUsuarios', 'pendientesAprobacion', 'faltantesInventario',
            'totalProductos', 'mascotasAdopcion', 'usuariosPendientes',
            'listaUsuarios', 'clientes', 'productosBajos', 'productos',
            'mascotas', 'vacunaciones', 'reportes', 'solicitudesAdopcion'
        ));
    }

    public function cambiarEstado(Request $request, int $id)
    {
        $request->validate([
            'estado' => 'required|in:activo,rechazado',
        ]);

        $usuario = User::findOrFail($id);
        $usuario->estado_cuenta = $request->estado;
        $usuario->save();

        return back()->with('success', 'El estado de la cuenta de ' . $usuario->nombre . ' fue actualizado a ' . $request->estado . '.');
    }
}