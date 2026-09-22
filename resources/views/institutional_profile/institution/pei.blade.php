@extends('layouts.app')

@section('content')

    @php
        $gestion_directiva = $gestion_directiva ?? null;
        $gestion_academica = $gestion_academica ?? null;
        $gestion_comunidad = $gestion_comunidad ?? null;
        $gestion_administrativa = $gestion_administrativa ?? null;
    @endphp

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #d98b8b;
        }
    </style>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div
            data-component="CInstitutionNavigations"
            data-back-url="{{ route('institution.index') }}"
            data-detail-url="{{ route('institution.show', $institucionId) }}"
            data-pei-url="#"
            data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
            data-pmi-url="{{ route('pmi.index', $institucionId) }}"
            data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institucionId) }}"
            data-institution-name="{{ $institucionNombre ?? '' }}"
        >
        </div>

        <!-- Content -->
        <div class="container mx-auto px-4 py-8 max-w-7xl">
            <div class="w-full">
                <div class="bg-white mb-4 !border border-custom-blue-light rounded-xl shadow-sm">
                    <div class="flex flex-col justify-center items-center">
                        <div class="py-3 text-center text-2xl text-custom-blue-light font-semibold">
                            {{ $institucionNombre ?? 'Nombre de la institución'}}
                        </div>
                        <div class="w-[95%] mx-auto mb-3 !border border-custom-blue-dark rounded-xl">
                            <!-- Tabs Navigation -->
                            <div class="text-center">
                                <div class="py-6 mx-4 gap-2 items-center justify-center">
                                    <div class="flex flex-wrap w-full border-gray-200" role="tablist" id="pei-tabs">
                                        <div class="flex-1">
                                            <button
                                                type="button"
                                                class="whitespace-nowrap p-1 tab-button w-full text-xs font-semibold bg-custom-blue-dark text-white rounded-md transition-colors duration-200 border-b-2 border-transparent active"
                                                role="tab"
                                                data-tab="resena-historica"
                                                aria-selected="true"
                                            >
                                                RESEÑA HISTORICA
                                            </button>
                                        </div>
                                        <div class="flex-1">
                                            <button
                                                type="button"
                                                class="whitespace-nowrap p-1  tab-button w-full text-xs font-semibold text-black bg-transparent  transition-colors duration-200 border-b-2 border-transparent"
                                                role="tab"
                                                data-tab="gestion-directiva"
                                            >
                                                GESTIÓN DIRECTIVA
                                            </button>
                                        </div>
                                        <div class="flex-1">
                                            <button
                                                type="button"
                                                class="whitespace-nowrap p-1  tab-button w-full text-xs font-semibold text-black bg-transparent  transition-colors duration-200 border-b-2 border-transparent"
                                                role="tab"
                                                data-tab="gestion-academica"
                                            >
                                                GESTIÓN ACADEMICA
                                            </button>
                                        </div>
                                        <div class="flex-1">
                                            <button
                                                type="button"
                                                class="whitespace-nowrap p-1  tab-button w-full text-xs font-semibold text-black bg-transparent  transition-colors duration-200 border-b-2 border-transparent"
                                                role="tab"
                                                data-tab="gestion-administrativa"
                                            >
                                                GESTIÓN ADMINISTRATIVA Y FINANCIERA
                                            </button>
                                        </div>
                                        <div class="flex-1">
                                            <button
                                                type="button"
                                                class="whitespace-nowrap p-1 tab-button w-full text-xs font-semibold text-black bg-transparent  transition-colors duration-200 border-b-2 border-transparent"
                                                role="tab"
                                                data-tab="gestion-comunidad"
                                            >
                                                GESTIÓN DE LA COMUNIDAD
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Contents -->
                                <div class="tab-content-wrapper">

                                    <!-- Resena historica -->
                                    <div class="tab-content active" id="tab-resena-historica" role="tabpanel">
                                        <div class="bg-white rounded-lg mb-4">
                                            <div class="flex">

                                                @php
                                                    $resenaHistorica = $resena_historica->resenahistorica ?? null;
                                                @endphp

                                                    <!-- Resena historica -->
                                                <div class="mb-4 w-full !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    @php
                                                        $camposGrupos = [
                                                            'Reseña historica' => 'resena_historica',
                                                        ];
                                                    @endphp
                                                    <div class="flex w-full justify-end gap-2">
                                                        <a
                                                            href="{{ route('institution.pei.update-pei', ['institutionId' => request()->route('institutionId')]) }}"
                                                            class=" !border border-custom-blue-light rounded-full text-custom-blue-light p-1 text-xs font-semibold  bg-transparent hover:!text-custom-blue-dark"
                                                        >
                                                            <i class="fa-solid fa-arrow-rotate-left"></i>
                                                            Actualizar
                                                        </a>
                                                        <a
                                                            href="{{ route('institution.pei.update-pei', ['institutionId' => request()->route('institutionId')]) }}"
                                                            class=" bg-custom-blue-dark rounded-circle text-white py-1 px-2 text-xs font-semibold"
                                                        >
                                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                                        </a>
                                                    </div>
                                                    @foreach($camposGrupos as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $resenaHistorica->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestión Directiva -->
                                    <div class="tab-content hidden" id="tab-gestion-directiva" role="tabpanel">
                                        <div class="bg-white rounded-lg mb-4">
                                            <div class="flex-col">
                                                <!-- Direccionamiento Estratégico -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">DIRECCIONAMIENTO ESTRATÉGICO</h5>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Misión:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->mision ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Visión:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->vision ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Principios institucionales:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->principios_institucionales ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Metas institucionales:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->metas_institucionales ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Política de inclusión:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->politica_inclusion ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de política:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if(isset($gestion_directiva->direccionamientoEstrategico->anexoPoliticaInclusion))
                                                                <a href="{{ $gestion_directiva->direccionamientoEstrategico->anexoPoliticaInclusion->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Gestión Estratégica -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">GESTIÓN ESTRATÉGICA</h5>

                                                    @php
                                                        $gestionEstrategica = $gestion_directiva->gestionEstrategica ?? null;
                                                        $camposEstrategica = [
                                                            'Liderazgo y trabajo en equipo' => 'liderazgo',
                                                            'Articulación de planes' => 'articulacion',
                                                            'Seguimiento y autoevaluación' => 'seguimiento'
                                                        ];
                                                    @endphp

                                                    @foreach($camposEstrategica as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $gestionEstrategica->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Gobierno Escolar -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">GOBIERNO ESCOLAR</h5>

                                                    @php
                                                        $gobiernoEscolar = $gestion_directiva->gobiernoEscolar ?? null;
                                                    @endphp

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Gobierno escolar:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $gobiernoEscolar->gobierno_escolar ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Manual de Funciones Gobierno Escolar:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($gobiernoEscolar && $gobiernoEscolar->anexoGobiernoEscolar)
                                                                <a href="{{ $gobiernoEscolar->anexoGobiernoEscolar->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cultura Institucional -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">CULTURA INSTITUCIONAL</h5>

                                                    @php
                                                        $culturaInstitucional = $gestion_directiva->culturaInstitucional ?? null;
                                                        $camposCultura = [
                                                            'Política de comunicación' => 'politica_comunicacion',
                                                            'Política de bienestar' => 'politica_bienestar',
                                                            'Buenas prácticas' => 'inventario_buenas_practicas'
                                                        ];
                                                    @endphp

                                                    @foreach($camposCultura as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $culturaInstitucional->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de política:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($culturaInstitucional && $culturaInstitucional->anexoPoliticaBienestar)
                                                                <a href="{{ $culturaInstitucional->anexoPoliticaBienestar->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de bienestar:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($culturaInstitucional && $culturaInstitucional->anexoCulturaInstitucional)
                                                                <a href="{{ $culturaInstitucional->anexoCulturaInstitucional->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Clima Escolar -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">CLIMA ESCOLAR</h5>

                                                    @php
                                                        $climaEscolar = $gestion_directiva->climaEscolar ?? null;
                                                        $camposClima = [
                                                            'Sentido de pertenencia' => 'sentido_pertenencia',
                                                            'Inducción institucional' => 'induccion_institucional',
                                                            'Actividades extracurriculares' => 'actividades_extracurriculares',
                                                            'Manejo de conflictos' => 'manejo_conflictos'
                                                        ];
                                                    @endphp

                                                    @foreach($camposClima as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $climaEscolar->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de inducción:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($climaEscolar && $climaEscolar->anexoProgramaInstitucionalInduccion)
                                                                <a href="{{ $climaEscolar->anexoProgramaInstitucionalInduccion->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Manual de convivencia:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($climaEscolar && $climaEscolar->manualConvivencia)
                                                                <a href="{{ $climaEscolar->manualConvivencia->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Relaciones con el Entorno -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">RELACIONES CON EL ENTORNO</h5>

                                                    @php
                                                        $relacionesEntorno = $gestion_directiva->relacionesEntorno ?? null;
                                                        $camposRelaciones = [
                                                            'Relación con familias' => 'relacion_familias',
                                                            'Seguimiento a egresados' => 'seguimiento_egresados',
                                                            'Alianzas institucionales' => 'alianzas_instituciones',
                                                            'Alianzas sector productivo' => 'alianzas_sector_productivo'
                                                        ];
                                                    @endphp

                                                    @foreach($camposRelaciones as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $relacionesEntorno->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de alianzas:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($relacionesEntorno && $relacionesEntorno->anexoAlianzasInstituciones)
                                                                <a href="{{ $relacionesEntorno->anexoAlianzasInstituciones->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento sector productivo:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($relacionesEntorno && $relacionesEntorno->anexoAlianzasSectorProductivo)
                                                                <a href="{{ $relacionesEntorno->anexoAlianzasSectorProductivo->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestión Académica -->
                                    <div class="tab-content hidden" id="tab-gestion-academica" role="tabpanel">
                                        <div class="bg-white rounded-lg mb-4">
                                            <div class="flex-col">
                                                @php
                                                    $disenos = $gestion_academica->disenosPedagogicos ?? null;
                                                    $practicas = $gestion_academica->practicasPedagogicas ?? null;
                                                    $aulas = $gestion_academica->gestionAulas ?? null;
                                                    $seguimientos = $gestion_academica->seguimientosAcademicos ?? null;
                                                @endphp


                                                    <!-- Diseño Pedagógico -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">DISEÑO PEDAGÓGICO</h5>

                                                    @php
                                                        $camposDisenos = [
                                                            'Plan de estudios' => 'plan_estudios',
                                                            'Enfoque metodológico' => 'enfoque_metodologico',
                                                            'Estrategia pedagógica' => 'estrategia_pedagogica',
                                                            'Análisis jornada escolar' => 'analisis_jornada_escolar',
                                                            'Sistema de evaluación (SIEE)' => 'sistema_evaluacion'
                                                        ];
                                                    @endphp

                                                    @foreach($camposDisenos as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $disenos->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de plan:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($disenos && $disenos->anexoPlanEstudios)
                                                                <a href="{{ $disenos->anexoPlanEstudios->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de enfoque:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($disenos && $disenos->anexoEnfoquePedagogico)
                                                                <a href="{{ $disenos->anexoEnfoquePedagogico->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de análisis:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($disenos && $disenos->anexoAnalisisJornada)
                                                                <a href="{{ $disenos->anexoAnalisisJornada->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento SIEE:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($disenos && $disenos->anexoSistemaEvaluacion)
                                                                <a href="{{ $disenos->anexoSistemaEvaluacion->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Prácticas Pedagógicas -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">PRÁCTICAS PEDAGÓGICAS</h5>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Estrategias para tareas:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $practicas->estrategias_tareas ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Gestión de Aula -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">GESTIÓN DE AULA</h5>

                                                    @php
                                                        $camposAulas = [
                                                            'Ambientes de aprendizaje' => 'ambientes_aprendizaje',
                                                            'Motivación al aprendizaje' => 'motivacion_aprendizaje',
                                                            'Plan de aula' => 'plan_aula',
                                                            'Evaluación en el aula' => 'evaluacion_aula'
                                                        ];
                                                    @endphp

                                                    @foreach($camposAulas as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $aulas->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documentos de aula:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($aulas && $aulas->anexoPlanesAula)
                                                                <a href="{{ $aulas->anexoPlanesAula->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Temas de enseñanza:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($aulas && $aulas->anexoTemasEnsenanza)
                                                                <a href="{{ $aulas->anexoTemasEnsenanza->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Seguimiento Académico -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">SEGUIMIENTO ACADÉMICO</h5>

                                                    @php
                                                        $camposSeguimiento = [
                                                            'Seguimiento a desempeños' => 'seguimiento_desempenos',
                                                            'Uso de evaluaciones externas' => 'uso_evaluaciones_externas',
                                                            'Apoyo pedagógico' => 'apoyo_pedagogico'
                                                        ];
                                                    @endphp

                                                    @foreach($camposSeguimiento as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $seguimientos->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Informe estadístico:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($seguimientos && $seguimientos->anexoInformeEstadistico)
                                                                <a href="{{ $seguimientos->anexoInformeEstadistico->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Análisis de pruebas externas:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($seguimientos && $seguimientos->anexoAnalisisPruebasExternas)
                                                                <a href="{{ $seguimientos->anexoAnalisisPruebasExternas->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Planes de mejoramiento:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($seguimientos && $seguimientos->anexoPlanesMejoramiento)
                                                                <a href="{{ $seguimientos->anexoPlanesMejoramiento->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestión Administrativa y Financiera -->
                                    <div class="tab-content hidden" id="tab-gestion-administrativa" role="tabpanel">
                                        <div class="bg-white rounded-lg mb-4">
                                            <div class="flex-col">

                                                @php
                                                    $plantaFisica = $gestion_administrativa->administracionPlantaFisica ?? null;
                                                    $financiero = $gestion_administrativa->apoyoFinancieroContable ?? null;
                                                    $apoyoAcademico = $gestion_administrativa->apoyoGestionAcademica ?? null;
                                                    $servicios = $gestion_administrativa->serviciosComplementarios ?? null;
                                                    $talento = $gestion_administrativa->talentoHumano ?? null;
                                                @endphp

                                                    <!-- Apoyo a la gestión académica -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">APOYO A LA GESTIÓN ACADÉMICA</h5>

                                                    @php
                                                        $camposApoyo = [
                                                            'Proceso de matrícula' => 'proceso_matricula',
                                                            'Sistema de información académica' => 'sistema_informacion_academica'
                                                        ];
                                                    @endphp

                                                    @foreach($camposApoyo as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $apoyoAcademico->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Acto administrativo:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($apoyoAcademico && $apoyoAcademico->anexoActoAdministrativo)
                                                                <a href="{{ $apoyoAcademico->anexoActoAdministrativo->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Administración de la planta física -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">ADMINISTRACIÓN DE PLANTA FÍSICA</h5>

                                                    @php
                                                        $camposPlanta = [
                                                            'Mantenimiento de infraestructura' => 'mantenimiento_infraestructura',
                                                            'Dotación de recursos' => 'dotacion_recursos_aprendizaje',
                                                            'Programas de seguridad' => 'programas_seguridad'
                                                        ];
                                                    @endphp

                                                    @foreach($camposPlanta as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $plantaFisica->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Política de mantenimiento:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($plantaFisica && $plantaFisica->anexoMantenimientoInfraestructura)
                                                                <a href="{{ $plantaFisica->anexoMantenimientoInfraestructura->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Política de dotación:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($plantaFisica && $plantaFisica->anexoDotacionRecursos)
                                                                <a href="{{ $plantaFisica->anexoDotacionRecursos->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Servicios complementarios -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">SERVICIOS COMPLEMENTARIOS</h5>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Estrategias de acceso:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $servicios->estrategias_acceso_permanencia ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Talento humano -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">TALENTO HUMANO</h5>

                                                    @php
                                                        $camposTalento = [
                                                            'Perfiles y asignación' => 'perfiles_asignacion',
                                                            'Programa de formación' => 'programa_formacion_capacitacion',
                                                            'Pertenencia del personal' => 'pertenencia_personal',
                                                            'Evaluación de desempeño' => 'evaluacion_desempeno',
                                                            'Convivencia y conflictos' => 'convivencia_manejo_conflictos'
                                                        ];
                                                    @endphp

                                                    @foreach($camposTalento as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $talento->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento de formación:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($talento && $talento->anexoProgramaFormacion)
                                                                <a href="{{ $talento->anexoProgramaFormacion->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Informe de evaluación:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($talento && $talento->anexoInformeAnual)
                                                                <a href="{{ $talento->anexoInformeAnual->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Apoyo financiero -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">APOYO FINANCIERO</h5>

                                                    @php
                                                        $camposFinanciero = [
                                                            'Presupuesto FSE' => 'presupuesto_fse',
                                                            'Contabilidad' => 'contabilidad',
                                                            'Contratación' => 'contratacion',
                                                            'Control fiscal' => 'control_fiscal'
                                                        ];
                                                    @endphp

                                                    @foreach($camposFinanciero as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $financiero->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento presupuesto:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($financiero && $financiero->anexoPresupuestoFse)
                                                                <a href="{{ $financiero->anexoPresupuestoFse->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Manual de contratación:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($financiero && $financiero->anexoManualContratacion)
                                                                <a href="{{ $financiero->anexoManualContratacion->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestión de la Comunidad -->
                                    <div class="tab-content hidden" id="tab-gestion-comunidad" role="tabpanel">
                                        <div class="bg-white rounded-lg mb-4">
                                            <div class="flex-col">
                                                @php
                                                    $gruposPoblacionales = $gestion_comunidad->atencionGrupoPoblacionales ?? null;
                                                    $servicioSocial = $gestion_comunidad->programasServicioSocial ?? null;
                                                    $prevencion = $gestion_comunidad->prevencionRiesgos ?? null;
                                                @endphp

                                                    <!-- Atención educativa a grupos poblacionales -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">ATENCIÓN EDUCATIVA A GRUPOS POBLACIONALES</h5>

                                                    @php
                                                        $camposGrupos = [
                                                            'Atención a grupos vulnerables' => 'atencion_grupos_vulnerabilidad',
                                                            'Necesidades y expectativas' => 'necesidades_expectativas_estudiantes',
                                                            'Proyectos de vida' => 'proyectos_vida',
                                                            'Escuela de padres' => 'escuela_padres',
                                                            'Oferta de servicios' => 'oferta_servicios_comunidad'
                                                        ];
                                                    @endphp

                                                    @foreach($camposGrupos as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $gruposPoblacionales->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Proyecto escuela de padres:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($gruposPoblacionales && $gruposPoblacionales->anexoProyectoEscuelaPadres)
                                                                <a href="{{ $gruposPoblacionales->anexoProyectoEscuelaPadres->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Programa de servicio social -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">PROGRAMA DE SERVICIO SOCIAL</h5>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Programa institucional:</div>
                                                        <div class="break-words text-gray-700">
                                                            {!! $servicioSocial->programa_servicio_social ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento del programa:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($servicioSocial && $servicioSocial->anexoProgramaServicioSocial)
                                                                <a href="{{ $servicioSocial->anexoProgramaServicioSocial->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Prevención de riesgos -->
                                                <div class="mb-4 !border border-custom-blue-dark rounded-lg p-4 shadow-sm">
                                                    <h5 class="text-lg font-bold text-gray-800 mb-3">PREVENCIÓN DE RIESGOS</h5>

                                                    @php
                                                        $camposPrevencion = [
                                                            'Riesgos físicos' => 'prevencion_riesgos_fisicos',
                                                            'Riesgos psicosociales' => 'prevencion_riesgos_psicosociales'
                                                        ];
                                                    @endphp

                                                    @foreach($camposPrevencion as $titulo => $campo)
                                                        <div class="mb-3 text-left">
                                                            <div class="font-semibold text-gray-800 mb-2">{{ $titulo }}:</div>
                                                            <div class="break-words text-gray-700">
                                                                {!! $prevencion->$campo ?? '<span class="text-gray-500 italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-left">
                                                        <div class="font-semibold text-gray-800 mb-2">Documento prevención:</div>
                                                        <div class="break-words text-gray-700">
                                                            @if($prevencion && $prevencion->anexoPrevencionRiesgosFisicos)
                                                                <a href="{{ $prevencion->anexoPrevencionRiesgosFisicos->url }}" target="_blank" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full hover:bg-blue-700 transition-colors no-underline">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500 italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-blue-600', 'text-white');
                        btn.classList.add('bg-transparent', 'text-black');
                    });

                    // Add active class to clicked button
                    this.classList.remove('bg-transparent', 'text-black');
                    this.classList.add('active', 'bg-custom-blue-dark', 'rounded-md', 'text-white');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                        content.classList.remove('active');
                    });

                    // Show target tab content
                    const targetContent = document.getElementById('tab-' + targetTab);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                        targetContent.classList.add('active');
                    }
                });
            });
        });
    </script>

@endsection
