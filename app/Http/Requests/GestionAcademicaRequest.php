<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GestionAcademicaRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'institution_id' => 'nullable|integer',
            'proceso_matricula' => 'required|string',
            'anexo_proceso_matricula' => 'nullable|file',
            'sistema_informacion_academica' => 'required|string',
            'mantenimiento_infraestructura' => 'required|string',
            'anexo_mantenimiento_infraestructura' => 'nullable|file',
            'dotacion_recursos_aprendizaje' => 'required|string',
            'anexo_dotacion_recursos' => 'nullable|file',
            'programas_seguridad' => 'required|string',
            'estrategias_acceso_permanencia' => 'required|string',
            'perfiles_asignacion' => 'required|string',
            'programa_formacion_capacitacion' => 'required|string',
            'anexo_programa_formacion' => 'nullable|file',
            'pertenencia_personal' => 'required|string',
            'evaluacion_desempeno' => 'required|string',
            'convivencia_manejo_conflictos' => 'required|string',
            'presupuesto_fse' => 'required|string',
            'anexo_presupuesto_fse' => 'nullable|file',
            'contabilidad' => 'required|string',
            'contratacion' => 'required|string',
            'control_fiscal' => 'required|string',
        ];
    }
   
    public function attributes(): array
    {
        return [
            'institution_id' => 'institución',
            'proceso_matricula' => 'proceso de matrícula',
            'anexo_proceso_matricula' => 'anexo del proceso de matrícula',
            'sistema_informacion_academica' => 'sistema de información académica',
            'mantenimiento_infraestructura' => 'mantenimiento de la infraestructura',
            'anexo_mantenimiento_infraestructura' => 'anexo del mantenimiento de la infraestructura',
            'dotacion_recursos_aprendizaje' => 'dotación de recursos de aprendizaje',
            'anexo_dotacion_recursos' => 'anexo de dotación de recursos',
            'programas_seguridad' => 'programas de seguridad',
            'estrategias_acceso_permanencia' => 'estrategias de acceso y permanencia',
            'perfiles_asignacion' => 'perfiles de asignación',
            'programa_formacion_capacitacion' => 'programa de formación y capacitación',
            'anexo_programa_formacion' => 'anexo del programa de formación',
            'pertenencia_personal' => 'pertenencia del personal',
            'evaluacion_desempeno' => 'evaluación del desempeño',
            'convivencia_manejo_conflictos' => 'convivencia y manejo de conflictos',
            'presupuesto_fse' => 'presupuesto FSE',
            'anexo_presupuesto_fse' => 'anexo del presupuesto FSE',
            'contabilidad' => 'contabilidad',
            'contratacion' => 'contratación',
            'control_fiscal' => 'control fiscal',
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
