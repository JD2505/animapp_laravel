<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Animapp</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo.jpeg') }}">
    <link rel="stylesheet" href="{{ asset('css/encabezado.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pie.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- BARRA SUPERIOR -->
    <header class="top-header">
        <div class="logo-container">
            <a href="{{ route('inicio') }}" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Animapp" class="logo-img">
                <span class="logo-text">Animapp</span>
            </a>
        </div>

        <div class="search-container">
            <input type="text" placeholder="Buscar usuarios, productos o registros..." class="search-input">
            <button class="search-btn">Buscar</button>
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

    <!-- LAYOUT DEL DASHBOARD -->
    <div class="dashboard-container">
        
        <!-- BARRA LATERAL -->
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#resumen" class="active"><i class="fa-solid fa-chart-pie"></i> Resumen General</a></li>
                <li><a href="#aprobaciones"><i class="fa-solid fa-user-clock"></i> Solicitudes Pendientes ({{ $pendientesAprobacion }})</a></li>
                <li><a href="#usuarios"><i class="fa-solid fa-users"></i> Gestionar Usuarios</a></li>
                <li><a href="#inventario"><i class="fa-solid fa-boxes-stacked"></i> Faltantes de Inventario</a></li>
                <li><a href="#productos"><i class="fa-solid fa-store"></i> Productos Tienda</a></li>
                <li><a href="#adopciones"><i class="fa-solid fa-paw"></i> Mascotas en Adopción</a></li>
            </ul>
        </aside>

        <!-- CONTENIDO DEL PANEL -->
        <main class="main-content">
            
            <div class="dashboard-header" id="resumen">
                <div class="admin-info">
                    <h1>Bienvenido, {{ Auth::user()->nombre }}</h1>
                    <p>Gestión global de la plataforma Animapp y Alfort Animal Care</p>
                </div>
                <div>
                    <span class="badge-status active"><i class="fa-solid fa-shield-halved"></i> Rol: Administrador</span>
                </div>
            </div>

            <!-- TARJETAS DE MÉTRICAS -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <i class="fa-solid fa-users metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $totalUsuarios }}</h3>
                        <p>Usuarios Registrados</p>
                    </div>
                </div>
                <div class="metric-card warning">
                    <i class="fa-solid fa-user-clock metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $pendientesAprobacion }}</h3>
                        <p>Personal por Aprobar</p>
                    </div>
                </div>
                <div class="metric-card warning">
                    <i class="fa-solid fa-triangle-exclamation metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $faltantesInventario }}</h3>
                        <p>Faltantes Inventario</p>
                    </div>
                </div>
                <div class="metric-card">
                    <i class="fa-solid fa-heart metric-icon"></i>
                    <div class="metric-details">
                        <h3>{{ $mascotasAdopcion }}</h3>
                        <p>Mascotas en Adopción</p>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: APROBACIÓN DE PERSONAL -->
            <section class="panel-section" id="aprobaciones">
                <div class="panel-header-actions">
                    <h2><i class="fa-solid fa-user-clock"></i> Cuentas de Personal Pendientes por Validar</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol Solicitado</th>
                            <th>Soporte / Credencial</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuariosPendientes as $user)
                            <tr>
                                <td>{{ $user->nombre }}</td>
                                <td>{{ $user->correo }}</td>
                                <td><span class="badge-status pending">{{ ucfirst($user->rol) }}</span></td>
                                <td>
                                    @if($user->archivo_soporte)
                                        <a href="{{ asset('storage/' . $user->archivo_soporte) }}" target="_blank" class="btn-action">
                                            <i class="fa-solid fa-file-pdf"></i> Ver Soporte
                                        </a>
                                    @else
                                        <span style="color: #999;">Sin archivo</span>
                                    @endif
                                </td>
                                <td style="display: flex; gap: 8px;">
                                    <form action="{{ route('admin.usuario.estado', $user->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="estado" value="activo">
                                        <button type="submit" style="background: #198754; color: #fff; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                                            Aprobar
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.usuario.estado', $user->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="estado" value="rechazado">
                                        <button type="submit" style="background: #dc3545; color: #fff; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                                            Rechazar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #666;">No hay solicitudes de personal pendientes por validar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <!-- SECCIÓN: GESTIONAR USUARIOS -->
            <section class="panel-section" id="usuarios">
                <div class="panel-header-actions">
                    <h2><i class="fa-solid fa-users"></i> Gestión de Usuarios y Roles</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Rol Asignado</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listaUsuarios as $u)
                            <tr>
                                <td>{{ $u->nombre }}</td>
                                <td>{{ $u->correo }}</td>
                                <td>{{ ucfirst($u->rol) }}</td>
                                <td>
                                    @if($u->estado_cuenta === 'activo')
                                        <span class="badge-status active">Activo</span>
                                    @elseif($u->estado_cuenta === 'pendiente_aprobacion')
                                        <span class="badge-status pending">Pendiente</span>
                                    @else
                                        <span class="badge-status low">Rechazado</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <!-- SECCIÓN: FALTANTES EN INVENTARIO -->
            <section class="panel-section" id="inventario">
                <div class="panel-header-actions">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i> Control y Faltantes de Inventario</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto / Insumo</th>
                            <th>Categoría</th>
                            <th>Stock Actual</th>
                            <th>Mínimo Requerido</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productosBajos as $prod)
                            <tr>
                                <td>PROD-{{ $prod->id }}</td>
                                <td>{{ $prod->nombre }}</td>
                                <td>{{ $prod->categoria }}</td>
                                <td>{{ $prod->stock_actual }}</td>
                                <td>{{ $prod->stock_minimo }}</td>
                                <td><span class="badge-status low">Bajo Stock</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #666;">Todo el inventario cuenta con stock suficiente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <!-- SECCIÓN: CATÁLOGO DE PRODUCTOS -->
            <section class="panel-section" id="productos">
                <div class="panel-header-actions">
                    <h2><i class="fa-solid fa-store"></i> Gestión de Catálogo de Productos</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $p)
                            <tr>
                                <td>PROD-{{ $p->id }}</td>
                                <td>{{ $p->nombre }}</td>
                                <td>{{ $p->categoria }}</td>
                                <td>$ {{ number_format($p->precio, 0, ',', '.') }}</td>
                                <td>{{ $p->stock_actual }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No hay productos registrados en la base de datos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <!-- SECCIÓN: MASCOTAS EN ADOPCIÓN -->
            <section class="panel-section" id="adopciones">
                <div class="panel-header-actions">
                    <h2><i class="fa-solid fa-heart"></i> Gestión de Mascotas en Adopción</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mascota</th>
                            <th>Especie / Raza</th>
                            <th>Edad Aproximada</th>
                            <th>Estado Adopción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mascotas as $m)
                            <tr>
                                <td>{{ $m->nombre_mascota }}</td>
                                <td>{{ $m->especie }} / {{ $m->raza }}</td>
                                <td>{{ $m->edad_aproximada }}</td>
                                <td>
                                    @if($m->estado_adopcion === 'Disponible')
                                        <span class="badge-status active">Disponible</span>
                                    @elseif($m->estado_adopcion === 'En Proceso')
                                        <span class="badge-status pending">En Proceso</span>
                                    @else
                                        <span class="badge-status confirmed">Adoptado</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">No hay mascotas registradas aún.</td>
                            </tr>
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
                    <li><a href="{{ route('adopcion') }}">Fundaciones aliadas</a></li>
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
        <script>
            Swal.fire({ icon: 'success', title: '¡Actualizado!', text: "{{ session('success') }}" });
        </script>
    @endif

</body>
</html>