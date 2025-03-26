<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\EducationalOffer;
use App\Models\Inventory;
use Exception;

class EducationalModelService {

    public function syncEducationalModel(array $educationalModels, int $educationalOfferId): void {
            // Verifica que la oferta exista
            $educationalOffer = EducationalOffer::findOrFail($educationalOfferId);

            // Filtra IDs válidos (enteros positivos)
            $validIds = array_filter($educationalModels, function($id) {
                return is_numeric($id) && $id > 0;
            });

            // Sincroniza la relación muchos-a-muchos
            $educationalOffer->educationalModels()->sync($validIds);
    }

}
