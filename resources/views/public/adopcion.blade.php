@extends('layouts.app')

@section('title', 'Adopción Responsable - Animapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/adopcion.css') }}">
    <style>
        .modal-adopcion-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 9999;
            overflow-y: auto;
            padding: 20px;
        }
        .modal-adopcion-card {
            background: #fff;
            max-width: 780px;
            margin: 20px auto;
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            position: relative;
        }
        .modal-adopcion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .modal-adopcion-header h2 {
            margin: 0;
            color: #005f73;
            font-size: 1.35rem;
        }
        .btn-cerrar-modal {
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            cursor: pointer;
            font-weight: bold;
        }
        .eval-section-title {
            background: #e6f4f1;
            color: #005f73;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 700;
            margin: 16px 0 10px;
            font-size: 0.95rem;
        }
        .eval-grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 12px;
        }
        .eval-field {
            margin-bottom: 12px;
        }
        .eval-field label {
            display: block;
            font-weight: 600;
            font-size: 0.88rem;
            margin-bottom: 4px;
            color: #222;
        }
        .eval-field small {
            display: block;
            color: #555;
            font-size: 0.8rem;
            margin-bottom: 5px;
        }
        .eval-field input, .eval-field select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 0.9rem;
        }
        .puntaje-live-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 15px;
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
@endpush

@section('content')
    <!-- BANNER HERO DE ADOPCIÓN -->
    <section class="adopcion-hero">
        <div class="hero-overlay">
            <h1>¡Adopta al amor de tu vida hoy mismo!</h1>
            <p>El próximo capítulo de tu vida te está esperando. Conoce a nuestras mascotas en adopción responsable.</p>
        </div>
    </section>

    <!-- CONTENEDOR PRINCIPAL: TARJETAS DE MASCOTAS + GUÍA DE PASOS -->
    <main class="adopcion-layout container">
        
        <!-- SECCIÓN IZQUIERDA: CATÁLOGO DE MASCOTAS EN ADOPCIÓN -->
        <section class="mascotas-seccion">
            <div class="seccion-titulo">
                <h2>Mascotas Disponibles</h2>
                <p>Mascotas rescatadas en alianzas con fundaciones cercanas a Engativá y Bogotá D.C.</p>
            </div>

            <div class="grid-mascotas">

                {{-- Mascotas dinámicas desde la base de datos --}}
                @forelse($mascotas as $mascota)
                    <div class="mascota-card">
                        <div class="img-box">
                            <img src="{{ $mascota->imagen ? asset($mascota->imagen) : asset('img/logo.jpeg') }}" alt="{{ $mascota->nombre_mascota }}">
                            <span class="badge-especie"><i class="fa-solid fa-paw"></i> {{ $mascota->especie }}</span>
                        </div>
                        <div class="mascota-info">
                            <h3 class="mascota-nombre">{{ $mascota->nombre_mascota }}</h3>
                            <p class="fundacion-tag"><i class="fa-solid fa-location-dot"></i> Sede Animapp Engativá - Bogotá</p>
                            
                            <ul class="mascota-detalles">
                                <li><strong>Raza:</strong> {{ $mascota->raza ?? 'Mestizo' }}</li>
                                <li><strong>Edad:</strong> {{ $mascota->edad_aproximada ?? 'No especificada' }}</li>
                                <li><strong>Estado:</strong> {{ $mascota->estado_adopcion }}</li>
                                @if($mascota->descripcion)
                                    <li><strong>Salud/Nota:</strong> {{ $mascota->descripcion }}</li>
                                @endif
                            </ul>

                            @if($mascota->estado_adopcion === 'Disponible')
                                <button type="button" class="btn-adoptar" data-nombre="{{ $mascota->nombre_mascota }}" data-id="{{ $mascota->id }}">
                                    <i class="fa-solid fa-heart"></i> ¡Quiero Adoptar a {{ $mascota->nombre_mascota }}!
                                </button>
                            @else
                                <button type="button" class="btn-adoptar" disabled style="background-color: #6c757d; cursor: not-allowed;">
                                    <i class="fa-solid fa-clock"></i> {{ $mascota->estado_adopcion }}
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <!-- Catálogo base de referencia (Bruno, Mia, Tambor, Luna) -->
                    <div class="mascota-card">
                        <div class="img-box">
                            <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=500&auto=format&fit=crop" alt="Perro Bruno">
                            <span class="badge-especie"><i class="fa-solid fa-dog"></i> Perro</span>
                        </div>
                        <div class="mascota-info">
                            <h3 class="mascota-nombre">Bruno</h3>
                            <p class="fundacion-tag"><i class="fa-solid fa-location-dot"></i> Fundación Huellitas Engativá</p>
                            <ul class="mascota-detalles">
                                <li><strong>Edad:</strong> 2 Años</li>
                                <li><strong>Tamaño:</strong> Mediano</li>
                                <li><strong>Sexo:</strong> Macho (Esterilizado)</li>
                                <li><strong>Salud:</strong> Vacunas al día y desparasitado</li>
                            </ul>
                            <button type="button" class="btn-adoptar" data-nombre="Bruno" data-id="">
                                <i class="fa-solid fa-heart"></i> ¡Quiero Adoptar a Bruno!
                            </button>
                        </div>
                    </div>

                    <div class="mascota-card">
                        <div class="img-box">
                            <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=500&auto=format&fit=crop" alt="Gata Mia">
                            <span class="badge-especie"><i class="fa-solid fa-cat"></i> Gato</span>
                        </div>
                        <div class="mascota-info">
                            <h3 class="mascota-nombre">Mia</h3>
                            <p class="fundacion-tag"><i class="fa-solid fa-location-dot"></i> Fundación San Francisco Bogotá</p>
                            <ul class="mascota-detalles">
                                <li><strong>Edad:</strong> 8 Meses</li>
                                <li><strong>Tamaño:</strong> Pequeño</li>
                                <li><strong>Sexo:</strong> Hembra (Esterilizada)</li>
                                <li><strong>Salud:</strong> Triple felina al día</li>
                            </ul>
                            <button type="button" class="btn-adoptar" data-nombre="Mia" data-id="">
                                <i class="fa-solid fa-heart"></i> ¡Quiero Adoptar a Mia!
                            </button>
                        </div>
                    </div>

                    <div class="mascota-card">
                        <div class="img-box">
                            <img src="https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?q=80&w=500&auto=format&fit=crop" alt="Conejo Tambor">
                            <span class="badge-especie"><i class="fa-solid fa-paw"></i> Conejo</span>
                        </div>
                        <div class="mascota-info">
                            <h3 class="mascota-nombre">Tambor</h3>
                            <p class="fundacion-tag"><i class="fa-solid fa-location-dot"></i> Rescate Silvestre & Exóticos</p>
                            <ul class="mascota-detalles">
                                <li><strong>Edad:</strong> 1 Año</li>
                                <li><strong>Tamaño:</strong> Pequeño</li>
                                <li><strong>Sexo:</strong> Macho</li>
                                <li><strong>Salud:</strong> Chequeo veterinario completo</li>
                            </ul>
                            <button type="button" class="btn-adoptar" data-nombre="Tambor" data-id="">
                                <i class="fa-solid fa-heart"></i> ¡Quiero Adoptar a Tambor!
                            </button>
                        </div>
                    </div>

                    <div class="mascota-card">
                        <div class="img-box">
                            <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?q=80&w=500&auto=format&fit=crop" alt="Perra Luna">
                            <span class="badge-especie"><i class="fa-solid fa-dog"></i> Perro</span>
                        </div>
                        <div class="mascota-info">
                            <h3 class="mascota-nombre">Luna</h3>
                            <p class="fundacion-tag"><i class="fa-solid fa-location-dot"></i> Amigos Peludos Calle 80</p>
                            <ul class="mascota-detalles">
                                <li><strong>Edad:</strong> 3 Años</li>
                                <li><strong>Tamaño:</strong> Grande</li>
                                <li><strong>Sexo:</strong> Hembra (Esterilizada)</li>
                                <li><strong>Salud:</strong> Carné completo y microchip</li>
                            </ul>
                            <button type="button" class="btn-adoptar" data-nombre="Luna" data-id="">
                                <i class="fa-solid fa-heart"></i> ¡Quiero Adoptar a Luna!
                            </button>
                        </div>
                    </div>
                @endforelse

            </div>
        </section>

        <!-- SECCIÓN DERECHA: PASO A PASO + APADRINAMIENTO Y VOLUNTARIADO -->
        <aside class="pasos-sidebar">
            <div class="pasos-box">
                <div class="pasos-header">
                    <h3><i class="fa-solid fa-clipboard-check"></i> Proceso de Adopción Responsable</h3>
                    <p>Sigue estas 4 etapas para completar la adopción:</p>
                </div>

                <div class="timeline-pasos">
                    <div class="paso-item">
                        <div class="paso-numero">1</div>
                        <div class="paso-contenido">
                            <h4>Formulario de Idoneidad (30 pts)</h4>
                            <p>Completa la plantilla oficial de valoración integral en el sistema.</p>
                        </div>
                    </div>

                    <div class="paso-item">
                        <div class="paso-numero">2</div>
                        <div class="paso-contenido">
                            <h4>Entrevista Presencial</h4>
                            <p>Charla breve en la veterinaria o con la fundación para resolver dudas sobre el cuidado.</p>
                        </div>
                    </div>

                    <div class="paso-item">
                        <div class="paso-numero">3</div>
                        <div class="paso-contenido">
                            <h4>Visita de Verificación</h4>
                            <p>El administrador programará una visita domiciliaria para garantizar seguridad y bienestar.</p>
                        </div>
                    </div>

                    <div class="paso-item">
                        <div class="paso-numero">4</div>
                        <div class="paso-contenido">
                            <h4>Dictamen Final & Entrega</h4>
                            <p><strong>25–30 pts:</strong> Aprobado.<br>
                            <strong>18–24 pts:</strong> Aprobado con condiciones.<br>
                            <strong>&lt; 18 pts:</strong> No aprobado.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pasos-box" style="margin-top: 20px;">
                <div class="pasos-header">
                    <h3><i class="fa-solid fa-hand-holding-heart"></i> ¿Quieres ayudar sin adoptar?</h3>
                    <p>Existen otras formas valiosas de apoyar a nuestros peludos rescatados:</p>
                </div>

                <div style="padding: 10px 0;">
                    <div style="margin-bottom: 15px;">
                        <h4 style="font-size: 1rem; color: #005f73; margin-bottom: 5px;"><i class="fa-solid fa-box-open"></i> Apadrinar o Donar</h4>
                        <p style="font-size: 0.9rem; color: #555; margin-bottom: 10px;">Contribuye con su alimentación, vacunación o suministros físicos.</p>
                        
                        <label for="periodo-aporte" style="display: block; font-size: 0.85rem; font-weight: bold; margin-bottom: 5px;">Selecciona tu tipo de aporte:</label>
                        <select id="periodo-aporte" name="periodo_aporte" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc; margin-bottom: 10px;">
                            <optgroup label="Apadrinamiento monetario">
                                <option value="7">7 días ($30.000 COP)</option>
                                <option value="15">15 días ($60.000 COP)</option>
                                <option value="30">30 días ($110.000 COP)</option>
                            </optgroup>
                            <optgroup label="Donación en especie / Suministros">
                                <option value="alimento">Donación de Alimento (Concentrado/Latas)</option>
                                <option value="insumos">Insumos y Medicamentos Veterinarios</option>
                                <option value="accesorios">Accesorios (Cobijas, juguetes, camas)</option>
                                <option value="otro">Otro tipo de donación física</option>
                            </optgroup>
                        </select>
                        <button type="button" id="btn-apadrinar" class="btn-adoptar" style="width: 100%; padding: 10px; background-color: #005f73; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            Continuar con el aporte
                        </button>
                    </div>

                    <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">

                    <div>
                        <h4 style="font-size: 1rem; color: #005f73; margin-bottom: 5px;"><i class="fa-solid fa-users"></i> Ser Voluntario</h4>
                        <p style="font-size: 0.9rem; color: #555; margin-bottom: 10px;">Apóyanos en jornadas de adopción, bienestar animal, eventos y logística en la sede.</p>
                        <button type="button" id="btn-voluntario" class="btn-adoptar" style="width: 100%; padding: 10px; background-color: #2a9d8f; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            Quiero ser voluntario
                        </button>
                    </div>
                </div>
            </div>
        </aside>

    </main>

    <!-- MODAL OFICIAL: PLANTILLA DE EVALUACIÓN Y PUNTUACIÓN PARA ADOPCIÓN (30 PUNTOS) -->
    <div id="modal-evaluacion-adopcion"
        class="modal-adopcion-backdrop"
        data-logueado="{{ Auth::check() ? '1' : '0' }}"
        data-login-url="{{ route('login') }}">
        <div class="modal-adopcion-card">
            <div class="modal-adopcion-header">
                <h2><i class="fa-solid fa-clipboard-check"></i> Evaluación de Adopción: <span id="modal-nombre-mascota">Mascota</span></h2>
                <button type="button" class="btn-cerrar-modal" id="btn-cerrar-modal">X Cerrar</button>
            </div>

            <form action="{{ route('adopcion.solicitar') }}" method="POST" id="form-evaluacion-30">
                @csrf
                <input type="hidden" name="mascota_id" id="input-mascota-id">
                <input type="hidden" name="nombre_mascota" id="input-nombre-mascota">

                <div class="eval-section-title">1. Datos Generales del Solicitante</div>
                <div class="eval-grid-2">
                    <div class="eval-field">
                        <label>Solicitante / Adoptante</label>
                        <input type="text" value="{{ Auth::check() ? Auth::user()->nombre : '' }}" readonly style="background: #f1f3f5;">
                    </div>
                    <div class="eval-field">
                        <label>Documento de Identidad *</label>
                        <input type="text" name="documento_identidad" required placeholder="Ej: 1012345678">
                    </div>
                    <div class="eval-field">
                        <label>Teléfono de Contacto *</label>
                        <input type="text" name="telefono_contacto" required placeholder="Ej: 310 123 4567">
                    </div>
                </div>

                <div class="eval-section-title">2. Requisitos Básicos (Verificación Obligatoria Excluyente)</div>
                <div class="eval-grid-2">
                    <div class="eval-field">
                        <label>¿Cuenta con documento de identidad vigente? *</label>
                        <select name="req_documento" class="req-basico" required>
                            <option value="Si">Sí</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="eval-field">
                        <label>¿Cuenta con comprobante de domicilio actual? *</label>
                        <select name="req_domicilio" class="req-basico" required>
                            <option value="Si">Sí</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="eval-field">
                        <label>¿Acepta entrevista y visita domiciliaria previa? *</label>
                        <select name="req_visita" class="req-basico" required>
                            <option value="Si">Sí</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="eval-field">
                        <label>¿Disposición para firma de contrato y seguimiento? *</label>
                        <select name="req_contrato" class="req-basico" required>
                            <option value="Si">Sí</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>

                <div class="eval-section-title">3. Matriz de Evaluación Puntuada (6 Categorías × 5 pts = 30 pts)</div>

                <div class="eval-field">
                    <label>1. Entorno y Vivienda (Máx. 5 pts) *</label>
                    <small>¿El espacio es seguro (rejas, balcones protegidos, cerramientos) y cuenta con autorización explícita para mascotas?</small>
                    <select name="c1_entorno" class="criterio-score" required>
                        <option value="5">5 pts - Excelente: Vivienda propia o con autorización escrita y totalmente segura/protegida</option>
                        <option value="4">4 pts - Bueno: Segura, requiere ajuste menor de cerramiento</option>
                        <option value="3">3 pts - Aceptable: Espacio mínimo adecuado, requiere recomendaciones</option>
                        <option value="2">2 pts - Deficiente: Riesgos moderados en balcones/puertas o sin permiso claro</option>
                        <option value="1">1 pt - Inadecuado: No cumple condiciones mínimas o prohíben mascotas</option>
                    </select>
                </div>

                <div class="eval-field">
                    <label>2. Situación Familiar (Máx. 5 pts) *</label>
                    <small>¿Todos los miembros del hogar están de acuerdo y se evaluó convivencia con niños o alergias?</small>
                    <select name="c2_familia" class="criterio-score" required>
                        <option value="5">5 pts - Excelente: 100% acuerdo familiar, sin alergias ni riesgos de convivencia</option>
                        <option value="4">4 pts - Bueno: Acuerdo general con supervisión en niños menores</option>
                        <option value="3">3 pts - Aceptable: Requiere acuerdo explícito de un miembro del hogar</option>
                        <option value="2">2 pts - Deficiente: Dudas o antecedentes de alergias leves sin control</option>
                        <option value="1">1 pt - Inadecuado: Desacuerdo familiar o alergias severas</option>
                    </select>
                </div>

                <div class="eval-field">
                    <label>3. Estilo de Vida y Tiempo (Máx. 5 pts) *</label>
                    <small>Tiempo que pasará sola la mascota al día, rutinas de paseo/juego y plan de cuidado en viajes.</small>
                    <select name="c3_tiempo" class="criterio-score" required>
                        <option value="5">5 pts - Excelente: Menos de 4h sola al día, paseos diarios y red de apoyo en viajes</option>
                        <option value="4">4 pts - Bueno: 4 a 6h sola al día con rutinas activas aseguradas</option>
                        <option value="3">3 pts - Aceptable: 6 a 8h sola, compensado con paseos y enriquecimiento</option>
                        <option value="2">2 pts - Deficiente: Más de 8h sola al día sin apoyo definido</option>
                        <option value="1">1 pt - Inadecuado: Sin tiempo disponible ni plan durante ausencias</option>
                    </select>
                </div>

                <div class="eval-field">
                    <label>4. Capacidad Económica (Máx. 5 pts) *</label>
                    <small>Presupuesto estable para alimentación de calidad, vacunas, desparasitación y fondo de emergencias.</small>
                    <select name="c4_economica" class="criterio-score" required>
                        <option value="5">5 pts - Excelente: Presupuesto estable + fondo dedicado para emergencias veterinarias</option>
                        <option value="4">4 pts - Bueno: Cubre alimentación, vacunas y controles periódicos sin dificultad</option>
                        <option value="3">3 pts - Aceptable: Cubre gastos básicos, margen ajustado para imprevistos</option>
                        <option value="2">2 pts - Deficiente: Ingresos inestables para mantener esquema preventivo</option>
                        <option value="1">1 pt - Inadecuado: No cuenta con recursos para manutención básica</option>
                    </select>
                </div>

                <div class="eval-field">
                    <label>5. Experiencia y Compromiso (Máx. 5 pts) *</label>
                    <small>Historial previo de tenencia responsable y compromiso de por vida (10–15+ años).</small>
                    <select name="c5_experiencia" class="criterio-score" required>
                        <option value="5">5 pts - Excelente: Experiencia previa positiva y compromiso total a largo plazo</option>
                        <option value="4">4 pts - Bueno: Primerizo bien informado y dispuesto a educación/adaptación</option>
                        <option value="3">3 pts - Aceptable: Experiencia básica, requiere guía en etapa de adaptación</option>
                        <option value="2">2 pts - Deficiente: Poco conocimiento sobre cuidados de largo plazo</option>
                        <option value="1">1 pt - Inadecuado: Antecedentes de abandono o falta de compromiso</option>
                    </select>
                </div>

                <div class="eval-field">
                    <label>6. Otras Mascotas / Preparación en el Hogar (Máx. 5 pts) *</label>
                    <small>Si hay otros animales: ¿son sociables, esterilizados y vacunados? (Si no hay, puntuar según preparación).</small>
                    <select name="c6_otras_mascotas" class="criterio-score" required>
                        <option value="5">5 pts - Excelente: Mascotas actuales esterilizadas/vacunadas o hogar 100% preparado</option>
                        <option value="4">4 pts - Bueno: Convivencia compatible con adaptación gradual</option>
                        <option value="3">3 pts - Aceptable: Requiere completar refuerzo o esterilización previa</option>
                        <option value="2">2 pts - Deficiente: Mascotas previas sin esquema sanitario al día</option>
                        <option value="1">1 pt - Inadecuado: Riesgo sanitario o agresividad comprobada</option>
                    </select>
                </div>

                <div class="puntaje-live-box">
                    <div>
                        <strong>Puntaje Calculado: <span id="live-puntos" style="color: #005f73; font-size: 1.15rem;">30</span> / 30 pts</strong><br>
                        <small id="live-dictamen" style="font-weight: 700; color: #198754;">Dictamen Preliminar: APROBADO (25 a 30 pts)</small>
                    </div>
                    <button type="submit" class="btn-adoptar" style="margin: 0; padding: 12px 22px;">
                        <i class="fa-solid fa-paper-plane"></i> Enviar Solicitud de Adopción
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modal-evaluacion-adopcion');
        const estaLogueado = modal.dataset.logueado === '1';
        const urlLogin = modal.dataset.loginUrl;
        const btnCerrar = document.getElementById('btn-cerrar-modal');

        function recalcularPuntaje() {
            let suma = 0;
            document.querySelectorAll('.criterio-score').forEach(sel => {
                suma += parseInt(sel.value || '0', 10);
            });

            let cumpleBasicos = true;
            document.querySelectorAll('.req-basico').forEach(req => {
                if (req.value !== 'Si') cumpleBasicos = false;
            });

            document.getElementById('live-puntos').textContent = suma;
            const dictamenEl = document.getElementById('live-dictamen');

            if (!cumpleBasicos || suma < 18) {
                dictamenEl.textContent = 'Dictamen Preliminar: NO APROBADO (Menos de 18 pts o incumple requisito básico)';
                dictamenEl.style.color = '#dc3545';
            } else if (suma >= 25) {
                dictamenEl.textContent = 'Dictamen Preliminar: APROBADO (25 a 30 pts - Condiciones óptimas)';
                dictamenEl.style.color = '#198754';
            } else {
                dictamenEl.textContent = 'Dictamen Preliminar: APROBADO CON CONDICIONES (18 a 24 pts)';
                dictamenEl.style.color = '#d97706';
            }
        }

        document.querySelectorAll('.criterio-score, .req-basico').forEach(el => {
            el.addEventListener('change', recalcularPuntaje);
        });

        document.querySelectorAll('.btn-adoptar[data-nombre]').forEach(btn => {
            btn.addEventListener('click', () => {
                const nombreMascota = btn.dataset.nombre;
                const idMascota = btn.dataset.id;

                if (!estaLogueado) {
                    Swal.fire({
                        title: "Inicia sesión para adoptar",
                        text: "Debes tener una cuenta activa en Animapp para diligenciar la evaluación de adopción.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#005f73",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Iniciar sesión",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = urlLogin;
                        }
                    });
                    return;
                }

                document.getElementById('modal-nombre-mascota').textContent = nombreMascota;
                document.getElementById('input-mascota-id').value = idMascota || '';
                document.getElementById('input-nombre-mascota').value = nombreMascota;
                recalcularPuntaje();
                modal.style.display = 'block';
            });
        });

        btnCerrar.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        const btnApadrinar = document.getElementById('btn-apadrinar');
        if (btnApadrinar) {
            btnApadrinar.addEventListener('click', () => {
                const selectDias = document.getElementById("periodo-aporte");
                const valorSeleccionado = selectDias.value;
                const textoSeleccionado = selectDias.options[selectDias.selectedIndex].text;

                if (isNaN(valorSeleccionado)) {
                    Swal.fire({
                        title: "¡Gracias por tu generosidad!",
                        text: "Has seleccionado: " + textoSeleccionado + ". Nos pondremos en contacto contigo para coordinar la entrega en nuestra sede de Animapp.",
                        icon: "success",
                        confirmButtonColor: "#005f73",
                        confirmButtonText: "Coordinar entrega"
                    });
                } else {
                    Swal.fire({
                        title: "¡Gracias por tu generosidad!",
                        text: "Has seleccionado apadrinar por un período de: " + textoSeleccionado + ". Te guiaremos al sistema de pago seguro.",
                        icon: "success",
                        confirmButtonColor: "#005f73",
                        confirmButtonText: "Continuar con el pago"
                    });
                }
            });
        }

        const btnVoluntario = document.getElementById('btn-voluntario');
        if (btnVoluntario) {
            btnVoluntario.addEventListener('click', () => {
                Swal.fire({
                    title: "¡Únete a nuestro equipo!",
                    text: "Nos alegra mucho tu interés en ser voluntario en Animapp. Te redirigiremos al registro de voluntarios.",
                    icon: "info",
                    confirmButtonColor: "#2a9d8f",
                    confirmButtonText: "Inscribirme"
                });
            });
        }
    });
</script>
@endpush