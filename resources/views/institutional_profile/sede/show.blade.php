@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.edit', $sede->institution_id) }}"
        data-detail-url="#"
        data-pei-url="{{ route('institution.pei', $sede->institution_id) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $sede->institution_id) }}"
        data-pmi-url="{{ route('pmi.index', $sede->institution_id) }}"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $sede->institution_id) }}"
        data-institution-name="{{ $sede->institution->nombre }}"
    >
    </div>
    <div class="m-6 !border border-custom-blue-light rounded-md bg-white">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        <div class="m-3">
            <h1 class="p-2 px-3 text-custom-primary" >Ver sede</h1>
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
                    <button class="nav-link" id="ofertas-tab" data-bs-toggle="tab" data-bs-target="#ofertas" type="button" role="tab">
                        Ofertas educativas
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
                <form >
                    <div class="tab-content mt-3" id="sedeTabsContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <!-- Campos existentes -->
                                    <div class="mb-3">
                                        <label for="tipo_sede" class="block text-sm mb-2 ml-4">Tipo de sede</label>
                                        <select name="tipo_sede" id="tipo_sede" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" disabled>
                                            <option value="Principal" @selected($sede->parentSede == null)>Principal</option>
                                            <option value="Adscrita a una principal" @selected($sede->parentSede != null)>Adscrita a una principal</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sede[latitude]" class="block text-sm mb-2 ml-4">Latitud</label>
                                        <input type="text" name="sede[latitude]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" placeholder="Ej: 4.123456" value="{{ $sede->latitude  }}" disabled>
                                    </div>
                                    <div class="mb-3" id="sede_principal_container" style="display: none;">
                                        <label for="sede_principal_id" class="block text-sm mb-2 ml-4">Sede Principal</label>
                                        <select name="sede[parent_sede_id]" id="sede_principal_id" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" disabled>
                                            <option value="">Seleccione una sede principal</option>
                                            @foreach ($availableSedes as $sedePrincipal)
                                                <option value="{{ $sedePrincipal->id }}" @selected($sede?->parentSede?->id == $sedePrincipal->id )>{{ $sedePrincipal->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3" id="is_sede_principal_container" style="display: none;">
                                        <label  class="block text-sm mb-2 ml-4">Estrategia pedagógica</label>
                                        <select name="sede[modelo_pedagogico_id]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" disabled>
                                            <option value="">Seleccione una estrategia pedagógica</option>
                                            @foreach ($modelosPedagogicos as $modeloPedagogico)
                                                <option value="{{ $modeloPedagogico?->id }}" @selected($sede?->modelo_pedagogico_id == $modeloPedagogico->id )  >{{ $modeloPedagogico->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sede[name]" class="block text-sm mb-2 ml-4">Nombre</label>
                                        <input type="text" name="sede[name]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" value="{{ $sede->name }}" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sede[address]" class="block text-sm mb-2 ml-4">Dirección</label>
                                        <input type="text" name="sede[address]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" value="{{ $sede->address }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="titularidad_sede" class="block text-sm mb-2 ml-4">Titularidad de la sede</label>

                                        <select name="titularity[titularity_type]" id="titularidad_sede" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill w-full"  disabled>
                                            <option value="Municipio" @selected($sede?->titularidadSede?->titularity_type == 'Municipio')>Municipio</option>
                                             <option value="Departamento" @selected($sede?->titularidadSede?->titularity_type == 'Departamento')>Departamento</option>
                                             <option value="Comité de Cafeteros" @selected($sede?->titularidadSede?->titularity_type == 'Comité de Cafeteros')>Comité de Cafeteros</option>
                                             <option value="Otro" @selected($sede?->titularidadSede?->titularity_type == 'Otro')>Otro</option>
                                             <option value="En arriendo" @selected($sede?->titularidadSede?->titularity_type == 'En arriendo')>En arriendo</option>
                                        </select>
                                    </div>
                                    <div class="row" id="otro_titularidad_container" style="display: none;">
                                        <div class="mb-3">
                                            <label for="otro_titularidad" class="block text-sm mb-2 ml-4">Especifique</label>
                                            <input type="text" name="titularity[name]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill">
                                        </div>
                                    </div>
                                        <label for="titularidad_sede" class="block text-sm mb-2 ml-4">Anexar Certificado de Libertad y Tradición u otro</label>
                                        @if($sede?->titularidadSede?->adjunto?->url)
                                            <a href="{{ $sede?->titularidadSede?->adjunto?->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-eye"></i> Ver anexo
                                            </a>
                                         @endif
                                </div>

                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <!-- Campos existentes -->
                                    <div class="mb-3">
                                        <label for="sede[zone]" class="block text-sm mb-2 ml-4">Zona</label>
                                        <select name="sede[zone]" id="titularidad_sede" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill w-full"  disabled>
                                           <option value="RURAL" {{ $sede->zone == 'RURAL' ? 'selected' : '' }}>Rural</option>
                                           <option value="URBANA" {{ $sede->zone == 'URBANA' ? 'selected' : '' }}>Urbana</option>
                                        </select>
                                    </div>



                                    <div class="mb-3">
                                        <label for="sede[longitude]" class="block text-sm mb-2 ml-4">Longitud</label>
                                        <input type="text" name="sede[longitude]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" placeholder="Ej: -74.123456" value="{{ $sede->longitude  }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sede[dane]" class="block text-sm mb-2 ml-4">Código DANE</label>
                                        <input type="text" name="sede[dane]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" value="{{ $sede->dane }}" disabled>
                                    </div>

                                    <div class="mb-3">
                                            <label for="administrative_act_file" class="block text-sm mb-2 ml-4">Acto Administrativo (Opcional)</label>
                                            @if($sede?->administrativeAct?->url)
                                                <a href="{{ $sede?->administrativeAct?->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye"></i> Ver anexo
                                                </a>
                                            @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm mb-2 ml-4">¿Es escuela nueva?</label>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sede[is_new_school]" id="sede[is_new_school]" value="{{ $sede->is_new_school }}" @if($sede->is_new_school == 1) checked @endif  disabled>
                                                <label class="form-check-label" for="sede[is_new_school]">¿Es una nueva escuela?</label>
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
                                        <input class="form-check-input" type="checkbox" id="aulas_steam_checkbox" @if($sede->steamClassroom != null) checked @endif disabled>
                                        <label class="form-check-label" for="aulas_steam_checkbox">¿Cuenta con Aulas Steam?</label>
                                    </div>
                                </div>

                                <!-- Campos adicionales ocultos -->
                                <div id="aulas_steam_fields" style="display: {{ $sede->steamClassroom != null ? 'block' : 'none' }};" >
                                    <div class="row">
                                        <!-- Campo para cantidad de aulas -->
                                        <div class="col-md-6">
                                            <label class="block text-sm mb-2 ml-4" for="cantidad_aulas">¿Cuántas?</label>
                                            <input type="number" id="cantidad_aulas" name="steam_classroom[quantity]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" min="1" value="{{$sede?->steamClassroom?->quantity}}" placeholder="Ingrese cantidad" disabled>
                                        </div>

                                        <!-- Campo para fase -->
                                        <div class="col-md-6">
                                            <label class="block text-sm mb-2 ml-4" for="fase_aula">Fase</label>
                                            <select name="steam_classroom[phase]"  class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill w-full" disabled>

                                                <option value="Fase 1" {{ $sede->steamClassroom?->phase == 'Fase 1' ? 'selected' : '' }}>Fase 1</option>
                                                <option value="Fase 2" {{ $sede->steamClassroom?->phase == 'Fase 2' ? 'selected' : '' }}>Fase 2</option>
                                                <option value="Fase 3" {{ $sede->steamClassroom?->phase == 'Fase 3' ? 'selected' : '' }}>Fase 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="block text-sm mb-2 ml-4">Equipos disponibles</label>

                                <!-- Sección de equipos (oculta inicialmente) -->
                                <div class="row  row-cols-md-1" >
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
                                                        <input class="form-check-input" type="checkbox" name="equipos[]" id="equipo_{{ Str::slug($equipo) }}" value="{{ $equipo }}" @if($sede->inventories->firstWhere('name', Str::slug($equipo))) checked @endif  disabled>
                                                        <label class="form-check-label" for="equipo_{{ Str::slug($equipo) }}">{{ $equipo }}</label>
                                                    </div>
                                                </div>
                                                <!-- Campos adyacentes para financiación y cantidad -->
                                                <div class="col-md-5">
                                                    <div id="label_fuente_{{ Str::slug($equipo) }}" style="display: {{ $sede->inventories->firstWhere('name', Str::slug($equipo)) != null ? 'block' : 'none' }};" >
                                                        <label class="form-check-label">Fuente de financiación</label>
                                                    </div>
                                                    <input hidden name="inventory[{{$key}}][name]" value="{{Str::slug($equipo)}}" disabled>
                                                    <select name="inventory[{{$key}}][financing_source]" id="fuente_financiacion_{{ Str::slug($equipo) }}" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" style="display: {{ $sede->inventories->firstWhere('name', Str::slug($equipo)) != null ? 'block' : 'none' }};" disabled>
                                                        <option value="Computadores para educar"  {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Computadores para educar')->count() > 0 ? 'selected' : '' }}>Computadores para educar</option>
                                                        <option value="Regalías: Bilingüismo, Innovación Social" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Regalías: Bilingüismo, Innovación Social')->count() > 0 ? 'selected' : '' }}>Regalías: Bilingüismo, Innovación Social</option>
                                                        <option value="Aula Steam" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Aula Steam')->count() > 0 ? 'selected' : '' }}>Aula Steam</option>
                                                        <option value="Obras por impuestos" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Obras por impuestos')->count() > 0 ? 'selected' : '' }}>Obras por impuestos</option>
                                                        <option value="Recursos propios" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Recursos propios')->count() > 0 ? 'selected' : '' }}>Recursos propios</option>
                                                        <option value="Donación entidad estatal" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Donación entidad estatal')->count() > 0 ? 'selected' : '' }}>Donación entidad estatal</option>
                                                        <option value="Donación entidad privada"  {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Donación entidad privada')->count() > 0 ? 'selected' : '' }}>Donación entidad privada</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="label_cantidad_{{ Str::slug($equipo) }}" style="display: {{ $sede->inventories->firstWhere('name', Str::slug($equipo)) != null ? 'block' : 'none' }};">
                                                        <label class="form-check-label">Cantidad</label>
                                                    </div>
                                                    <input type="number" name="inventory[{{$key}}][quantity]" id="cantidad_{{ Str::slug($equipo) }}" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" style="display: {{ $sede->inventories->firstWhere('name', Str::slug($equipo)) != null ? 'block' : 'none' }};" placeholder="Cantidad" value="{{  $sede->inventories->firstWhere('name', Str::slug($equipo))?->quantity}}" disabled>
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
                                                        <input class="form-check-input" type="checkbox" name="infraestructura[]" id="infraestructura_{{ Str::slug($equipo['nombre']) }}" value="{{ $equipo['nombre'] }}" @if( $sede->infraestructuras->firstWhere('nombre', $equipo['nombre']) ) checked @endif  disabled>
                                                        <label class="form-check-label" for="infraestructura_{{ Str::slug($equipo['nombre']) }}">{{ $equipo['nombre'] }}</label>
                                                    </div>
                                                </div>
                                                @if($equipo['tiene_cantidad'])
                                                    <div class="col-md-4">
                                                        <div id="label_cantidad_{{ Str::slug($equipo['nombre']) }}" style="display: {{ $sede->infraestructuras->firstWhere('nombre', $equipo ['nombre']) != null ? 'block' : 'none' }};">
                                                            <label class="form-check-label">Cantidad.</label>
                                                        </div>
                                                        <input type="number" name="infraestructura[{{$key}}][cantidad]" value="{{ $sede->infraestructuras->firstWhere('nombre', $equipo ['nombre'])?->cantidad  }}" id="cantidad_{{ Str::slug($equipo['nombre']) }}" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" style="display: {{ $sede->infraestructuras->firstWhere('nombre', $equipo ['nombre']) != null ? 'block' : 'none' }};" placeholder="Cantidad" step="1" disabled>
                                                    </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div id="label_area_{{ Str::slug($equipo['nombre']) }}" style="display: {{ $sede->infraestructuras->firstWhere('nombre', $equipo ['nombre']) != null ? 'block' : 'none' }};">
                                                        <label class="form-check-label">Área (m²).</label>
                                                    </div>
                                                    <input type="hidden" name="infraestructura[{{$key}}][nombre]" value="{{ $equipo['nombre'] }}"  />
                                                    <input type="hidden" name="infraestructura[{{$key}}][tiene_cantidad]" value="{{ $equipo['tiene_cantidad'] }}"  />
                                                    <input type="number" name="infraestructura[{{$key}}][area]" id="area_{{ Str::slug($equipo['nombre']) }}" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" value="{{ $sede->infraestructuras->firstWhere('nombre', $equipo ['nombre'])?->area  }}" style="display: {{ $sede->infraestructuras->firstWhere('nombre', $equipo ['nombre']) != null ? 'block' : 'none' }};" placeholder="Área (m²)" step="0.1" disabled>
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
                                                        <input class="form-check-input" type="checkbox" name="mobiliario[]" id="mobiliario_{{ Str::slug($mobiliario['nombre']) }}" value="{{ $mobiliario['nombre'] }}" @if( $sede->mobiliarios->firstWhere('nombre', $mobiliario['nombre'] ))) checked @endif  disabled>
                                                        <label class="form-check-label" for="mobiliario_{{ Str::slug($mobiliario['nombre']) }}">{{ $mobiliario['nombre'] }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="label_cantidad_{{ Str::slug($mobiliario['nombre']) }}" style="display: {{ $sede->mobiliarios->firstWhere('nombre', $mobiliario['nombre']) != null ? 'block' : 'none' }};">
                                                        <label class="form-check-label">Cantidad.</label>
                                                    </div>
                                                    <input type="hidden" name="mobiliario[{{$key}}][nombre]" value="{{ $mobiliario['nombre'] }}"  />

                                                    <input type="number" name="mobiliario[{{$key}}][cantidad]" id="cantidad_{{ Str::slug($mobiliario['nombre']) }}"  value="{{$sede->mobiliarios->firstWhere('nombre', $mobiliario['nombre'])?->cantidad }}" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" style="display: {{ $sede->mobiliarios->firstWhere('nombre', $mobiliario['nombre']) != null ? 'block' : 'none' }};" placeholder="Cantidad" step="1" disabled>
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
                                    <label for="modelos" class="block text-sm mb-2 ml-4">Modelos Educativos Flexibles</label>
                                    <select name="educational_models[]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl" multiple disabled>
                                        @foreach($educationalOffer->educationalModels as $model)
                                            <option value="{{ $model->id }}">
                                                {{ $model->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tiene_autorizacion" class="block text-sm mb-2 ml-4">¿Tiene autorización para validación de estudios?</label>
                                    <select name="educational_offer[has_study_validation_auth]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" id="tiene_autorizacion" disabled>
                                        <option value="0" {{ $educationalOffer->has_study_validation_auth == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $educationalOffer->has_study_validation_auth == '1' ? 'selected' : '' }}>Sí</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="anexo_resolucion_container" style="display: {{ $educationalOffer->validationAuthorizationAdjunto != null ? 'block' : 'none' }};">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="anexo_resolucion" class="block text-sm mb-2 ml-4">Anexo Resolución</label>
                                        @if($educationalOffer->validationAuthorizationAdjunto?->url)
                                            <a href="{{ $educationalOffer->validationAuthorizationAdjunto?->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-eye"></i> Ver anexo
                                            </a>
                                        @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="block text-sm mb-2 ml-4">¿Atención a estudiantes del sistema de responsabilidad penal?</label>
                                    <select name="educational_offer[serves_juvenile_justice]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" disabled>
                                        <option value="0" {{ $educationalOffer->serves_juvenile_justice == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $educationalOffer->serves_juvenile_justice == '1' ? 'selected' : '' }}>Sí</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="block text-sm mb-2 ml-4">¿Atención a estudiantes del sistema nacional de protección?</label>
                                    <select name="educational_offer[national_protection_students]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" disabled>
                                        <option value="0" {{ $educationalOffer->national_protection_students == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $educationalOffer->national_protection_students == '1' ? 'selected' : '' }}>Sí</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="block text-sm mb-2 ml-4">¿Atención a población étnica?</label>
                                    <select name="educational_offer[serves_ethnic_population]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" disabled>
                                        <option value="0" {{ $educationalOffer->serves_ethnic_population == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $educationalOffer->serves_ethnic_population == '1' ? 'selected' : '' }}>Sí</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <div class="tab-pane fade"  id="ofertas" role="tabpanel">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>NIVELES EDUCATIVOS</th>
                                            <th>DOCUMENTO EDUCATIVOS</th>
                                            <th>JORNADA</th>
                                            <th>DOCUMENTO JORNADA</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($sede->levelSedeEducational as $levelSede)
                                            <tr>
                                                <td class="text-wrap" style="max-width: 200px;">
                                                    {{ $levelSede->educationalLevel->name }}
                                                </td>
                                                <td>
                                                    @if($levelSede->educationalLevel->document_id)
                                                        <a href="{{ $levelSede->educationalLevel->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                                            <i class="fas fa-eye"></i> Ver Anexo
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($levelSede?->schedules)
                                                        @foreach($levelSede->schedules as $schedule)
                                                            {{$schedule->name}}
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($levelSede?->schedules)
                                                        @foreach($levelSede->schedules as $schedule)
                                                            @if($schedule?->anexo?->url)
                                                                <a href="{{ $schedule->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                                                    <i class="fas fa-eye"></i> Ver Anexo
                                                                </a>
                                                                @if(!$loop->last) @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('educational-offer.vinculate-show', ['levelSedeId' => $levelSede->id]) }}" class="btn btn-primary btn-sm">Ver detalles</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                        cantidad.value='';
                        cantidad.style.display = 'none';
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
                    const cantidadInput = document.getElementById('cantidad_aulas');
                    cantidadInput.value = '';

                }
            });

    </script>
@endsection
