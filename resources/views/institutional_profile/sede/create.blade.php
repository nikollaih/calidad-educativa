@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('institution.edit', $institutionId) }}" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-primary btn-sm">Perfil</a>
            <a href="{{ route('institution.pei', $institutionId) }}" class="btn btn-outline-success  btn-sm">PEI</a>
            <a href="{{ route('institution.autoevaluaciones', $institutionId) }}" class="btn btn-outline-info btn-sm">Autoevaluación</a>
            <a href="{{ route('pmi.index', $institutionId) }}" class="btn btn-outline-secondary  btn-sm">PMI</a>
            <a href="{{ route('proyectos_transversales.index', $institutionId) }}" class="btn btn-outline-warning btn-sm">PPT</a>
        </div>
    </div>
    <div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        <div class="card">
            <div class="card-header">
                <h1>Crear Sede </h1>
            </div>
            <ul class="nav nav-tabs" id="sedeTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                        Información general
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="modelos-tab" data-bs-toggle="tab" data-bs-target="#modelos" type="button" role="tab">
                        Modelos educativos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inventario-tab" data-bs-toggle="tab" data-bs-target="#inventario" type="button" role="tab">
                        Inventario tecnologico
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="infraestructura-tab" data-bs-toggle="tab" data-bs-target="#infraestructura" type="button" role="tab">
                        Infraestructura
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="mobiliario-tab" data-bs-toggle="tab" data-bs-target="#mobiliario" type="button" role="tab">
                        Mobiliario
                    </button>
                </li>

                <!-- Agrega más pestañas si es necesario -->
            </ul>

            <div class="card-body">
                <form action="{{ route('sede.store', [ 'institutionId' => $institutionId ] ) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="sede[institution_id]" class="form-control" value="{{ $institutionId }}" required>
                    <div class="tab-content mt-3" id="sedeTabsContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <!-- Campos existentes -->
                            <div class="mb-3">
                                <label for="tipo_sede" class="form-label">Tipo de Sede<span class="text-danger">*</span></label>
                                <select name="tipo_sede" id="tipo_sede" class="form-control" required>
                                    <option value="Principal">Principal</option>
                                    <option value="Adscrita a una principal">Adscrita a una principal</option>
                                </select>
                            </div>
                            <div class="mb-3" id="sede_principal_container" style="display: none;">
                                <label for="sede_principal_id" class="form-label">Sede Principal<span class="text-danger">*</span></label>
                                <select name="sede[parent_sede_id]" id="sede_principal_id" class="form-control">
                                    <option value="">Seleccione una sede principal</option>
                                    @foreach ($availableSedes as $sede)
                                        <option value="{{ $sede->id }}">{{ $sede->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="is_sede_principal_container" style="display: block;">
                                <label  class="form-label">Estrategia pedagógica <span class="text-danger">*</span></label>
                                <select name="sede[modelo_pedagogico_id]" class="form-control">
                                    <option value="">Seleccione una estrategia pedagógica</option>
                                    @foreach ($modelosPedagogicos as $modeloPedagogico)
                                        <option value="{{ $modeloPedagogico->id }}">{{ $modeloPedagogico->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sede[name]" class="form-label">Nombre<span class="text-danger">*</span></label>
                                <div
                                    data-component="CTextInput"
                                    data-name="sede[name]"
                                    data-is-required="true"
                                >
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="sede[dane]" class="form-label">Código DANE<span class="text-danger">*</span></label>
                                <div
                                    data-component="CNumberInput"
                                    data-name="sede[dane]"
                                    data-tipo="entero"
                                    data-rango="positivo"
                                    data-is-required="true"
                                >
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="sede[address]" class="form-label">Dirección</label>
                                <input type="text" name="sede[address]" class="form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="titularidad_sede" class="form-label">Titularidad de la Sede<span class="text-danger">*</span></label>
                                <select name="titularity[titularity_type]" id="titularidad_sede" class="form-control w-full" required>
                                    <option value="Municipio">Municipio</option>
                                    <option value="Departamento">Departamento</option>
                                    <option value="Comité de Cafeteros">Comité de Cafeteros</option>
                                    <option value="Otro">Otro</option>
                                    <option value="En arriendo">En arriendo</option>
                                </select>
                            </div>
                            <div class="row" id="otro_titularidad_container" style="display: none;">
                                <div class="mb-3">
                                    <label for="otro_titularidad" class="form-label">Especifique</label>
                                    <input type="text" name="titularity[name]" class="form-control">
                                </div>
                            </div>

                            <div class="row" id="anexo_certificado_container" >
                                <div class="mb-3">
                                    <label for="anexo_certificado" class="form-label">Anexar Certificado de Libertad y Tradición u otro<span class="text-danger">*</span></label>
                                    <input type="file" name="titularity_certificate" class="form-control" accept="application/pdf" required>
                                </div>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <!-- Campos existentes -->
                        <div class="mb-3">
                            <label for="sede[zone]" class="form-label">Zona</label>
                            <select name="sede[zone]"  class="form-control w-full" >
                                <option value="RURAL">Rural</option>
                                <option value="URBANA">Urbana</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="sede[longitude]" class="form-label">Longitud<span class="text-danger">*</span></label>
                            <div
                                data-component="CNumberInput"
                                data-name="sede[longitude]"
                                data-place-holder="Ej: -74.123456"
                                data-tipo="decimal"
                                data-rango="mixto"
                                data-is-required="true"
                            >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sede[latitude]" class="form-label">Latitud<span class="text-danger">*</span></label>
                            <div
                                data-component="CNumberInput"
                                data-name="sede[latitude]"
                                data-place-holder="Ej: 4.123456"
                                data-tipo="decimal"
                                data-rango="mixto"
                                data-is-required="true"
                            >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="administrative_act_file" class="form-label">Acto Administrativo (Opcional)</label>
                            <input type="file" name="administrative_act_file" class="form-control" accept="application/pdf">
                        </div>

                        <div class="mb-3">
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sede[is_new_school]" id="sede[is_new_school]" value="1">
                                    <label class="form-check-label" for="sede[is_new_school]">¿Tiene Implementado modelo Escuela Nueva?</label>
                                </div>
                            </div>
                        </div>

                        </div>

                    </div>
                        </div>
                        <div class="tab-pane fade" id="inventario" role="tabpanel">
                            <div>
                                <!-- Sección de Aulas Steam -->
                                <div id="aulas_steam_container" class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="aulas_steam_checkbox">
                                        <label class="form-check-label" for="aulas_steam_checkbox">¿Cuenta con Aulas Steam?</label>
                                    </div>
                                </div>

                                <!-- Campos adicionales ocultos -->
                                <div id="aulas_steam_fields" style="display: none;">
                                    <div class="row">
                                        <!-- Campo para cantidad de aulas -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="cantidad_aulas">¿Cuántas?</label>
                                            <div
                                                data-component="CNumberInput"
                                                data-name="steam_classroom[quantity]"
                                                data-place-holder="Ingrese la cantidad"
                                                data-tipo="entero"
                                                data-rango="positivo_sin_cero"
                                            >
                                            </div>
                                        </div>

                                        <!-- Campo para fase -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="fase_aula">Fase</label>
                                            <select name="steam_classroom[phase]"  class="form-control w-full" required>
                                                <option value="Fase 1">Fase 1</option>
                                                <option value="Fase 2">Fase 2</option>
                                                <option value="Fase 3">Fase 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="form-label">Equipos disponibles.</label>
                                <!-- Sección de equipos (oculta inicialmente) -->
                                <div class="row row-cols-md-1 " >
                                    @php
                                        $equipos = [

                                       'Equipo Servidor.',
                                       'Computadores de escritorio para uso académico en buen estado.',
                                       'Computadores portátiles para uso académico en buen estado.',
                                       'Tabletas para uso académico en buen estado.',
                                       'Pantallas interactivas en buen estado.',
                                       'Computadores de escritorio para uso administrativo en buen estado.',
                                       'Computadores portátiles para uso administrativo en buen estado.',
                                       'Routers.',
                                       'Switch de red.',
                                       'Access Point.',
                                       'Proyectores / Videobeam.',
                                       'Kit de robótica.',
                                       'Kit STEM.',
                                       'Arduinos.',
                                       'Microbit.',
                                       'UPS.',
                                       'Brazo robótico.',
                                       'Impresora 3D.',
                                       'Televisores.',
                                       'Cabinas de sonido.',
                                        'Carrito de carga Smart charging',
                                       'Brazo soporte de monitor',
                                       'Computador docente',
                                       'Cámara U70',
                                       'Tablero Interactivo',
                                       'Brazo soporte para Video Beam',
                                       'Lápiz interactivo',
                                       'Kit Iot estudio',
                                       'Microscopio digital ',
                                   ];
                                    @endphp
                                    @foreach ($equipos as $key => $equipo)
                                        <div class="mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="equipos[]" id="equipo_{{ Str::slug($equipo) }}" value="{{ $equipo }}">
                                                        <label class="form-check-label" for="equipo_{{ Str::slug($equipo) }}">{{ $equipo }}</label>
                                                    </div>
                                                </div>
                                                <!-- Campos adyacentes para financiación y cantidad -->
                                                <div class="col-md-5">
                                                    <div id="label_fuente_{{ Str::slug($equipo) }}" style="display: none;">
                                                        <label class="form-check-label">Fuente de financiación.</label>
                                                    </div>
                                                    <input hidden name="inventory[{{$key}}][name]" value="{{Str::slug($equipo)}}">
                                                    <select name="inventory[{{$key}}][financing_source]" id="fuente_financiacion_{{ Str::slug($equipo) }}" class="form-control" style="display: none;">
                                                        <option value="Computadores para educar">Computadores para educar</option>
                                                        <option value="Regalías: Bilingüismo, Innovación Social">Regalías: Bilingüismo, Innovación Social</option>
                                                        <option value="Aula Steam">Aula Steam</option>
                                                        <option value="Obras por impuestos">Obras por impuestos</option>
                                                        <option value="Recursos propios">Recursos propios</option>
                                                        <option value="Donación entidad estatal">Donación entidad estatal</option>
                                                        <option value="Donación entidad privada">Donación entidad privada</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="label_cantidad_{{ Str::slug($equipo) }}" style="display: none;">
                                                        <label class="form-check-label">Cantidad.</label>
                                                    </div>
                                                    <div
                                                        data-component="CNumberInput"
                                                        data-id="cantidad_{{ Str::slug($equipo) }}"
                                                        data-name="inventory[{{$key}}][quantity]"
                                                        data-place-holder="Cantidad"
                                                        data-style="display: none;"
                                                        data-tipo="entero"
                                                        data-rango="positivo_sin_cero"
                                                    >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="infraestructura" role="tabpanel">
                            <div class="row">
                                <!-- Sección de equipos (oculta inicialmente) -->
                                <div class="row row-cols-md-1 " >
                                    @php
                                        $infraestructura = [
                                            [
                                                'nombre' => 'Baterias sanitarias mujeres',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Baterias sanitarias hombres',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Área del lote',
                                                'tiene_cantidad' => false
                                            ],
                                            [
                                                'nombre' => 'Área construida',
                                                'tiene_cantidad' => false
                                            ],
                                            [
                                                'nombre' => 'Área total del primer piso',
                                                'tiene_cantidad' => false
                                            ],
                                            [
                                                'nombre' => 'Área zonas de recreación',
                                                'tiene_cantidad' => false
                                            ],
                                            [
                                                'nombre' => 'Área libre',
                                                'tiene_cantidad' => false
                                            ],
                                            [
                                                'nombre' => 'Aulas de preescolar',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Aulas de primaria',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Aulas de secundaria',
                                                'tiene_cantidad' => true
                                            ],
                                             [
                                                'nombre' => 'Biblioteca general',
                                                'tiene_cantidad' => true
                                            ],[
                                                'nombre' => 'Biblioteca infantil',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Sala audiovisuales',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Aulas de tecnología',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Aula múltiple',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Laboratorio integrado',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Laboratorio ciencias',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Laboratorio biología',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Laboratorio fisíca',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Ludoteca',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Auditorio/Teatro',
                                                'tiene_cantidad' => true
                                            ],
                                            [
                                                'nombre' => 'Otro',
                                                'tiene_cantidad' => true
                                            ],

                                        ];
                                    @endphp
                                    @foreach ($infraestructura as $key => $equipo)
                                        <div class="mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="infraestructura[]" id="infraestructura_{{ Str::slug($equipo['nombre']) }}" value="{{ $equipo['nombre'] }}">
                                                        <label class="form-check-label" for="infraestructura_{{ Str::slug($equipo['nombre']) }}">{{ $equipo['nombre'] }}</label>
                                                    </div>
                                                </div>
                                                @if($equipo['tiene_cantidad'])
                                                <div class="col-md-4">
                                                    <div id="label_cantidad_{{ Str::slug($equipo['nombre']) }}" style="display: none;">
                                                        <label class="form-check-label">Cantidad.</label>
                                                    </div>
                                                    <input type="number" name="infraestructura[{{$key}}][cantidad]" id="cantidad_{{ Str::slug($equipo['nombre']) }}" class="form-control" style="display: none;" placeholder="Cantidad" step="1">
                                                </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div id="label_area_{{ Str::slug($equipo['nombre']) }}" style="display: none;">
                                                        <label class="form-check-label">Área (m²)</label>
                                                    </div>
                                                    <input type="hidden" name="infraestructura[{{$key}}][nombre]" value="{{ $equipo['nombre'] }}"  />
                                                    <input type="hidden" name="infraestructura[{{$key}}][tiene_cantidad]" value="{{ $equipo['tiene_cantidad'] }}"  />
                                                    <input type="number" name="infraestructura[{{$key}}][area]" id="area_{{ Str::slug($equipo['nombre']) }}" class="form-control" style="display: none;" placeholder="Área (m²)" step="0.1" >
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="mobiliario" role="tabpanel">
                            <div class="row">
                                <!-- Sección de equipos (oculta inicialmente) -->
                                <div class="row row-cols-md-1 " >
                                    @php
                                        $mobiliarios = [
                                        [
                                                 'nombre' => 'Locker',
                                             ],
                                             [
                                                 'nombre' => 'Ventilador',
                                             ],
                                              [
                                                 'nombre' => 'Silla docente',
                                             ],
                                             [
                                                 'nombre' => 'Mesa Docente',
                                             ],
                                             [
                                                 'nombre' => 'Mesa escolar trapezoidal',
                                             ],
                                             [
                                                 'nombre' => 'Silla escolar',
                                             ],
                                             [
                                                 'nombre' => 'Cajoneros',
                                             ],
                                             [
                                                 'nombre' => 'Sillas universitarias',
                                             ],
                                             [
                                                 'nombre' => 'Pupitres individuales',
                                             ],
                                             [
                                                 'nombre' => 'Sillas individuales',
                                             ],
                                              [
                                                 'nombre' => 'Escritorio rector',
                                             ],
                                              [
                                                 'nombre' => 'Escritorio Coordinador',
                                             ],
                                              [
                                                 'nombre' => 'Escritorio docentes',
                                             ],
                                              [
                                                 'nombre' => 'Escritorio Auxiliares Administrativas',
                                             ],
                                              [
                                                 'nombre' => 'Estantería de Archivo',
                                             ],
                                              [
                                                 'nombre' => 'Sillas ejecutivas',
                                             ]
                                            ,[
                                                 'nombre' => 'Archivador',
                                             ],

                                         ];
                                    @endphp
                                    @foreach ($mobiliarios as $key => $mobiliario)
                                        <div class="mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="mobiliario[]" id="mobiliario_{{ Str::slug($mobiliario['nombre']) }}" value="{{ $mobiliario['nombre'] }}">
                                                        <label class="form-check-label" for="mobiliario_{{ Str::slug($mobiliario['nombre']) }}">{{ $mobiliario['nombre'] }}</label>
                                                    </div>
                                                </div>
                                                    <div class="col-md-4">
                                                        <div id="label_cantidad_{{ Str::slug($mobiliario['nombre']) }}" style="display: none;">
                                                            <label class="form-check-label">Cantidad.</label>
                                                        </div>
                                                        <input type="hidden" name="mobiliario[{{$key}}][nombre]" value="{{ $mobiliario['nombre'] }}"  />

                                                        <div
                                                            data-component="CNumberInput"
                                                            data-id="cantidad_{{ Str::slug($mobiliario['nombre']) }}"
                                                            data-name="mobiliario[{{$key}}][cantidad]"
                                                            data-place-holder="Cantidad"
                                                            data-style="display: none;"
                                                            data-tipo="entero"
                                                            data-rango="positivo_sin_cero"
                                                        >
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade"  id="modelos" role="tabpanel">
                            <div class="m-3">
                                <div class="row">
                                    <!-- Modelos educativos -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="modelos" class="form-label">Modelos Educativos Flexibles.</label>
                                            <select name="educational_models[]" class="form-control" multiple >
                                                @foreach($eduactionalModels as $model)
                                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tiene_autorizacion" class="form-label">¿Tiene autorización para validación de estudios?</label>
                                            <select name="educational_offer[has_study_validation_auth]" class="form-control" id="tiene_autorizacion" required>
                                                <option value="0">No</option>
                                                <option value="1">Sí</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="anexo_resolucion_container" style="display: none;">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="anexo_resolucion" class="form-label">Anexo Resolución</label>
                                            <input type="file" name="validation_authorization" class="form-control" accept="application/pdf">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">¿Atención a estudiantes del sistema de responsabilidad penal?</label>
                                            <select name="educational_offer[serves_juvenile_justice]" class="form-control" required>
                                                <option value="0">No</option>
                                                <option value="1">Sí</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">¿Atención a estudiantes del sistema nacional de protección?</label>
                                            <select name="educational_offer[national_protection_students]" class="form-control" required>
                                                <option value="0">No</option>
                                                <option value="1">Sí</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">¿Atención a población étnica?</label>
                                                <select name="educational_offer[serves_ethnic_population]" class="form-control" required>
                                                    <option value="0">No</option>
                                                    <option value="1">Sí</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="{{ route('sede.index', [ 'institutionId' => $institutionId ]) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para manejar la lógica de los campos -->
    <script>
        document.getElementById('tiene_autorizacion').addEventListener('change', function () {
            const anexoContainer = document.getElementById('anexo_resolucion_container');
            anexoContainer.style.display = this.value === '1' ? 'block' : 'none';
        });
        document.addEventListener('DOMContentLoaded', function () {
            const aulasSteamContainer = document.getElementById('aulas_steam_container');
            const equiposContainer = document.getElementById('equipos_container');
            const tipoSedeSelect = document.getElementById('tipo_sede');
            const sedePrincipalContainer = document.getElementById('sede_principal_container');
            const isSedePrincipalContainer = document.getElementById('is_sede_principal_container');

            tipoSedeSelect.addEventListener('change', function () {
                if (this.value === 'Adscrita a una principal') {
                    sedePrincipalContainer.style.display = 'block';
                    isSedePrincipalContainer.style.display = 'none';
                } else {
                    sedePrincipalContainer.style.display = 'none';
                    isSedePrincipalContainer.style.display = 'block';
                }
            });

            // Ejecutar al cargar la página para manejar el estado inicial
            if (tipoSedeSelect.value === 'Adscrita a una principal') {
                sedePrincipalContainer.style.display = 'block';
                isSedePrincipalContainer.style.display = 'none';
            } else{
                sedePrincipalContainer.style.display = 'none';
                isSedePrincipalContainer.style.display = 'block';
            }
            const equiposCheckboxes = document.querySelectorAll('input[name="equipos[]"]');
            equiposCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const equipoId = this.id.replace('equipo_', '');
                    const labelFuente = document.getElementById(`label_fuente_${equipoId}`);
                    const labelCantidad = document.getElementById(`label_cantidad_${equipoId}`);
                    const fuenteFinanciacion = document.getElementById(`fuente_financiacion_${equipoId}`);
                    const cantidad = document.getElementById(`cantidad_${equipoId}`);

                    if (this.checked) {
                        labelFuente.style.display = 'block';
                        labelCantidad.style.display = 'block';
                        fuenteFinanciacion.style.display = 'block';
                        cantidad.style.display = 'block';
                    } else {
                        labelFuente.style.display = 'none';
                        labelCantidad.style.display = 'none';
                        fuenteFinanciacion.style.display = 'none';
                        cantidad.style.display = 'none';
                        cantidad.value = '';


                    }
                });
            });

            const infraestructuraCheckboxes = document.querySelectorAll('input[name="infraestructura[]"]');
            infraestructuraCheckboxes.forEach(infra => {
                infra.addEventListener('change', function () {
                    const equipoId = this.id.replace('infraestructura_', '');
                    const labelArea = document.getElementById(`label_area_${equipoId}`);
                    const labelCantidad = document.getElementById(`label_cantidad_${equipoId}`);
                    const cantidad = document.getElementById(`cantidad_${equipoId}`);
                    const area = document.getElementById(`area_${equipoId}`);

                    if (this.checked) {
                        labelArea.style.display = 'block';
                        area.style.display = 'block';
                        if ( labelCantidad && cantidad){
                            cantidad.style.display = 'block';
                            labelCantidad.style.display = 'block';
                        }
                    } else {
                        labelArea.style.display = 'none';
                        area.style.display = 'none';
                        if ( labelCantidad && cantidad){
                            cantidad.style.display = 'none';
                            labelCantidad.style.display = 'none';
                        }
                    }
                });
            });

            const mobiliarioCheckboxes = document.querySelectorAll('input[name="mobiliario[]"]');
            mobiliarioCheckboxes.forEach(mobiliario => {
                mobiliario.addEventListener('change', function () {
                    const equipoId = this.id.replace('mobiliario_', '');
                    const labelCantidad = document.getElementById(`label_cantidad_${equipoId}`);
                    const cantidad = document.getElementById(`cantidad_${equipoId}`);

                    if (this.checked) {
                        cantidad.style.display = 'block';
                        labelCantidad.style.display = 'block';

                    } else {
                        cantidad.style.display = 'none';
                        labelCantidad.style.display = 'none';
                    }
                });
            });
        });
        document.getElementById('titularidad_sede').addEventListener('change', function () {
            const otroContainer = document.getElementById('otro_titularidad_container');
            const anexoContainer = document.getElementById('anexo_certificado_container');

            if (this.value === 'Otro') {
                otroContainer.style.display = 'block';
            } else {
                otroContainer.style.display = 'none';
            }

            if (this.value !== 'En arriendo') {
                anexoContainer.style.display = 'block';
            } else {
                anexoContainer.style.display = 'none';
            }
        });
            document.getElementById('aulas_steam_checkbox').addEventListener('change', function () {
        let fields = document.getElementById('aulas_steam_fields');
        if (this.checked) {
            fields.style.display = 'block';
        } else {
            fields.style.display = 'none';
        }
    });
    </script>
@endsection
