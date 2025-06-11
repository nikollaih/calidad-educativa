@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-primary btn-sm">Detalles</a>
            <a href="{{ route('institution.autoevaluaciones', $institution->id) }}" class="btn btn-outline-info btn-sm">Autoevaluación</a>
            <a href="{{ route('institution.pei', $institution->id) }}" class="btn btn-outline-success  btn-sm">PEI</a>

        </div>
    </div>

    <div class="container pt-3">
    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
        <div class="card">
            <div class="card-header">
                <h1>Ver institución</h1>
            </div>
            <div class="card-body">
                <form >
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre_ie" class="form-label">Nombre de la Institución Educativa (IE)</label>
                                <input type="text" name="nombre" class="form-control" value="{{ $institution->nombre }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="dane" class="form-label">Código DANE</label>
                                <input type="text" name="dane" class="form-control" value="{{ $institution->dane }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" value="{{ $institution->email }}" disabled>
                            </div>
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
                            <div class="mb-3">
                                <label for="telefono_ie" class="form-label">Teléfono de la IE</label>
                                <input type="text" name="telefono" class="form-control" value={{ $institution->telefono }} disabled>
                            </div>

                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT</label>
                                <input type="text" name="nit" class="form-control" value="{{ $institution->nit }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="pagina_web" class="form-label">Página Web</label>
                                <input type="url" name="web_url" class="form-control" value="{{ $institution->web_url }}" disabled>
                            </div>




                            <div class="mb-3">
                                <label for="nombre_rector" class="form-label">Nombre del Rector</label>
                                <input type="text" name="nombre_rector" class="form-control" value="{{ $institution->nombre_rector}}" disabled>
                            </div>
                            <div
                                data-component="TextMultipleTags"
                                data-initial-value="{{$institution->nombre_coordinadores}}"
                                data-is-editable="{{false}}"
                            >
                        </div>
                    </div>
                    <!-- Redes Sociales -->
                    <div class="mb-3">
                        <label class="form-label">Redes Sociales</label>
                        @if ($institution?->redesSociales->count() > 0 )
                        <div id="redes-sociales-container" class="row">
                            @php
                                $redes = [
                                    ['icono' => 'fa-facebook', 'nombre' => 'Facebook'],
                                    ['icono' => 'fa-twitter', 'nombre' => 'Twitter'],
                                    ['icono' => 'fa-instagram', 'nombre' => 'Instagram'],
                                    ['icono' => 'fa-linkedin', 'nombre' => 'LinkedIn'],
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
                                                <strong>{{ $red['nombre'] }}</strong>
                                            </div>
                                            <label class="form-label mt-2">URL</label>

                                            <!-- Input oculto para el nombre de la red social -->
                                            <input type="hidden" name="redes_sociales[{{ $key }}][nombre]" value="{{ $red['nombre'] }}">

                                            <!-- Input para la URL con el valor correcto -->
                                            <input type="url" name="redes_sociales[{{ $key }}][url]" class="form-control"
                                                   placeholder="Ej: https://{{ strtolower($red['nombre']) }}.com"
                                                   value="{{ $social['url'] ?? '' }}" disabled>
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
                    <a href="{{ route('institution.edit', $institution->id) }}" class="btn btn-outline-warning btn-sm">Editar</a>
                    <form action="{{ route('institution.destroy', $institution->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta institución?')" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                    </form>
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
