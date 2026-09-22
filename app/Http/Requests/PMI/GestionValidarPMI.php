<?php

namespace App\Http\Requests\PMI;

use Illuminate\Foundation\Http\FormRequest;

class GestionValidarPMI extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('s-pmi-validar');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [];
    }
}
