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
                                <h2>FORMULARIOS DE GESTION DE PEI</h2>
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
                                    <!-- Gestion directiva -->
                                    <div class="tab-pane fade show active" id="navs-tab-gestion-directiva" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card mb-4">
                                                        <div class="card-body">
                                                            <form id="mainForm" method="post" action="pei/executive-management" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="accordion" id="strategicAccordion">
                                                                    <!-- Direccionamiento Estratégico -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="headingOne">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#collapseOne" aria-expanded="false" 
                                                                                    aria-controls="collapseOne">
                                                                                <span class="fw-bold fs-4">Direccionamiento Estratégico</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseOne" class="accordion-collapse collapse" 
                                                                            aria-labelledby="headingOne" data-bs-parent="#strategicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Misión</label>
                                                                                        <textarea class="form-control" id="full-editor" rows="3" 
                                                                                                name="mision">{{ $gestion_directiva->mision ?? old('mision') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Visión</label>
                                                                                        <textarea class="form-control" id="full-editor2" rows="3" 
                                                                                                name="vision">{{ $gestion_directiva->vision ?? old('vision') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Principios Institucionales</label>
                                                                                        <textarea class="form-control" id="full-editor3" rows="3" 
                                                                                                name="principios_institucionales">{{ $gestion_directiva->principios_institucionales ?? old('principios_institucionales') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Metas Institucionales</label>
                                                                                        <textarea class="form-control" id="full-editor4" rows="3" 
                                                                                                name="metas_institucionales">{{ $gestion_directiva->metas_institucionales ?? old('metas_institucionales') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Política de inclusión</label>
                                                                                        <textarea class="form-control" id="full-editor5" rows="3" 
                                                                                                name="politica_inclusion">{{ $gestion_directiva->politica_inclusion ?? old('politica_inclusion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <label for="licencia_funcionamiento" class="form-label mb-0">Política de inclusión</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_directiva->anexoPoliticaInclusion))
                                                                                            <a href="{{ $gestion_directiva->anexoPoliticaInclusion->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_politica_inclusion" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Gestión Estratégica -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="headingTwo">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#collapseTwo" aria-expanded="false" 
                                                                                    aria-controls="collapseTwo">
                                                                                <span class="fw-bold fs-4">Gestión Estratégica</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseTwo" class="accordion-collapse collapse" 
                                                                            aria-labelledby="headingTwo" data-bs-parent="#strategicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Liderazgo y trabajo en equipo</label>
                                                                                        <textarea class="form-control" id="full-editor6" rows="3" 
                                                                                                name="liderazgo">{{ $gestion_directiva->liderazgo ?? old('liderazgo') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Articulación de planes, proyectos y acciones</label>
                                                                                        <textarea class="form-control" id="full-editor7" rows="3" 
                                                                                                name="articulacion">{{ $gestion_directiva->articulacion ?? old('articulacion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Seguimiento y autoevaluación</label>
                                                                                        <textarea class="form-control" id="full-editor8" rows="3" 
                                                                                                name="seguimiento">{{ $gestion_directiva->seguimiento ?? old('seguimiento') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Gobierno Escolar -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="headingThree">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#collapseThree" aria-expanded="false" 
                                                                                    aria-controls="collapseThree">
                                                                                <span class="fw-bold fs-4">Gobierno Escolar</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseThree" class="accordion-collapse collapse" 
                                                                            aria-labelledby="headingThree" data-bs-parent="#strategicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Gobierno Escolar</label>
                                                                                        <textarea class="form-control" id="full-editor9" rows="3" 
                                                                                                name="gobierno_escolar">{{ $gestion_directiva->gobierno_escolar ?? old('gobierno_escolar') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <label for="licencia_funcionamiento" class="form-label mb-0">Licencia de Funcionamiento</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_directiva->anexoGobiernoEscolar))
                                                                                            <a href="{{ $gestion_directiva->anexoGobiernoEscolar->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_gobierno_escolar" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Cultura Institucional -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="headingFour">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#collapseFour" aria-expanded="false" 
                                                                                    aria-controls="collapseFour">
                                                                                <span class="fw-bold fs-4">Cultura Institucional</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseFour" class="accordion-collapse collapse" 
                                                                            aria-labelledby="headingFour" data-bs-parent="#strategicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Politica de comunicación</label>
                                                                                        <textarea class="form-control" id="full-editor10" rows="3" 
                                                                                                name="politica_comunicacion">{{ $gestion_directiva->politica_comunicacion ?? old('politica_comunicacion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo Cultura Institucional (Política de comunicación)</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_directiva->anexoCulturaInstitucional))
                                                                                            <a href="{{ $gestion_directiva->anexoCulturaInstitucional->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_cultura_institucional" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Política de bienestar</label>
                                                                                        <textarea class="form-control" id="full-editor11" rows="3" 
                                                                                                name="politica_bienestar">{{ $gestion_directiva->politica_bienestar ?? old('politica_bienestar') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo política de bienestar</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_directiva->anexoPoliticaBienestar))
                                                                                            <a href="{{ $gestion_directiva->anexoPoliticaBienestar->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_politica_bienestar" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <!-- <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Apoyo a la investigación y divulgación de buenas prácticas</label>
                                                                                        <textarea class="form-control" id="full-editor12" rows="3" 
                                                                                                name="apoyo_investigacion">{{ $gestion_directiva->apoyo_investigacion ?? old('apoyo_investigacion') }}</textarea>
                                                                                    </div>
                                                                                </div> -->
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Inventario de caracterización de buenas prácticas, con vigencia</label>
                                                                                        <textarea class="form-control" id="full-editor13" rows="3" 
                                                                                                name="inventario_buenas_practicas">{{ $gestion_directiva->inventario_buenas_practicas ?? old('inventario_buenas_practicas') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Clima Escolar -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="headingFive">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#collapseFive" aria-expanded="false" 
                                                                                    aria-controls="collapseFive">
                                                                                <span class="fw-bold fs-4">Clima Escolar</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseFive" class="accordion-collapse collapse" 
                                                                            aria-labelledby="headingFive" data-bs-parent="#strategicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Sentido de pertenencia y participación</label>
                                                                                        <textarea class="form-control" id="full-editor14" rows="3" 
                                                                                                name="sentido_pertenencia">{{ $gestion_directiva->sentido_pertenencia ?? old('sentido_pertenencia') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Inducción Institucional</label>
                                                                                        <textarea class="form-control" id="full-editor15" rows="3" 
                                                                                                name="induccion_institucional">{{ $gestion_directiva->induccion_institucional ?? old('induccion_institucional') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo - Programa institucional de inducción (Estudiantes y padres de familia, docentes y administrativos)</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_directiva->anexoProgramaInstitucionalInduccion))
                                                                                            <a href="{{ $gestion_directiva->anexoProgramaInstitucionalInduccion->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_programa_institucional_induccion" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Manual de Convivencia</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_directiva->manualConvivencia))
                                                                                            <a href="{{ $gestion_directiva->manualConvivencia->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="manual_convivencia" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Actividades extracurriculares</label>
                                                                                        <textarea class="form-control" id="full-editor16" rows="3" 
                                                                                                name="actividades_extracurriculares">{{ $gestion_directiva->actividades_extracurriculares ?? old('actividades_extracurriculares') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Manejo de conflictos y casos difíciles</label>
                                                                                        <textarea class="form-control" id="full-editor17" rows="3" 
                                                                                                name="manejo_conflictos">{{ $gestion_directiva->manejo_conflictos ?? old('manejo_conflictos') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Relaciones con el Entorno -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="headingSix">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#collapseSix" aria-expanded="false" 
                                                                                    aria-controls="collapseSix">
                                                                                <span class="fw-bold fs-4">Relaciones con el Entorno</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseSix" class="accordion-collapse collapse" 
                                                                            aria-labelledby="headingSix" data-bs-parent="#strategicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Relación con familias y acudientes</label>
                                                                                        <textarea class="form-control" id="full-editor18" rows="3" 
                                                                                                name="relacion_familias">{{ $gestion_directiva->relacion_familias ?? old('relacion_familias') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Seguimiento a egresados</label>
                                                                                        <textarea class="form-control" id="full-editor19" rows="3" 
                                                                                                name="seguimiento_egresados">{{ $gestion_directiva->seguimiento_egresados ?? old('seguimiento_egresados') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Alianzas con otras instituciones</label>
                                                                                        <textarea class="form-control" id="full-editor20" rows="3" 
                                                                                                name="alianzas_instituciones">{{ $gestion_directiva->alianzas_instituciones ?? old('alianzas_instituciones') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexos Alianzas con otras instituciones</label>                                                                                        
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_directiva->anexoAlianzasInstituciones))
                                                                                            <a href="{{ $gestion_directiva->manualConvivencia->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_alianzas_instituciones" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Alianzas con el sector productivo</label>
                                                                                        <textarea class="form-control" id="full-editor21" rows="3" 
                                                                                                name="alianzas_sector_productivo">{{ $gestion_directiva->alianzas_sector_productivo ?? old('alianzas_sector_productivo') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <label class="form-label">Anexos Alianzas con el sector productivo</label>                                                                                        
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_directiva->anexoAlianzasSectorProductivo))
                                                                                            <a href="{{ $gestion_directiva->manualConvivencia->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_alianzas_sector_productivo" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="text-center mt-4">
                                                                    <button type="submit" class="btn btn-success btn-lg">
                                                                        <i class="bx bx-save me-1"></i> Guardar Todo
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestion academica -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-academica" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card mb-4">
                                                        <div class="card-body">
                                                            <form id="mainFormAcademica" method="post" action="pei/academic-management" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="accordion" id="academicAccordion">
                                                                    <!-- Apoyo a la gestión académica -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="academicHeadingOne">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#academicCollapseOne" aria-expanded="false" 
                                                                                    aria-controls="academicCollapseOne">
                                                                                <span class="fw-bold fs-4">Apoyo a la gestión académica</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="academicCollapseOne" class="accordion-collapse collapse" 
                                                                            aria-labelledby="academicHeadingOne" data-bs-parent="#academicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Proceso de matrícula</label>
                                                                                        <textarea class="form-control" id="academic-editor1" rows="3" 
                                                                                                name="proceso_matricula">{{ $gestion_academica->proceso_matricula ?? old('proceso_matricula') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo Proceso de matrícula (Acto Administrativo)</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_academica->anexoActoAdministrativoProcesoMatricula))
                                                                                            <a href="{{ $gestion_academica->anexoActoAdministrativoProcesoMatricula->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_acto_administrativo_proceso_matricula" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Sistema de información académica</label>
                                                                                        <textarea class="form-control" id="academic-editor2" rows="3" 
                                                                                                name="sistema_informacion_academica">{{ $gestion_academica->sistema_informacion_academica ?? old('sistema_informacion_academica') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Administración de la planta física y de los recursos -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="academicHeadingTwo">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#academicCollapseTwo" aria-expanded="false" 
                                                                                    aria-controls="academicCollapseTwo">
                                                                                <span class="fw-bold fs-4">Administración de la planta física y de los recursos</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="academicCollapseTwo" class="accordion-collapse collapse" 
                                                                            aria-labelledby="academicHeadingTwo" data-bs-parent="#academicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa</label>
                                                                                        <textarea class="form-control" id="academic-editor3" rows="3" 
                                                                                                name="mantenimiento_infraestructura">{{ $gestion_academica->mantenimiento_infraestructura ?? old('mantenimiento_infraestructura') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_academica->anexoMantenimientoInfraestructura))
                                                                                            <a href="{{ $gestion_academica->anexoMantenimientoInfraestructura->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_mantenimiento_infraestructura" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Dotación, mantenimiento y uso de recursos para el aprendizaje</label>
                                                                                        <textarea class="form-control" id="academic-editor4" rows="3" 
                                                                                                name="dotacion_recursos_aprendizaje">{{ $gestion_academica->dotacion_recursos_aprendizaje ?? old('dotacion_recursos_aprendizaje') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo Dotación, mantenimiento y uso de recursos para el aprendizaje</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_academica->anexoDotacionRecursos))
                                                                                            <a href="{{ $gestion_academica->anexoDotacionRecursos->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_dotacion_recursos" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Programas de seguridad</label>
                                                                                        <textarea class="form-control" id="academic-editor5" rows="3" 
                                                                                                name="programas_seguridad">{{ $gestion_academica->programas_seguridad ?? old('programas_seguridad') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Talento humano -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="academicHeadingFour">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#academicCollapseFour" aria-expanded="false" 
                                                                                    aria-controls="academicCollapseFour">
                                                                                <span class="fw-bold fs-4">Talento humano</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="academicCollapseFour" class="accordion-collapse collapse" 
                                                                            aria-labelledby="academicHeadingFour" data-bs-parent="#academicAccordion">
                                                                            <div class="accordion-body">
                                                                                <!-- Perfiles, asignación académica y de funciones -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Perfiles, asignación académica y de funciones</label>
                                                                                        <textarea class="form-control" id="academic-editor7" rows="3" 
                                                                                                name="perfiles_asignacion">{{ $gestion_academica->perfiles_asignacion ?? old('perfiles_asignacion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <!-- Programa de formación y capacitación institucional -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Programa de formación y capacitación institucional</label>
                                                                                        <textarea class="form-control" id="academic-editor8" rows="3" 
                                                                                                name="programa_formacion_capacitacion">{{ $gestion_academica->programa_formacion_capacitacion ?? old('programa_formacion_capacitacion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <!-- Anexo Programa de formación y capacitación institucional -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Anexo Programa de formación y capacitación institucional</label>
                                                                                        <div class="d-flex gap-2 justify-content-between align-items-center">
                                                                                            @if(isset($gestion_academica->anexoProgramaFormacion))
                                                                                                <a href="{{ $gestion_academica->anexoProgramaFormacion->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                    <i class="fas fa-eye"></i> Ver adjunto
                                                                                                </a>
                                                                                            @endif
                                                                                            <input type="file" name="anexo_programa_formacion" class="form-control" accept="application/pdf">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <!-- Pertenencia del personal vinculado -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Pertenencia del personal vinculado</label>
                                                                                        <textarea class="form-control" id="academic-editor9" rows="3" 
                                                                                                name="pertenencia_personal">{{ $gestion_academica->pertenencia_personal ?? old('pertenencia_personal') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <!-- Evaluación del desempeño -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Evaluación del desempeño de directivos, docentes y administrativos</label>
                                                                                        <textarea class="form-control" id="academic-editor10" rows="3" 
                                                                                                name="evaluacion_desempeno">{{ $gestion_academica->evaluacion_desempeno ?? old('evaluacion_desempeno') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <!-- Convivencia y manejo de conflictos -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Convivencia y manejo de conflictos</label>
                                                                                        <textarea class="form-control" id="academic-editor11" rows="3" 
                                                                                                name="convivencia_manejo_conflictos">{{ $gestion_academica->convivencia_manejo_conflictos ?? old('convivencia_manejo_conflictos') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Apoyo financiero y contable -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="academicHeadingFive">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#academicCollapseFive" aria-expanded="false" 
                                                                                    aria-controls="academicCollapseFive">
                                                                                <span class="fw-bold fs-4">Apoyo financiero y contable</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="academicCollapseFive" class="accordion-collapse collapse" 
                                                                            aria-labelledby="academicHeadingFive" data-bs-parent="#academicAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Presupuesto anual del Fondo de Servicios Educativos (FSE)</label>
                                                                                        <textarea class="form-control" id="academic-editor12" rows="3" 
                                                                                                name="presupuesto_fse">{{ $gestion_academica->presupuesto_fse ?? old('presupuesto_fse') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo Presupuesto anual del Fondo de Servicios Educativos (FSE)</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_academica->anexoPresupuestoFse))
                                                                                            <a href="{{ $gestion_academica->anexoPresupuestoFse->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_presupuesto_fse" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Contabilidad</label>
                                                                                        <textarea class="form-control" id="academic-editor13" rows="3" 
                                                                                                name="contabilidad">{{ $gestion_academica->contabilidad ?? old('contabilidad') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Contratación</label>
                                                                                        <textarea class="form-control" id="academic-editor14" rows="3" 
                                                                                                name="contratacion">{{ $gestion_academica->contratacion ?? old('contratacion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Control Fiscal</label>
                                                                                        <textarea class="form-control" id="academic-editor15" rows="3" 
                                                                                                name="control_fiscal">{{ $gestion_academica->control_fiscal ?? old('control_fiscal') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="text-center mt-4">
                                                                    <button type="submit" class="btn btn-success btn-lg">
                                                                        <i class="bx bx-save me-1"></i> Guardar Todo
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Gestion administrativa y financiera -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-administrativa" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card mb-4">
                                                        <div class="card-body">
                                                            <form id="mainFormAdministrativa" method="post" action="pei/administrative-management" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="accordion" id="administrativaAccordion">
                                                                    
                                                                    <!-- Apoyo a la gestión académica -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="administrativaHeadingOne">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#administrativaCollapseOne" aria-expanded="false" 
                                                                                    aria-controls="administrativaCollapseOne">
                                                                                <span class="fw-bold fs-4">Apoyo a la gestión académica</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="administrativaCollapseOne" class="accordion-collapse collapse" 
                                                                            aria-labelledby="administrativaHeadingOne" data-bs-parent="#administrativaAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Proceso de matrícula</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="proceso_matricula">{{ $gestion_administrativa->proceso_matricula ?? old('proceso_matricula') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <label for="licencia_funcionamiento" class="form-label mb-0">Acto administrativo del proceso de matricula</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_administrativa->anexoActoAdministrativoProcesoMatricula))
                                                                                            <a href="{{ $gestion_administrativa->anexoActoAdministrativoProcesoMatricula->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_acto_administrativo_proceso_matricula" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Sistema de información académica</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="sistema_informacion_academica">{{ $gestion_administrativa->sistema_informacion_academica ?? old('sistema_informacion_academica') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Administración de la planta física y de los recursos -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="administrativaHeadingTwo">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#administrativaCollapseTwo" aria-expanded="false" 
                                                                                    aria-controls="administrativaCollapseTwo">
                                                                                <span class="fw-bold fs-4">Administración de la planta física y de los recursos</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="administrativaCollapseTwo" class="accordion-collapse collapse" 
                                                                            aria-labelledby="administrativaHeadingTwo" data-bs-parent="#administrativaAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="mantenimiento_infraestructura">{{ $gestion_administrativa->mantenimiento_infraestructura ?? old('mantenimiento_infraestructura') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo - Política de mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_administrativa->anexoActoAdministrativoProcesoMatricula))
                                                                                            <a href="{{ $gestion_administrativa->anexoActoAdministrativoProcesoMatricula->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_politica_mantenimiento" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Dotación, mantenimiento y uso de recursos para el aprendizaje</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="dotacion_recursos_aprendizaje">{{ $gestion_administrativa->dotacion_recursos_aprendizaje ?? old('dotacion_recursos_aprendizaje') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo - Política de dotación, mantenimiento y uso de recursos para el aprendizaje</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_administrativa->anexoDotacionRecursos))
                                                                                            <a href="{{ $gestion_administrativa->anexoDotacionRecursos->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_dotacion_recursos" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Programas de seguridad</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="programas_seguridad">{{ $gestion_administrativa->programas_seguridad ?? old('programas_seguridad') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Administración de los Servicios Complementarios -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="administrativaHeadingThree">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#administrativaCollapseThree" aria-expanded="false" 
                                                                                    aria-controls="administrativaCollapseThree">
                                                                                <span class="fw-bold fs-4">Administración de los Servicios Complementarios</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="administrativaCollapseThree" class="accordion-collapse collapse" 
                                                                            aria-labelledby="administrativaHeadingThree" data-bs-parent="#administrativaAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Estrategias de acceso y permanencia (PAE, transporte escolar y otros).</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="estrategias_acceso_permanencia">{{ $gestion_administrativa->estrategias_acceso_permanencia ?? old('estrategias_acceso_permanencia') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Talento humano -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="administrativaHeadingFour">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#administrativaCollapseFour" aria-expanded="false" 
                                                                                    aria-controls="administrativaCollapseFour">
                                                                                <span class="fw-bold fs-4">Talento humano</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="administrativaCollapseFour" class="accordion-collapse collapse" 
                                                                            aria-labelledby="administrativaHeadingFour" data-bs-parent="#administrativaAccordion">
                                                                            <div class="accordion-body">

                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Perfiles, asignación académica y de funciones</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="perfiles_asignacion">{{ $gestion_administrativa->perfiles_asignacion ?? old('perfiles_asignacion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Programa de formación y capacitación institucional</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="programa_formacion_capacitacion">{{ $gestion_administrativa->programa_formacion_capacitacion ?? old('programa_formacion_capacitacion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo - Programa de formación y capacitación institucional</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_administrativa->anexoProgramaFormacion))
                                                                                            <a href="{{ $gestion_administrativa->anexoProgramaFormacion->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_programa_formacion" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Pertenencia del personal vinculado</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="pertenencia_personal">{{ $gestion_administrativa->pertenencia_personal ?? old('pertenencia_personal') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Evaluación del desempeño de directivos, docentes  y administrativos</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="evaluacion_desempeno">{{ $gestion_administrativa->evaluacion_desempeno ?? old('evaluacion_desempeno') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo - informe anual de análisis de evaluación de desempeño</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_administrativa->anexoInformeAnual))
                                                                                            <a href="{{ $gestion_administrativa->anexoInformeAnual->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_informe_anual" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Convivencia y manejo de conflictos</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="convivencia_manejo_conflictos">{{ $gestion_administrativa->convivencia_manejo_conflictos ?? old('convivencia_manejo_conflictos') }}</textarea>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Apoyo financiero y contable -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="administrativaHeadingFive">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#administrativaCollapseFive" aria-expanded="false" 
                                                                                    aria-controls="administrativaCollapseFive">
                                                                                <span class="fw-bold fs-4">Apoyo financiero y contable</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="administrativaCollapseFive" class="accordion-collapse collapse" 
                                                                            aria-labelledby="administrativaHeadingFive" data-bs-parent="#administrativaAccordion">
                                                                            <div class="accordion-body">

                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Presupuesto anual del Fondo de Servicios Educativos (FSE)</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="presupuesto_fse">{{ $gestion_administrativa->presupuesto_fse ?? old('presupuesto_fse') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo. Acto administrativo de  Presupuesto del Fondo Anual de Servicios Educativos</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_administrativa->anexoPresupuestoFse))
                                                                                            <a href="{{ $gestion_administrativa->anexoPresupuestoFse->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_presupuesto_fse" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Contabilidad</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="contabilidad">{{ $gestion_administrativa->contabilidad ?? old('contabilidad') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Contratación</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="contratacion">{{ $gestion_administrativa->contratacion ?? old('contratacion') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo. Manual de contratación</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_administrativa->anexoManualContratacion))
                                                                                            <a href="{{ $gestion_administrativa->anexoManualContratacion->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_manual_contratacion" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Control fiscal</label>
                                                                                        <textarea class="form-control" id="administrativa-editor1" rows="3" 
                                                                                                name="control_fiscal">{{ $gestion_administrativa->control_fiscal ?? old('control_fiscal') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="text-center mt-4">
                                                                    <button type="submit" class="btn btn-success btn-lg">
                                                                        <i class="bx bx-save me-1"></i> Guardar Todo
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gestion de la comunidad -->
                                    <div class="tab-pane fade" id="navs-tab-gestion-comunidad" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card mb-4">
                                                        <div class="card-body">
                                                            <form id="mainFormComunidad" method="post" action="pei/community-management" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="accordion" id="comunidadAccordion">
                                                                    
                                                                    <!-- Atención educativa a grupos poblacionales -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="comunidadHeadingOne">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#comunidadCollapseOne" aria-expanded="false" 
                                                                                    aria-controls="comunidadCollapseOne">
                                                                                <span class="fw-bold fs-4">Atención educativa a grupos poblacionales o en situación de vulnerabilidad</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="comunidadCollapseOne" class="accordion-collapse collapse" 
                                                                            aria-labelledby="comunidadHeadingOne" data-bs-parent="#comunidadAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Atención educativa a grupos poblacionales o en situación de vulnerabilidad que experimentan barreras en el aprendizaje y la participación</label>
                                                                                        <textarea class="form-control" id="comunidad-editor1" rows="3" 
                                                                                                name="atencion_grupos_vulnerabilidad">{{ $gestion_comunidad->atencion_grupos_vulnerabilidad ?? old('atencion_grupos_vulnerabilidad') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Necesidades y expectativas de los estudiantes</label>
                                                                                        <textarea class="form-control" id="comunidad-editor2" rows="3" 
                                                                                                name="necesidades_expectativas_estudiantes">{{ $gestion_comunidad->necesidades_expectativas_estudiantes ?? old('necesidades_expectativas_estudiantes') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Proyectos de vida</label>
                                                                                        <textarea class="form-control" id="comunidad-editor3" rows="3" 
                                                                                                name="proyectos_vida">{{ $gestion_comunidad->proyectos_vida ?? old('proyectos_vida') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Escuela de padres</label>
                                                                                        <textarea class="form-control" id="comunidad-editor4" rows="3" 
                                                                                                name="escuela_padres">{{ $gestion_comunidad->escuela_padres ?? old('escuela_padres') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <label class="form-label">Anexo, Proyecto escuela de padres</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_comunidad->anexoProyectoEscuelaPadres))
                                                                                            <a href="{{ $gestion_comunidad->anexoProyectoEscuelaPadres->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_proyecto_escuela_padres" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Oferta de servicios a la comunidad</label>
                                                                                        <textarea class="form-control" id="comunidad-editor5" rows="3" 
                                                                                                name="oferta_servicios_comunidad">{{ $gestion_comunidad->oferta_servicios_comunidad ?? old('oferta_servicios_comunidad') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Programa de servicio social -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="comunidadHeadingTwo">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#comunidadCollapseTwo" aria-expanded="false" 
                                                                                    aria-controls="comunidadCollapseTwo">
                                                                                <span class="fw-bold fs-4">Programa de servicio social</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="comunidadCollapseTwo" class="accordion-collapse collapse" 
                                                                            aria-labelledby="comunidadHeadingTwo" data-bs-parent="#comunidadAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Programa de servicio social institucional</label>
                                                                                        <textarea class="form-control" id="comunidad-editor6" rows="3" 
                                                                                                name="programa_servicio_social">{{ $gestion_comunidad->programa_servicio_social ?? old('programa_servicio_social') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <label class="form-label">Anexo Programa de servicio social institucional</label>
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_comunidad->anexoProgramaServicioSocial))
                                                                                            <a href="{{ $gestion_comunidad->anexoProgramaServicioSocial->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_programa_servicio_social" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Prevención de riesgos -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="comunidadHeadingThree">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                                    data-bs-target="#comunidadCollapseThree" aria-expanded="false" 
                                                                                    aria-controls="comunidadCollapseThree">
                                                                                <span class="fw-bold fs-4">Prevención de riesgos</span>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="comunidadCollapseThree" class="accordion-collapse collapse" 
                                                                            aria-labelledby="comunidadHeadingThree" data-bs-parent="#comunidadAccordion">
                                                                            <div class="accordion-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Prevención de riesgos físicos</label>
                                                                                        <textarea class="form-control" id="comunidad-editor7" rows="3" 
                                                                                                name="prevencion_riesgos_fisicos">{{ $gestion_comunidad->prevencion_riesgos_fisicos ?? old('prevencion_riesgos_fisicos') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="form-label">Anexo Prevención de riesgos físicos</label>
                                                                                    
                                                                                    <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                                                        @if(isset($gestion_comunidad->anexoPrevencionRiesgosFisicos))
                                                                                            <a href="{{ $gestion_comunidad->anexoPrevencionRiesgosFisicos->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                                                                <i class="fas fa-eye"></i> Ver adjunto
                                                                                            </a>
                                                                                        @endif
                                                                                        <input type="file" name="anexo_prevencion_riesgos_fisicos" class="form-control" accept="application/pdf">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Prevención de riesgos psicosociales</label>
                                                                                        <textarea class="form-control" id="comunidad-editor8" rows="3" 
                                                                                                name="prevencion_riesgos_psicosociales">{{ $gestion_comunidad->prevencion_riesgos_psicosociales ?? old('prevencion_riesgos_psicosociales') }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="text-center mt-4">
                                                                    <button type="submit" class="btn btn-success btn-lg">
                                                                        <i class="bx bx-save me-1"></i> Guardar Todo
                                                                    </button>
                                                                </div>
                                                            </form>
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