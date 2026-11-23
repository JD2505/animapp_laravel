<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Producto;

class PublicController extends Controller
{
    public function index()
    {
        return view('public.index');
    }

    public function nosotros()
    {
        return view('public.nosotros');
    }

    public function salud()
    {
        return view('public.salud');
    }

    public function estetica()
    {
        return view('public.estetica');
    }

    public function guarderia()
    {
        return view('public.guarderia');
    }

    public function vacunacion()
    {
        return view('public.vacunacion');
    }

    public function citas()
    {
        return view('public.citas');
    }

    public function adopcion()
    {
        $mascotas = Mascota::where('estado_adopcion', 'Disponible')->get();
        return view('public.adopcion', compact('mascotas'));
    }

    public function tienda()
    {
        $productos = Producto::where('stock_actual', '>', 0)->get();
        return view('public.tienda', compact('productos'));
    }

    public function carrito()
    {
        return view('public.carrito');
    }
}