<?php

namespace App\Http\Services\PMI;

use App\Models\PMI\PmiIndicadorVinculado;

class PmiIndicadorVinculadoService {
    public function __construct(private PmiActividadVinculadasService $pmiActividadVinculadasService) {
    }

    public function syncIndicadoresVinculados(array $indicadoresArray, int $idMeta): void {
        $ids = [];
        // Recorre los registros
        foreach ($indicadoresArray as $key => $indicador) {
            $cannotCreateOrUpdate = !is_array($indicador) ||
                empty($indicador) ||
                empty($indicador['unidad_total']) ||
                empty($indicador['unidad_parcial']) ||
                empty($indicador['valor_requerido']);


            if ($cannotCreateOrUpdate) {
                continue;
            }
            $indicador['meta_id'] = $idMeta;
            $indicadorId = (isset($indicador['id']) && strpos($indicador['id'], 'v') === false)
                ? $indicador['id']
                : null;

            if ($indicadorId == null) {
                unset($indicador['id']);
            }
            // Syncroniza el registro
            $indicadorUpdated = PmiIndicadorVinculado::updateOrCreate(['id' => $indicadorId], $indicador);
            $this->pmiActividadVinculadasService->syncActividades(actividadesArray: $indicador['actividades'], indicadorId:  $indicadorUpdated->id);
            array_push($ids, $indicadorUpdated->id);
        }
        // Elimina los sobrantes
        PmiIndicadorVinculado::where('meta_id', $idMeta)->whereNotIn('id', $ids)->delete();
    }
}
