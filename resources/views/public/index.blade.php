@extends('layouts.app')

@section('title', 'Inicio - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        .hero-nosotros {
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.85) 10%, rgba(0, 0, 0, 0.3) 100%), url("{{ asset('img/nosotros.jpeg') }}") center/cover no-repeat;
            min-height: 320px;
        }
    </style>
@endpush

@section('content')
    <!-- BANNER / SECCIÓN "SOBRE NOSOTROS" -->
    <section class="container my-4">
        <div class="p-5 text-white rounded position-relative overflow-hidden shadow-sm hero-nosotros d-flex align-items-center">
            <div class="col-md-7 px-0">
                <h1 class="display-5 fw-bold text-white">Sobre Nosotros</h1>
                <p class="lead my-3 text-light">Conoce a nuestro equipo de especialistas y el compromiso que tenemos con el cuidado de tu mascota.</p>
                <div>
                    <a href="{{ route('nosotros') }}" class="btn btn-primary px-4 py-2 fw-bold">Conocer más</a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECCIÓN DE NUESTROS SERVICIOS PRINCIPALES -->
    <section class="container my-5">
        <div class="row">
            <div class="col-12 mb-4 text-center">
                <span class="badge bg-light text-primary border mb-2 px-3 py-1">Lo que ofrecemos</span>
                <h2 class="fw-bold text-dark">Nuestros Servicios Principales</h2>
                <div class="mx-auto mt-2" style="width: 80px; height: 3px; background-color: #005f73;"></div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Tarjeta 1: Jornada de Desparasitación -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100 border-0 overflow-hidden">
                    <img src="{{ asset('img/despara.jpeg') }}" data-fallback="{{ asset('img/logo.jpeg') }}" class="card-img-top img-fallback" alt="Desparasitación" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4 d-flex flex-column">
                        <h4 class="fw-bold text-dark">Jornada de Desparasitación</h4>
                        <p class="text-muted mb-3">Protege a tu peludo contra parásitos internos y externos con productos certificados.</p>
                        <div class="mt-auto">
                            <a href="{{ route('vacunacion') }}" class="btn btn-primary btn-sm px-4">Conocer más</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2: Esquema de Vacunación -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100 border-0 overflow-hidden">
                    <img src="{{ asset('img/vacuna.jpeg') }}" data-fallback="{{ asset('img/logo.jpeg') }}" class="card-img-top img-fallback" alt="Vacunación" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4 d-flex flex-column">
                        <h4 class="fw-bold text-dark">Esquema de Vacunación</h4>
                        <p class="text-muted mb-3">Mantén sus vacunas al día con nuestros especialistas y lleva un control seguro.</p>
                        <div class="mt-auto">
                            <a href="{{ route('vacunacion') }}" class="btn btn-primary btn-sm px-4">Agendar Cita</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.img-fallback').forEach(img => {
        img.addEventListener('error', function() {
            this.src = this.dataset.fallback;
        });
    });
</script>
@endpush