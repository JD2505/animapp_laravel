<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Veterinario - Animapp</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo.jpeg') }}">
    <link rel="stylesheet" href="{{ asset('css/encabezado.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pie.css') }}">
    <link rel="stylesheet" href="{{ asset('css/veter.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header class="top-header">
        <div class="logo-container">
            <a href="{{ route('inicio') }}" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Animapp" class="logo-img">
                <span class="logo-text">Animapp</span>
            </a>
        </div>

        <div class="user-actions" style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('inicio') }}" class="btn-login" style="background-color: #0d6efd;">
                <i class="fa-solid fa-house"></i> Ir al Sitio
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-login" style="background-color: #d33; border: none; cursor: pointer;">
                    <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#resumen" class="active"><i class="fa-solid fa-stethoscope"></i> Resumen Clínico</a></li>
                <li><a href="#vacunacion"><i class="fa-solid fa-syringe"></i> Vacunación</a></li>
                <li><a href="#reportes"><i class="fa-solid fa-file-medical"></i> Crear Reportes</a></li>
                <li><a href="#adopciones"><i class="fa-solid fa-paw"></i> Mascotas Adopción</a></li>
                <li><a href="#productos"><i class="fa-solid fa-store"></i> Productos Tienda</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="dashboard-header" id="resumen">
                <div class="vet-info">
                    <h1>Bienvenido/a, {{ Auth::user()->nombre }}</h1>
                    <p>Módulo médico de vacunación, reportes clínicos, adopciones e inventario — Alfort Animal Care</p>
                </div>
                <div>
                    <span class="badge-status active"><i class="fa-solid fa-user-doctor"></i> Rol: Veterinario</span>
                </div>
            </div>

            <div class="metrics-grid">
                <div class="metric-card">
                    <i class="fa-solid fa-syringe metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $vacunaciones->count() }}</h3>
                        <p>Vacunas Registradas</p>
                    </div>
                </div>
                <div class="metric-card accent">
                    <i class="fa-solid fa-file-medical metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $reportes->count() }}</h3>
                        <p>Reportes Emitidos</p>
                    </div>
                </div>
                <div class="metric-card">
                    <i class="fa-solid fa-paw metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $mascotas->where('estado_adopcion', 'Disponible')->count() }}</h3>
                        <p>Mascotas Disponibles</p>
                    </div>
                </div>
                <div class="metric-card accent">
                    <i class="fa-solid fa-box metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $productos->count() }}</h3>
                        <p>Productos en Tienda</p>
                    </div>
                </div>
            </div>

            @include('dashboards.partials.modulos_operativos')
        </main>
    </div>

    <footer class="pie-completo">
        <div class="pie-container">
            <div class="pie-columna">
                <h3>Nosotros</h3>
                <ul>
                    <li><a href="{{ route('nosotros') }}">¿Quiénes somos?</a></li>
                    <li><a href="{{ route('adopcion') }}">Nuestros aliados</a></li>
                </ul>
            </div>
            <div class="pie-columna">
                <h3>Información</h3>
                <ul>
                    <li><a href="#">Términos y Condiciones del Sitio</a></li>
                    <li><a href="#">Política de privacidad y datos</a></li>
                </ul>
            </div>
            <div class="pie-columna">
                <h3>Contáctanos</h3>
                <div class="contacto-info">
                    <p>Localidad de Engativá, Bogotá D.C.</p>
                    <p>Email: info@alfortanimalcare.com</p>
                </div>
            </div>
        </div>
        <div class="pie-creditos">
            <p>&copy; 2026 Alfort Animal Care - Todos los derechos reservados.</p>
        </div>
    </footer>

    @if(session('success'))
        <script>Swal.fire({ icon: 'success', title: '¡Guardado!', text: "{{ session('success') }}" });</script>
    @endif
</body>
</html>