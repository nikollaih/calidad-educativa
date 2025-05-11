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

    /* Botón del acordeón abierto */
    .accordion-button:not(.collapsed) {
        background-color: var(--blue-pastel);
    }

    /* Botón del acordeón en hover */
    .accordion-button:hover {
        background-color: var(--blue-pastel);
    }

    /* Cuerpo del acordeón cuando está visible (desplegado) */
    .accordion-collapse.show .accordion-body {
        background-color: var(--blue-pastel-bg);
    }

    /* Hover dentro del cuerpo también azul pastel */
    .accordion-body:hover {
        background-color: var(--blue-pastel-bg);
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
        
    <div
        data-component="CBackButton"
    >
    </div>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-header">
                            <center>
                                <h2>PROYECTO EDUCATIVO INSTITUCIONAL (PEI)</h2>
                            </center>
                        </h5>
                        <div class="col-md-12">
                            <div class="card text-center mb-3">
                                <div class="card-header ">
                                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-directiva" aria-controls="navs-tab-gestion-directiva" aria-selected="true">1. GESTIÓN DIRECTIVA</button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-academica" aria-controls="navs-tab-gestion-academica" aria-selected="true">2. GESTIÓN ACADEMICA</button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-administrativa" aria-controls="navs-tab-gestion-administrativa" aria-selected="true">3. GESTIÓN ADMINISTRATIVA Y FINANCIERA</button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-comunidad" aria-controls="navs-tab-gestion-comunidad" aria-selected="true">4. GESTIÓN DE LA COMUNIDAD</button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-resena-historica" aria-controls="navs-tab-resena-historica" aria-selected="true">5. RESEÑA HISTORICA</button>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('institution.pei.update-pei', ['institutionId' => request()->route('institutionId')]) }}" class="nav-link">5. ACTUALIZAR INFORMACIÓN</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">

                                    <!-- Gestión Directiva -->
                                    <div class="tab-pane fade show active" id="navs-tab-gestion-directiva" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body p-4">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold  pb-2 mb-4">GESTIÓN DIRECTIVA</h4>
                                                

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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $climaEscolar->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de inducción:</div>
                                                        <div class="col-md-6">
                                                            @if($climaEscolar && $climaEscolar->anexoProgramaInstitucionalInduccion)
                                                                <a href="{{ $climaEscolar->anexoProgramaInstitucionalInduccion->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Manual de convivencia:</div>
                                                        <div class="col-md-6">
                                                            @if($climaEscolar && $climaEscolar->manualConvivencia)
                                                                <a href="{{ $climaEscolar->manualConvivencia->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $culturaInstitucional->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de política:</div>
                                                        <div class="col-md-6">
                                                            @if($culturaInstitucional && $culturaInstitucional->anexoPoliticaBienestar)
                                                                <a href="{{ $culturaInstitucional->anexoPoliticaBienestar->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de bienestar:</div>
                                                        <div class="col-md-6">
                                                            @if($culturaInstitucional && $culturaInstitucional->anexoCulturaInstitucional)
                                                                <a href="{{ $culturaInstitucional->anexoCulturaInstitucional->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Direccionamiento Estratégico -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <h5 class="fw-bold mb-3">DIRECCIONAMIENTO ESTRATÉGICO</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Misión:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->mision ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Visión:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->vision ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Principios institucionales:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->principios_institucionales ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Metas institucionales:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->metas_institucionales ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Política de inclusión:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_directiva->direccionamientoEstrategico->politica_inclusion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de política:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_directiva->direccionamientoEstrategico->anexoPoliticaInclusion))
                                                                <a href="{{ $gestion_directiva->direccionamientoEstrategico->anexoPoliticaInclusion->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
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
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Gobierno escolar:</div>
                                                        <div class="col-md-6">
                                                            {!! $gobiernoEscolar->gobierno_escolar ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Manual de Funciones Gobierno Escolar:</div>
                                                        <div class="col-md-6">
                                                            @if($gobiernoEscolar && $gobiernoEscolar->anexoGobiernoEscolar)
                                                                <a href="{{ $gobiernoEscolar->anexoGobiernoEscolar->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $relacionesEntorno->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de alianzas:</div>
                                                        <div class="col-md-6">
                                                            @if($relacionesEntorno && $relacionesEntorno->anexoAlianzasInstituciones)
                                                                <a href="{{ $relacionesEntorno->anexoAlianzasInstituciones->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento sector productivo:</div>
                                                        <div class="col-md-6">
                                                            @if($relacionesEntorno && $relacionesEntorno->anexoAlianzasSectorProductivo)
                                                                <a href="{{ $relacionesEntorno->anexoAlianzasSectorProductivo->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                            <div class="card-body p-4">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold  pb-2 mb-4">GESTIÓN ACADÉMICA</h4>
                                                
                                                @php
                                                    $disenos = $gestion_academica->disenosPedagogicos ?? null;
                                                    $practicas = $gestion_academica->practicasPedagogicas ?? null;
                                                    $aulas = $gestion_academica->gestionAulas ?? null;
                                                    $seguimientos = $gestion_academica->seguimientosAcademicos ?? null;
                                                @endphp

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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $aulas->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documentos de aula:</div>
                                                        <div class="col-md-6">
                                                            @if($aulas && $aulas->anexoPlanesAula)
                                                                <a href="{{ $aulas->anexoPlanesAula->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Temas de enseñanza:</div>
                                                        <div class="col-md-6">
                                                            @if($aulas && $aulas->anexoTemasEnsenanza)
                                                                <a href="{{ $aulas->anexoTemasEnsenanza->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documentos
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
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Estrategias para tareas:</div>
                                                        <div class="col-md-6">
                                                            {!! $practicas->estrategias_tareas ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $seguimientos->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Informe estadístico:</div>
                                                        <div class="col-md-6">
                                                            @if($seguimientos && $seguimientos->anexoInformeEstadistico)
                                                                <a href="{{ $seguimientos->anexoInformeEstadistico->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Análisis de pruebas externas:</div>
                                                        <div class="col-md-6">
                                                            @if($seguimientos && $seguimientos->anexoAnalisisPruebasExternas)
                                                                <a href="{{ $seguimientos->anexoAnalisisPruebasExternas->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Planes de mejoramiento:</div>
                                                        <div class="col-md-6">
                                                            @if($seguimientos && $seguimientos->anexoPlanesMejoramiento)
                                                                <a href="{{ $seguimientos->anexoPlanesMejoramiento->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $disenos->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de plan:</div>
                                                        <div class="col-md-6">
                                                            @if($disenos && $disenos->anexoPlanEstudios)
                                                                <a href="{{ $disenos->anexoPlanEstudios->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de enfoque:</div>
                                                        <div class="col-md-6">
                                                            @if($disenos && $disenos->anexoEnfoquePedagogico)
                                                                <a href="{{ $disenos->anexoEnfoquePedagogico->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de análisis:</div>
                                                        <div class="col-md-6">
                                                            @if($disenos && $disenos->anexoAnalisisJornada)
                                                                <a href="{{ $disenos->anexoAnalisisJornada->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento SIEE:</div>
                                                        <div class="col-md-6">
                                                            @if($disenos && $disenos->anexoSistemaEvaluacion)
                                                                <a href="{{ $disenos->anexoSistemaEvaluacion->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                            <div class="card-body p-4">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold  pb-2 mb-4">GESTIÓN ADMINISTRATIVA Y FINANCIERA</h4>
                                                
                                                @php
                                                    $plantaFisica = $gestion_administrativa->administracionPlantaFisica ?? null;
                                                    $financiero = $gestion_administrativa->apoyoFinancieroContable ?? null;
                                                    $apoyoAcademico = $gestion_administrativa->apoyoGestionAcademica ?? null;
                                                    $servicios = $gestion_administrativa->serviciosComplementarios ?? null;
                                                    $talento = $gestion_administrativa->talentoHumano ?? null;
                                                @endphp
                                                
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $plantaFisica->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Política de mantenimiento:</div>
                                                        <div class="col-md-6">
                                                            @if($plantaFisica && $plantaFisica->anexoMantenimientoInfraestructura)
                                                                <a href="{{ $plantaFisica->anexoMantenimientoInfraestructura->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Política de dotación:</div>
                                                        <div class="col-md-6">
                                                            @if($plantaFisica && $plantaFisica->anexoDotacionRecursos)
                                                                <a href="{{ $plantaFisica->anexoDotacionRecursos->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $financiero->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento presupuesto:</div>
                                                        <div class="col-md-6">
                                                            @if($financiero && $financiero->anexoPresupuestoFse)
                                                                <a href="{{ $financiero->anexoPresupuestoFse->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Manual de contratación:</div>
                                                        <div class="col-md-6">
                                                            @if($financiero && $financiero->anexoManualContratacion)
                                                                <a href="{{ $financiero->anexoManualContratacion->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $apoyoAcademico->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Acto administrativo:</div>
                                                        <div class="col-md-6">
                                                            @if($apoyoAcademico && $apoyoAcademico->anexoActoAdministrativo)
                                                                <a href="{{ $apoyoAcademico->anexoActoAdministrativo->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Estrategias de acceso:</div>
                                                        <div class="col-md-6">
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $talento->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de formación:</div>
                                                        <div class="col-md-6">
                                                            @if($talento && $talento->anexoProgramaFormacion)
                                                                <a href="{{ $talento->anexoProgramaFormacion->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Informe de evaluación:</div>
                                                        <div class="col-md-6">
                                                            @if($talento && $talento->anexoInformeAnual)
                                                                <a href="{{ $talento->anexoInformeAnual->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                            <div class="card-body p-4">
                                                
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $gruposPoblacionales->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Proyecto escuela de padres:</div>
                                                        <div class="col-md-6">
                                                            @if($gruposPoblacionales && $gruposPoblacionales->anexoProyectoEscuelaPadres)
                                                                <a href="{{ $gruposPoblacionales->anexoProyectoEscuelaPadres->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $prevencion->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Documentos especiales -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento prevención:</div>
                                                        <div class="col-md-6">
                                                            @if($prevencion && $prevencion->anexoPrevencionRiesgosFisicos)
                                                                <a href="{{ $prevencion->anexoPrevencionRiesgosFisicos->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Programa institucional:</div>
                                                        <div class="col-md-6">
                                                            {!! $servicioSocial->programa_servicio_social ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento del programa:</div>
                                                        <div class="col-md-6">
                                                            @if($servicioSocial && $servicioSocial->anexoProgramaServicioSocial)
                                                                <a href="{{ $servicioSocial->anexoProgramaServicioSocial->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
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
                                    <div class="tab-pane fade" id="navs-tab-resena-historica" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body p-4">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold  pb-2 mb-4">RESEÑA HISTORICA</h4>
                                                
                                                @php
                                                    $resenaHistorica = $resena_historica->resenahistorica ?? null;
                                                @endphp
                                                
                                                <!-- Resena historica -->
                                                <div class="mb-4 border rounded p-3 shadow-sm">
                                                    <!-- <h5 class="fw-bold mb-3">RESEÑA HISTORICA</h5> -->
                                                    
                                                    @php
                                                        $camposGrupos = [
                                                            'Reseña historica' => 'resena_historica',
                                                        ];
                                                    @endphp
                                                    
                                                    @foreach($camposGrupos as $titulo => $campo)
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 fw-semibold">{{ $titulo }}:</div>
                                                            <div class="col-md-6">
                                                                {!! $resenaHistorica->$campo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
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