@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('institution.index') }}" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-primary btn-sm">Perfil</a>
            <a href="{{ route('institution.pei', $institution->id) }}" class="btn btn-outline-success  btn-sm">PEI</a>
            <a href="{{ route('institution.autoevaluaciones', $institution->id) }}" class="btn btn-outline-info btn-sm">Autoevaluación</a>
            <a href="{{ route('pmi.index', $institution->id) }}" class="btn btn-outline-secondary  btn-sm">PMI</a>
            <a href="{{ route('proyectos_transversales.index', $institution->id) }}" class="btn btn-outline-warning btn-sm">PPT</a>
        </div>
    </div>
    <div class="m-6 !border border-custom-blue-light rounded-md bg-white">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="m-3">
            <h1 class="p-2 px-3 text-custom-primary">Editar Institución</h1>
            <div class="card-body">
                <form action="{{ route('institution.update',$institution->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <div
                                data-component="CInputComponent"
                                data-label="Nombre de la Institución Educativa (IE)"
                                data-input-name="nombre"
                                data-input-type="c_text_input"
                                data-input-value="{{ $institution->nombre }}"
                                data-is-disabled="{{false}}"
                                data-is-required="{{true}}"
                            ></div>
                            <div class="mb-3">
                                <label for="dane" class="block text-sm mb-2 ml-4">Código DANE <span class="text-danger">*</span></label>
                                <div
                                    data-component="CNumberInput"
                                    data-name="dane"
                                    data-value="{{ $institution->dane }}"
                                    data-tipo="entero"
                                    data-rango="positivo"
                                    data-is-required="true"
                                >
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="block text-sm mb-2 ml-4">Correo Electrónico  <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" value="{{ $institution->email }}" required>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="licencia_funcionamiento" class="block text-sm mb-2 ml-4">Licencia de Funcionamiento <span class="text-danger">*</span></label>
                                    @if(isset($institution->licenciaFuncionamiento))
                                        <a href="{{ $institution->licenciaFuncionamiento->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver Licencia Actual
                                        </a>
                                    @endif
                                </div>
                                <input type="file" name="licencia_funcionamiento" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" accept="application/pdf" >
                            </div>
                            <div class="mb-3">
                                <label for="sede_principal_id" class="block text-sm mb-2 ml-4">Municipio</label>
                                <select name="municipio_id" id="sede_principal_id" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill">
                                    <option value="">Seleccione un municipio</option>
                                    @foreach ($municipios as $municipio)
                                        <option value="{{ $municipio->id }}" @selected($institution?->municipio_id== $municipio->id )>{{ $municipio->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono_ie" class="block text-sm mb-2 ml-4">Teléfono de la IE</label>
                                <input type="text" name="telefono" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" value={{ $institution->telefono }} >
                            </div>
                            <div class="mb-3">
                                <label for="nit" class="block text-sm mb-2 ml-4">NIT <span class="text-danger">*</span></label>
                                <div
                                    data-component="CNumberInput"
                                    data-name="nit"
                                    data-value="{{ $institution->nit }}"
                                    data-tipo="entero"
                                    data-rango="positivo"
                                    data-is-required="true"
                                >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pagina_web" class="block text-sm mb-2 ml-4">Página Web</label>
                                <input type="text" name="web_url" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" value="{{ $institution->web_url }}">
                            </div>

                            <div class="mb-3">
                                <label for="nombre_rector" class="block text-sm mb-2 ml-4">Rector<span class="text-danger">*</span></label>
                                <div
                                    data-component="CAutocompleteFromArray"
                                    data-data='@json($availableRectors)'
                                    data-field-name="rector_id"
                                    data-is-editable="{{ !( Auth::user()->hasRole('rector') && !(Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('administrador')) ) }}"
                                    data-initial-value="{{ Auth::user()->hasRole('rector') && !(Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('administrador')) ? Auth::user()->id : $institution->rector_id }}"
                                    data-order-by='@json(["field" => "id", "direction" => "asc"])'
                                    data-search-fields='@json(["name", "email"])'
                                    data-label-fields='@json(["name", "email"])'
                                ></div>


                            </div>
                            <div
                                data-component="TextMultipleTags"
                                data-initial-value="{{$institution->nombre_coordinadores}}"
                                data-is-editable="{{true}}"
                            >
                            </div>
                    </div>

                    <!-- Redes Sociales -->
                    <div class="mb-3">
                        <label class="block text-sm mb-2 ml-4">Redes Sociales</label>
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
                                ['icono' => 'fa-threads', 'nombre' => 'Threads'],
                            ];

                            $redesGuardadas = collect($institution?->redesSociales ?? []);
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

                        <div id="redes-sociales-container" class="row">
                            @foreach ($redes as $index => $red)
                                @php
                                    $social = $redesGuardadas->firstWhere('nombre', $red['nombre']);
                                @endphp
                                @if ($social)
                                    <div class="col-md-6 mb-3" data-red="{{ $red['nombre'] }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fab {{ $red['icono'] }} fa-2x me-3"></i>
                                                        <strong>{{ $red['nombre'] }}</strong>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarRed('{{ $red['nombre'] }}', this)">×</button>
                                                </div>
                                                <label class="block text-sm mb-2 ml-4 mt-2">URL</label>
                                                <input type="hidden" name="redes_sociales[{{ $index }}][nombre]" value="{{ $red['nombre'] }}">
                                                <input type="url" name="redes_sociales[{{ $index }}][url]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                                       placeholder="Ej: https://{{ strtolower($red['nombre']) }}.com"
                                                       value="{{ $social['url'] }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <script>
                            const redesDisponibles = @json($redes);
                            const redesIniciales = @json($redesGuardadas->pluck('nombre'));
                            const usadas = new Set(redesIniciales);

                            function mostrarSelectorRed() {
                                document.getElementById('selector-red').classList.remove('d-none');
                                document.getElementById('red-select').focus();
                            }

                            function agregarRedSocial() {
                                const select = document.getElementById('red-select');
                                const nombre = select.value;
                                const icono = select.selectedOptions[0]?.dataset.icono;

                                if (!nombre || usadas.has(nombre)) return;

                                usadas.add(nombre);
                                const index = document.querySelectorAll('#redes-sociales-container .col-md-6').length;

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
                                            <label class="block text-sm mb-2 ml-4 mt-2">URL</label>
                                            <input type="hidden" name="redes_sociales[${index}][nombre]" value="${nombre}">
                                            <input type="url" name="redes_sociales[${index}][url]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                                   placeholder="Ej: https://${nombre.toLowerCase().replace(/[^a-z]/g, '')}.com">
                                        </div>
                                    </div>
                                </div>
                            `;

                                container.insertAdjacentHTML('beforeend', html);

                                // Ocultar y resetear selector
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

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fas fa-save "></i> Guardar
                        </button>
                        <a href="{{ route('institution.show', $institution->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cerrar edición
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- seccion de las sedes asociadas a la institucion -->
    <div class=" pt-3">
    <div class="col-md-12">
        <div class="card">
            <h1 class="card-header">Sedes</h1>
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{ route('sede-with-institution.create',$institution->id) }}" class="btn btn-primary mb-3">Crear Sede</a>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DANE</th>
                            <th>DIRECCIÓN</th>
                            <th>ZONA</th>
                            <th>TIPO DE SEDE</th>
                            <th>ACCIONES</th>


                        </tr>
                        </thead>
                        <tbody>
                            <!-- Institución 1 -->
                             @foreach ($institution->sedes as $sede)
                            <tr>
                                <td>{{ $sede->name }}</td>
                                <td>{{ $sede->dane }}</td>
                                <td>{{ $sede->address }}</td>
                                <td>{{ $sede->zone }}</td>
                                <td>{{ $sede->parent_sede_id ? "Adscrita" : "Principal" }}</td>
                                <td>
                                    <a href="{{ route('sede-with-institution.show', ['institutionId' => $institution->id, 'sede_with_institution' => $sede->id]) }}" class="btn btn-primary btn-sm">Ver detalles</a>
                                    <a href="{{ route('sede-with-institution.edit', ['institutionId' => $institution->id, 'sede_with_institution' => $sede->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('sede.destroy', ['sede' => $sede->id]) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta sede?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                         </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- fin session de las sedes asociadas a la institucion -->
    <!-- seccion de las ofertas educativas vinculadas -->
    <div class=" pt-3">
    </div>

    <!-- fin session de las sedes asociadas a la institucion -->

@endsection
