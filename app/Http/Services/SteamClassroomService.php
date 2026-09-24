<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\SteamClassroom;
use Exception;

class SteamClassroomService {

    public function create(array $data):Result {
        try {
            $steamClassroomCreated = SteamClassroom::create($data);
            if($steamClassroomCreated)
            return Result::success('Aula steam creada con éxito', $steamClassroomCreated);
        } catch (Exception $e) {
            return Result::error($e->getMessage());
        }
    }
}
