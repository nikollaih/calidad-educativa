<?php

namespace App\Http\Services\PMI;

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
