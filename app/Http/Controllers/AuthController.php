<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.iniciar_sesion');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required',
        ], [
            'correo.required' => 'Por favor ingresa tu correo electrónico.',
            'correo.email' => 'Ingresa un formato de correo electrónico válido.',
            'password.required' => 'Por favor ingresa tu contraseña.',
        ]);

        $usuario = User::where('correo', $request->correo)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return back()->with('error', 'Correo electrónico o contraseña incorrectos.');
        }

        if ($usuario->estado_cuenta === 'pendiente_aprobacion') {
            return back()->with('error', 'Tu cuenta está en proceso de revisión por el Administrador.');
        }

        if ($usuario->estado_cuenta === 'rechazado') {
            return back()->with('error', 'Tu solicitud de acceso ha sido rechazada.');
        }

        Auth::login($usuario);
        $request->session()->regenerate();

        return $this->redirigirSegunRol($usuario->rol);
    }

    public function showRegister()
    {
        return view('auth.registrarse');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'rol' => 'required|in:cliente,veterinario,auxiliar',
            'soporte_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nombre.required' => 'Por favor ingresa tu nombre completo.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Ingresa un formato de correo electrónico válido.',
            'correo.unique' => 'Este correo electrónico ya está registrado. Intenta iniciar sesión.',
            'password.required' => 'Debes crear una contraseña.',
            'password.min' => 'La contraseña es muy corta: debe tener mínimo 8 caracteres.',
            'password.mixed' => 'La contraseña debe combinar letras mayúsculas y minúsculas.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
            'password.symbols' => 'La contraseña debe incluir al menos un símbolo especial (ej. @, #, $, *, !).',
            'soporte_doc.mimes' => 'El soporte profesional debe ser un archivo PDF o imagen (JPG, PNG).',
            'soporte_doc.max' => 'El archivo de soporte no puede pesar más de 5 MB.',
        ]);

        $estadoCuenta = 'activo';
        $rutaSoporte = null;

        if (in_array($request->rol, ['veterinario', 'auxiliar'])) {
            $estadoCuenta = 'pendiente_aprobacion';

            if (!$request->hasFile('soporte_doc')) {
                return back()->with('error', 'Debes adjuntar tu credencial o soporte profesional en PDF o Imagen.');
            }

            $rutaSoporte = $request->file('soporte_doc')->store('soportes', 'public');
        }

        User::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'archivo_soporte' => $rutaSoporte,
            'estado_cuenta' => $estadoCuenta,
        ]);

        if ($estadoCuenta === 'pendiente_aprobacion') {
            return redirect()->route('login')->with('info', 'Registro completado. Tu cuenta requiere aprobación del Administrador antes de ingresar.');
        }

        return redirect()->route('login')->with('success', '¡Registro exitoso! Tu cuenta ha sido creada. Ya puedes iniciar sesión.');
    }

    public function miPerfil()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return $this->redirigirSegunRol(Auth::user()->rol);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }

    private function redirigirSegunRol(string $rol)
    {
        return match ($rol) {
            'admin' => redirect()->route('dashboard.admin'),
            'veterinario' => redirect()->route('dashboard.veterinario'),
            'auxiliar' => redirect()->route('dashboard.auxiliar'),
            'cliente' => redirect()->route('dashboard.cliente'),
            default => redirect()->route('inicio'),
        };
    }
}