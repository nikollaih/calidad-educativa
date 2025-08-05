<?php
namespace App\Http\Services;
use App\Models\PMI\PmiActividad;
use App\Models\PMI\PmiIndicador;

class PmiActividadService {
    public function __construct(){}

    public function syncActividades(array $actividadesArray, int $indicadorId): void {
            $ids = [];
            // Recorre los registros
            foreach ($actividadesArray as $key => $actividad) {

                if (!is_array($actividad) || empty($actividad) || empty($actividad['descripcion']) || empty($actividad['peso'] )) {
                    continue;
                }
                $actividad['indicador_id'] = $indicadorId;
                $actividadId = isset($actividad['id']) ? $actividad['id']:null;
                // Syncroniza el registro
                $actividadUpdated = PmiActividad::updateOrCreate(['id' => $actividadId], $actividad);
                array_push($ids, $actividadUpdated->id);
            }
            // Elimina los sobrantes
        PmiActividad::where('indicador_id',$indicadorId)->whereNotIn('id', $ids)->delete();
    }

}
