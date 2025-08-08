<?php
namespace App\Http\Services\PMI;
use App\Models\PMI\PmiActividad;
use App\Models\PMI\PmiIndicador;
use App\Models\PmiActividadVinculada;

class PmiActividadVinculadasService {
    public function __construct(){}

    public function syncActividades(array $actividadesArray, int $metaId): void {
            $ids = [];
            // Recorre los registros
            foreach ($actividadesArray as $key => $actividad) {

                if (!is_array($actividad) ||
                    empty($actividad) ||
                    empty($actividad['descripcion']) ||
                    empty($actividad['peso']) ||
                    empty($actividad['recursos']) ||
                    empty($actividad['fecha_inicio']) ||
                    empty($actividad['fecha_fin'])
                ) {
                    continue;
                }
                $actividad['meta_id'] = $metaId;

                $actividadId = (isset($actividad['id']) && strpos($actividad['id'], 'virtual') === false)
                    ? $actividad['id']
                    : null;

                if($actividadId == null){
                    unset($actividad['id']);
                }
                // Syncroniza el registro
                $actividadUpdated = PmiActividadVinculada::updateOrCreate(['id' => $actividadId], $actividad);
                array_push($ids, $actividadUpdated->id);
            }
            // Elimina los sobrantes
        PmiActividadVinculada::where('meta_id',$metaId)->whereNotIn('id', $ids)->delete();
    }

}
