<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inicio - Animapp')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo.jpeg') }}">
    <!-- Hojas de estilos vinculadas -->
    <link rel="stylesheet" href="{{ asset('css/encabezado.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pie.css') }}">
    @stack('styles')
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- BARRA SUPERIOR (Encabezado) -->
    <header class="top-header">
        <a href="{{ route('inicio') }}" class="logo-container text-decoration-none d-flex align-items-center">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Animapp" class="logo-img">
            <span class="logo-text">Animapp</span>
        </a>

        <div class="search-container">
            <input type="text" placeholder="¿Qué servicio buscas para tu mascota?" class="search-input">
            <button class="search-btn">Buscar</button>
        </div>

        <div class="user-actions">
            <a href="{{ route('carrito') }}" class="btn-cart">🛒 Carrito <span class="cart-count">(0)</span></a>
            
            @auth
                <span class="sesion-badge" style="display:inline-block; margin-right: 8px; font-weight: bold;">
                    Hola, {{ Auth::user()->nombre }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-login" style="background-color: #dc3545; border: none; cursor: pointer;">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn-register">Registrarse</a>
            @endauth
        </div>
    </header>

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="main-nav">
        <ul>
            <li><a href="{{ route('inicio') }}" class="{{ request()->routeIs('inicio') ? 'active' : '' }}">Inicio</a></li>
            <li class="dropdown">
                <a href="#servicios" class="dropbtn">Servicios ▾</a>
                <div class="dropdown-content">
                    <div class="dropdown-column">
                        <h4>Servicios Especializados</h4>
                        <a href="{{ route('estetica') }}">Servicios de Estética y Spa</a>
                    </div>
                    <div class="dropdown-column">
                        <h4>Servicios Médicos</h4>
                        <a href="{{ route('salud') }}">Salud Veterinaria</a>
                    </div>
                    <div class="dropdown-column">
                        <h4>Servicios Complementarios</h4>
                        <a href="{{ route('vacunacion') }}">Vacunación</a>
                        <a href="{{ route('citas') }}">Citas</a>
                        <a href="{{ route('guarderia') }}">Guardería</a>
                    </div>
                </div>
            </li>
            <li><a href="{{ route('tienda') }}" class="{{ request()->routeIs('tienda') ? 'active' : '' }}">Tienda</a></li>
            <li><a href="{{ route('adopcion') }}" class="{{ request()->routeIs('adopcion') ? 'active' : '' }}">Adopción</a></li>
            <!-- BOTÓN MI PERFIL FUNCIONAL: Redirige al Dashboard del rol o al Login si no hay sesión -->
            <li><a href="{{ route('mi.perfil') }}">Mi perfil</a></li>
        </ul>
    </nav>

    <!-- CONTENIDO DINÁMICO DE CADA PÁGINA -->
    @yield('content')

    <!-- PIE DE PÁGINA COMPLETO -->
    <footer class="pie-completo" id="contacto">
        <div class="pie-container">
            <div class="pie-columna">
                <h3>Nosotros</h3>
                <ul>
                    <li><a href="{{ route('nosotros') }}">¿Quiénes somos?</a></li>
                    <li><a href="{{ route('adopcion') }}">Nuestros aliados</a></li>
                    <li><a href="#">Trabaja con nosotros</a></li>
                    <li><a href="#">Política de SST</a></li>
                    <li><a href="#">Responsabilidad social</a></li>
                </ul>
            </div>
            <div class="pie-columna">
                <h3>Información</h3>
                <ul>
                    <li><a href="#">Términos y Condiciones del Sitio</a></li>
                    <li><a href="#">Preguntas frecuentes</a></li>
                    <li><a href="#">¿Cómo agendar/comprar?</a></li>
                    <li><a href="#">Política de privacidad y datos</a></li>
                    <li><a href="#">Métodos de pago aceptados</a></li>
                    <li><a href="#">Políticas de servicios y garantías</a></li>
                </ul>
            </div>
            <div class="pie-columna">
                <h3>Contáctanos</h3>
                <div class="contacto-info">
                    <p><strong>Atención al cliente:</strong></p>
                    <p>Localidad de Engativá, Bogotá D.C.</p>
                    <p>Tel: 300 123 4567</p>
                    <p>Email: <a href="mailto:info@animapp.com">info@animapp.com</a></p>
                    <p>Horarios: Lun - Sáb 8:00 a.m. - 6:00 p.m.</p>
                    <br>
                    <p><a href="#" class="link-destacado">Formulario de contacto</a></p>
                    <p><a href="#" class="link-destacado">PQR'S</a></p>
                </div>
            </div>
        </div>
        <div class="pie-creditos">
            <p>&copy; 2026 Animapp - Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- SCRIPTS JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    @if(session('success'))
        <script>Swal.fire({ icon: 'success', title: '¡Listo!', text: "{{ session('success') }}" });</script>
    @endif
    @if(session('error'))
        <script>Swal.fire({ icon: 'error', title: 'Atención', text: "{{ session('error') }}" });</script>
    @endif
</body>
</html>