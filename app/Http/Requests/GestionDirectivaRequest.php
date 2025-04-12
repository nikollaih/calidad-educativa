<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GestionDirectivaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'mision' => 'required',
            'vision' => 'required',
            'principios_institucionales' => 'required',
            'metas_institucionales' => 'required',
            'politica_inclusion' => 'required',
            'liderazgo' => 'required',
            'articulacion' => 'required',
            'seguimiento' => 'required',
            'gobierno_escolar' => 'required',
            'anexo_gobierno_escolar' => 'nullable',
            'cultura' => 'required',
            'anexo_cultura' => 'nullable',
            'politica_bienestar' => 'required',
            'apoyo_investigacion' => 'required',
            'inventario_buenas_practicas' => 'required',
            'sentido_pertenencia' => 'required',
            'induccion_institucional' => 'required',
            'manual_convivencia' => 'nullable',
            'actividades_extracurriculares' => 'required',
            'manejo_conflictos' => 'required',
            'relacion_familias' => 'required',
            'seguimiento_egresados' => 'required',
            'alianzas_instituciones' => 'required',
            'anexo_alianzas' => 'nullable',
            'alianzas_sector_productivo' => 'required',
            'anexo_sector' => 'nullable',
        ];
    }
    
    public function messages(): array {
        return [
            'mision.required' => 'El campo Misión es obligatorio.',
            'vision.required' => 'El campo Visión es obligatorio.',
            'principios_institucionales.required' => 'El campo Principios institucionales es obligatorio.',
            'metas_institucionales.required' => 'El campo Metas institucionales es obligatorio.',
            'politica_inclusion.required' => 'El campo Política de inclusión es obligatorio.',
            'liderazgo.required' => 'El campo Liderazgo y trabajo en equipo es obligatorio.',
            'articulacion.required' => 'El campo Articulación de planes es obligatorio.',
            'seguimiento.required' => 'El campo Seguimiento y autoevaluación es obligatorio.',
            'gobierno_escolar.required' => 'El campo Gobierno Escolar es obligatorio.',
            'cultura.required' => 'El campo Cultura Institucional es obligatorio.',
            'politica_bienestar.required' => 'El campo Política de bienestar es obligatorio.',
            'apoyo_investigacion.required' => 'El campo Investigación es obligatorio.',
            'inventario_buenas_practicas.required' => 'El campo Inventario es obligatorio.',
            'sentido_pertenencia.required' => 'El campo Pertenencia es obligatorio.',
            'induccion_institucional.required' => 'El campo Inducción es obligatorio.',
            'actividades_extracurriculares.required' => 'El campo Actividades es obligatorio.',
            'manejo_conflictos.required' => 'El campo Conflictos es obligatorio.',
            'relacion_familias.required' => 'El campo Familias es obligatorio.',
            'seguimiento_egresados.required' => 'El campo Egresados es obligatorio.',
            'alianzas_instituciones.required' => 'El campo Alianzas es obligatorio.',
            'alianzas_sector_productivo.required' => 'El campo Sector productivo es obligatorio.',
        ];
    }
    
}
