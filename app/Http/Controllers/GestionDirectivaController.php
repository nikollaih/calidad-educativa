<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionDirectivaRequest;
use App\Http\Services\AdjuntoService;
use App\Models\GdClimaEscolar;
use App\Models\GdCulturaInstitucional;
use App\Models\GdDireccionamientoEstrategico;
use App\Models\GdGobiernoEscolar;
use App\Models\GdRelacionesEntorno;
use App\Models\GestionDirectiva;
use Illuminate\Http\Request;

class GestionDirectivaController extends Controller {

    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(GestionDirectivaRequest $request, int $institutionId) {
        $gestionDirectiva = $request->all(); 
        
        
        // Mapeo de archivos a sus claves correspondientes y nombres de columnas en DB
        $anexos = [
            'anexo_politica_inclusion' => [
                'seccion' => 'direccionamiento_estrategico',
                'campo' => 'anexo_politica_inclusion'
            ],
            'anexo_gobierno_escolar' => [
                'seccion' => 'gobierno_escolar',
                'campo' => 'anexo_gobierno_escolar'
            ],
            'anexo_politica_bienestar' => [
                'seccion' => 'cultura_institucional',
                'campo' => 'anexo_politica_bienestar'
            ],
            'anexo_cultura_institucional' => [
                'seccion' => 'cultura_institucional',
                'campo' => 'anexo_cultura_institucional'
            ],
            'anexo_programa_institucional_induccion' => [
                'seccion' => 'clima_escolar',
                'campo' => 'anexo_programa_institucional_induccion'
            ],
            'manual_convivencia' => [
                'seccion' => 'clima_escolar',
                'campo' => 'manual_convivencia'
            ],
            'anexo_alianzas_instituciones' => [
                'seccion' => 'relaciones_entorno',
                'campo' => 'anexo_alianzas_instituciones'
            ],
            'anexo_alianzas_sector_productivo' => [
                'seccion' => 'relaciones_entorno',
                'campo' => 'anexo_alianzas_sector_productivo'
            ],
        ];
        
        // Procesar los archivos y guardar sus IDs en el array correspondiente
        foreach ($anexos as $field => $info) {
            if ($request->hasFile($field)) {
                $storedFile = $this->adjuntoService->storeAdjunto(
                    $request->file($field),
                    "institucion/{$institutionId}/{$info['seccion']}/{$field}",
                    'public'
                );

                if (!$storedFile->success) {
                    return redirect()->back()->with('flash_error_message', $storedFile->msg);
                }

                $gestionDirectiva[$info['seccion']][$info['campo']] = $storedFile->data->id;
            }
        }
        
        // Crear la instancia principal y obtener el ID
        $gestionDirectivaSaved = GestionDirectiva::create([
            'institution_id' => $institutionId
        ]);

        $gestionDirectivaId = $gestionDirectivaSaved->id;
        // Preparar los datos con el ID relacionado
        $secciones = [
            'direccionamiento_estrategico' => GdDireccionamientoEstrategico::class,
            'gobierno_escolar' => GdGobiernoEscolar::class,
            'cultura_institucional' => GdCulturaInstitucional::class,
            'clima_escolar' => GdClimaEscolar::class,
            'relaciones_entorno' => GdRelacionesEntorno::class,
        ];

        foreach ($secciones as $key => $model) {
            $gestionDirectiva[$key]['gestion_directiva_id'] = $gestionDirectivaId;
            $model::create($gestionDirectiva[$key]);
        }

        return redirect()->back()->with('flash_success_message', 'Gestion directiva creada correctamente.');
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {
        // Validación y actualización
    }

    public function destroy($id) {
        // Eliminación
    }
}
