<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Inventory;
use App\Models\Sede;
use App\Models\SedeInfraestructura;
use App\Models\SedeMobiliario;
use Exception;

class MobiliarioService {

    public function create(array $data):Result {
        try {
            $mobiliario = SedeMobiliario::create($data);
            if($mobiliario)
                return Result::success('Elemento de mobiliario creado con éxito', $mobiliario);
            throw new Exception("Error al crear el elemento mobiliario");
        } catch (Exception $e) {
            return Result::error($e->getMessage());
        }
    }
    public function syncMobiliarios(array $mobiliarioArray, int $sedeId): void {
            $ids = [];
            // Recorre los registros
            foreach ($mobiliarioArray as $key => $mobiliario) {

                if (!is_array($mobiliario) || empty($mobiliario) || empty($mobiliario['cantidad'])) {
                    continue;
                }
                $mobiliario['sede_id']= $sedeId;
                // Syncroniza el registro
                $mobiliarioCreated = SedeMobiliario::updateOrCreate(['nombre' => $mobiliario['nombre']], $mobiliario);

                array_push($ids, $mobiliarioCreated->id);
            }
            // Elimina los sobrantes
            SedeMobiliario::where('sede_id',$sedeId)->whereNotIn('id', $ids)->delete();
    }

}
