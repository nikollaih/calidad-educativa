@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
    >
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Crear Institución</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('institution.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre_ie" class="form-label required">Nombre de la Institución Educativa (IE) <span class="text-danger">*</span></label>
                                <div
                                    data-component="CTextInput"
                                    data-name="nombre"
                                    data-isRequired="true"
                                >
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dane" class="form-label">Código DANE <span class="text-danger">*</span></label>
                                <div
                                    data-component="CNumberInput"
                                    data-name="dane"
                                    data-tipo="entero"
                                    data-rango="positivo"
                                    data-isRequired="true"
                                >
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span> </label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="licencia_funcionamiento" class="form-label">Licencia de Funcionamiento <span class="text-danger">*</span></label>
                                <input type="file" name="licencia_funcionamiento" class="form-control" accept="application/pdf" required>
                            </div>
                            <div class="mb-3">
                                <label for="modelos" class="form-label">Municipio</label>
                                <select name="municipio_id" class="form-control" >
                                    @foreach($municipios as $municipio)
                                        <option value="{{ $municipio->id }}">{{ $municipio->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono_ie" class="form-label">Teléfono de la IE</label>
                                <input type="text" name="telefono" class="form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT <span class="text-danger">*</span></label>
                                <div
                                    data-component="CNumberInput"
                                    data-name="nit"
                                    data-tipo="entero"
                                    data-rango="positivo"
                                    data-isRequired="true"
                                >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pagina_web" class="form-label">Página Web</label>
                                <input type="text" name="web_url" class="form-control">
                            </div>


                            <div class="mb-3">
                                <label for="nombre_rector" class="form-label">Nombre del Rector <span class="text-danger">*</span></label>
                                <div
                                    data-component="CTextInput"
                                    data-name="nombre_rector"
                                >
                                </div>
                            </div>

                            <div
                                data-component="TextMultipleTags"
                            >
                        </div>
                    </div>

                    <!-- Redes Sociales -->
                    <div class="mb-3">
                        <label class="form-label">Redes Sociales</label>
                        <div id="redes-sociales-container" class="row">
                            @php
                                $redes = [
                                     ['icono' => 'fa-facebook', 'nombre' => 'Facebook'],
                                     ['icono' => 'fa-x-twitter', 'nombre' => 'X (Twitter)'],
                                     ['icono' => 'fa-instagram', 'nombre' => 'Instagram'],
                                     ['icono' => 'fa-linkedin', 'nombre' => 'LinkedIn'],
                                     ['icono' => 'fa-youtube', 'nombre' => 'YouTube'],
                                     ['icono' => 'fa-whatsapp', 'nombre' => 'WhatsApp'],
                                     ['icono' => 'fa-tiktok', 'nombre' => 'TikTok'],
                                     ['icono' => 'fa-telegram', 'nombre' => 'Telegram'],
                                     ['icono' => 'fa-discord', 'nombre' => 'Discord'],
                                     ['icono' => 'fa-snapchat', 'nombre' => 'Snapchat'],
                                     ['icono' => 'fa-reddit', 'nombre' => 'Reddit'],
                                     ['icono' => 'fa-pinterest', 'nombre' => 'Pinterest'],
                                 ];

                            @endphp

                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" onclick="mostrarSelectorRed()">Agregar red social</button>
                                </div>
                                <div class="col-md-4 d-none" id="selector-red">
                                    <select id="red-select" class="form-select" onchange="agregarRedSocial()">
                                        <option value="">Selecciona una red social</option>
                                        @foreach ($redes as $red)
                                            <option value="{{ $red['nombre'] }}" data-icono="{{ $red['icono'] }}">{{ $red['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div id="redes-sociales-container" class="row"></div>

                            <script>
                                const redesDisponibles = @json($redes);
                                const usadas = new Set();

                                function mostrarSelectorRed() {
                                    const selector = document.getElementById('selector-red');
                                    selector.classList.remove('d-none');
                                    selector.querySelector('select').focus();
                                }

                                function agregarRedSocial() {
                                    const select = document.getElementById('red-select');
                                    const nombre = select.value;
                                    const icono = select.selectedOptions[0]?.dataset.icono;

                                    if (!nombre || usadas.has(nombre)) return;

                                    usadas.add(nombre);
                                    const index = usadas.size - 1;

                                    const container = document.getElementById('redes-sociales-container');

                                    const html = `
                                        <div class="col-md-6 mb-3" data-red="${nombre}">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fab ${icono} fa-2x me-3"></i>
                                                            <strong>${nombre}</strong>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarRed('${nombre}', this)">×</button>
                                                    </div>
                                                    <label class="form-label mt-2">URL</label>
                                                    <input hidden name="redes_sociales[${index}][nombre]" value="${nombre}">
                                                    <input type="url" name="redes_sociales[${index}][url]" class="form-control"
                                                           placeholder="Ej: https://${nombre.toLowerCase().replace(/[^a-z]/g, '')}.com">
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    container.insertAdjacentHTML('beforeend', html);

                                    // Ocultar y resetear el selector
                                    document.getElementById('selector-red').classList.add('d-none');
                                    select.selectedIndex = 0;
                                }

                                function eliminarRed(nombre, btn) {
                                    usadas.delete(nombre);
                                    const card = btn.closest(`[data-red="${nombre}"]`);
                                    if (card) card.remove();
                                }
                            </script>

                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fas fa-save "></i> Guardar
                        </button>
                        <a href="{{ route('institution.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
