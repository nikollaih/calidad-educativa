@extends('layouts.app')

@section('title', 'Plan de Desarrollo Educativo Completo')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 compact-view">

            <!-- Componente -->
            <div class="card mb-2 border">
                <div class="card-header bg-white p-2">
                    <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseComponente">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <strong>COMPONENTE</strong>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </h6>
                    </button>
                </div>
                <div id="collapseComponente" class="collapse">
                    <div class="card-body p-2">
                        <div class="textarea-container" id="componenteContainer">
                            <textarea class="form-control form-control-sm mb-2" rows="2" readonly>ACOMPAÑAMIENTO A ESTABLECIMIENTOS EDUCATIVOS</textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="componenteContainer">
                            <i class="fas fa-plus me-1"></i> Agregar Texto
                        </button>
                    </div>
                </div>
            </div>

            <!-- Proceso -->
            <div class="card mb-2 border">
                <div class="card-header bg-white p-2">
                    <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseProceso">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <strong>PROCESO</strong>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </h6>
                    </button>
                </div>
                <div id="collapseProceso" class="collapse">
                    <div class="card-body p-2">
                        <div class="textarea-container" id="procesoContainer">
                            <textarea class="form-control form-control-sm mb-2" rows="2" readonly>GARANTIZAR EL MEJORAMIENTO CONTINUO DE LOS ESTABLECIMIENTOS EDUCATIVOS</textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="procesoContainer">
                            <i class="fas fa-plus me-1"></i> Agregar Texto
                        </button>
                    </div>
                </div>
            </div>

            <!-- Subproceso -->
            <div class="card mb-2 border">
                <div class="card-header bg-white p-2">
                    <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseSubproceso">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <strong>SUBPROCESO</strong>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </h6>
                    </button>
                </div>
                <div id="collapseSubproceso" class="collapse">
                    <div class="card-body p-2">
                        <div class="textarea-container" id="subprocesoContainer">
                            <textarea class="form-control form-control-sm mb-2" rows="2" readonly>APOYAR LA GESTIÓN DEL PROYECTO EDUCATIVO</textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="subprocesoContainer">
                            <i class="fas fa-plus me-1"></i> Agregar Texto
                        </button>
                    </div>
                </div>
            </div>

            <!-- Meta del Plan de Desarrollo -->
            <div class="card mb-2 border">
                <div class="card-header bg-white p-2">
                    <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseMetaPlan">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <strong>META DEL PLAN DE DESARROLLO</strong>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </h6>
                    </button>
                </div>
                <div id="collapseMetaPlan" class="collapse">
                    <div class="card-body p-2">
                        <div class="textarea-container" id="metaPlanContainer">
                            <textarea class="form-control form-control-sm mb-2" rows="3" readonly>Servicio de asistencia técnica en educación inicial, preescolar, básica y media</textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="metaPlanContainer">
                            <i class="fas fa-plus me-1"></i> Agregar Texto
                        </button>
                    </div>
                </div>
            </div>

            <!-- Objetivo Estratégico -->
            <div class="card mb-2 border">
                <div class="card-header bg-white p-2">
                    <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseObjetivo">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <strong>OBJETIVO ESTRATÉGICO</strong>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </h6>
                    </button>
                </div>
                <div id="collapseObjetivo" class="collapse">
                    <div class="card-body p-2">
                        <div class="textarea-container" id="objetivoContainer">
                            <textarea class="form-control form-control-sm mb-2" rows="4" readonly>Acompañamiento tecnico-pedagógico a las 54 instituciones educativas en los programas y proyectos enmarcados en la ruta de mejoramiento continuo para el fortalecimiento de la calidad en la prestación del servicio educativo</textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="objetivoContainer">
                            <i class="fas fa-plus me-1"></i> Agregar Texto
                        </button>
                    </div>
                </div>
            </div>

            <!-- Meta -->
            <div class="card mb-2 border">
                <div class="card-header bg-white p-2">
                    <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseMeta">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <strong>META</strong>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </h6>
                    </button>
                </div>
                <div id="collapseMeta" class="collapse">
                    <div class="card-body p-2">
                        <div class="textarea-container" id="metaContainer">
                            <textarea class="form-control form-control-sm mb-2" rows="4" readonly>Al finalizar el año lectivo 2021, el 100% de las instituciones educativas son asistidas técnicamente para la re-significación del Proyecto educativo institucional generadas por la implementación de las modalidades de educación en casa y alternancia educativa.</textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="metaContainer">
                            <i class="fas fa-plus me-1"></i> Agregar Texto
                        </button>
                    </div>
                </div>
            </div>

            <!-- Indicador -->
            <div class="card mb-2 border">
                <div class="card-header bg-white p-2">
                    <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseIndicador">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <strong>INDICADOR</strong>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </h6>
                    </button>
                </div>
                <div id="collapseIndicador" class="collapse">
                    <div class="card-body p-2">
                        <div class="textarea-container" id="indicadorContainer">
                            <textarea class="form-control form-control-sm mb-2" rows="3" readonly>Número de instituciones educativas asistidas tecnicamente en la re-significación del Proyecto educativo institucional durante la emergencia / Número de instituciones educativas, programadas para asistencia tecnica en re-significacion del proyecto educativo institucional durante la emergencia</textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="indicadorContainer">
                            <i class="fas fa-plus me-1"></i> Agregar Texto
                        </button>
                    </div>
                </div>
            </div>

            <!-- Acción (con elementos anidados) -->
            <div class="card mb-2 border">
                <div class="card-header bg-white p-2">
                    <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseAccion">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <strong>ACCIÓN</strong>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </h6>
                    </button>
                </div>
                <div id="collapseAccion" class="collapse">
                    <div class="card-body p-2">
                        <div class="textarea-container" id="accionContainer">
                            <textarea class="form-control form-control-sm mb-2" rows="5" readonly>1. asistencia técnica a las 54 instituciones educativas en la elaboración y socialización de los lineamientos pedagógicos de la flexibilización curricular en las modalidades de educación en casa y alternancia del servicio educativo 
2. Recolectar, consolidar y validar los actos administrativos institucionales</textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="accionContainer">
                            <i class="fas fa-plus me-1"></i> Agregar Texto
                        </button>
                        
                        <!-- Responsable (dentro de Acción) -->
                        <div class="card mt-3 border">
                            <div class="card-header bg-white p-2">
                                <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapseResponsable">
                                    <h6 class="mb-0 d-flex justify-content-between align-items-center">
                                        <strong>RESPONSABLE</strong>
                                        <i class="fas fa-chevron-down arrow-icon"></i>
                                    </h6>
                                </button>
                            </div>
                            <div id="collapseResponsable" class="collapse">
                                <div class="card-body p-2">
                                    <div class="textarea-container" id="responsableContainer">
                                        <textarea class="form-control form-control-sm mb-2" rows="2" readonly>MARIA VICTORIA FERNANDEZ GARZÓN
MARÍA AMPARO LONDOÑO GUTIERREZ</textarea>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="responsableContainer">
                                        <i class="fas fa-plus me-1"></i> Agregar Texto
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recursos (dentro de Acción) -->
                        <div class="card mt-3 border">
                            <div class="card-header bg-white p-2">
                                <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapseRecursos">
                                    <h6 class="mb-0 d-flex justify-content-between align-items-center">
                                        <strong>RECURSOS (MILLONES)</strong>
                                        <i class="fas fa-chevron-down arrow-icon"></i>
                                    </h6>
                                </button>
                            </div>
                            <div id="collapseRecursos" class="collapse">
                                <div class="card-body p-2">
                                    <div class="textarea-container" id="recursosContainer">
                                        <textarea class="form-control form-control-sm mb-2" rows="1" readonly>test recurso</textarea>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="recursosContainer">
                                        <i class="fas fa-plus me-1"></i> Agregar Texto
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fechas (dentro de Acción) -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-header bg-white p-2">
                                        <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapseInicio">
                                            <h6 class="mb-0 d-flex justify-content-between align-items-center">
                                                <strong>FECHA DE INICIO</strong>
                                                <i class="fas fa-chevron-down arrow-icon"></i>
                                            </h6>
                                        </button>
                                    </div>
                                    <div id="collapseInicio" class="collapse">
                                        <div class="card-body p-2">
                                            <div class="textarea-container" id="fechaInicioContainer">
                                                <textarea class="form-control form-control-sm mb-2" rows="1" readonly>feb-21</textarea>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="fechaInicioContainer">
                                                <i class="fas fa-plus me-1"></i> Agregar Texto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-header bg-white p-2">
                                        <button class="btn btn-sm btn-link text-dark text-decoration-none w-100 text-start p-1" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapseTerminacion">
                                            <h6 class="mb-0 d-flex justify-content-between align-items-center">
                                                <strong>FECHA DE TERMINACIÓN</strong>
                                                <i class="fas fa-chevron-down arrow-icon"></i>
                                            </h6>
                                        </button>
                                    </div>
                                    <div id="collapseTerminacion" class="collapse">
                                        <div class="card-body p-2">
                                            <div class="textarea-container" id="fechaTerminacionContainer">
                                                <textarea class="form-control form-control-sm mb-2" rows="1" readonly>dic-21</textarea>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary add-textarea-btn" data-target="fechaTerminacionContainer">
                                                <i class="fas fa-plus me-1"></i> Agregar Texto
                                            </button>
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

@section('styles')
<style>
    .compact-view {
        max-width: 600px;
        margin: 0 auto;
    }
    textarea.form-control {
        resize: none;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    textarea.form-control:focus {
        background-color: white;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }
    .card-header {
        padding: 0;
        background-color: white !important;
    }
    .card-header button {
        padding: 0.25rem 0.5rem;
    }
    .card-header button:hover {
        background-color: rgba(0,0,0,0.05);
    }
    .card-body {
        padding: 0.5rem !important;
    }
    h6 {
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    .arrow-icon {
        transition: transform 0.3s ease;
        font-size: 0.8rem;
    }
    .collapsed .arrow-icon {
        transform: rotate(-90deg);
    }
    .add-textarea-btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        margin-top: 0.25rem;
    }
    .textarea-container {
        margin-bottom: 0.5rem;
    }
    .new-textarea {
        margin-top: 0.5rem;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Estilo para tarjetas anidadas */
    .card .card {
        margin-bottom: 0.5rem;
    }
    .card .card .card-header {
        background-color: #f8f9fa !important;
    }
    /* Estilo para textareas editables */
    .editable-textarea {
        background-color: white !important;
        border: 1px solid #ced4da !important;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de flechas al desplegar
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('.arrow-icon');
                if (icon) {
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                }
            });
        });

        // Función para agregar nuevos textareas (mejorada)
        document.querySelectorAll('.add-textarea-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const container = document.getElementById(targetId);
                
                if (container) {
                    // Crear contenedor para el nuevo textarea y botón de eliminar
                    const newTextareaWrapper = document.createElement('div');
                    newTextareaWrapper.className = 'textarea-wrapper position-relative mb-2';
                    
                    // Crear el nuevo textarea
                    const newTextarea = document.createElement('textarea');
                    newTextarea.className = 'form-control form-control-sm editable-textarea new-textarea';
                    newTextarea.rows = 2;
                    newTextarea.placeholder = 'Escribe aquí...';
                    
                    // Crear botón para eliminar el textarea
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = 'btn btn-sm btn-outline-danger position-absolute delete-textarea-btn';
                    deleteBtn.style.right = '5px';
                    deleteBtn.style.bottom = '5px';
                    deleteBtn.innerHTML = '<i class="fas fa-times"></i>';
                    deleteBtn.onclick = function() {
                        newTextareaWrapper.remove();
                    };
                    
                    // Agregar elementos al DOM
                    newTextareaWrapper.appendChild(newTextarea);
                    newTextareaWrapper.appendChild(deleteBtn);
                    container.appendChild(newTextareaWrapper);
                    
                    // Animación y foco
                    newTextarea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    newTextarea.focus();
                }
            });
        });

        // Opcional: Abrir todos los acordeones al cargar
        const collapses = document.querySelectorAll('.collapse');
        collapses.forEach(collapse => {
            new bootstrap.Collapse(collapse, {
                toggle: true
            });
        });
    });
</script>
@endsection
@endsection