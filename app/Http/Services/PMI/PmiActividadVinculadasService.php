<?php
namespace App\Http\Services\PMI;
use App\Models\PmiActividadVinculada;

class PmiActividadVinculadasService {
    public function __construct() {
    }

    public function syncActividades(array $actividadesArray, int $indicadorId): void {
        $ids = [];
        // Recorre los registros
        foreach ($actividadesArray as $key => $actividad) {
            if (!is_array($actividad) ||
                empty($actividad) ||
                empty($actividad['descripcion']) ||
                empty($actividad['fecha_inicio']) ||
                empty($actividad['fecha_fin'])
            ) {
                continue;
            }
            $actividad['indicador_id'] = $indicadorId;

            $actividad['afecta_indicador'] = $actividad['afecta_indicador'] ? 1 : 0;

            $actividadId = (isset($actividad['id']) && strpos($actividad['id'], 'virtual') === false)
                ? $actividad['id']
                : null;

            if ($actividadId == null) {
                unset($actividad['id']);
            }
            // Syncroniza el registro
            $actividadUpdated = PmiActividadVinculada::updateOrCreate(['id' => $actividadId], $actividad);
            array_push($ids, $actividadUpdated->id);
        }
        // Elimina los sobrantes
        PmiActividadVinculada::where('indicador_id',$indicadorId)->whereNotIn('id', $ids)->delete();
    }
}
