<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionAdministrativaRequest;
use App\Http\Services\AdjuntoService;
use App\Models\GadAdministracionPlantaFisica;
use App\Models\GadApoyoFinancieroContable;
use App\Models\GadApoyoGestionAcademica;
use App\Models\GadTalentoHumano;
use App\Models\GestionAdministrativa;
use Illuminate\Http\Request;

class GestionAdministrativaController extends Controller {
    
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(GestionAdministrativaRequest $request, int $institutionId) {
        $gestionAdministrativa = $request->all(); 
    
        // Mapeo de anexos con modelo y campo correspondiente
        $anexos = [
            'anexo_acto_administrativo_proceso_matricula' => [
                'seccion' => 'apoyo_gestion_academico',
                'campo' => 'anexo_acto_administrativo_proceso_matricula',
            ],
            'anexo_politica_mantenimiento' => [
                'seccion' => 'administracion_planta_fisica',
                'campo' => 'anexo_mantenimiento_infraestructura',
            ],
            'anexo_dotacion_recursos' => [
                'seccion' => 'administracion_planta_fisica',
                'campo' => 'anexo_dotacion_recursos',
            ],
            'anexo_programa_formacion' => [
                'seccion' => 'talento_humano',
                'campo' => 'anexo_programa_formacion',
            ],
            'anexo_informe_anual' => [
                'seccion' => 'talento_humano',
                'campo' => 'anexo_informe_anual',
            ],
            'anexo_presupuesto_fse' => [
                'seccion' => 'apoyo_financiero_contable',
                'campo' => 'anexo_presupuesto_fse',
            ],
            'anexo_manual_contratacion' => [
                'seccion' => 'apoyo_financiero_contable',
                'campo' => 'anexo_manual_contratacion',
            ],
        ];
    
        // Procesar los archivos y guardar en sus modelos correspondientes
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

                $gestionAdministrativa[$info['seccion']][$info['campo']] = $storedFile->data->id;
            }
        }
    
        
        // Crear la instancia principal y obtener el ID
        $gestionAdministrativaSaved = GestionAdministrativa::create([
            'institution_id' => $institutionId
        ]);

        $gestionAdministrativaId = $gestionAdministrativaSaved->id;
        
        // Preparar los datos con el ID relacionado
        $secciones = [
            'apoyo_gestion_academico' => GadApoyoGestionAcademica::class,
            'administracion_planta_fisica' => GadAdministracionPlantaFisica::class,
            'talento_humano' => GadTalentoHumano::class,
            'apoyo_financiero_contable' => GadApoyoFinancieroContable::class,
        ];

        foreach ($secciones as $key => $model) {
            $gestionAdministrativa[$key]['gestion_administrativa_id'] = $gestionAdministrativaId;
            $model::create($gestionAdministrativa[$key]);
        }
    
        return redirect()->back()->with('flash_success_message', 'Gestión administrativa creada correctamente.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
