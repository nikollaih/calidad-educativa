<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Inventory;
use App\Models\Sede;
use App\Models\SedeInfraestructura;
use Exception;

class InfraestructuraService {

    public function create(array $data):Result {
        try {
            $infraestructura = SedeInfraestructura::create($data);
            if($infraestructura)
                return Result::success('Elemento de infraestructura creado con éxito', $infraestructura);
            throw new Exception("Error al crear el elemento de infraestructura");
        } catch (Exception $e) {
            return Result::error($e->getMessage());
        }
    }
    public function syncInfraestructura(array $infraestructuraArray, int $sedeId): void {
            $ids = [];
            // Recorre los registros
            foreach ($infraestructuraArray as $key => $infraestructura) {

                if (!is_array($infraestructura) || empty($infraestructura) || empty($infraestructura['area'])) {
                    continue;
                }
                $infraestructura['sede_id']= $sedeId;
                // Syncroniza el registro
                $infraestructuraCreated = SedeInfraestructura::updateOrCreate(['nombre' => $infraestructura['nombre']], $infraestructura);

                array_push($ids, $infraestructuraCreated->id);
            }
            // Elimina los sobrantes
            SedeInfraestructura::where('sede_id',$sedeId)->whereNotIn('id', $ids)->delete();


    }

}
