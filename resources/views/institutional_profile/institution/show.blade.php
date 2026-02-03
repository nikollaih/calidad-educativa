@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.index') }}"
        data-detail-url="#"
        data-pei-url="{{ route('institution.pei', $institution->id) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institution->id) }}"
        data-pmi-url="{{ route('pmi.index', $institution->id) }}"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institution->id) }}"
        data-institution-name="{{ $institution->nombre }}"
    >
    </div>

    <div class="m-6 !border border-custom-blue-light rounded-md bg-white">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="m-3">
            <h1 class="p-2 px-3 text-custom-primary">Ver institución</h1>
            <div class="card-body">
                <form >
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <div
                                data-component="CInputComponent"
                                data-label="Nombre de la Institución Educativa (IE)"
                                data-input-name="nombre"
                                data-input-value="{{ $institution->nombre }}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div
                                data-component="CInputComponent"
                                data-label="Código DANE"
                                data-input-name="dane"
                                data-input-value="{{ $institution->dane }}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div
                                data-component="CInputComponent"
                                data-label="Correo Electrónico"
                                data-input-name="email"
                                data-input-value="{{ $institution->email }}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div
                                data-component="CInputComponent"
                                data-label="Correo Electrónico"
                                data-input-name="email"
                                data-input-value="{{ $institution->email }}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="licencia_funcionamiento" class="form-label mb-0">Licencia de Funcionamiento</label>
                                    @if(isset($institution->licenciaFuncionamiento))
                                        <a href="{{ $institution->licenciaFuncionamiento->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver Licencia Actual
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="sede_principal_id" class="form-label">Municipio</label>
                                <select name="municipio_id" id="sede_principal_id" class="form-control" disabled>
                                    <option value="">Seleccione un municipio</option>
                                    @foreach ($municipios as $municipio)
                                        <option value="{{ $municipio->id }}" @selected($institution?->municipio_id== $municipio->id )>{{ $municipio->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <div
                                data-component="CInputComponent"
                                data-label="Teléfono de la IE"
                                data-input-name="telefono"
                                data-input-value="{{ $institution->telefono }}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div
                                data-component="CInputComponent"
                                data-label="NIT"
                                data-input-name="nit"
                                data-input-value="{{ $institution->nit }}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div
                                data-component="CInputComponent"
                                data-label="Página Web"
                                data-input-name="web_url"
                                data-input-value="{{ $institution->web_url }}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div
                                data-component="CInputComponent"
                                data-label="Nombre del Rector"
                                data-input-name="nombre_rector"
                                data-input-value="{{ $institution?->rector?->name ?? "Sin rector"}}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div
                                data-component="CInputComponent"
                                data-label="Nombre del Rector"
                                data-input-name="nombre_rector"
                                data-input-value="{{ $institution?->rector?->name ?? "Sin rector"}}"
                                data-is-disabled="{{true}}"
                            ></div>
                            <div
                                data-component="CInputComponent"
                                data-input-type="text_multiple_tags"
                                data-label="Coordinadores"
                                data-input-name="nombre_coordinadores"
                                data-input-value="{{$institution->nombre_coordinadores}}"
                                data-is-disabled="{{true}}"
                            ></div>
                    </div>
                    <!-- Redes Sociales -->
                    <div class="mb-3">
                        <label class="form-label">Redes Sociales</label>
                        @if ($institution?->redesSociales->count() > 0 )
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
                               ['icono' => 'fa-threads', 'nombre' => 'Threads'],
                           ];
                            @endphp



                            @foreach ($redes as $key => $red)
                                @php
                                    // Buscar la red social correspondiente en la base de datos
                                    $social = collect($institution?->redesSociales ?? [])->firstWhere('nombre', $red['nombre']);
                                @endphp
                                @if ( $social)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <i class="fab {{ $red['icono'] }} fa-2x me-3"></i>
                                                @if(!empty($social['url']))
                                                    <a href="{{ $social['url'] }}" target="_blank" class="text-decoration-none">
                                                        <strong>{{ $red['nombre'] }}</strong>
                                                    </a>
                                                @else
                                                    <strong>{{ $red['nombre'] }}</strong>
                                                @endif
                                            </div>

                                            <label class="form-label mt-2">URL</label>
                                            <!-- Input para la URL con el valor correcto -->
                                            <input type="url" name="redes_sociales[{{ $key }}][url]" class="form-control"
                                                   placeholder="Ej: https://{{ strtolower($red['nombre']) }}.com"
                                                   value="{{ $social['url'] ?? '' }}" >
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach


                        </div>
                        @else
                        <div class="text-center">
                            No hay redes sociales registradas
                        </div>
                        @endif

                    </div>
                    </div>
                </form>
            </div>
            <div class="py-3 d-flex justify-content-center">
                <div class="d-flex gap-2">
                    @if(auth()->user()->can('s-institucion-editar') || auth()->user()->hasRole('rector'))
                        <a href="{{ route('institution.edit', $institution->id) }}" class="btn btn-outline-warning btn-sm">Editar</a>
                    @endif
                    @if(auth()->user()->can('s-institucion-eliminar') || auth()->user()->hasRole('rector'))
                        <form action="{{ route('institution.destroy', $institution->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta institución?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>



    </div>

    <!-- seccion de las sedes asociadas a la institucion -->
    <div class="container pt-3">
    <div class="col-md-12">
        <div class="card">
            <h1 class="card-header">Sedes</h1>
            <div class="card-body">
                <div class="col-md-12">
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


@endsection
