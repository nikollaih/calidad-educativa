<?php

namespace App\Http\Services\PMI;

use App\Models\FactorCritico;
use App\Models\FactorCriticoCalificacion;
use App\Models\PMI\PmiObjetivo;
use App\Models\PmiObjetivoVinculado;

class PmiObjetivoVinculadoService {
    public function __construct(private PmiMetasVinculadasService $metasVinculadasService) {
    }

    public function syncObjetivosVinculados(array $objetivosArray, int $idFactorCritico): void {
        $ids = [];
        // Recorre los registros
        foreach ($objetivosArray as $key => $objetivo) {
            $cannotCreateOrUpdate = !is_array($objetivo) ||
                empty($objetivo) ||
                empty($objetivo['descripcion']);

            if ($cannotCreateOrUpdate) {
                continue;
            }
            $objetivo['factor_id'] = $idFactorCritico;
            $objetivoId = (isset($objetivo['id']) && strpos($objetivo['id'], 'virtual') === false)
                ? $objetivo['id']
                : null;

            if ($objetivoId == null) {
                unset($objetivo['id']);
            }
            // Syncroniza el registro
            $objetivoUpdated = PmiObjetivoVinculado::updateOrCreate(['id' => $objetivoId], $objetivo);
            if (data_get($objetivo,'objetivo_general_id') == null && request()->input('institucionId') != null) {
                $institucionId = request()->input('institucionId');
                $factorCriticoVinculado = FactorCritico::findOrFail($objetivoUpdated->factor_id);
                $factorCalificacion = FactorCriticoCalificacion::where('descripcion', $factorCriticoVinculado->descripcion)
                    ->where(function ($query) use ($institucionId) {
                        $query->whereNull('institucion_id')
                              ->orWhere('institucion_id', $institucionId);
                    })
                    ->first();
                if (!empty($factorCalificacion)) {
                    // Verificar si ya existe uno con mismo descripcion + indice_calificacion
                    // con institucion_id NULL o exactamente el mismo institucion_id
                    $existe = PmiObjetivo::where('descripcion', $objetivoUpdated->descripcion)
                        ->where('factor_id', $factorCalificacion->id)
                        ->where(function ($q) use ($institucionId) {
                            $q->whereNull('institucion_id')
                            ->orWhere('institucion_id', $institucionId);
                        })
                        ->exists();
                    // Si no existe, lo creamos
                    if (!$existe) {
                        PmiObjetivo::create([
                            'descripcion'    => $objetivoUpdated->descripcion,
                            'factor_id'      => $factorCalificacion->id,
                            'institucion_id' => $institucionId,
                        ]);
                    }
                }
            }
            if (!isset($objetivo['metas'])) {
                throw new \Exception('No pueden haber objetivos sin meta, el objetivo ( ' . $objetivoUpdated->descripcion . ') no tiene ni una meta asociada');
            }
            $this->metasVinculadasService->syncMetasVinculados(metasArray: $objetivo['metas'],idObjetivo:  $objetivoUpdated->id);
            array_push($ids, $objetivoUpdated->id);
        }
        // Elimina los sobrantes
        PmiObjetivoVinculado::where('factor_id', $idFactorCritico)->whereNotIn('id', $ids)->delete();
    }
}
