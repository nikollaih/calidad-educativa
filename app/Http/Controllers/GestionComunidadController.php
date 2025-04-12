<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionComunidadRequest;
use App\Http\Services\AdjuntoService;
use App\Models\GestionComunidad;
use Illuminate\Http\Request;

class GestionComunidadController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(GestionComunidadRequest $request, int $institutionId) {
        $gestionComunidad = $request->all(); 
        $gestionComunidad['institution_id'] = $institutionId;

        // Valida y almacena anexo_programa_servicio_social
        if ($request->hasFile('anexo_programa_servicio_social')) {
            $storeAnexoServicioSocial = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_programa_servicio_social'),
                "institucion/{$institutionId}/anexo_programa_servicio_social",
                'public'
            );

            if ($storeAnexoServicioSocial->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoServicioSocial->msg);
            }
            $gestionComunidad['anexo_programa_servicio_social'] = $storeAnexoServicioSocial->data->id;
        }

        // Valida y almacena anexo_prevencion_riesgos_fisicos
        if ($request->hasFile('anexo_prevencion_riesgos_fisicos')) {
            $storeAnexoPrevencion = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_prevencion_riesgos_fisicos'),
                "institucion/{$institutionId}/anexo_prevencion_riesgos_fisicos",
                'public'
            );

            if ($storeAnexoPrevencion->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPrevencion->msg);
            }
            $gestionComunidad['anexo_prevencion_riesgos_fisicos'] = $storeAnexoPrevencion->data->id;
        }

        $modelComunidad = GestionComunidad::where('institution_id', $institutionId)->first();
        if ($modelComunidad) {
            $modelComunidad->update($gestionComunidad);
        } else {
            $modelComunidad = GestionComunidad::create($gestionComunidad);
        }
        GestionComunidad::create($gestionComunidad);

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
