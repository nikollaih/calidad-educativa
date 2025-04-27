<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionComunidadRequest;
use App\Http\Services\AdjuntoService;
use App\Models\GcAtencionGruposPoblacionales;
use App\Models\GcPrevencionRiesgos;
use App\Models\GcProgramaServicioSocial;
use App\Models\GestionComunidad;
use Illuminate\Http\Request;

class GestionComunidadController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(GestionComunidadRequest $request, int $institutionId) {
        $gestionComunidad = $request->all(); 

        // Mapeo de archivos a sus claves correspondientes y nombres de columnas en DB
        $anexos = [
            'anexo_proyecto_escuela_padres' => [
                'seccion' => 'atencion_grupos_poblacionales',
                'campo' => 'anexo_proyecto_escuela_padres_id',
            ],
            'anexo_programa_servicio_social' => [
                'seccion' => 'programa_servicio_social',
                'campo' => 'anexo_programa_servicio_social_id',
            ],
            'anexo_prevencion_riesgos_fisicos' => [
                'seccion' => 'prevencion_riesgos',
                'campo' => 'anexo_prevencion_riesgos_fisicos_id',
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

                $gestionComunidad[$info['seccion']][$info['campo']] = $storedFile->data->id;
            }
        }

        // Crear la instancia principal y obtener el ID
        $gestionComunidadSaved = GestionComunidad::create([
            'institution_id' => $institutionId
        ]);

        $gestionComunidadId = $gestionComunidadSaved->id;
        // Preparar los datos con el ID relacionado
        $secciones = [
            'atencion_grupos_poblacionales' => GcAtencionGruposPoblacionales::class,
            'programa_servicio_social' => GcProgramaServicioSocial::class,
            'prevencion_riesgos' => GcPrevencionRiesgos::class,
        ];

        foreach ($secciones as $key => $model) {
            $gestionComunidad[$key]['gestion_comunidad_id'] = $gestionComunidadId;
            $model::create($gestionComunidad[$key]);
        }

        return redirect()->back()->with('flash_success_message', 'Gestion comunidad creada correctamente.');
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
