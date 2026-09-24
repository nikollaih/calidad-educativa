<?php

namespace App\Http\Services;

use App\Models\Sede;
use App\DTOs\Result;
use Exception;

class SedesService {

    public function createSede(array $sedeData):Result {
        try {
            $sedeCreated = Sede::create($sedeData);
            if($sedeCreated)
            return Result::success('Sede creada con éxito', $sedeCreated);
        } catch (Exception $e) {
            return Result::error($e->getMessage());
        }
    }
}
