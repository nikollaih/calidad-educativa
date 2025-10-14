<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitucionRequest extends FormRequest {
    public function authorize(): bool {
        // Allow any authenticated user
        return auth()->check();
    }

    public function rules(): array {
        return [
            'municipio_id' => ['nullable', 'integer'],
        ];
    }

    /**
     * Returns a closure to be consumed by ->filters() in the model.
     *
     * This closure can apply role-based or contextual filters dynamically.
     */
    public function filters(): callable {
        $user = $this->user();
        $municipioId = $this->query('municipio_id');

        return function ($query) use ($user, $municipioId) {
            $user = $this->user();
            $municipioId = $this->query('municipio_id');

            // Optional filter by municipio_id
            if ($municipioId) {
                $query->where('municipio_id', $municipioId);
            }

            // Role-based filters
            if ($user->hasRole('rector')) {
                $query->where('rector_id', $user->id);
            }

            return $query;
        };
    }
}

