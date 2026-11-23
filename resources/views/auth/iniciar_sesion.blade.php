<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Animapp</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo.jpeg') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="auth-container">
        <div class="auth-header">
            <span class="logo-text">Animapp</span>
            <h2>¡Bienvenido de nuevo!</h2>
            <p>Ingresa a tu cuenta para gestionar tus citas y servicios.</p>
        </div>

        <form id="formLogin" class="auth-form" action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="correo" value="{{ old('correo') }}" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="form-group input-password-wrapper">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                <button type="button" class="btn-toggle-password" id="btnTogglePassword" aria-label="Mostrar contraseña">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            <button type="submit" class="btn-submit">Iniciar Sesión</button>
        </form>

        <div class="auth-footer">
            <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
            <a href="{{ route('inicio') }}" class="back-home">← Volver al inicio</a>
        </div>
    </div>

    <script>
        const btnToggle = document.getElementById('btnTogglePassword');
        const passInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (btnToggle && passInput) {
            btnToggle.addEventListener('click', () => {
                const isPassword = passInput.type === 'password';
                passInput.type = isPassword ? 'text' : 'password';
                eyeIcon.className = isPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
            });
        }
    </script>

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error de autenticación', text: "{{ session('error') }}", confirmButtonColor: '#d33' });
        </script>
    @endif
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: '¡Listo!', text: "{{ session('success') }}", confirmButtonColor: '#3085d6' });
        </script>
    @endif
    @if(session('info'))
        <script>
            Swal.fire({ icon: 'info', title: 'En revisión', text: "{{ session('info') }}", confirmButtonColor: '#3085d6' });
        </script>
    @endif
</body>
</html>