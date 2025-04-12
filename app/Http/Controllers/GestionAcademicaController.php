<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionAcademicaRequest;
use App\Http\Services\AdjuntoService;
use App\Models\GestionAcademica;
use Illuminate\Http\Request;

class GestionAcademicaController extends Controller
{
    
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(GestionAcademicaRequest $request, int $institutionId) {
        $gestionAcademica = $request->all(); 
        $gestionAcademica['institution_id'] = $institutionId;

        // Valida y almacena anexo_proceso_matricula
        if ($request->hasFile('anexo_proceso_matricula')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_proceso_matricula'),
                "institucion/{$institutionId}/anexo_proceso_matricula",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAcademica['anexo_proceso_matricula'] = $storeAnexoMatricula->data->id;
        }

        // Valida y almacena anexo_mantenimiento_infraestructura
        if ($request->hasFile('anexo_mantenimiento_infraestructura')) {
            $storeAnexoMantenimiento = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_mantenimiento_infraestructura'),
                "institucion/{$institutionId}/anexo_mantenimiento_infraestructura",
                'public'
            );

            if ($storeAnexoMantenimiento->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMantenimiento->msg);
            }
            $gestionAcademica['anexo_mantenimiento_infraestructura'] = $storeAnexoMantenimiento->data->id;
        }

        // Valida y almacena anexo_dotacion_recursos
        if ($request->hasFile('anexo_dotacion_recursos')) {
            $storeAnexoDotacion = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_dotacion_recursos'),
                "institucion/{$institutionId}/anexo_dotacion_recursos",
                'public'
            );

            if ($storeAnexoDotacion->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoDotacion->msg);
            }
            $gestionAcademica['anexo_dotacion_recursos'] = $storeAnexoDotacion->data->id;
        }

        // Valida y almacena anexo_programa_formacion
        if ($request->hasFile('anexo_programa_formacion')) {
            $storeAnexoPrograma = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_programa_formacion'),
                "institucion/{$institutionId}/anexo_programa_formacion",
                'public'
            );

            if ($storeAnexoPrograma->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPrograma->msg);
            }
            $gestionAcademica['anexo_programa_formacion'] = $storeAnexoPrograma->data->id;
        }

        // Valida y almacena anexo_presupuesto_fse
        if ($request->hasFile('anexo_presupuesto_fse')) {
            $storeAnexoPresupuesto = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_presupuesto_fse'),
                "institucion/{$institutionId}/anexo_presupuesto_fse",
                'public'
            );

            if ($storeAnexoPresupuesto->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPresupuesto->msg);
            }
            $gestionAcademica['anexo_presupuesto_fse'] = $storeAnexoPresupuesto->data->id;
        }

        $modelAcademica = GestionAcademica::where('institution_id', $institutionId)->first();
        if ($modelAcademica) {
            $modelAcademica->update($gestionAcademica);
        } else {
            $modelAcademica = GestionAcademica::create($gestionAcademica);
        }

        return redirect()->back()->with('flash_success_message', 'Gestion academica creada correctamente.');
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
