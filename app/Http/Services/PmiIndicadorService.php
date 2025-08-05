<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Inventory;
use App\Models\PMI\PmiIndicador;
use Exception;

class PmiIndicadorService {
    public function __construct(private PmiActividadService $pmiActividadService){}

    public function syncIndicadores(array $indicadorArray, int $metaId): void {
            $ids = [];
            // Recorre los registros
            foreach ($indicadorArray as $key => $indicador) {

                if (!is_array($indicador) || empty($indicador) || empty($indicador['descripcion'])) {
                    continue;
                }
                $indicador['meta_id']= $metaId;
                $indicadorId = isset($indicador['id'])?$indicador['id']:null;
                // Syncroniza el registro
                $indicadorUpdated = PmiIndicador::updateOrCreate(['id' => $indicadorId], $indicador);
                $this->pmiActividadService->syncActividades($indicador['actividades'], $indicadorUpdated->id);
                array_push($ids, $indicadorUpdated->id);
            }
            // Elimina los sobrantes
            PmiIndicador::where('meta_id',$metaId)->whereNotIn('id', $ids)->delete();
    }

}
