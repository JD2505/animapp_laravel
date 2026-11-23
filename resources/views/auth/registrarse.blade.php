<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Animapp</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo.jpeg') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="auth-container">
        <div class="auth-header">
            <span class="logo-text">Animapp</span>
            <h2>Crea tu cuenta</h2>
            <p>Únete para cuidar de tu mascota de forma rápida y fácil.</p>
        </div>

        <form id="formRegistro" class="auth-form" action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre y apellido" required>
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="correo" value="{{ old('correo') }}" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="form-group">
                <label for="rol">Selecciona tu Perfil / Rol</label>
                <select id="rol" name="rol" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;" required>
                    <option value="cliente" {{ old('rol') == 'cliente' ? 'selected' : '' }}>Cliente / Propietario de Mascota</option>
                    <option value="veterinario" {{ old('rol') == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                    <option value="auxiliar" {{ old('rol') == 'auxiliar' ? 'selected' : '' }}>Auxiliar / Recepción</option>
                </select>
            </div>

            <div class="form-group" id="grupoSoporte" style="display: none;">
                <label for="soporte_doc">Soporte Profesional / Credencial (PDF o Imagen)</label>
                <input type="file" id="soporte_doc" name="soporte_doc" accept=".pdf,.jpg,.jpeg,.png">
                <small style="color: #666; font-size: 0.85em; display: block; margin-top: 4px;">
                    Obligatorio para personal médico o asistencial. Tu cuenta quedará pendiente de aprobación por el Administrador.
                </small>
            </div>

            <div class="form-group input-password-wrapper">
            <small style="color: #555; font-size: 0.82em; display: block; margin-top: -8px; margin-bottom: 12px;">
                <strong>Requisitos:</strong> Mínimo 8 caracteres, 1 mayúscula, 1 minúscula, 1 número y 1 símbolo (ej. <code>@ # $ * !</code>).
            </small>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" required>
                <button type="button" class="btn-toggle-password" id="btnTogglePassword" aria-label="Mostrar contraseña">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            <div class="form-group-checkbox">
                <input type="checkbox" id="aceptoPoliticas" required>
                <label for="aceptoPoliticas">
                    Acepto la <a href="#" target="_blank">Política de privacidad y manejo de datos personales</a>.
                </label>
            </div>

            <button type="submit" class="btn-submit">Crear Cuenta</button>
        </form>

        <div class="auth-footer">
            <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
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

        const selectRol = document.getElementById('rol');
        const grupoSoporte = document.getElementById('grupoSoporte');
        const inputSoporte = document.getElementById('soporte_doc');

        function toggleSoporte() {
            if (selectRol.value === 'veterinario' || selectRol.value === 'auxiliar') {
                grupoSoporte.style.display = 'block';
                inputSoporte.required = true;
            } else {
                grupoSoporte.style.display = 'none';
                inputSoporte.required = false;
                inputSoporte.value = '';
            }
        }

        selectRol.addEventListener('change', toggleSoporte);
        document.addEventListener('DOMContentLoaded', toggleSoporte);
    </script>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Revisa los datos',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d33'
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}", confirmButtonColor: '#d33' });
        </script>
    @endif
</body>
</html>