<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Models\GestionAcademica;
use Illuminate\Http\Request;

class GestionAcademicaController extends Controller
{
    
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(Request $request, int $institutionId) {
        $gestionAcademica = $request->all(); 
        $gestionAcademica['institution_id'] = $institutionId;

        // Valida y almacena anexo_plan_estudios
        if ($request->hasFile('anexo_plan_estudios')) {
            $storeAnexoMatricula = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_plan_estudios'),
                "institucion/{$institutionId}/anexo_plan_estudios",
                'public'
            );

            if ($storeAnexoMatricula->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMatricula->msg);
            }
            $gestionAcademica['anexo_plan_estudios'] = $storeAnexoMatricula->data->id;
        }

        // Valida y almacena anexo_enfoque_pedagogico
        if ($request->hasFile('anexo_enfoque_pedagogico')) {
            $storeAnexoMantenimiento = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_enfoque_pedagogico'),
                "institucion/{$institutionId}/anexo_enfoque_pedagogico",
                'public'
            );

            if ($storeAnexoMantenimiento->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoMantenimiento->msg);
            }
            $gestionAcademica['anexo_enfoque_pedagogico'] = $storeAnexoMantenimiento->data->id;
        }

        // Valida y almacena anexo_analisis_jornada
        if ($request->hasFile('anexo_analisis_jornada')) {
            $storeAnexoDotacion = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_analisis_jornada'),
                "institucion/{$institutionId}/anexo_analisis_jornada",
                'public'
            );

            if ($storeAnexoDotacion->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoDotacion->msg);
            }
            $gestionAcademica['anexo_analisis_jornada'] = $storeAnexoDotacion->data->id;
        }

        // Valida y almacena anexo_sistema_evaluacion
        if ($request->hasFile('anexo_sistema_evaluacion')) {
            $storeAnexoPrograma = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_sistema_evaluacion'),
                "institucion/{$institutionId}/anexo_sistema_evaluacion",
                'public'
            );

            if ($storeAnexoPrograma->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPrograma->msg);
            }
            $gestionAcademica['anexo_sistema_evaluacion'] = $storeAnexoPrograma->data->id;
        }

        // Valida y almacena anexos_planes_aula
        if ($request->hasFile('anexos_planes_aula')) {
            $storeAnexoPresupuesto = $this->adjuntoService->storeAdjunto(
                $request->file('anexos_planes_aula'),
                "institucion/{$institutionId}/anexos_planes_aula",
                'public'
            );

            if ($storeAnexoPresupuesto->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPresupuesto->msg);
            }
            $gestionAcademica['anexos_planes_aula'] = $storeAnexoPresupuesto->data->id;
        }

        // Valida y almacena anexos_temas_ensenanza
        if ($request->hasFile('anexos_temas_ensenanza')) {
            $storeAnexoPresupuesto = $this->adjuntoService->storeAdjunto(
                $request->file('anexos_temas_ensenanza'),
                "institucion/{$institutionId}/anexos_temas_ensenanza",
                'public'
            );

            if ($storeAnexoPresupuesto->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPresupuesto->msg);
            }
            $gestionAcademica['anexos_temas_ensenanza'] = $storeAnexoPresupuesto->data->id;
        }

        // Valida y almacena anexo_informe_estadistico
        if ($request->hasFile('anexo_informe_estadistico')) {
            $storeAnexoPresupuesto = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_informe_estadistico'),
                "institucion/{$institutionId}/anexo_informe_estadistico",
                'public'
            );

            if ($storeAnexoPresupuesto->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPresupuesto->msg);
            }
            $gestionAcademica['anexo_informe_estadistico'] = $storeAnexoPresupuesto->data->id;
        }

        // Valida y almacena anexo_analisis_pruebas_externas
        if ($request->hasFile('anexo_analisis_pruebas_externas')) {
            $storeAnexoPresupuesto = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_analisis_pruebas_externas'),
                "institucion/{$institutionId}/anexo_analisis_pruebas_externas",
                'public'
            );

            if ($storeAnexoPresupuesto->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPresupuesto->msg);
            }
            $gestionAcademica['anexo_analisis_pruebas_externas'] = $storeAnexoPresupuesto->data->id;
        }

        // Valida y almacena anexos_planes_mejoramiento
        if ($request->hasFile('anexos_planes_mejoramiento')) {
            $storeAnexoPresupuesto = $this->adjuntoService->storeAdjunto(
                $request->file('anexos_planes_mejoramiento'),
                "institucion/{$institutionId}/anexos_planes_mejoramiento",
                'public'
            );

            if ($storeAnexoPresupuesto->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoPresupuesto->msg);
            }
            $gestionAcademica['anexos_planes_mejoramiento'] = $storeAnexoPresupuesto->data->id;
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
