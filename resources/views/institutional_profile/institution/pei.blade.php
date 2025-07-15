@extends('layouts.app')

@section('content')

@php
    $gestion_directiva = $gestion_directiva ?? null;
    $gestion_academica = $gestion_academica ?? null;
    $gestion_comunidad = $gestion_comunidad ?? null;
    $gestion_administrativa = $gestion_administrativa ?? null;
@endphp
<style>
    /* Color base para azul pastel */
    :root {
        --blue-pastel: #cfe2ff;
        --blue-pastel-bg: #E2EDFF;
    }
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

    /* Estilo de tabs */
    .nav-tabs .nav-link {
        background-color: #d6d6d6; /* Gris claro */
        border: 1px solid transparent;
        color: #000;
    }

    .nav-tabs .nav-link.active {
        background-color: var(--blue-pastel); /* Azul pastel */
        color: #084298;
        border-color: #dee2e6 #dee2e6 #fff;
    }
</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.show', $institucionId) }}" class="btn btn-outline-primary btn-sm">Perfil</a>
            <a href="#" class="btn btn-success  btn-sm">PEI</a>
            <a href="{{ route('institution.autoevaluaciones', $institucionId) }}" class="btn btn-outline-info btn-sm">Autoevaluación</a>
            <a href="{{ route('pmi.index') }}" class="btn btn-outline-secondary  btn-sm">PMI</a>
        </div>
    </div>

    <!-- <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.edit', $institucionId) }}" class="btn btn-outline-warning btn-sm">Editar</a>
            <a href="{{ route('institution.autoevaluaciones', $institucionId) }}" class="btn btn-outline-info btn-sm">Autoevaluaciones</a>
            <a href="{{ route('institution.pei', $institucionId) }}" class="btn btn-outline-success  btn-sm active">PEI</a>
            <form  action="{{ route('institution.destroy', $institucionId) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta institución?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
            </form>
        </div>
    </div> -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body ">
                        <h5 class="card-header">
                            <!-- <center>
                                <h2>PROYECTO EDUCATIVO INSTITUCIONAL (PEI)</h2>
                            </center> -->
                        </h5>
                        <div class="col-md-12">
                            <div class="card text-center mb-3">
                                <div class="card-header ">
                                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-resena-historica" aria-controls="navs-tab-resena-historica" aria-selected="true">RESEÑA HISTORICA</button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-directiva" aria-controls="navs-tab-gestion-directiva" aria-selected="true">GESTIÓN DIRECTIVA</button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-academica" aria-controls="navs-tab-gestion-academica" aria-selected="true">GESTIÓN ACADEMICA</button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-administrativa" aria-controls="navs-tab-gestion-administrativa" aria-selected="true">GESTIÓN ADMINISTRATIVA Y FINANCIERA</button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-comunidad" aria-controls="navs-tab-gestion-comunidad" aria-selected="true">GESTIÓN DE LA COMUNIDAD</button>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('institution.pei.update-pei', ['institutionId' => request()->route('institutionId')]) }}" class="nav-link">ACTUALIZAR</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">

                                    <!-- Resena historica -->
                                    <div class="tab-pane fade show active" id="navs-tab-resena-historica" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body ">
                                                
                                                @php
                                                    $resenaHistorica = $resena_historica->resenahistorica ?? null;
                                                @endphp
                                                
                                                <!-- Resena historica -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    @php
                                                        $camposGrupos = [
                                                            'Reseña historica' => 'resena_historica',
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposGrupos as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $resenaHistorica->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestión Directiva -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-directiva" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body ">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold  pb-2 mb-4">GESTIÓN DIRECTIVA</h4>

                                                <!-- Direccionamiento Estratégico -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">DIRECCIONAMIENTO ESTRATÉGICO</h5>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Misión:</div>
                                                        <div class="text-break">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->mision ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Visión:</div>
                                                        <div class="text-break">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->vision ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Principios institucionales:</div>
                                                        <div class="text-break">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->principios_institucionales ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Metas institucionales:</div>
                                                        <div class="text-break">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->metas_institucionales ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Política de inclusión:</div>
                                                        <div class="text-break">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->politica_inclusion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de política:</div>
                                                        <div class="text-break">
                                                            @if(isset($gestion_directiva->direccionamientoEstrategico->anexoPoliticaInclusion))
                                                                <a href="{{ $gestion_directiva->direccionamientoEstrategico->anexoPoliticaInclusion->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Gestión Estratégica -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">GESTIÓN ESTRATÉGICA</h5>
                                                    
                                                    @php
                                                        $gestionEstrategica = $gestion_directiva->gestionEstrategica ?? null;
                                                        $camposEstrategica = [
                                                            'Liderazgo y trabajo en equipo' => 'liderazgo',
                                                            'Articulación de planes' => 'articulacion',
                                                            'Seguimiento y autoevaluación' => 'seguimiento'
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposEstrategica as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $gestionEstrategica->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Gobierno Escolar -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">GOBIERNO ESCOLAR</h5>
                                                    
                                                    @php
                                                        $gobiernoEscolar = $gestion_directiva->gobiernoEscolar ?? null;
                                                    @endphp
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Gobierno escolar:</div>
                                                        <div class="text-break">
                                                            {!! $gobiernoEscolar->gobierno_escolar ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Manual de Funciones Gobierno Escolar:</div>
                                                        <div class="text-break">
                                                            @if($gobiernoEscolar && $gobiernoEscolar->anexoGobiernoEscolar)
                                                                <a href="{{ $gobiernoEscolar->anexoGobiernoEscolar->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cultura Institucional -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">CULTURA INSTITUCIONAL</h5>
                                                    
                                                    @php
                                                        $culturaInstitucional = $gestion_directiva->culturaInstitucional ?? null;
                                                        $camposCultura = [
                                                            'Política de comunicación' => 'politica_comunicacion',
                                                            'Política de bienestar' => 'politica_bienestar',
                                                            'Buenas prácticas' => 'inventario_buenas_practicas'
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposCultura as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $culturaInstitucional->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de política:</div>
                                                        <div class="text-break">
                                                            @if($culturaInstitucional && $culturaInstitucional->anexoPoliticaBienestar)
                                                                <a href="{{ $culturaInstitucional->anexoPoliticaBienestar->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de bienestar:</div>
                                                        <div class="text-break">
                                                            @if($culturaInstitucional && $culturaInstitucional->anexoCulturaInstitucional)
                                                                <a href="{{ $culturaInstitucional->anexoCulturaInstitucional->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Clima Escolar -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">CLIMA ESCOLAR</h5>
                                                    
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
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $climaEscolar->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de inducción:</div>
                                                        <div class="text-break">
                                                            @if($climaEscolar && $climaEscolar->anexoProgramaInstitucionalInduccion)
                                                                <a href="{{ $climaEscolar->anexoProgramaInstitucionalInduccion->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Manual de convivencia:</div>
                                                        <div class="text-break">
                                                            @if($climaEscolar && $climaEscolar->manualConvivencia)
                                                                <a href="{{ $climaEscolar->manualConvivencia->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Relaciones con el Entorno -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">RELACIONES CON EL ENTORNO</h5>
                                                    
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
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $relacionesEntorno->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de alianzas:</div>
                                                        <div class="text-break">
                                                            @if($relacionesEntorno && $relacionesEntorno->anexoAlianzasInstituciones)
                                                                <a href="{{ $relacionesEntorno->anexoAlianzasInstituciones->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento sector productivo:</div>
                                                        <div class="text-break">
                                                            @if($relacionesEntorno && $relacionesEntorno->anexoAlianzasSectorProductivo)
                                                                <a href="{{ $relacionesEntorno->anexoAlianzasSectorProductivo->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestión Académica -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-academica" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body ">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold  pb-2 mb-4">GESTIÓN ACADÉMICA</h4>
                                                
                                                @php
                                                    $disenos = $gestion_academica->disenosPedagogicos ?? null;
                                                    $practicas = $gestion_academica->practicasPedagogicas ?? null;
                                                    $aulas = $gestion_academica->gestionAulas ?? null;
                                                    $seguimientos = $gestion_academica->seguimientosAcademicos ?? null;
                                                @endphp

                                                
                                                <!-- Diseño Pedagógico -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">DISEÑO PEDAGÓGICO</h5>
                                                    
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
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $disenos->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de plan:</div>
                                                        <div class="text-break">
                                                            @if($disenos && $disenos->anexoPlanEstudios)
                                                                <a href="{{ $disenos->anexoPlanEstudios->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de enfoque:</div>
                                                        <div class="text-break">
                                                            @if($disenos && $disenos->anexoEnfoquePedagogico)
                                                                <a href="{{ $disenos->anexoEnfoquePedagogico->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de análisis:</div>
                                                        <div class="text-break">
                                                            @if($disenos && $disenos->anexoAnalisisJornada)
                                                                <a href="{{ $disenos->anexoAnalisisJornada->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento SIEE:</div>
                                                        <div class="text-break">
                                                            @if($disenos && $disenos->anexoSistemaEvaluacion)
                                                                <a href="{{ $disenos->anexoSistemaEvaluacion->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Prácticas Pedagógicas -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">PRÁCTICAS PEDAGÓGICAS</h5>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Estrategias para tareas:</div>
                                                        <div class="text-break">
                                                            {!! $practicas->estrategias_tareas ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Gestión de Aula -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">GESTIÓN DE AULA</h5>
                                                    
                                                    @php
                                                        $camposAulas = [
                                                            'Ambientes de aprendizaje' => 'ambientes_aprendizaje',
                                                            'Motivación al aprendizaje' => 'motivacion_aprendizaje',
                                                            'Plan de aula' => 'plan_aula',
                                                            'Evaluación en el aula' => 'evaluacion_aula'
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposAulas as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $aulas->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documentos de aula:</div>
                                                        <div class="text-break">
                                                            @if($aulas && $aulas->anexoPlanesAula)
                                                                <a href="{{ $aulas->anexoPlanesAula->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Temas de enseñanza:</div>
                                                        <div class="text-break">
                                                            @if($aulas && $aulas->anexoTemasEnsenanza)
                                                                <a href="{{ $aulas->anexoTemasEnsenanza->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Seguimiento Académico -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">SEGUIMIENTO ACADÉMICO</h5>
                                                    
                                                    @php
                                                        $camposSeguimiento = [
                                                            'Seguimiento a desempeños' => 'seguimiento_desempenos',
                                                            'Uso de evaluaciones externas' => 'uso_evaluaciones_externas',
                                                            'Apoyo pedagógico' => 'apoyo_pedagogico'
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposSeguimiento as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $seguimientos->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Informe estadístico:</div>
                                                        <div class="text-break">
                                                            @if($seguimientos && $seguimientos->anexoInformeEstadistico)
                                                                <a href="{{ $seguimientos->anexoInformeEstadistico->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Análisis de pruebas externas:</div>
                                                        <div class="text-break">
                                                            @if($seguimientos && $seguimientos->anexoAnalisisPruebasExternas)
                                                                <a href="{{ $seguimientos->anexoAnalisisPruebasExternas->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Planes de mejoramiento:</div>
                                                        <div class="text-break">
                                                            @if($seguimientos && $seguimientos->anexoPlanesMejoramiento)
                                                                <a href="{{ $seguimientos->anexoPlanesMejoramiento->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestión Administrativa y Financiera -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-administrativa" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body ">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold  pb-2 mb-4">GESTIÓN ADMINISTRATIVA Y FINANCIERA</h4>
                                                
                                                @php
                                                    $plantaFisica = $gestion_administrativa->administracionPlantaFisica ?? null;
                                                    $financiero = $gestion_administrativa->apoyoFinancieroContable ?? null;
                                                    $apoyoAcademico = $gestion_administrativa->apoyoGestionAcademica ?? null;
                                                    $servicios = $gestion_administrativa->serviciosComplementarios ?? null;
                                                    $talento = $gestion_administrativa->talentoHumano ?? null;
                                                @endphp
                                                
                                                <!-- Apoyo a la gestión académica -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">APOYO A LA GESTIÓN ACADÉMICA</h5>
                                                    
                                                    @php
                                                        $camposApoyo = [
                                                            'Proceso de matrícula' => 'proceso_matricula',
                                                            'Sistema de información académica' => 'sistema_informacion_academica'
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposApoyo as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $apoyoAcademico->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Acto administrativo:</div>
                                                        <div class="text-break">
                                                            @if($apoyoAcademico && $apoyoAcademico->anexoActoAdministrativo)
                                                                <a href="{{ $apoyoAcademico->anexoActoAdministrativo->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Administración de la planta física -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">ADMINISTRACIÓN DE PLANTA FÍSICA</h5>
                                                    
                                                    @php
                                                        $camposPlanta = [
                                                            'Mantenimiento de infraestructura' => 'mantenimiento_infraestructura',
                                                            'Dotación de recursos' => 'dotacion_recursos_aprendizaje',
                                                            'Programas de seguridad' => 'programas_seguridad'
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposPlanta as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $plantaFisica->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Política de mantenimiento:</div>
                                                        <div class="text-break">
                                                            @if($plantaFisica && $plantaFisica->anexoMantenimientoInfraestructura)
                                                                <a href="{{ $plantaFisica->anexoMantenimientoInfraestructura->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Política de dotación:</div>
                                                        <div class="text-break">
                                                            @if($plantaFisica && $plantaFisica->anexoDotacionRecursos)
                                                                <a href="{{ $plantaFisica->anexoDotacionRecursos->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Servicios complementarios -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">SERVICIOS COMPLEMENTARIOS</h5>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Estrategias de acceso:</div>
                                                        <div class="text-break">
                                                            {!! $servicios->estrategias_acceso_permanencia ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Talento humano -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">TALENTO HUMANO</h5>
                                                    
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
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $talento->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento de formación:</div>
                                                        <div class="text-break">
                                                            @if($talento && $talento->anexoProgramaFormacion)
                                                                <a href="{{ $talento->anexoProgramaFormacion->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Informe de evaluación:</div>
                                                        <div class="text-break">
                                                            @if($talento && $talento->anexoInformeAnual)
                                                                <a href="{{ $talento->anexoInformeAnual->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Apoyo financiero -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">APOYO FINANCIERO</h5>
                                                    
                                                    @php
                                                        $camposFinanciero = [
                                                            'Presupuesto FSE' => 'presupuesto_fse',
                                                            'Contabilidad' => 'contabilidad',
                                                            'Contratación' => 'contratacion',
                                                            'Control fiscal' => 'control_fiscal'
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposFinanciero as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $financiero->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento presupuesto:</div>
                                                        <div class="text-break">
                                                            @if($financiero && $financiero->anexoPresupuestoFse)
                                                                <a href="{{ $financiero->anexoPresupuestoFse->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Manual de contratación:</div>
                                                        <div class="text-break">
                                                            @if($financiero && $financiero->anexoManualContratacion)
                                                                <a href="{{ $financiero->anexoManualContratacion->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestión de la Comunidad -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-comunidad" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body ">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold  pb-2 mb-4">GESTIÓN DE LA COMUNIDAD</h4>
                                                
                                                @php
                                                    $gruposPoblacionales = $gestion_comunidad->atencionGrupoPoblacionales ?? null;
                                                    $servicioSocial = $gestion_comunidad->programasServicioSocial ?? null;
                                                    $prevencion = $gestion_comunidad->prevencionRiesgos ?? null;
                                                @endphp
                                                
                                                <!-- Atención educativa a grupos poblacionales -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">ATENCIÓN EDUCATIVA A GRUPOS POBLACIONALES</h5>
                                                    
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
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $gruposPoblacionales->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Proyecto escuela de padres:</div>
                                                        <div class="text-break">
                                                            @if($gruposPoblacionales && $gruposPoblacionales->anexoProyectoEscuelaPadres)
                                                                <a href="{{ $gruposPoblacionales->anexoProyectoEscuelaPadres->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Programa de servicio social -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">PROGRAMA DE SERVICIO SOCIAL</h5>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Programa institucional:</div>
                                                        <div class="text-break">
                                                            {!! $servicioSocial->programa_servicio_social ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento del programa:</div>
                                                        <div class="text-break">
                                                            @if($servicioSocial && $servicioSocial->anexoProgramaServicioSocial)
                                                                <a href="{{ $servicioSocial->anexoProgramaServicioSocial->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Prevención de riesgos -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">PREVENCIÓN DE RIESGOS</h5>
                                                    
                                                    @php
                                                        $camposPrevencion = [
                                                            'Riesgos físicos' => 'prevencion_riesgos_fisicos',
                                                            'Riesgos psicosociales' => 'prevencion_riesgos_psicosociales'
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposPrevencion as $titulo => $campo)
                                                        <div class="mb-3 text-start">
                                                            <div class="fw-semibold">{{ $titulo }}:</div>
                                                            <div class="text-break">
                                                                {!! $prevencion->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="mb-3 text-start">
                                                        <div class="fw-semibold">Documento prevención:</div>
                                                        <div class="text-break">
                                                            @if($prevencion && $prevencion->anexoPrevencionRiesgosFisicos)
                                                                <a href="{{ $prevencion->anexoPrevencionRiesgosFisicos->url }}" target="_blank" class="badge bg-primary rounded-pill text-decoration-none">
                                                                    Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
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
@endsection