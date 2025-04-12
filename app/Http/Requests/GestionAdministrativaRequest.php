<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GestionAdministrativaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'institution_id' => 'nullable|integer',
            'proceso_matricula' => 'required|string',
            'anexo_proceso_matricula' => 'nullable|string',
            'sistema_informacion_academica' => 'required|string',
            'mantenimiento_infraestructura' => 'required|string',
            'anexo_mantenimiento_infraestructura' => 'nullable|string',
            'dotacion_recursos_aprendizaje' => 'required|string',
            'anexo_dotacion_recursos' => 'nullable|string',
            'programas_seguridad' => 'required|string',
            'estrategias_acceso_permanencia' => 'required|string',
            'perfiles_asignacion' => 'required|string',
            'programa_formacion_capacitacion' => 'required|string',
            'anexo_programa_formacion' => 'nullable|string',
            'pertenencia_personal' => 'required|string',
            'evaluacion_desempeno' => 'required|string',
            'convivencia_manejo_conflictos' => 'required|string',
            'presupuesto_fse' => 'required|string',
            'anexo_presupuesto_fse' => 'nullable|string',
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
            'mantenimiento_infraestructura' => 'mantenimiento y adecuación de infraestructura',
            'anexo_mantenimiento_infraestructura' => 'anexo de infraestructura',
            'dotacion_recursos_aprendizaje' => 'dotación y mantenimiento de recursos',
            'anexo_dotacion_recursos' => 'anexo de dotación de recursos',
            'programas_seguridad' => 'programas de seguridad',
            'estrategias_acceso_permanencia' => 'estrategias de acceso y permanencia',
            'perfiles_asignacion' => 'perfiles y asignación académica',
            'programa_formacion_capacitacion' => 'programa de formación y capacitación institucional',
            'anexo_programa_formacion' => 'anexo de formación institucional',
            'pertenencia_personal' => 'pertenencia del personal vinculado',
            'evaluacion_desempeno' => 'evaluación del desempeño de directivos, docentes y administrativos',
            'convivencia_manejo_conflictos' => 'convivencia y manejo de conflictos',
            'presupuesto_fse' => 'presupuesto anual del Fondo de Servicios Educativos',
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
