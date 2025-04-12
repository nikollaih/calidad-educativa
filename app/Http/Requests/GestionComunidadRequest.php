<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GestionComunidadRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'institution_id' => 'nullable|integer',
            'atencion_grupos_vulnerabilidad' => 'required|string',
            'necesidades_expectativas_estudiantes' => 'required|string',
            'proyectos_vida' => 'required|string',
            'escuela_padres' => 'required|string',
            'oferta_servicios_comunidad' => 'required|string',
            'programa_servicio_social' => 'required|string',
            'anexo_programa_servicio_social' => 'nullable|file',
            'prevencion_riesgos_fisicos' => 'required|string',
            'anexo_prevencion_riesgos_fisicos' => 'nullable|file',
            'prevencion_riesgos_psicosociales' => 'required|string',
        ];
    }
   
    public function attributes(): array
    {
        return [
            'institution_id' => 'institución',
            'atencion_grupos_vulnerabilidad' => 'atención a grupos en condición de vulnerabilidad',
            'necesidades_expectativas_estudiantes' => 'necesidades y expectativas de los estudiantes',
            'proyectos_vida' => 'proyectos de vida',
            'escuela_padres' => 'escuela de padres',
            'oferta_servicios_comunidad' => 'oferta de servicios a la comunidad',
            'programa_servicio_social' => 'programa de servicio social',
            'anexo_programa_servicio_social' => 'anexo del programa de servicio social',
            'prevencion_riesgos_fisicos' => 'prevención de riesgos físicos',
            'anexo_prevencion_riesgos_fisicos' => 'anexo de prevención de riesgos físicos',
            'prevencion_riesgos_psicosociales' => 'prevención de riesgos psicosociales',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'file' => 'El campo :attribute debe ser un archivo válido.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
        ];
    }
}
