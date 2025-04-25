<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Models\GaDisenosPedagogicos;
use App\Models\GaGestionAulas;
use App\Models\GaSeguimientosAcademicos;
use App\Models\GdDireccionamientoEstrategico;
use App\Models\GestionAcademica;
use Illuminate\Http\Request;

class GestionAcademicaController extends Controller
{
    
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(Request $request, int $institutionId) {
        $gestionAcademica = $request->all(); 
    
        // Mapeo de anexos por categoría con modelo y campo correspondiente
        $anexos = [
            // Diseño Pedagógico
            'anexo_plan_estudios' => [
                'modelo' => GaDisenosPedagogicos::class,
                'campo' => 'anexo_plan_estudios',
                'seccion' => 'diseno_pedagogico'
            ],
            'anexo_enfoque_pedagogico' => [
                'modelo' => GaDisenosPedagogicos::class,
                'campo' => 'anexo_enfoque_pedagogico',
                'seccion' => 'diseno_pedagogico'
            ],
            'anexo_analisis_jornada' => [
                'modelo' => GaDisenosPedagogicos::class,
                'campo' => 'anexo_analisis_jornada',
                'seccion' => 'diseno_pedagogico'
            ],
            'anexo_sistema_evaluacion' => [
                'modelo' => GaDisenosPedagogicos::class,
                'campo' => 'anexo_sistema_evaluacion',
                'seccion' => 'diseno_pedagogico'
            ],
            
            // Gestión de Aula
            'anexos_planes_aula' => [
                'modelo' => GaGestionAulas::class,
                'campo' => 'anexos_planes_aula',
                'seccion' => 'gestion_aula'
            ],
            'anexos_temas_ensenanza' => [
                'modelo' => GaGestionAulas::class,
                'campo' => 'anexos_temas_ensenanza',
                'seccion' => 'gestion_aula'
            ],
            
            // Seguimiento Académico
            'anexo_informe_estadistico' => [
                'modelo' => GaSeguimientosAcademicos::class,
                'campo' => 'anexo_informe_estadistico',
                'seccion' => 'seguimiento_academico'
            ],
            'anexo_analisis_pruebas_externas' => [
                'modelo' => GaSeguimientosAcademicos::class,
                'campo' => 'anexo_analisis_pruebas_externas',
                'seccion' => 'seguimiento_academico'
            ],
            'anexos_planes_mejoramiento' => [
                'modelo' => GaSeguimientosAcademicos::class,
                'campo' => 'anexos_planes_mejoramiento',
                'seccion' => 'seguimiento_academico'
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

                $gestionAcademica[$info['seccion']][$info['campo']] = $storedFile->data->id;
            }
        }
        
        // Crear la instancia principal y obtener el ID
        $gestionAcademicaSaved = GestionAcademica::create([
            'institution_id' => $institutionId
        ]);

        $gestionAcademicaId = $gestionAcademicaSaved->id;
        
        // Preparar los datos con el ID relacionado
        $secciones = [
            'diseno_pedagogico' => GaDisenosPedagogicos::class,
            'gestion_aula' => GaGestionAulas::class,
            'seguimiento_academico' => GaSeguimientosAcademicos::class,
        ];

        foreach ($secciones as $key => $model) {
            $gestionAcademica[$key]['gestion_academica_id'] = $gestionAcademicaId;
            $model::create($gestionAcademica[$key]);
        }
    
        return redirect()->back()->with('flash_success_message', 'Gestión académica creada correctamente.');
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
