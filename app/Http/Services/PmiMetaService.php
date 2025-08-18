<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Inventory;
use App\Models\PMI\PmiIndicador;
use App\Models\PMI\PmiMeta;
use Exception;

class PmiMetaService {
    public function __construct(private PmiActividadService $pmiActividadService){}

    public function syncMetas(array $metasArray, int $objetivoId): void {
            $ids = [];
            // Recorre los registros
            foreach ($metasArray as $key => $meta) {
                $cannotCreateOrUpdate = !is_array($meta) ||
                    empty($meta) ||
                    empty($meta['descripcion']) ||
                    empty($meta['indicador_id']);

                if ($cannotCreateOrUpdate) {
                    continue;
                }
                $meta['objetivo_id'] = $objetivoId;
                $metaId = isset($meta['id']) ? $meta['id'] : null;
                // Syncroniza el registro
                $metaUpdated = PmiMeta::updateOrCreate(['id' => $metaId], $meta);
                $this->pmiActividadService->syncActividades($meta['actividades'], $metaUpdated->id);
                array_push($ids, $metaUpdated->id);
            }
            // Elimina los sobrantes
            PmiMeta::where('objetivo_id', $objetivoId)->whereNotIn('id', $ids)->delete();
    }

}
