@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.autoevaluaciones', $institution->id) }}" class="btn btn-outline-info btn-sm">Autoevaluaciones</a>
            <a href="{{ route('institution.pei', $institution->id) }}" class="btn btn-outline-success  btn-sm">PEI</a>
            <form class="" action="{{ route('institution.destroy', $institution->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta institución?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
            </form>
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
                <h1>Editar Institución</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('institution.update',$institution->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre_ie" class="form-label">Nombre de la Institución Educativa (IE)</label>

                                <input type="text" name="nombre" class="form-control" value="{{ $institution->nombre }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="dane" class="form-label">Código DANE</label>
                                <input type="text" name="dane" class="form-control" value="{{ $institution->dane }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" value="{{ $institution->email }}" required>
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
                                <input type="file" name="licencia_funcionamiento" class="form-control mt-2" accept="application/pdf" >
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono_ie" class="form-label">Teléfono de la IE</label>
                                <input type="text" name="telefono" class="form-control" value={{ $institution->telefono }} required>
                            </div>
                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT</label>
                                <input type="text" name="nit" class="form-control" value="{{ $institution->nit }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="pagina_web" class="form-label">Página Web</label>
                                <input type="url" name="web_url" class="form-control" value="{{ $institution->web_url }}">
                            </div>

                            <div class="mb-3">
                                <label for="nombre_rector" class="form-label">Nombre del Rector</label>
                                <input type="text" name="nombre_rector" class="form-control" value="{{ $institution->nombre_rector}}" required>
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
                        <label class="form-label">Redes Sociales</label>
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
                                                   value="{{ $social['url'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach


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
    <div class="col-md-12">
        <div class="card">
            <h1 class="card-header">Ofertas educativas de esta institución</h1>
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{ route('educational-offer.vinculate', $institution->id) }}" class="btn btn-primary mb-3">Vincular una oferta educativa</a>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>NIVELES EDUCATIVOS</th>
                            <th>JORNADA</th>
                            <th>NOMBRE SEDE</th>
                            <th>TIPO DE SEDE</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($institution->sedes as $sede)
                                @foreach ($sede->levelSedeEducational as $levelSede)
                                    <tr>
                                        <td>
                                            {{ $levelSede->educationalLevel->name }}
                                            @if($levelSede->educationalLevel->document_id)
                                                <a href="{{ $levelSede->educationalLevel->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                                    <i class="fas fa-eye"></i> Ver Anexo
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $levelSede->schedule->schedule }}
                                            @if($levelSede->schedule->document_id)
                                                <a href="{{ $levelSede->schedule->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                                    <i class="fas fa-eye"></i> Ver Anexo
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $sede->name }}</td>
                                        <td>{{ $sede->parent_sede_id ? "Adscrita" : "Principal" }}</td>
                                        <td>
                                            <a href="{{ route('educational-offer.vinculate-show', ['levelSedeId' => $levelSede->id]) }}" class="btn btn-primary btn-sm">Ver detalles</a>
                                            <a href="{{ route('educational-offer.vinculate-edit', ['levelSedeId' => $levelSede->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('educational-offer.vinculate-destroy', ['levelSedeId' => $levelSede->id]) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta vinculación?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- fin session de las sedes asociadas a la institucion -->

@endsection
