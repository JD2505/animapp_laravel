@extends('layouts.app')

@section('title', 'Agendar Cita - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}">
@endpush

@section('content')
    <!-- BANNER DE ENCABEZADO -->
    <section class="servicio-hero">
        <div class="hero-overlay">
            <h1>Agendamiento de Citas</h1>
            <p>Reserva tu turno de atención médica, estética o vacunación de forma rápida y sencilla.</p>
        </div>
    </section>

    <!-- FORMULARIO DE AGENDAMIENTO -->
    <section class="servicio-seccion container">
        <div class="grid-2-col">
            
            <!-- Formulario de reserva -->
            <div class="form-reserva-box">
                <span class="badge-subtitulo">Reserva en Línea</span>
                <h2>Solicita tu Cita</h2>
                <p>Selecciona la especialidad y el horario que mejor se adapte a tu disponibilidad.</p>

                @if($errors->any())
                    <div style="background: #f8d7da; color: #842029; padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 0.9rem;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form class="form-citas" id="form-agendar-cita" action="{{ route('citas.agendar') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="servicio"><i class="fa-solid fa-list-check"></i> Servicio Requerido:</label>
                        <select id="servicio" name="servicio" required>
                            <option value="" disabled {{ old('servicio') ? '' : 'selected' }}>-- Selecciona un servicio --</option>
                            <option value="Estética y Spa" {{ old('servicio') == 'Estética y Spa' ? 'selected' : '' }}>Estética y Spa Canino/Felino</option>
                            <option value="Consulta Médica" {{ old('servicio') == 'Consulta Médica' ? 'selected' : '' }}>Consulta Médica General</option>
                            <option value="Vacunación" {{ old('servicio') == 'Vacunación' ? 'selected' : '' }}>Vacunación e Inmunización</option>
                            <option value="Guardería" {{ old('servicio') == 'Guardería' ? 'selected' : '' }}>Guardería Veterinaria</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre_mascota"><i class="fa-solid fa-tag"></i> Nombre de tu Mascota:</label>
                        <input type="text" id="nombre_mascota" name="nombre_mascota" value="{{ old('nombre_mascota') }}" placeholder="Ej: Max, Luna..." required>
                    </div>

                    <div class="form-group">
                        <label for="tipo-mascota"><i class="fa-solid fa-paw"></i> Especie:</label>
                        <select id="tipo-mascota" name="tipo_mascota" required>
                            <option value="Perro" {{ old('tipo_mascota') == 'Perro' ? 'selected' : '' }}>Perro</option>
                            <option value="Gato" {{ old('tipo_mascota') == 'Gato' ? 'selected' : '' }}>Gato</option>
                            <option value="otro" {{ old('tipo_mascota') == 'otro' ? 'selected' : '' }}>Otro (Especificar)</option>
                        </select>
                    </div>

                    <!-- Campo oculto que se despliega si elige "Otro" -->
                    <div class="form-group" id="campo-otro-especificar" style="display: none;">
                        <label for="especificar-mascota"><i class="fa-solid fa-pen"></i> ¿Qué tipo de animal es?:</label>
                        <input type="text" id="especificar-mascota" name="especificar_mascota" value="{{ old('especificar_mascota') }}" placeholder="Ej: Conejo, Hámster, Ave...">
                    </div>

                    <div class="form-group-double">
                        <div class="form-group">
                            <label for="fecha"><i class="fa-regular fa-calendar-days"></i> Fecha Deseada:</label>
                            <input type="date" id="fecha" name="fecha" min="{{ date('Y-m-d') }}" value="{{ old('fecha') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="hora"><i class="fa-regular fa-clock"></i> Hora Preferida:</label>
                            <input type="time" id="hora" name="hora" min="08:00" max="18:00" value="{{ old('hora') }}" required>
                            <small style="color: #555; font-size: 0.8rem; display: block; margin-top: 4px;">Atención: 8:00 a.m. a 6:00 p.m.</small>
                        </div>
                    </div>

                    <div class="aviso-registro">
                        @auth
                            <p><i class="fa-solid fa-circle-check"></i> Sesión activa como <strong>{{ Auth::user()->nombre }}</strong>. Tu cita quedará registrada de inmediato.</p>
                            <button type="submit" class="btn-agendar-cita">Confirmar Cita</button>
                        @else
                            <p><i class="fa-solid fa-circle-info"></i> Al hacer clic en agendar, serás redirigido para iniciar sesión o registrarte y confirmar tu cita.</p>
                            <button type="submit" class="btn-agendar-cita">Continuar Agendamiento</button>
                        @endauth
                    </div>
                </form>
            </div>

            <!-- Información paso a paso -->
            <div class="info-pasos-box">
                <h3>¿Cómo funciona nuestro sistema de citas?</h3>
                
                <div class="paso-card">
                    <div class="paso-numero">1</div>
                    <div>
                        <h4>Elige el Servicio</h4>
                        <p>Selecciona entre estética, consulta médica, vacunas o guardería según lo que necesite tu mascota.</p>
                    </div>
                </div>

                <div class="paso-card">
                    <div class="paso-numero">2</div>
                    <div>
                        <h4>Inicia Sesión</h4>
                        <p>Accede con tu cuenta o regístrate en segundos para asociar la cita a la historia clínica de tu mascota.</p>
                    </div>
                </div>

                <div class="paso-card">
                    <div class="paso-numero">3</div>
                    <div>
                        <h4>¡Cita Confirmada!</h4>
                        <p>Recibirás la confirmación de tu turno en tu panel de usuario y recordatorios de tu visita.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputFecha = document.getElementById('fecha');
        if (inputFecha) {
            const hoy = new Date().toISOString().split('T')[0];
            inputFecha.setAttribute('min', hoy);
        }

        const selectMascota = document.getElementById('tipo-mascota');
        const campoOtro = document.getElementById('campo-otro-especificar');
        if (selectMascota && campoOtro) {
            selectMascota.addEventListener('change', () => {
                campoOtro.style.display = selectMascota.value === 'otro' ? 'flex' : 'none';
            });
        }

        const formCita = document.getElementById('form-agendar-cita');
        const inputHora = document.getElementById('hora');
        if (formCita && inputHora) {
            formCita.addEventListener('submit', (e) => {
                const hora = inputHora.value;
                if (hora && (hora < '08:00' || hora > '18:00')) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Fuera de horario',
                        text: 'Nuestro horario de atención veterinaria y estética es de 8:00 a.m. a 6:00 p.m.',
                        confirmButtonColor: '#005f73'
                    });
                }
            });
        }
    });
</script>
@endpush