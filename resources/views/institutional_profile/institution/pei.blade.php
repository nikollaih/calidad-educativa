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
                                <div class="card-header border-bottom">
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
                                    </ul>
                                </div>
                                <div class="tab-content">

                                   <!-- Gestión Directiva -->
<div class="tab-pane fade show active" id="navs-tab-gestion-directiva" role="tabpanel">
    <div class="card mb-4">
        <div class="card-body p-4">
            
            <!-- Título principal -->
            <h4 class="fw-bold border-bottom pb-2 mb-4">GESTIÓN DIRECTIVA</h4>
            
            <!-- Direccionamiento Estratégico -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3">DIRECCIONAMIENTO ESTRATÉGICO</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Misión:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->mision ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Visión:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->vision ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Principios institucionales:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->principios_institucionales ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Metas institucionales:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->metas_institucionales ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Política de inclusión:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->politica_inclusion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Documento de política:</div>
                    <div class="col-md-6">
                        @if(isset($gestion_directiva->anexoPoliticaInclusion))
                            <a href="{{ $gestion_directiva->anexoPoliticaInclusion->url }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                            </a>
                        @else
                            <span class="text-muted fst-italic">No disponible</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Gestión Estratégica -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3">GESTIÓN ESTRATÉGICA</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Liderazgo y trabajo en equipo:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->liderazgo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Articulación de planes:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->articulacion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Seguimiento y autoevaluación:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->seguimiento ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
            </div>

            <!-- Gobierno Escolar -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3">GOBIERNO ESCOLAR</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Gobierno escolar:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->gobierno_escolar ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Manual de Funciones Gobierno Escolar:</div>
                    <div class="col-md-6">
                        @if(isset($gestion_directiva->anexoGobiernoEscolar))
                            <a href="{{ $gestion_directiva->anexoGobiernoEscolar->url }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                            </a>
                        @else
                            <span class="text-muted fst-italic">No disponible</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cultura Institucional -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3">CULTURA INSTITUCIONAL</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Política de comunicación:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->politica_comunicacion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Documento de política:</div>
                    <div class="col-md-6">
                        @if(isset($gestion_directiva->anexoCulturaInstitucional))
                            <a href="{{ $gestion_directiva->anexoCulturaInstitucional->url }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                            </a>
                        @else
                            <span class="text-muted fst-italic">No disponible</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Política de bienestar:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->politica_bienestar ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Documento de bienestar:</div>
                    <div class="col-md-6">
                        @if(isset($gestion_directiva->anexoPoliticaBienestar))
                            <a href="{{ $gestion_directiva->anexoPoliticaBienestar->url }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                            </a>
                        @else
                            <span class="text-muted fst-italic">No disponible</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Buenas prácticas:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->inventario_buenas_practicas ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
            </div>

            <!-- Clima Escolar -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3">CLIMA ESCOLAR</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Sentido de pertenencia:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->sentido_pertenencia ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Inducción institucional:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->induccion_institucional ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Documento de inducción:</div>
                    <div class="col-md-6">
                        @if(isset($gestion_directiva->anexoProgramaInstitucionalInduccion))
                            <a href="{{ $gestion_directiva->anexoProgramaInstitucionalInduccion->url }}" target="_blank" class="text-decoration-none">
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
                        @if(isset($gestion_directiva->manualConvivencia))
                            <a href="{{ $gestion_directiva->manualConvivencia->url }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                            </a>
                        @else
                            <span class="text-muted fst-italic">No disponible</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Actividades extracurriculares:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->actividades_extracurriculares ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Manejo de conflictos:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->manejo_conflictos ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
            </div>

            <!-- Relaciones con el Entorno -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3">RELACIONES CON EL ENTORNO</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Relación con familias:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->relacion_familias ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Seguimiento a egresados:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->seguimiento_egresados ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Alianzas institucionales:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->alianzas_instituciones ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Documento de alianzas:</div>
                    <div class="col-md-6">
                        @if(isset($gestion_directiva->anexoAlianzasInstituciones))
                            <a href="{{ $gestion_directiva->anexoAlianzasInstituciones->url }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                            </a>
                        @else
                            <span class="text-muted fst-italic">No disponible</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Alianzas sector productivo:</div>
                    <div class="col-md-6">
                        {!! $gestion_directiva->alianzas_sector_productivo ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 fw-semibold">Documento sector productivo:</div>
                    <div class="col-md-6">
                        @if(isset($gestion_directiva->anexoAlianzasSectorProductivo))
                            <a href="{{ $gestion_directiva->anexoAlianzasSectorProductivo->url }}" target="_blank" class="text-decoration-none">
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
                                                <h4 class="fw-bold border-bottom pb-2 mb-4">GESTIÓN ACADÉMICA</h4>
                                                
                                                <!-- Diseño Pedagógico -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">DISEÑO PEDAGÓGICO</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Plan de estudios:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->plan_estudios ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de plan:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_academica->anexoPlanEstudios))
                                                                <a href="{{ $gestion_academica->anexoPlanEstudios->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Enfoque metodológico:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->enfoque_metodologico ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de enfoque:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_academica->anexoEnfoquePedagogico))
                                                                <a href="{{ $gestion_academica->anexoEnfoquePedagogico->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Estrategia pedagógica:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->estrategia_pedagogica ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Análisis jornada escolar:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->analisis_jornada_escolar ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de análisis:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_academica->anexoAnalisisJornada))
                                                                <a href="{{ $gestion_academica->anexoAnalisisJornada->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Sistema de evaluación (SIEE):</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->sistema_evaluacion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento SIEE:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_academica->anexoSistemaEvaluacion))
                                                                <a href="{{ $gestion_academica->anexoSistemaEvaluacion->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Prácticas Pedagógicas -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">PRÁCTICAS PEDAGÓGICAS</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Estrategias para tareas:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->estrategias_tareas ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Gestión de Aula -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">GESTIÓN DE AULA</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Ambientes de aprendizaje:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->ambientes_aprendizaje ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Motivación al aprendizaje:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->motivacion_aprendizaje ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Plan de aula:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->plan_aula ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documentos de aula:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_academica->anexosPlanesAula))
                                                                <a href="{{ $gestion_academica->anexosPlanesAula->url }}" target="_blank" class="text-decoration-none">
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
                                                            @if(isset($gestion_academica->anexosTemasEnsenanza))
                                                                <a href="{{ $gestion_academica->anexosTemasEnsenanza->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Evaluación en el aula:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->evaluacion_aula ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Seguimiento Académico -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">SEGUIMIENTO ACADÉMICO</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Seguimiento a desempeños:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->seguimiento_desempenos ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Informe estadístico:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_academica->anexoInformeEstadistico))
                                                                <a href="{{ $gestion_academica->anexoInformeEstadistico->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Uso de evaluaciones externas:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->uso_evaluaciones_externas ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Análisis de pruebas externas:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_academica->anexoAnalisisPruebasExternas))
                                                                <a href="{{ $gestion_academica->anexoAnalisisPruebasExternas->url }}" target="_blank" class="text-decoration-none">
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
                                                            @if(isset($gestion_academica->anexosPlanesMejoramiento))
                                                                <a href="{{ $gestion_academica->anexosPlanesMejoramiento->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documentos
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Apoyo pedagógico:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_academica->apoyo_pedagogico ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Gestion administrativa y financiera -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-administrativa" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body p-4">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold border-bottom pb-2 mb-4">GESTIÓN ADMINISTRATIVA Y FINANCIERA</h4>
                                                
                                                <!-- Apoyo a la gestión académica -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">APOYO A LA GESTIÓN ACADÉMICA</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Proceso de matrícula:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->proceso_matricula ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Acto administrativo:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_administrativa->anexoActoAdministrativoProcesoMatricula))
                                                                <a href="{{ $gestion_administrativa->anexoActoAdministrativoProcesoMatricula->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Sistema de información académica:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->sistema_informacion_academica ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Administración de la planta física -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">ADMINISTRACIÓN DE PLANTA FÍSICA</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Mantenimiento de infraestructura:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->mantenimiento_infraestructura ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Política de mantenimiento:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_administrativa->anexoPoliticaMantenimiento))
                                                                <a href="{{ $gestion_administrativa->anexoPoliticaMantenimiento->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Dotación de recursos:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->dotacion_recursos_aprendizaje ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Política de dotación:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_administrativa->anexoDotacionRecursos))
                                                                <a href="{{ $gestion_administrativa->anexoDotacionRecursos->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Programas de seguridad:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->programas_seguridad ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Servicios complementarios -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">SERVICIOS COMPLEMENTARIOS</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Estrategias de acceso:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->estrategias_acceso_permanencia ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Talento humano -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">TALENTO HUMANO</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Perfiles y asignación:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->perfiles_asignacion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Programa de formación:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->programa_formacion_capacitacion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento de formación:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_administrativa->anexoProgramaFormacion))
                                                                <a href="{{ $gestion_administrativa->anexoProgramaFormacion->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Pertenencia del personal:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->pertenencia_personal ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Evaluación de desempeño:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->evaluacion_desempeno ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Informe de evaluación:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_administrativa->anexoInformeAnual))
                                                                <a href="{{ $gestion_administrativa->anexoInformeAnual->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Convivencia y conflictos:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->convivencia_manejo_conflictos ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Apoyo financiero -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">APOYO FINANCIERO</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Presupuesto FSE:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->presupuesto_fse ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento presupuesto:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_administrativa->anexoPresupuestoFse))
                                                                <a href="{{ $gestion_administrativa->anexoPresupuestoFse->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Contabilidad:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->contabilidad ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Contratación:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->contratacion ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Manual de contratación:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_administrativa->anexoManualContratacion))
                                                                <a href="{{ $gestion_administrativa->anexoManualContratacion->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Control fiscal:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_administrativa->control_fiscal ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestion de la comunidad -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-comunidad" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-body p-4">
                                                
                                                <!-- Título principal -->
                                                <h4 class="fw-bold border-bottom pb-2 mb-4">GESTIÓN DE LA COMUNIDAD</h4>
                                                
                                                <!-- Atención educativa a grupos poblacionales -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">ATENCIÓN EDUCATIVA A GRUPOS POBLACIONALES</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Atención a grupos vulnerables:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_comunidad->atencion_grupos_vulnerabilidad ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Necesidades y expectativas:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_comunidad->necesidades_expectativas_estudiantes ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Proyectos de vida:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_comunidad->proyectos_vida ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Escuela de padres:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_comunidad->escuela_padres ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Proyecto escuela de padres:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_comunidad->anexoProyectoEscuelaPadres))
                                                                <a href="{{ $gestion_comunidad->anexoProyectoEscuelaPadres->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Oferta de servicios:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_comunidad->oferta_servicios_comunidad ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Programa de servicio social -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">PROGRAMA DE SERVICIO SOCIAL</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Programa institucional:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_comunidad->programa_servicio_social ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento del programa:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_comunidad->anexoProgramaServicioSocial))
                                                                <a href="{{ $gestion_comunidad->anexoProgramaServicioSocial->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Prevención de riesgos -->
                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-3">PREVENCIÓN DE RIESGOS</h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Riesgos físicos:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_comunidad->prevencion_riesgos_fisicos ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Documento prevención:</div>
                                                        <div class="col-md-6">
                                                            @if(isset($gestion_comunidad->anexoPrevencionRiesgosFisicos))
                                                                <a href="{{ $gestion_comunidad->anexoPrevencionRiesgosFisicos->url }}" target="_blank" class="text-decoration-none">
                                                                    <i class="fas fa-file-pdf text-danger me-1"></i>Ver documento
                                                                </a>
                                                            @else
                                                                <span class="text-muted fst-italic">No disponible</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 fw-semibold">Riesgos psicosociales:</div>
                                                        <div class="col-md-6">
                                                            {!! $gestion_comunidad->prevencion_riesgos_psicosociales ?? '<span class="text-muted fst-italic">No registrado</span>' !!}
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