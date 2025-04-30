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
                    ['manual_convivencia', 'anexo_programa_institucional_induccion']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('clima_escolar')]
            ),
            'cultura_institucional' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->culturaInstitucional,
                    ['politica_comunicacion', 'politica_bienestar', 'inventario_buenas_practicas'],
                    ['anexo_cultura_institucional', 'anexo_politica_bienestar']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('cultura_institucional')]
            ),
            'direccionamiento_estrategico' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->direccionamientoEstrategico,
                    ['mision', 'vision', 'principios_institucionales', 'metas_institucionales', 'politica_inclusion'],
                    ['anexo_politica_inclusion']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('direccionamiento_estrategico')]
            ),
            'gestion_estrategica' => array_merge(
                $this->transformSimple(
                    $this->gestionDirectiva->gestionEstrategica,
                    ['liderazgo', 'articulacion', 'seguimiento']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('gestion_estrategica')]
            ),
            'gobierno_escolar' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->gobiernoEscolar,
                    ['gobierno_escolar'],
                    ['anexo_gobierno_escolar']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('gobierno_escolar')]
            ),
            'relaciones_entorno' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionDirectiva->relacionesEntorno,
                    ['relacion_familias', 'seguimiento_egresados', 'alianzas_instituciones', 'alianzas_sector_productivo'],
                    ['anexo_alianzas_instituciones', 'anexo_alianzas_sector_productivo']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('relaciones_entorno')]
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
                    ['anexo_planes_aula', 'anexo_temas_ensenanza']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('gestion_aulas')]
            ),
            'practicas_pedagogicas' => array_merge(
                $this->transformSimple(
                    $this->gestionAcademica->practicasPedagogicas,
                    ['estrategias_tareas']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('practicas_pedagogicas')]
            ),
            'seguimientos_academicos' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAcademica->seguimientosAcademicos,
                    ['seguimiento_desempenos', 'uso_evaluaciones_externas', 'apoyo_pedagogico'],
                    ['anexo_informe_estadistico', 'anexo_analisis_pruebas_externas', 'anexo_planes_mejoramiento']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('seguimientos_academicos')]
            ),
            'disenos_pedagogicos' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAcademica->disenosPedagogicos,
                    ['plan_estudios', 'enfoque_metodologico', 'estrategia_pedagogica', 'analisis_jornada_escolar', 'sistema_evaluacion'],
                    ['anexo_plan_estudios', 'anexo_enfoque_pedagogico', 'anexo_analisis_jornada', 'anexo_sistema_evaluacion']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('disenos_pedagogicos')]
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
                    ['anexo_mantenimiento_infraestructura', 'anexo_dotacion_recursos']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('administracion_planta_fisica')]
            ),
            'apoyo_financiero_contable' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAdministrativa->apoyoFinancieroContable,
                    ['presupuesto_fse', 'contabilidad', 'contratacion', 'control_fiscal'],
                    ['anexo_presupuesto_fse', 'anexo_manual_contratacion']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('apoyo_financiero_contable')]
            ),
            'apoyo_gestion_academica' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAdministrativa->apoyoGestionAcademica,
                    ['proceso_matricula', 'sistema_informacion_academica'],
                    ['anexo_acto_administrativo']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('apoyo_gestion_academica')]
            ),
            'servicios_complementarios' => array_merge(
                $this->transformSimple(
                    $this->gestionAdministrativa->serviciosComplementarios,
                    ['estrategias_acceso_permanencia']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('servicios_complementarios')]
            ),
            'talento_humano' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionAdministrativa->talentoHumano,
                    ['perfiles_asignacion', 'programa_formacion_capacitacion', 'pertenencia_personal', 'evaluacion_desempeno', 'convivencia_manejo_conflictos'],
                    ['anexo_programa_formacion', 'anexo_informe_anual']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('talento_humano')]
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
                    ['anexo_proyecto_escuela_padres']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('atencion_grupo_poblacionales')]
            ),
            'prevencion_riesgos' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionComunidad->prevencionRiesgos,
                    ['prevencion_riesgos_fisicos', 'prevencion_riesgos_psicosociales'],
                    ['anexo_prevencion_riesgos_fisicos']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('prevencion_riesgos')]
            ),
            'programas_servicio_social' => array_merge(
                $this->transformWithDocuments(
                    $this->gestionComunidad->programasServicioSocial,
                    ['programa_servicio_social'],
                    ['anexo_programa_servicio_social']
                ),
                ['nombre_gestion' => $this->obtieneNombreProceso('programas_servicio_social')]
            )
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
            if (isset($model->{$docField})) {
                $documents[$docField] = $model->{$docField};
            }
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
        };
    }
}