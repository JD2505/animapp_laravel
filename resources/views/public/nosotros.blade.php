@extends('layouts.app')

@section('title', 'Sobre Nosotros - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/nosotrohtml.css') }}">
@endpush

@section('content')
    <!-- BANNER DE ENCABEZADO -->
    <section class="nosotros-hero">
        <div class="hero-overlay">
            <h1>Sobre Nosotros</h1>
            <p>Conoce la misión, el propósito y la tecnología que impulsan a Animapp para conectar el bienestar de tus mascotas.</p>
        </div>
    </section>

    <!-- SECCIÓN: ¿QUIÉNES SOMOS? -->
    <section class="nosotros-seccion container">
        <div class="grid-2-col">
            <div class="texto-nosotros">
                <span class="badge-subtitulo">Nuestra Historia</span>
                <h2>¿Quiénes somos?</h2>
                <p>En <strong>Animapp</strong> nos consolidamos como la plataforma tecnológica integral diseñada para simplificar el cuidado y la gestión de la salud de tus mascotas en la localidad de Engativá, Bogotá. Nacimos con el propósito de transformar la experiencia de los tutores, centralizando en un solo lugar servicios médicos, estética, adopción y tienda de manera ágil, confiable y moderna.</p>
                <p>Nuestro equipo combina la pasión por el bienestar animal con el desarrollo de soluciones digitales eficientes, entendiendo que cada mascota merece la mejor atención y un cuidado familiar sin complicaciones.</p>
            </div>
            <div class="imagen-nosotros-box">
                <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?q=80&w=800&auto=format&fit=crop" alt="Equipo veterinario cuidando una mascota">
            </div>
        </div>
    </section>

    <!-- SECCIÓN: MISIÓN Y VISIÓN (CAJAS ELEVABLES) -->
    <section class="mision-vision-bg">
        <div class="container grid-2-col">
            
            <div class="tarjeta-mv">
                <div class="mv-icono">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h3>Nuestra Misión</h3>
                <p>Facilitar y optimizar el acceso a servicios veterinarios y de bienestar animal de excelencia a través de una plataforma intuitiva y segura. Nos esforzamos por conectar a los tutores con profesionales confiables, promoviendo la prevención, el diagnóstico oportuno y una atención transparente.</p>
            </div>

            <div class="tarjeta-mv">
                <div class="mv-icono">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h3>Nuestra Visión</h3>
                <p>Ser la aplicación digital de referencia en Bogotá para el cuidado integral de mascotas, reconocidos por nuestra innovación tecnológica, la calidad de nuestra red de servicios y nuestro firme compromiso con la comunidad animalista.</p>
            </div>

        </div>
    </section>

    <!-- SECCIÓN: VALORES CORPORATIVOS -->
    <section class="nosotros-seccion container">
        <div class="titulo-centrado">
            <span class="badge-subtitulo">Lo que nos define</span>
            <h2>Nuestros Valores</h2>
        </div>

        <div class="grid-valores">
            <div class="valor-card">
                <i class="fa-solid fa-heart"></i>
                <h4>Empatía y Amor</h4>
                <p>Tratamos a cada paciente y usuario con el mismo respeto y cariño con el que cuidamos a nuestras propias mascotas.</p>
            </div>
            <div class="valor-card">
                <i class="fa-solid fa-user-doctor"></i>
                <h4>Excelencia y Calidad</h4>
                <p>Impulsamos altos estándares en nuestra red de servicios médicos y de atención para garantizar diagnósticos y procesos confiables.</p>
            </div>
            <div class="valor-card">
                <i class="fa-solid fa-shield-halved"></i>
                <h4>Compromiso Tecnológico y Ético</h4>
                <p>Transparencia absoluta en la gestión de citas, transacciones y el manejo responsable de los datos de nuestros usuarios.</p>
            </div>
            <div class="valor-card">
                <i class="fa-solid fa-handshake"></i>
                <h4>Confianza</h4>
                <p>Construimos una comunidad duradera entre tutores, profesionales y servicios aliados, basada en la honestidad y una experiencia digital segura.</p>
            </div>
        </div>
    </section>
@endsection