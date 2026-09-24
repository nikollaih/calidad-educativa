<?php

namespace App\Http\Services;

use App\Models\Sede;
use App\DTOs\Result;
use App\Models\EducationalOffer;
use Exception;

class EducationalOfferService {

    public function create(array $data):Result {
            $educatinalOfferCreated = EducationalOffer::create($data);
            if($educatinalOfferCreated)
                return Result::success('Oferta educativa creada con éxito', $educatinalOfferCreated);
            return Result::error('Error al crear la oferta educativa');
    }
}
