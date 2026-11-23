<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdopcionController;
use App\Http\Controllers\GestionController;
use App\Models\Vacunacion;
use App\Models\SolicitudAdopcion;
use App\Models\Reporte;
use App\Http\Controllers\CitaController;

// En la sección de RUTAS PÚBLICAS:
Route::get('/citas', [PublicController::class, 'citas'])->name('citas');
Route::get('/guarderia', [PublicController::class, 'guarderia'])->name('guarderia');
Route::post('/citas/agendar', [CitaController::class, 'agendar'])->name('citas.agendar');

// --- RUTAS PÚBLICAS ---
Route::get('/', [PublicController::class, 'index'])->name('inicio');
Route::get('/nosotros', [PublicController::class, 'nosotros'])->name('nosotros');
Route::get('/salud', [PublicController::class, 'salud'])->name('salud');
Route::get('/estetica', [PublicController::class, 'estetica'])->name('estetica');
Route::get('/guarderia', [PublicController::class, 'guarderia'])->name('guarderia');
Route::get('/vacunacion', [PublicController::class, 'vacunacion'])->name('vacunacion');
Route::get('/citas', [PublicController::class, 'citas'])->name('citas');
Route::get('/adopcion', [PublicController::class, 'adopcion'])->name('adopcion');
Route::post('/adopcion/solicitar', [AdopcionController::class, 'solicitar'])->name('adopcion.solicitar');
Route::get('/tienda', [PublicController::class, 'tienda'])->name('tienda');
Route::get('/carrito', [PublicController::class, 'carrito'])->name('carrito');

// --- AUTENTICACIÓN ---
Route::get('/iniciar-sesion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/iniciar-sesion', [AuthController::class, 'login'])->name('login.post');
Route::get('/registrarse', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registrarse', [AuthController::class, 'register'])->name('register.post');
Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('logout');
Route::get('/mi-perfil', [AuthController::class, 'miPerfil'])->name('mi.perfil');

// --- OPERACIONES COMPARTIDAS (ADMIN, VETERINARIO Y AUXILIAR) ---
Route::middleware(['rol:admin,veterinario,auxiliar'])->prefix('gestion')->group(function () {
    Route::post('/vacunacion', [GestionController::class, 'guardarVacunacion'])->name('gestion.vacunacion.store');
    Route::put('/vacunacion/{id}', [GestionController::class, 'editarVacunacion'])->name('gestion.vacunacion.update');
    Route::post('/reportes', [GestionController::class, 'guardarReporte'])->name('gestion.reportes.store');
    Route::post('/mascotas', [GestionController::class, 'guardarMascota'])->name('gestion.mascotas.store');
    Route::post('/productos', [GestionController::class, 'guardarProducto'])->name('gestion.productos.store');
});

// --- DASHBOARD ADMINISTRADOR ---
Route::middleware(['rol:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::post('/usuarios/{id}/estado', [AdminController::class, 'cambiarEstado'])->name('admin.usuario.estado');
    Route::post('/adopciones/{id}/resolver', [AdopcionController::class, 'resolverSolicitud'])->name('admin.adopcion.resolver');
});

// --- DASHBOARD VETERINARIO ---
Route::middleware(['rol:veterinario'])->prefix('veterinario')->group(function () {
    Route::get('/dashboard', [GestionController::class, 'dashboardVeterinario'])->name('dashboard.veterinario');
});

// --- DASHBOARD AUXILIAR ---
Route::middleware(['rol:auxiliar'])->prefix('auxiliar')->group(function () {
    Route::get('/dashboard', [GestionController::class, 'dashboardAuxiliar'])->name('dashboard.auxiliar');
});

// --- DASHBOARD CLIENTE (Solo reportes, próxima vacuna y próxima visita de adopción) ---
Route::middleware(['rol:cliente'])->prefix('cliente')->group(function () {
    Route::get('/dashboard', function () {
        $vacunas = Vacunacion::where('cliente_id', Auth::id())->orderBy('proxima_vacuna', 'asc')->get();
        $solicitudes = SolicitudAdopcion::with('mascota')->where('cliente_id', Auth::id())->orderBy('id', 'desc')->get();
        $reportes = Reporte::where('cliente_id', Auth::id())->orderBy('id', 'desc')->get();
        return view('dashboards.cliente.cliente', compact('vacunas', 'solicitudes', 'reportes'));
    })->name('dashboard.cliente');
});