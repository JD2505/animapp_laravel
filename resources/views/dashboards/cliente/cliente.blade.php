<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente - Animapp</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo.jpeg') }}">
    <link rel="stylesheet" href="{{ asset('css/encabezado.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pie.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cliente.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                <i class="fa-solid fa-house"></i> Volver al Sitio
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
                <li><a href="#resumen" class="active"><i class="fa-solid fa-house"></i> Inicio Cliente</a></li>
                <li><a href="#proximas-vacunas"><i class="fa-solid fa-syringe"></i> Próximas Vacunas</a></li>
                <li><a href="#adopciones"><i class="fa-solid fa-heart"></i> Visitas de Adopción</a></li>
                <li><a href="#reportes"><i class="fa-solid fa-file-lines"></i> Mis Reportes</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="dashboard-header" id="resumen">
                <div class="client-info">
                    <h1>Bienvenido/a, {{ Auth::user()->nombre }}</h1>
                    <p>Consulta tus alertas de próxima vacuna, visitas de adopción y reportes médicos</p>
                </div>
                <div>
                    <span class="badge-status active"><i class="fa-solid fa-user"></i> Rol: Cliente</span>
                </div>
            </div>

            <div class="metrics-grid">
                <div class="metric-card">
                    <i class="fa-solid fa-syringe metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $vacunas->whereNotNull('proxima_vacuna')->count() }}</h3>
                        <p>Próximas Vacunas</p>
                    </div>
                </div>
                <div class="metric-card accent">
                    <i class="fa-solid fa-hand-holding-heart metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $solicitudes->count() }}</h3>
                        <p>Solicitudes Adopción</p>
                    </div>
                </div>
                <div class="metric-card">
                    <i class="fa-solid fa-file-medical metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $reportes->count() }}</h3>
                        <p>Reportes Recibidos</p>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 1: RECORDATORIOS DE PRÓXIMA VACUNA -->
            <section class="panel-section" id="proximas-vacunas">
                <div class="panel-header-actions">
                    <h2><i class="fa-solid fa-syringe"></i> Esquema y Próximas Vacunas</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mascota</th>
                            <th>Vacuna Aplicada</th>
                            <th>Fecha Aplicación</th>
                            <th>Próxima Vacuna</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vacunas as $v)
                            <tr>
                                <td><strong>{{ $v->nombre_mascota }}</strong></td>
                                <td>{{ $v->vacuna_aplicada }}</td>
                                <td>{{ $v->fecha_aplicacion }}</td>
                                <td>
                                    @if($v->proxima_vacuna)
                                        <span class="badge-status pending"><i class="fa-solid fa-calendar-check"></i> {{ $v->proxima_vacuna }}</span>
                                    @else
                                        <span>Esquema al día</span>
                                    @endif
                                </td>
                                <td>{{ $v->observaciones ?? 'Sin observaciones' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align: center; color: #666;">Aún no tienes recordatorios de vacunación registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <!-- SECCIÓN 2: ESTADO Y PRÓXIMA VISITA DE ADOPCIÓN -->
            <section class="panel-section" id="adopciones">
                <div class="panel-header-actions">
                    <h2><i class="fa-solid fa-heart"></i> Estado de Solicitudes y Próxima Visita de Adopción</h2>
                    <a href="{{ route('adopcion') }}" class="btn-action"><i class="fa-solid fa-magnifying-glass"></i> Ver Mascotas en Adopción</a>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mascota</th>
                            <th>Puntaje Evaluación</th>
                            <th>Resultado</th>
                            <th>Próxima Visita</th>
                            <th>Estado Confirmación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($solicitudes as $s)
                            <tr>
                                <td><strong>{{ $s->mascota->nombre_mascota ?? 'Mascota #' . $s->mascota_id }}</strong></td>
                                <td>{{ $s->puntaje }} / 30 pts</td>
                                <td>{{ $s->resultado_evaluacion }}</td>
                                <td>
                                    @if($s->fecha_visita)
                                        <span class="badge-status active"><i class="fa-solid fa-calendar-day"></i> {{ $s->fecha_visita }}</span>
                                        @if($s->observaciones_visita)
                                            <br><small>{{ $s->observaciones_visita }}</small>
                                        @endif
                                    @else
                                        <span style="color: #777;">Por programar por el administrador</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-status {{ $s->estado_adopcion === 'Aprobada' ? 'active' : ($s->estado_adopcion === 'Rechazada' ? 'low' : 'pending') }}">
                                        {{ $s->estado_adopcion }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align: center; color: #666;">No has enviado solicitudes de adopción todavía.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <!-- SECCIÓN 3: REPORTES Y NOTIFICACIONES -->
            <section class="panel-section" id="reportes">
                <div class="panel-header-actions">
                    <h2><i class="fa-solid fa-file-lines"></i> Reportes y Notificaciones Recibidas</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Título</th>
                            <th>Detalle / Indicaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportes as $r)
                            <tr>
                                <td>{{ $r->created_at ? $r->created_at->format('d/m/Y') : date('d/m/Y') }}</td>
                                <td><span class="badge-status active">{{ $r->tipo_reporte }}</span></td>
                                <td><strong>{{ $r->titulo }}</strong></td>
                                <td>{{ $r->descripcion }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align: center; color: #666;">No tienes reportes pendientes por revisar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
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

</body>
</html>