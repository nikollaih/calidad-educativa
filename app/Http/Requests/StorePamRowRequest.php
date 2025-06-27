<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePamRowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Cambia a true para permitir la validación
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pam_id' => 'nullable|integer|exists:pams,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'proceso' => 'required|string|max:255',
            'subproceso' => 'required|string|max:255',
            'meta_plan_desarrollo' => 'required|string|max:255',
            'objetivo_estrategico' => 'required|string|max:255',
            'meta' => 'required|string|max:255',
            'indicador' => 'required|string|max:255',
            'accion' => 'required|string|max:255',
            'recursos' => 'required|string|max:255',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_final',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
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
            'pam_id.exists' => 'El PAM seleccionado no existe en nuestros registros',
            'user_id.exists' => 'El usuario seleccionado no existe',
            'proceso.required' => 'El campo proceso es obligatorio',
            'subproceso.required' => 'El campo subproceso es obligatorio',
            'meta_plan_desarrollo.required' => 'La meta del plan de desarrollo es obligatoria',
            'objetivo_estrategico.required' => 'El objetivo estratégico es obligatorio',
            'meta.required' => 'La meta es obligatoria',
            'indicador.required' => 'El indicador es obligatorio',
            'accion.required' => 'La acción es obligatoria',
            'recursos.required' => 'Los recursos son obligatorios',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria',
            'fecha_final.required' => 'La fecha final es obligatoria',
            'fecha_inicio.before_or_equal' => 'La fecha de inicio debe ser anterior o igual a la fecha final',
            'fecha_final.after_or_equal' => 'La fecha final debe ser posterior o igual a la fecha de inicio',
            '*.string' => 'El campo debe ser texto',
            '*.max' => 'El campo no debe exceder los :max caracteres',
            '*.date' => 'Debe ingresar una fecha válida',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'proceso' => 'Proceso',
            'subproceso' => 'Subproceso',
            'meta_plan_desarrollo' => 'Meta del Plan de Desarrollo',
            'objetivo_estrategico' => 'Objetivo Estratégico',
            'meta' => 'Meta',
            'indicador' => 'Indicador',
            'accion' => 'Acción',
            'recursos' => 'Recursos',
            'fecha_inicio' => 'Fecha de Inicio',
            'fecha_final' => 'Fecha Final',
        ];
    }
}