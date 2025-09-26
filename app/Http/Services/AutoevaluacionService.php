<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Autoevaluacion;
use App\Models\Calificacion;
use App\Models\FactorCritico;
use App\Models\FactorCriticoCalificacion;
use App\Models\GrupoCalificacion;
use Illuminate\Support\Collection;

class AutoevaluacionService {
    const PUNTAJE_MINIMO_PARA_PMI = 4;

    // Permite almacenar un adjunto
    public function tieneNotasPendientes(Autoevaluacion $autoevaluacion):Result {
        $cantidadTotalNotas = Calificacion::count();
        $cantidadTotalNotasCalificadas = $autoevaluacion->notas()->count();

        $tieneNotasPendientes  = $cantidadTotalNotas - $cantidadTotalNotasCalificadas != 0;
        if ( $tieneNotasPendientes) {
            // Obtener los IDs de las notas ya calificadas
            $notasCalificadasIds = $autoevaluacion->notas()->pluck('indice_calificacion');

            // Obtener la primera nota que no está calificada
            $primeraNotaSinCalificar = Calificacion::whereNotIn('indice', $notasCalificadasIds)
                ->orderBy('indice')
                ->first();

            return  Result::success('Actualmente tienes '. $primeraNotaSinCalificar->indice . ' ' . $primeraNotaSinCalificar->nombre .
                ' y otras '
                . $cantidadTotalNotas - ($cantidadTotalNotasCalificadas + 1) . ' notas pendientes por calificar.');
        }
        return Result::error(msg:' No tienes notas pendientes por calificar.');
    }
    public function obtenerNotasPendientes(Autoevaluacion $autoevaluacion):Collection {
        // Extrae los índices de calificación ya respondidos
        $indicesRespondidos = $autoevaluacion->notas()->pluck('indice_calificacion');

        // Retorna las calificaciones cuyo índice no esté en la lista de respondidos
        return Calificacion::whereNotIn('indice', $indicesRespondidos)
            ->orderBy('indice')
            ->get();
    }
    public function asignarPmiFactoresCriticos(Autoevaluacion $autoevaluacion,int $pmiId):Collection {
        $factoresCriticos = $autoevaluacion->factoresCriticos;

        $asignados = $factoresCriticos->filter(function ($factor) {
            return $factor->valor >= self::PUNTAJE_MINIMO_PARA_PMI;
        })->each(function ($factor) use ($pmiId) {
            $factor->pmi_id = $pmiId;
            $factor->save();
        });

        return $asignados->values();
    }
    public function getFortalezasDebilidades(int $autoevaluacionId): array {
        $autoevaluacion = Autoevaluacion::with(
            'notas',
            'notas.calificacion',
            'notas.calificacion.grupo',
            'notas.calificacion.grupo.padre',
            'factoresCriticos'
        )
            ->where('id', $autoevaluacionId)
            ->first();

        $factoresCriticosRegistrados = $autoevaluacion->factoresCriticos()->get();


        if (empty($autoevaluacion)) {
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');
        }
        $gestiones = GrupoCalificacion::whereNull('padre_id')->get();

        // Obtener todas las calificaciones existentes para poder identificar las no calificadas
        $todasCalificaciones = Calificacion::with(['grupo', 'grupo.padre'])->get();

        // Mapear las notas de la autoevaluación
        $notasFormateadas = $autoevaluacion->notas->map(function ($nota) {
            return [
                'id' => $nota->calificacion->id,
                'nombre_calificacion' => $nota->calificacion->nombre,
                'indice_calificacion' => $nota->calificacion->indice,
                'grupo_indice' => $nota->calificacion->grupo->indice,
                'grupo_nombre' => $nota->calificacion->grupo->nombre,
                'padre_id' => $nota->calificacion->grupo->padre_id,
                'padre_nombre' => $nota->calificacion->grupo->padre->nombre,
                'padre_indice' => $nota->calificacion->grupo->padre->indice,
                'valor' => $nota->valor
            ];
        });

        // Identificar calificaciones no evaluadas
        $calificacionesNoEvaluadas = collect();
        $idsCalificacionesEvaluadas = $notasFormateadas->pluck('id')->toArray();

        foreach ($todasCalificaciones as $calificacion) {
            if (!in_array($calificacion->id, $idsCalificacionesEvaluadas)) {
                $calificacionesNoEvaluadas->push([
                    'id' => $calificacion->id,
                    'nombre_calificacion' => $calificacion->nombre,
                    'indice_calificacion' => $calificacion->indice,
                    'grupo_indice' => $calificacion->grupo->indice,
                    'grupo_nombre' => $calificacion->grupo->nombre,
                    'padre_id' => $calificacion->grupo->padre_id,
                    'padre_nombre' => $calificacion->grupo->padre->nombre,
                    'padre_indice' => $calificacion->grupo->padre->indice,
                    'valor' => null // No evaluadas
                ]);
            }
        }

        // Combinar las notas evaluadas con las no evaluadas
        $todasLasNotas = $notasFormateadas->concat($calificacionesNoEvaluadas);

        // Agrupar notas por grupo para calcular promedios
        $gruposConNotas = $todasLasNotas->groupBy('grupo_indice');

        // Obtener el total de calificaciones por grupo (para usar en el cálculo del promedio)
        $totalCalificacionesPorGrupo = [];
        foreach ($todasCalificaciones as $calificacion) {
            $grupoIndice = $calificacion->grupo->indice;
            if (!isset($totalCalificacionesPorGrupo[$grupoIndice])) {
                $totalCalificacionesPorGrupo[$grupoIndice] = 0;
            }
            $totalCalificacionesPorGrupo[$grupoIndice]++;
        }

        $grupos = [];
        foreach ($gruposConNotas as $grupoIndice => $notas) {
            // Calcular el promedio del grupo considerando el total de calificaciones disponibles
            $notasConValor = $notas->filter(function ($nota) {
                return !is_null($nota['valor']);
            });

            $totalCalificaciones = isset($totalCalificacionesPorGrupo[$grupoIndice])
                ? $totalCalificacionesPorGrupo[$grupoIndice]
                : $notas->count();

            $promedio = $notasConValor->sum('valor') / $totalCalificaciones;
            $promedio = round($promedio, 2);

            $grupos[$grupoIndice] = [
                'indice' => $grupoIndice,
                'nombre' => $notas->first()['grupo_nombre'],
                'padre_nombre' => $notas->first()['padre_nombre'],
                'padre_indice' => $notas->first()['padre_indice'],
                'promedio' => $promedio,
                'notas' => $notas,
                'total_calificaciones' => $totalCalificaciones,
                'calificaciones_evaluadas' => $notasConValor->count()
            ];
        }

        $fortalezas = collect();
        foreach ($grupos as $grupo) {
            if ($grupo['promedio'] > 3) {
                $nombreGrupoPadre = $grupo['padre_nombre'];
                if (!$fortalezas->has($nombreGrupoPadre)) {
                    $fortalezas[$nombreGrupoPadre] = collect();
                }

                // Agregar el grupo como fortaleza
                $fortalezas[$nombreGrupoPadre]->push([
                    'nombre' => $grupo['nombre'],
                    'indice' => $grupo['indice'],
                    'promedio' => $grupo['promedio'],
                    'calificados' => $grupo['calificaciones_evaluadas'] . ' de ' . $grupo['total_calificaciones'],
                    'calificaciones' => collect() // Agregar siempre la clave calificaciones
                ]);
            }

            // También agregamos las calificaciones individuales con valores altos (4 o 5)
            $calificacionesFortaleza = $grupo['notas']->filter(function ($nota) {
                return $nota['valor'] >= 4;
            });

            if ($calificacionesFortaleza->count() > 0) {
                $nombreGrupoPadre = $grupo['padre_nombre'];
                $nombreGrupo = $grupo['nombre'];

                if (!$fortalezas->has($nombreGrupoPadre)) {
                    $fortalezas[$nombreGrupoPadre] = collect();
                }

                // Buscar si el subgrupo ya existe
                $indiceSubgrupo = $fortalezas[$nombreGrupoPadre]->search(function ($item) use ($nombreGrupo) {
                    return $item['nombre'] === $nombreGrupo;
                });

                // Si no existe, crearlo
                if ($indiceSubgrupo === false) {
                    $fortalezas[$nombreGrupoPadre]->push([
                        'nombre' => $nombreGrupo,
                        'calificaciones' => collect()
                    ]);
                    $indiceSubgrupo = $fortalezas[$nombreGrupoPadre]->count() - 1;
                } else {
                    // Si existe pero no tiene calificaciones, crearlas
                    if (!isset($fortalezas[$nombreGrupoPadre][$indiceSubgrupo]['calificaciones'])) {
                        $fortalezas[$nombreGrupoPadre][$indiceSubgrupo]['calificaciones'] = collect();
                    }
                }

                // Agregar las calificaciones
                foreach ($calificacionesFortaleza as $nota) {
                    $estado = $nota['valor'] == 4 ? 'Funcional (4)' : 'Óptimo (5)';
                    $fortalezas[$nombreGrupoPadre][$indiceSubgrupo]['calificaciones']->push([
                        'nombre' => $nota['nombre_calificacion'],
                        'indice' => $nota['indice_calificacion'],
                        'estado' => $estado
                    ]);
                }
            }
        }


        // Identificar oportunidades de mejora (calificaciones con valor 1 o no calificadas)
        $oportunidadesMejora = collect();
        $factoresCriticosPorDefecto = collect();
        foreach ($grupos as $grupo) {
            // Incluir grupos con promedio bajo (menor a 3) como oportunidad de mejora general

            $nombreGrupoPadre = $grupo['padre_nombre'];
            if (!$oportunidadesMejora->has($nombreGrupoPadre)) {
                $oportunidadesMejora[$nombreGrupoPadre] = collect();
            }
            // Agregar el grupo completo como oportunidad de mejora
            $oportunidadesMejora[$nombreGrupoPadre]->push([
                'nombre' => $grupo['nombre'],
                'indice' => $grupo['indice'],
                'promedio' => $grupo['promedio'],
                'calificados' => $grupo['calificaciones_evaluadas'] . ' de ' . $grupo['total_calificaciones']
            ]);


            // También agregamos las calificaciones individuales con valor 1 o no calificadas
            $calificacionesMejora = $grupo['notas']->filter(function ($nota) {
                return $nota['valor'] <= 3 || is_null($nota['valor']);
            });

            if ($calificacionesMejora->count() > 0) {
                $nombreGrupo = $grupo['nombre'];
                if (!$oportunidadesMejora->has('Calificaciones específicas - ' . $nombreGrupo)) {
                    $oportunidadesMejora['Calificaciones específicas - ' . $nombreGrupo] = collect();
                }

                foreach ($calificacionesMejora as $nota) {
                    $factorCritico = FactorCriticoCalificacion::where('indice_calificacion',$nota['indice_calificacion'])->first();
                    $factoresCriticosPorDefecto->push($factorCritico);
                    $oportunidadesMejora['Calificaciones específicas - ' . $nombreGrupo]->push([
                        'nombre' => $nota['nombre_calificacion'],
                        'indice' => $nota['indice_calificacion'],
                        'estado' => is_null($nota['valor']) ? 'No evaluada' : 'Existencia (1)'
                    ]);
                }
            }
        }
        if ($autoevaluacion->alias_estado != 'VALIDACION') {
            // Recolectar los registros válidos que vamos a mantener
            $idsParaMantener = [];
            foreach ($factoresCriticosPorDefecto as $factorPorDefecto) {
                $factoresCriticosExistentes = $factoresCriticosRegistrados->where('calificacion_indice',$factorPorDefecto->indice_calificacion);
                if ($factoresCriticosExistentes->isNotEmpty()) {
                    $idsParaMantener = array_merge(
                        $idsParaMantener,
                        $factoresCriticosExistentes->pluck('id')->toArray()
                    );
                } else {
                    // Buscar si ya existe uno igual
                    $factorCreado = FactorCritico::create(
                        [
                            'calificacion_indice' => $factorPorDefecto->indice_calificacion,
                            'autoevaluacion_id' => $autoevaluacionId,
                            'descripcion' => $factorPorDefecto->descripcion,
                            'valor' => 1,
                        ],
                    );
                    $idsParaMantener[] = $factorCreado->id;
                }
            }
            FactorCritico::where('autoevaluacion_id',  $autoevaluacionId)
                ->whereNotIn('id', $idsParaMantener)
                ->delete();
            $autoevaluacion->refresh();
            $autoevaluacion->fresh();
        }

        $factoresCriticos = FactorCritico::with('calificacion')
            ->where('autoevaluacion_id', $autoevaluacionId)
            ->get();
        $factoresCriticosInstitucion = FactorCriticoCalificacion::with('calificacion')
            ->whereNull('institucion_id')
            ->orWhere('institucion_id',$autoevaluacion->institucion_id)
            ->get();
        return [
            'fortalezas' => $fortalezas,
            'oportunidadesMejora' => $oportunidadesMejora,
            'gestiones' => $gestiones,
            'autoevaluacionId' => $autoevaluacion->id,
            'institucionId' => $autoevaluacion->institucion_id,
            'factoresCriticosPorDefecto' => $factoresCriticos,
            'puedeEditar' => $autoevaluacion->alias_estado != 'VALIDACION',
            'factoresCriticosInstitucion' => $factoresCriticosInstitucion
        ];
    }
}
