@extends('layouts.app')

@section('title', 'Salud Veterinaria - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/salud.css') }}">
@endpush

@section('content')
    <!-- BANNER DE ENCABEZADO -->
    <section class="servicio-hero">
        <div class="hero-overlay">
            <h1>Consulta Médica & Salud Veterinaria</h1>
            <p>Atención médica especializada, diagnósticos precisos y cuidado preventivo para tu mascota a través de nuestra red de aliados.</p>
        </div>
    </section>

    <!-- DETALLE DEL SERVICIO -->
    <section class="servicio-seccion container">
        <div class="grid-2-col">
            <div class="texto-servicio">
                <span class="badge-subtitulo">Atención Médica Integral</span>
                <h2>Medicina Veterinaria Especializada</h2>
                <p>En <strong>Alfort Animal Care</strong> conectamos el bienestar de tu compañero con los mejores centros y profesionales de la salud. Ofrecemos un acceso rápido a un enfoque médico centrado en la prevención, el diagnóstico temprano de enfermedades y tratamientos adaptados a las necesidades de cada paciente en la localidad de Engativá, Bogotá.</p>
                
                <h3>Nuestros Servicios Médicos Incluyen:</h3>
                <ul class="lista-servicios">
                    <li><i class="fa-solid fa-user-doctor"></i> Consulta médica general y revisión preventiva.</li>
                    <li><i class="fa-solid fa-notes-medical"></i> Diagnóstico y tratamiento de patologías agudas y crónicas.</li>
                    <li><i class="fa-solid fa-flask"></i> Exámenes de laboratorio clínico y pruebas de diagnóstico.</li>
                    <li><i class="fa-solid fa-shield-cat"></i> Chequeos geriátricos para mascotas adultas mayores.</li>
                    <li><i class="fa-solid fa-paw"></i> Control pediátrico y de crecimiento para cachorros y gatitos.</li>
                    <li><i class="fa-solid fa-file-prescription"></i> Formulación, guía farmacológica y seguimiento.</li>
                </ul>

                <div class="aviso-registro">
                    @auth
                        <p><i class="fa-solid fa-circle-check"></i> Ya iniciaste sesión como <strong>{{ Auth::user()->nombre }}</strong>. Agenda tu consulta médica ahora mismo.</p>
                        <a href="{{ route('citas') }}" class="btn-agendar-cita">Agendar Consulta Médica</a>
                    @else
                        <p><i class="fa-solid fa-circle-info"></i> Para agendar la consulta médica con nuestros especialistas, debes contar con un registro activo en nuestra plataforma.</p>
                        <a href="{{ route('register') }}" class="btn-agendar-cita">Agendar Consulta Médica</a>
                    @endauth
                </div>
            </div>

            <div class="imagen-servicio-box">
                <img src="https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?q=80&w=800&auto=format&fit=crop" alt="Consulta médica veterinaria">
            </div>
        </div>
    </section>
@endsection