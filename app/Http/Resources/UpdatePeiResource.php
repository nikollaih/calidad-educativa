<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdatePeiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'gestion_directiva' => $this->transformGestionDirectiva(),
            'gestion_academica' => $this->transformGestionAcademica(),
            'gestion_administrativa' => $this->transformGestionAdministrativa(),
            'gestion_comunidad' => $this->transformGestionComunidad(),
            'resena_historica' => $this->transformResenaHistorica(),
        ];
    }

    protected function transformGestionDirectiva(): ?array
    {
        if (!$this->gestionDirectiva) return null;

        return [
            'clima_escolar' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->climaEscolar,
                    ['sentido_pertenencia', 'induccion_institucional', 'actividades_extracurriculares', 'manejo_conflictos'],
                    ['manualConvivencia', 'anexoProgramaInstitucionalInduccion']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('clima_escolar'),
                    'relation_name' => 'gestionDirectiva->climaEscolar',
                    'traces' => $this->gestionDirectiva->climaEscolar?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'cultura_institucional' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->culturaInstitucional,
                    ['politica_comunicacion', 'politica_bienestar', 'inventario_buenas_practicas'],
                    ['anexoCulturaInstitucional', 'anexoPoliticaBienestar']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('cultura_institucional'),
                    'relation_name' => 'gestionDirectiva->culturaInstitucional',
                    'traces' => $this->gestionDirectiva->culturaInstitucional?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'direccionamiento_estrategico' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->direccionamientoEstrategico,
                    ['mision', 'vision', 'principios_institucionales', 'metas_institucionales', 'politica_inclusion'],
                    ['anexoPoliticaInclusion']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('direccionamiento_estrategico'),
                    'relation_name' => 'gestionDirectiva->direccionamientoEstrategico',
                    'traces' => $this->gestionDirectiva->direccionamientoEstrategico?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'gestion_estrategica' => array_merge(
                $this->transformSimple(
                    $this->gestionDirectiva->gestionEstrategica,
                    ['liderazgo', 'articulacion', 'seguimiento']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('gestion_estrategica'),
                    'relation_name' => 'gestionDirectiva->gestionEstrategica',
                    'traces' => $this->gestionDirectiva->gestionEstrategica?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'gobierno_escolar' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->gobiernoEscolar,
                    ['gobierno_escolar'],
                    ['anexoGobiernoEscolar']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('gobierno_escolar'),
                    'relation_name' => 'gestionDirectiva->gobiernoEscolar',
                    'traces' => $this->gestionDirectiva->gobiernoEscolar?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'relaciones_entorno' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->relacionesEntorno,
                    ['relacion_familias', 'seguimiento_egresados', 'alianzas_instituciones', 'alianzas_sector_productivo'],
                    ['anexoAlianzasInstituciones', 'anexoAlianzasSectorProductivo']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('relaciones_entorno'),
                    'relation_name' => 'gestionDirectiva->relacionesEntorno',
                    'traces' => $this->gestionDirectiva->relacionesEntorno?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            )
        ];
    }

    protected function transformGestionAcademica(): ?array
    {
        if (!$this->gestionAcademica) return null;

        return [
            'gestion_aulas' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAcademica->gestionAulas,
                    ['ambientes_aprendizaje', 'motivacion_aprendizaje', 'plan_aula', 'evaluacion_aula'],
                    ['anexoPlanesAula', 'anexoTemasEnsenanza']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('gestion_aulas'),
                    'relation_name' => 'gestionAcademica->gestionAulas',
                    'traces' => $this->gestionAcademica->gestionAulas?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'practicas_pedagogicas' => array_merge(
                $this->transformSimple(
                    $this->gestionAcademica->practicasPedagogicas,
                    ['estrategias_tareas']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('practicas_pedagogicas'),
                    'relation_name' => 'gestionAcademica->practicasPedagogicas',
                    'traces' => $this->gestionAcademica->practicasPedagogicas?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'seguimientos_academicos' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAcademica->seguimientosAcademicos,
                    ['seguimiento_desempenos', 'uso_evaluaciones_externas', 'apoyo_pedagogico'],
                    ['anexoInformeEstadistico', 'anexoAnalisisPruebasExternas', 'anexoPlanesMejoramiento']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('seguimientos_academicos'),
                    'relation_name' => 'gestionAcademica->seguimientosAcademicos',
                    'traces' => $this->gestionAcademica->seguimientosAcademicos?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'disenos_pedagogicos' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAcademica->disenosPedagogicos,
                    ['plan_estudios', 'enfoque_metodologico', 'estrategia_pedagogica', 'analisis_jornada_escolar', 'sistema_evaluacion'],
                    ['anexoPlanEstudios', 'anexoEnfoquePedagogico', 'anexoAnalisisJornada', 'anexoSistemaEvaluacion']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('disenos_pedagogicos'),
                    'relation_name' => 'gestionAcademica->disenosPedagogicos',
                    'traces' => $this->gestionAcademica->disenosPedagogicos?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            )
        ];
    }

    protected function transformGestionAdministrativa(): ?array
    {
        if (!$this->gestionAdministrativa) return null;

        return [
            'administracion_planta_fisica' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAdministrativa->administracionPlantaFisica,
                    ['mantenimiento_infraestructura', 'dotacion_recursos_aprendizaje', 'programas_seguridad'],
                    ['anexoMantenimientoInfraestructura', 'anexoDotacionRecursos']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('administracion_planta_fisica'),
                    'relation_name' => 'gestionAdministrativa->administracionPlantaFisica',
                    'traces' => $this->gestionAdministrativa->administracionPlantaFisica?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'apoyo_financiero_contable' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAdministrativa->apoyoFinancieroContable,
                    ['presupuesto_fse', 'contabilidad', 'contratacion', 'control_fiscal'],
                    ['anexoPresupuestoFse', 'anexoManualContratacion']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('apoyo_financiero_contable'),
                    'relation_name' => 'gestionAdministrativa->apoyoFinancieroContable',
                    'traces' => $this->gestionAdministrativa->apoyoFinancieroContable?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'apoyo_gestion_academica' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAdministrativa->apoyoGestionAcademica,
                    ['proceso_matricula', 'sistema_informacion_academica'],
                    ['anexoActoAdministrativo']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('apoyo_gestion_academica'),
                    'relation_name' => 'gestionAdministrativa->apoyoGestionAcademica',
                    'traces' => $this->gestionAdministrativa->apoyoGestionAcademica?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'servicios_complementarios' => array_merge(
                $this->transformSimple(
                    $this->gestionAdministrativa->serviciosComplementarios,
                    ['estrategias_acceso_permanencia']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('servicios_complementarios'),
                    'relation_name' => 'gestionAdministrativa->serviciosComplementarios',
                    'traces' => $this->gestionAdministrativa->serviciosComplementarios?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'talento_humano' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAdministrativa->talentoHumano,
                    ['perfiles_asignacion', 'programa_formacion_capacitacion', 'pertenencia_personal', 'evaluacion_desempeno', 'convivencia_manejo_conflictos'],
                    ['anexoProgramaFormacion', 'anexoInformeAnual']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('talento_humano'),
                    'relation_name' => 'gestionAdministrativa->talentoHumano',
                    'traces' => $this->gestionAdministrativa->talentoHumano?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            )
        ];
    }

    protected function transformGestionComunidad(): ?array
    {
        if (!$this->gestionComunidad) return null;

        return [
            'atencion_grupo_poblacionales' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionComunidad->atencionGrupoPoblacionales,
                    ['atencion_grupos_vulnerabilidad', 'necesidades_expectativas_estudiantes', 'proyectos_vida', 'escuela_padres', 'oferta_servicios_comunidad'],
                    ['anexoProyectoEscuelaPadres']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('atencion_grupo_poblacionales'),
                    'relation_name' => 'atencionGrupoPoblacionales',
                    'traces' => $this->gestionComunidad->atencionGrupoPoblacionales?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'prevencion_riesgos' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionComunidad->prevencionRiesgos,
                    ['prevencion_riesgos_fisicos', 'prevencion_riesgos_psicosociales'],
                    ['anexoPrevencionRiesgosFisicos']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('prevencion_riesgos'),
                    'relation_name' => 'prevencionRiesgos',
                    'traces' => $this->gestionComunidad->prevencionRiesgos?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
            'programas_servicio_social' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionComunidad->programasServicioSocial,
                    ['programa_servicio_social'],
                    ['anexoProgramaServicioSocial']
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('programas_servicio_social'),
                    'relation_name' => 'programasServicioSocial',
                    'traces' => $this->gestionComunidad->programasServicioSocial?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            )
        ];
    }

    protected function transformResenaHistorica(): ?array {
        if (!$this->resenaHistorica) return null;

        return [
            'resena_historica' => array_merge(
                $this->transformSimple(
                    $this->resenaHistorica->resenaHistorica,
                    ['resena_historica'],
                ),
                [
                    'nombre_gestion' => $this->obtieneNombreProceso('resena_historica'),
                    'relation_name' => 'resenaHistorica->resenaHistorica',
                    'traces' => $this->resenaHistorica->resenaHistorica?->historialesPei->map(function ($trace) {
                        return [
                            'model_id'          => $trace->model_id ?? 'Sin informacion',
                            'model_type'        => $trace->model_type ?? 'Sin informacion',
                            'changes'           => [
                                'old_data'          => $trace->old_data ?? 'Sin informacion',
                                'new_data'          => $trace->new_data ?? 'Sin informacion',
                            ],
                            'attachment_id'     => $trace->attachment_id ?? 'Sin informacion',
                            'attachment_url'    => $trace->attachment?->ruta ?? 'Sin ruta',
                            'tipo_codificacion' => $trace->tipo_codificacion ?? 'Sin informacion',
                            'date'              => $trace->date ?? 'Sin informacion',
                            'observation'       => $trace->observation ?? 'Sin informacion',
                        ];
                    })
                ]
            ),
        ];
    }

    protected function transformSimple($model, array $fields): ?array
    {
        if (!$model) return null;

        $result = [];

        foreach ($fields as $field) {
            $result[$field] = $model->{$field} ?? null;
        }
        return $result;
    }

    protected function transformWithDocuments($model, array $fields, array $documentFields): ?array
    {
        if (!$model) return null;

        $result = $this->transformSimple($model, $fields);

        $documents = [];
        foreach ($documentFields as $docField) {
            $documents[$docField] = $model->{$docField};
        }

        if (!empty($documents)) {
            $result['documentos'] = $documents;
        }

        return $result;
    }

    protected function obtieneNombreProceso(string $nombre)
    {
        return match ($nombre) {
            'clima_escolar' => 'CLIMA ESCOLAR',
            'cultura_institucional' => 'CULTURA INSTITUCIONAL',
            'direccionamiento_estrategico' => 'DIRECCIONAMIENTO ESTRATÉGICO',
            'gestion_estrategica' => 'GESTIÓN ESTRATÉGICA',
            'gobierno_escolar' => 'GOBIERNO ESCOLAR',
            'relaciones_entorno' => 'RELACIONES CON EL ENTORNO',
            'gestion_aulas' => 'GESTIÓN DE AULA',
            'practicas_pedagogicas' => 'PRÁCTICAS PEDAGÓGICAS',
            'seguimientos_academicos' => 'SEGUIMIENTO ACADÉMICO',
            'disenos_pedagogicos' => 'DISEÑO PEDAGÓGICO',
            'administracion_planta_fisica' => 'ADMINISTRACIÓN DE PLANTA FÍSICA',
            'apoyo_financiero_contable' => 'APOYO FINANCIERO',
            'apoyo_gestion_academica' => 'APOYO A LA GESTIÓN ACADÉMICA',
            'servicios_complementarios' => 'SERVICIOS COMPLEMENTARIOS',
            'talento_humano' => 'TALENTO HUMANO',
            'atencion_grupo_poblacionales' => 'ATENCIÓN EDUCATIVA A GRUPOS POBLACIONALES',
            'prevencion_riesgos' => 'PREVENCIÓN DE RIESGOS',
            'programas_servicio_social' => 'PROGRAMA DE SERVICIO SOCIAL',
            'resena_historica' => 'RESEÑA HISTORICA',
            default => 'SIN NOMBRE DE PROCESO'
        };
    }
}