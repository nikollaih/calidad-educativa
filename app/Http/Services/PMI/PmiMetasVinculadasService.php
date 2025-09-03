<?php

namespace App\Http\Services\PMI;

use App\Models\PmiMetaVinculada;

class PmiMetasVinculadasService {
    public function __construct(private PmiActividadVinculadasService $pmiActividadVinculadasService){}

    public function syncMetasVinculados(array $metasArray, int $idObjetivo): void {
            $ids = [];
            // Recorre los registros
            foreach ($metasArray as $key => $meta) {
                $cannotCreateOrUpdate = !is_array($meta) ||
                    empty($meta) ||
                    empty($meta['descripcion']);

                if ($cannotCreateOrUpdate) {
                    continue;
                }
                $meta['objetivo_id'] = $idObjetivo;
                $metaId = (isset($meta['id']) && strpos($meta['id'], 'virtual') === false)
                    ? $meta['id']
                    : null;

                if($metaId == null){
                    unset($meta['id']);
                }
                // Syncroniza el registro
                $metaUpdated = PmiMetaVinculada::updateOrCreate(['id' => $metaId], $meta);
                $this->pmiActividadVinculadasService->syncActividades(actividadesArray: $meta['actividades'],metaId:  $metaUpdated->id);
                array_push($ids, $metaUpdated->id);
            }
            // Elimina los sobrantes
        PmiMetaVinculada::where('objetivo_id', $idObjetivo)->whereNotIn('id', $ids)->delete();
    }

}
