@extends('layouts.app')

@section('title', 'Estética y Spa - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/estetica.css') }}">
@endpush

@section('content')
    <!-- SERVICIO HERO -->
    <section class="servicio-hero">
        <div class="hero-overlay">
            <h1>Estética y Spa Canino & Felino</h1>
            <p>Cuidado, higiene y relajación profesional para tu compañero consentido.</p>
        </div>
    </section>

    <!-- DETALLE DEL SERVICIO -->
    <section class="servicio-container">
        <div class="grid-servicio">
            
            <div class="info-servicio">
                <span class="badge-categoria">Higiene y Bienestar</span>
                <h2>Grooming y Relajación Profesional</h2>
                <p>En <strong>Animapp</strong> entendemos que el baño y la estética no son solo cuestión de apariencia, sino de salud física y emocional. Contamos con instalaciones adaptadas para reducir el estrés durante el proceso de aseo.</p>
                
                <h3>Nuestros Paquetes Incluyen:</h3>
                <ul class="lista-servicios">
                    <li><i class="fa-solid fa-check"></i> Baño medicado o cosmético según el tipo de piel.</li>
                    <li><i class="fa-solid fa-check"></i> Corte de pelo según la raza o preferencia del tutor.</li>
                    <li><i class="fa-solid fa-check"></i> Limpieza profunda de oídos y drenaje de glándulas.</li>
                    <li><i class="fa-solid fa-check"></i> Corte y limado de uñas.</li>
                    <li><i class="fa-solid fa-check"></i> Cepillado y eliminación de pelo muerto.</li>
                    <li><i class="fa-solid fa-check"></i> Hidratación de almohadillas plantares.</li>
                </ul>

                <div class="aviso-registro">
                    @auth
                        <p><i class="fa-solid fa-circle-check"></i> Ya iniciaste sesión como <strong>{{ Auth::user()->nombre }}</strong>. Agenda tu turno de spa ahora mismo.</p>
                        <a href="{{ route('citas') }}" class="btn-agendar-cita">Agendar Cita de Spa</a>
                    @else
                        <p><i class="fa-solid fa-circle-info"></i> Para agendar el turno de spa de tu mascota, es necesario registrarte en nuestra plataforma.</p>
                        <a href="{{ route('register') }}" class="btn-agendar-cita">Agendar Cita de Spa</a>
                    @endauth
                </div>
            </div>

            <div class="imagen-servicio-box">
                <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=800&auto=format&fit=crop" alt="Perro en sesión de spa y baño">
            </div>

        </div>
    </section>
@endsection