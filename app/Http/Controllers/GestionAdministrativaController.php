<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionAdministrativaRequest;
use App\Http\Services\AdjuntoService;
use App\Models\GestionAdministrativa;
use Illuminate\Http\Request;

class GestionAdministrativaController extends Controller {
    
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(GestionAdministrativaRequest $request, int $institutionId) {
        $gestionAdministrativa = $request->all(); 
        $gestionAdministrativa['institution_id'] = $institutionId;

        // Valida y almacena anexo_acto_administrativo_proceso_matricula
        if ($request->hasFile('anexo_acto_administrativo_proceso_matricula')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_acto_administrativo_proceso_matricula'),
                "institucion/{$institutionId}/anexo_acto_administrativo_proceso_matricula",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAdministrativa['anexo_acto_administrativo_proceso_matricula'] = $storeAnexoMatricula->data->id;
        }

        // Valida y almacena anexo_politica_mantenimiento
        if ($request->hasFile('anexo_politica_mantenimiento')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_politica_mantenimiento'),
                "institucion/{$institutionId}/anexo_politica_mantenimiento",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAdministrativa['anexo_politica_mantenimiento'] = $storeAnexoMatricula->data->id;
        }

        // Valida y almacena anexo_dotacion_recursos
        if ($request->hasFile('anexo_dotacion_recursos')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_dotacion_recursos'),
                "institucion/{$institutionId}/anexo_dotacion_recursos",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAdministrativa['anexo_dotacion_recursos'] = $storeAnexoMatricula->data->id;
        }

        // Valida y almacena anexo_programa_formacion
        if ($request->hasFile('anexo_programa_formacion')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_programa_formacion'),
                "institucion/{$institutionId}/anexo_programa_formacion",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAdministrativa['anexo_programa_formacion'] = $storeAnexoMatricula->data->id;
        }

        // Valida y almacena anexo_presupuesto_fse
        if ($request->hasFile('anexo_presupuesto_fse')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_presupuesto_fse'),
                "institucion/{$institutionId}/anexo_presupuesto_fse",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAdministrativa['anexo_presupuesto_fse'] = $storeAnexoMatricula->data->id;
        }

        // Valida y almacena anexo_informe_anual
        if ($request->hasFile('anexo_informe_anual')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_informe_anual'),
                "institucion/{$institutionId}/anexo_informe_anual",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAdministrativa['anexo_informe_anual'] = $storeAnexoMatricula->data->id;
        }

        // Valida y almacena anexo_manual_contratacion
        if ($request->hasFile('anexo_manual_contratacion')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_manual_contratacion'),
                "institucion/{$institutionId}/anexo_manual_contratacion",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAdministrativa['anexo_manual_contratacion'] = $storeAnexoMatricula->data->id;
        }

        $modelAdministrativa = GestionAdministrativa::where('institution_id', $institutionId)->first();
        if ($modelAdministrativa) {
            $modelAdministrativa->update($gestionAdministrativa);
        } else {
            $modelAdministrativa = GestionAdministrativa::create($gestionAdministrativa);
        }

        return redirect()->back()->with('flash_success_message', 'Gestion administrativa creada correctamente.');
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
