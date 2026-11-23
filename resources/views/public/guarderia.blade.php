@extends('layouts.app')

@section('title', 'Guardería y Campamento - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/guarderia.css') }}">
@endpush

@section('content')
    <!-- BANNER DE ENCABEZADO -->
    <section class="servicio-hero">
        <div class="hero-overlay">
            <h1>Guardería y Hotel Canino & Felino</h1>
            <p>Elige el plan ideal para el cuidado, entretenimiento y seguimiento de tu mascota.</p>
        </div>
    </section>

    <!-- SECCIÓN DE PLANES DE GUARDERÍA -->
    <section class="planes-seccion container my-5">
        <div class="titulo-centrado text-center mb-5">
            <span class="badge bg-secondary mb-2">Planes de Estancia</span>
            <h2>Selecciona el Plan Ideal</h2>
            <p class="text-muted">Adaptamos el nivel de atención, actividades y reporte de seguimiento según tus necesidades.</p>
        </div>

        <div class="row g-4">
            <!-- Tarjeta Plan Básico -->
            <div class="col-md-4">
                <div class="card p-4 shadow-sm plan-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h3 class="plan-titulo">Plan Básico</h3>
                        <p class="text-muted">Cuidado Esencial</p>
                        <h4 class="text-success fw-bold my-3 precio-plan">$ 35.000 <small class="text-muted fs-6">/ noche</small></h4>
                        <ul class="list-unstyled mb-4">
                            <li>✓ Alimentación según horarios del tutor</li>
                            <li>✓ Paseos recreativos (2 al día)</li>
                            <li>✓ Zona de descanso climatizada</li>
                            <li>✓ Supervisión veterinaria básica</li>
                        </ul>
                        <button type="button" class="btn btn-outline-primary w-100 mt-auto btn-seleccionar-plan" data-plan="Plan Básico">Seleccionar Plan</button>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Plan Medio (Más Popular) -->
            <div class="col-md-4">
                <div class="card p-4 shadow-sm plan-card border-primary h-100">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-success mb-2 align-self-start">MÁS POPULAR</span>
                        <h3 class="plan-titulo">Plan Medio</h3>
                        <p class="text-muted">Atención Ampliada</p>
                        <h4 class="text-success fw-bold my-3 precio-plan">$ 55.000 <small class="text-muted fs-6">/ noche</small></h4>
                        <ul class="list-unstyled mb-4">
                            <li>✓ Todo lo del Plan Básico</li>
                            <li>✓ Paseos y juego guiado (4 al día)</li>
                            <li>✓ Socialización supervisada en grupos</li>
                            <li>✓ Reporte diario con fotos</li>
                        </ul>
                        <button type="button" class="btn btn-primary w-100 mt-auto btn-seleccionar-plan" data-plan="Plan Medio">Seleccionar Plan</button>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Plan Premium VIP -->
            <div class="col-md-4">
                <div class="card p-4 shadow-sm plan-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h3 class="plan-titulo">Plan Premium VIP</h3>
                        <p class="text-muted">Experiencia Completa</p>
                        <h4 class="text-success fw-bold my-3 precio-plan">$ 85.000 <small class="text-muted fs-6">/ noche</small></h4>
                        <ul class="list-unstyled mb-4">
                            <li>✓ Todo lo del Plan Medio</li>
                            <li>✓ Acceso a piscina de pelotas</li>
                            <li>✓ Sesión de relajación y masajes</li>
                            <li>✓ Seguimiento con fotos y videos</li>
                        </ul>
                        <button type="button" class="btn btn-outline-primary w-100 mt-auto btn-seleccionar-plan" data-plan="Plan Premium VIP">Seleccionar Plan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FORMULARIO DE RESERVA Y REQUISITOS -->
    <section class="reserva-seccion container mb-5" id="seccion-reserva-guarderia">
        <div class="form-container-box p-4 shadow-sm bg-white rounded">
            <div class="form-header-text mb-4">
                <h2>Reserva de Estancia y Requisitos de Ingreso</h2>
                <p class="text-muted">Completa la información médica y de estancia antes de confirmar la solicitud.</p>
            </div>

            <form class="form-guarderia" action="{{ route('citas.agendar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="servicio" value="Guardería">
                <input type="hidden" name="tipo_mascota" value="Perro">
                <input type="hidden" name="hora" value="09:00">

                <!-- 1. Datos del servicio -->
                <div class="form-seccion-titulo fw-bold mb-3">
                    <i class="fa-solid fa-sliders"></i> 1. Selección del Plan y Fechas
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <label for="nombre_mascota" class="form-label">Nombre de la Mascota:</label>
                        <input type="text" id="nombre_mascota" name="nombre_mascota" class="form-control" placeholder="Ej: Bruno" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="plan-seleccionado" class="form-label">Plan de Guardería:</label>
                        <select id="plan-seleccionado" name="plan" class="form-select" required>
                            <option value="" disabled selected>-- Selecciona un plan --</option>
                            <option value="Plan Básico">Plan Básico</option>
                            <option value="Plan Medio">Plan Medio</option>
                            <option value="Plan Premium VIP">Plan Premium VIP</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fecha-ingreso" class="form-label">Fecha de Ingreso:</label>
                        <input type="date" id="fecha-ingreso" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fecha-salida" class="form-label">Fecha de Salida:</label>
                        <input type="date" id="fecha-salida" name="fecha_salida" class="form-control" required>
                    </div>
                </div>

                <!-- 2. Requisitos y Salud de la mascota -->
                <div class="form-seccion-titulo fw-bold mb-3">
                    <i class="fa-solid fa-file-medical"></i> 2. Requisitos Sanitarios y Ficha Médica
                </div>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="carne-vacunas" class="form-label">Carné de Vacunas al Día (PDF o Imagen):</label>
                        <input type="file" id="carne-vacunas" name="carne_vacunas" class="form-control" accept="image/*,.pdf">
                        <small class="form-text text-muted">Requerido: Rabia, Pentavalente/Triple y Traqueobronquitis.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="desparasitacion" class="form-label">Fecha de última desparasitación:</label>
                        <input type="date" id="desparasitacion" name="desparasitacion" class="form-control" required>
                    </div>
                </div>

                <!-- 3. Observaciones especiales -->
                <div class="form-seccion-titulo fw-bold mb-3">
                    <i class="fa-solid fa-clipboard-list"></i> 3. Observaciones y Cuidados Especiales
                </div>
                <div class="mb-4">
                    <label for="observaciones" class="form-label">Alimentación, medicamentos, hábitos o comportamiento:</label>
                    <textarea id="observaciones" name="observaciones" class="form-control" rows="3" placeholder="Ej: Es alérgico al pollo, toma medicación a las 3:00 PM, le asustan los ruidos fuertes..."></textarea>
                </div>

                <!-- Confirmación -->
                <div class="aviso-registro alert alert-secondary">
                    @auth
                        <p class="mb-2"><i class="fa-solid fa-circle-check"></i> Sesión activa como <strong>{{ Auth::user()->nombre }}</strong>. Tu reserva de guardería se registrará inmediatamente.</p>
                        <button type="submit" class="btn btn-primary w-100 btn-agendar-cita">Confirmar Reserva de Guardería</button>
                    @else
                        <p class="mb-2"><i class="fa-solid fa-circle-info"></i> Al hacer clic en reservar, serás redirigido para iniciar sesión o registrarte y vincular la reserva a la ficha de tu mascota.</p>
                        <button type="submit" class="btn btn-primary w-100 btn-agendar-cita">Continuar y Validar Reserva</button>
                    @endauth
                </div>

            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hoy = new Date();
        const hoyStr = hoy.toISOString().split('T')[0];

        const maxFecha = new Date(hoy);
        maxFecha.setFullYear(hoy.getFullYear() + 3);
        const maxFechaStr = maxFecha.toISOString().split('T')[0];

        const minDespara = new Date(hoy);
        minDespara.setFullYear(hoy.getFullYear() - 5);
        const minDesparaStr = minDespara.toISOString().split('T')[0];

        const inpIngreso = document.getElementById('fecha-ingreso');
        const inpSalida = document.getElementById('fecha-salida');
        const inpDespara = document.getElementById('desparasitacion');
        const selectPlan = document.getElementById('plan-seleccionado');
        const seccionReserva = document.getElementById('seccion-reserva-guarderia');

        if (inpIngreso) {
            inpIngreso.setAttribute('min', hoyStr);
            inpIngreso.setAttribute('max', maxFechaStr);
        }
        if (inpSalida) {
            inpSalida.setAttribute('min', hoyStr);
            inpSalida.setAttribute('max', maxFechaStr);
        }
        if (inpDespara) {
            inpDespara.setAttribute('min', minDesparaStr);
        }

        document.querySelectorAll('.btn-seleccionar-plan').forEach(btn => {
            btn.addEventListener('click', () => {
                if (selectPlan) {
                    selectPlan.value = btn.dataset.plan;
                }
                if (seccionReserva) {
                    seccionReserva.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    });
</script>
@endpush