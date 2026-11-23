@extends('layouts.app')

@section('title', 'Tienda Mascotas - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
@endpush

@section('content')
    <!-- BANNER DE TIENDA -->
    <section class="tienda-hero">
        <div class="hero-overlay">
            <h1>Tienda para Mascotas</h1>
            <p>Encuentra alimento, accesorios, medicamentos y juguetes con entrega a domicilio.</p>
        </div>
    </section>

    <!-- CONTENEDOR PRINCIPAL: FILTROS + PRODUCTOS -->
    <main class="tienda-layout container">
        
        <!-- LATERAL IZQUIERDO: FILTROS -->
        <aside class="filtros-sidebar">
            <div class="filtros-header">
                <h3><i class="fa-solid fa-filter"></i> Filtrar Productos</h3>
                <button type="button" class="btn-limpiar-filtros">Limpiar</button>
            </div>

            <!-- Filtro por Especie de Animal -->
            <div class="filtro-grupo">
                <h4>Especie / Mascota</h4>
                <label class="checkbox-container">
                    <input type="checkbox" checked> Perros
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Gatos
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Aves / Loros
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Conejos y roedores
                </label>
            </div>

            <!-- Filtro por Categoría -->
            <div class="filtro-grupo">
                <h4>Categorías</h4>
                <label class="checkbox-container">
                    <input type="checkbox"> Alimento y Snacks
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Juguetes
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Salud e Higiene
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Accesorios y Camas
                </label>
            </div>

            <!-- Filtro por Edad / Etapa de Vida -->
            <div class="filtro-grupo">
                <h4>Edad / Etapa</h4>
                <label class="checkbox-container">
                    <input type="checkbox"> Cachorro / Gatito
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Adulto
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Senior (Mayores de 7 años)
                </label>
                <label class="checkbox-container">
                    <input type="checkbox"> Todas las edades
                </label>
            </div>

            <!-- Filtro por Rango de Precio -->
            <div class="filtro-grupo">
                <h4>Rango de Precio</h4>
                <div class="precio-inputs">
                    <input type="number" placeholder="Mín $">
                    <span>-</span>
                    <input type="number" placeholder="Máx $">
                </div>
            </div>

            <button type="button" class="btn-aplicar-filtros">Aplicar Filtros</button>
        </aside>

        <!-- SECCIÓN DERECHA: CATÁLOGO DE PRODUCTOS -->
        <section class="productos-seccion">
            
            <div class="productos-header-bar">
                <p>Mostrando <strong>{{ $productos->count() > 0 ? $productos->count() : 4 }}</strong> productos encontrados</p>
                <div class="ordenar-box">
                    <label for="ordenar">Ordenar por:</label>
                    <select id="ordenar">
                        <option value="populares">Más populares</option>
                        <option value="precio-bajo">Precio: menor a mayor</option>
                        <option value="precio-alto">Precio: mayor a menor</option>
                    </select>
                </div>
            </div>

            <!-- GRILLA DE TARJETAS DE PRODUCTO -->
            <div class="grid-productos">

                {{-- Productos dinámicos desde MySQL si existen --}}
                @forelse($productos as $producto)
                    <div class="producto-card">
                        <span class="badge-categoria">{{ $producto->categoria ?? 'General' }}</span>
                        <div class="img-box">
                            <img src="{{ $producto->imagen_url ? asset($producto->imagen_url) : asset('img/logo.jpeg') }}" alt="{{ $producto->nombre }}">
                        </div>
                        <div class="producto-info">
                            <span class="especie-tag"><i class="fa-solid fa-paw"></i> Stock disponible: {{ $producto->stock }}</span>
                            <h3 class="producto-titulo">{{ $producto->nombre }}</h3>
                            <div class="estrellas">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                                <span>(4.9)</span>
                            </div>
                            <div class="precio-box">
                                <span class="precio-actual">$ {{ number_format($producto->precio, 0, ',', '.') }}</span>
                            </div>

                            <!-- Selector de Cantidad + Botón -->
                            <div class="compras-acciones">
                                <div class="contador-cantidad">
                                    <button type="button" class="btn-cant">-</button>
                                    <input type="number" value="1" min="1" max="{{ $producto->stock > 0 ? $producto->stock : 10 }}" readonly>
                                    <button type="button" class="btn-cant">+</button>
                                </div>
                                <button type="button" class="btn-agregar-carrito"><i class="fa-solid fa-cart-plus"></i> Agregar</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Catálogo base de referencia -->
                    <!-- Producto 1 -->
                    <div class="producto-card">
                        <span class="badge-categoria">Alimento</span>
                        <div class="img-box">
                            <img src="{{ asset('img/Alimento Chunky Adulto Pollo 8kg.jpg') }}" alt="Alimento balanceado perros">
                        </div>
                        <div class="producto-info">
                            <span class="especie-tag"><i class="fa-solid fa-dog"></i> Perros • Adulto</span>
                            <h3 class="producto-titulo">Alimento Chunky Adulto Pollo 8kg</h3>
                            <div class="estrellas">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                                <span>(4.8)</span>
                            </div>
                            <div class="precio-box">
                                <span class="precio-actual">$ 65.000</span>
                                <span class="precio-anterior">$ 72.000</span>
                            </div>

                            <div class="compras-acciones">
                                <div class="contador-cantidad">
                                    <button type="button" class="btn-cant">-</button>
                                    <input type="number" value="1" min="1" max="10" readonly>
                                    <button type="button" class="btn-cant">+</button>
                                </div>
                                <button type="button" class="btn-agregar-carrito"><i class="fa-solid fa-cart-plus"></i> Agregar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Producto 2 -->
                    <div class="producto-card">
                        <span class="badge-categoria">Juguetes</span>
                        <div class="img-box">
                            <img src="{{ asset('img/Torre Rascador Multinivel Felino.jpg') }}" alt="Rascador para gatos">
                        </div>
                        <div class="producto-info">
                            <span class="especie-tag"><i class="fa-solid fa-cat"></i> Gatos • Todas las edades</span>
                            <h3 class="producto-titulo">Torre Rascador Multinivel Felino</h3>
                            <div class="estrellas">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <div class="precio-box">
                                <span class="precio-actual">$ 110.000</span>
                            </div>

                            <div class="compras-acciones">
                                <div class="contador-cantidad">
                                    <button type="button" class="btn-cant">-</button>
                                    <input type="number" value="1" min="1" max="10" readonly>
                                    <button type="button" class="btn-cant">+</button>
                                </div>
                                <button type="button" class="btn-agregar-carrito"><i class="fa-solid fa-cart-plus"></i> Agregar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Producto 3 -->
                    <div class="producto-card">
                        <span class="badge-categoria">Higiene</span>
                        <div class="img-box">
                            <img src="{{ asset('img/Shampoo Hipoalergénico Aloe 500ml.jpg') }}" alt="Shampoo veterinario">
                        </div>
                        <div class="producto-info">
                            <span class="especie-tag"><i class="fa-solid fa-paw"></i> Perros & Gatos • Cachorro</span>
                            <h3 class="producto-titulo">Shampoo Hipoalergénico Aloe 500ml</h3>
                            <div class="estrellas">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <span>(4.2)</span>
                            </div>
                            <div class="precio-box">
                                <span class="precio-actual">$ 28.000</span>
                            </div>

                            <div class="compras-acciones">
                                <div class="contador-cantidad">
                                    <button type="button" class="btn-cant">-</button>
                                    <input type="number" value="1" min="1" max="10" readonly>
                                    <button type="button" class="btn-cant">+</button>
                                </div>
                                <button type="button" class="btn-agregar-carrito"><i class="fa-solid fa-cart-plus"></i> Agregar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Producto 4 -->
                    <div class="producto-card">
                        <span class="badge-categoria">Accesorios</span>
                        <div class="img-box">
                            <img src="{{ asset('img/Cama Ortopédica Acolchada Talla M.png') }}" alt="Cama para mascota">
                        </div>
                        <div class="producto-info">
                            <span class="especie-tag"><i class="fa-solid fa-dog"></i> Perros • Senior</span>
                            <h3 class="producto-titulo">Cama Ortopédica Acolchada Talla M</h3>
                            <div class="estrellas">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span>(4.9)</span>
                            </div>
                            <div class="precio-box">
                                <span class="precio-actual">$ 85.000</span>
                            </div>

                            <div class="compras-acciones">
                                <div class="contador-cantidad">
                                    <button type="button" class="btn-cant">-</button>
                                    <input type="number" value="1" min="1" max="10" readonly>
                                    <button type="button" class="btn-cant">+</button>
                                </div>
                                <button type="button" class="btn-agregar-carrito"><i class="fa-solid fa-cart-plus"></i> Agregar</button>
                            </div>
                        </div>
                    </div>
                @endforelse

            </div>
        </section>

    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/tienda.js') }}"></script>
@endpush