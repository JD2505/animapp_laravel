@extends('layouts.app')

@section('title', 'Vacunación - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vacunacion.css') }}">
@endpush

@section('content')
    <!-- BANNER DE ENCABEZADO -->
    <section class="servicio-hero">
        <div class="hero-overlay">
            <h1>Esquema de Vacunación e Inmunización</h1>
            <p>Protege la vida de tu mascota con vacunas certificadas y un control inmunológico preventivo.</p>
        </div>
    </section>

    <!-- DETALLE DEL SERVICIO -->
    <section class="servicio-seccion container">
        <div class="grid-2-col">
            <div class="texto-servicio">
                <span class="badge-subtitulo">Inmunización & Prevención</span>
                <h2>Protección Preventiva para Caninos y Felinos</h2>
                <p>En <strong>Animapp</strong> mantenemos los más altos estándares en la conservación de la cadena de frío de nuestros biológicos. La vacunación regular protege a tus animales contra enfermedades infectocontagiosas graves o letales.</p>
                
                <h3>Esquemas Disponibles:</h3>
                <ul class="lista-servicios">
                    <li><i class="fa-solid fa-syringe"></i> <strong>Caninos:</strong> Pentavalente/Hexavalente, Parvovirus, Traqueobronquitis y Rabia.</li>
                    <li><i class="fa-solid fa-syringe"></i> <strong>Felinos:</strong> Triple Felina, Leucemia Felina y Rabia.</li>
                    <li><i class="fa-solid fa-shield-virus"></i> <strong>Refuerzos Anuales:</strong> Mantenimiento de anticuerpos para perros y gatos adultos.</li>
                    <li><i class="fa-solid fa-file-medical"></i> Expedición y actualización del carné oficial de vacunación.</li>
                    <li><i class="fa-solid fa-stethoscope"></i> Valoración médica básica antes de cada aplicación.</li>
                </ul>

                <div class="aviso-registro">
                    @auth
                        <p><i class="fa-solid fa-circle-check"></i> Ya iniciaste sesión como <strong>{{ Auth::user()->nombre }}</strong>. Programa la vacunación de tu mascota ahora mismo.</p>
                        <a href="{{ route('citas') }}" class="btn-agendar-cita">Agendar Vacunación</a>
                    @else
                        <p><i class="fa-solid fa-circle-info"></i> Para programar la vacunación de tu mascota y llevar el registro de su carné digital, crea tu cuenta en nuestra plataforma.</p>
                        <a href="{{ route('register') }}" class="btn-agendar-cita">Agendar Vacunación</a>
                    @endauth
                </div>
            </div>

            <div class="imagen-servicio-box">
                <img src="{{ asset('img/imagenvacunacion.png') }}" alt="Vacunación veterinaria">
            </div>
        </div>
    </section>
@endsection