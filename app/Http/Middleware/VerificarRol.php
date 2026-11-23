<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        $usuario = Auth::user();

        if ($usuario->estado_cuenta !== 'activo') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Tu cuenta no está activa o está pendiente de aprobación.');
        }

        if (!in_array($usuario->rol, $roles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}