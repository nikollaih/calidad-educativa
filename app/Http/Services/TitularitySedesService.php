<?php

namespace App\Http\Services;

use App\Models\Sede;
use App\DTOs\Result;
use App\Models\TitularidadSede;
use Exception;

class TitularitySedesService {

    public function create(array $titularitySedesData):Result {
        try {
            $titularitySedeCreated = TitularidadSede::create($titularitySedesData);
            if($titularitySedeCreated)
            return Result::success('Titularidad creada con éxito', $titularitySedeCreated);
        } catch (Exception $e) {
            return Result::error($e->getMessage());
        }
    }
}
