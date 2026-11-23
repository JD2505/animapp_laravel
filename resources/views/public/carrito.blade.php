@extends('layouts.app')

@section('title', 'Animapp - Carrito de Compras')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
@endpush

@section('content')
    <!-- CONTENIDO PRINCIPAL DEL CARRITO -->
    <div class="container my-5" id="carrito-app" data-logueado="{{ Auth::check() ? '1' : '0' }}" data-login-url="{{ route('login') }}">
        <h2 class="mb-4">Tu Carrito de Compras</h2>
        
        <div class="row">
            <!-- Listado de productos en el carrito -->
            <div class="col-lg-8">
                <div id="contenedor-carrito" class="list-group mb-3">
                    <!-- Los productos se cargarán dinámicamente aquí con JavaScript -->
                </div>
                <button type="button" id="btn-vaciar" class="btn btn-outline-danger btn-sm" style="display: none;">Vaciar Carrito</button>
            </div>

            <!-- Resumen de compra -->
            <div class="col-lg-4">
                <div class="card p-3 shadow-sm">
                    <h4>Resumen del Pedido</h4>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total a pagar:</span>
                        <strong id="total-carrito" class="fs-5 text-success">$ 0</strong>
                    </div>
                    <button type="button" id="btn-finalizar" class="btn btn-primary w-100" style="display: none;">Proceder al Pago</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/carrito.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const app = document.getElementById('carrito-app');
            const btnFinalizar = document.getElementById('btn-finalizar');

            if (app && btnFinalizar) {
                btnFinalizar.addEventListener('click', (e) => {
                    const estaLogueado = app.dataset.logueado === '1';
                    const loginUrl = app.dataset.loginUrl;

                    if (!estaLogueado) {
                        e.stopImmediatePropagation();
                        Swal.fire({
                            title: 'Inicia sesión para finalizar tu compra',
                            text: 'Debes acceder a tu cuenta de Animapp para procesar el pedido.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#005f73',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Iniciar sesión',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = loginUrl;
                            }
                        });
                    }
                }, true);
            }
        });
    </script>
@endpush