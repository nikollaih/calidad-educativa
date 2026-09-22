<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMunicipioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('s-parametro-editar');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $municipioId = $this->route('municipio');
        
        return [
            'nombre' => 'required|string|max:255|unique:municipios,nombre,' . $municipioId,
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del municipio es obligatorio.',
            'nombre.unique' => 'El municipio ya existe.',
            'nombre.max' => 'El nombre del municipio no puede exceder 255 caracteres.',
        ];
    }
}
