<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionDirectivaRequest;
use App\Http\Services\AdjuntoService;
use App\Models\GestionDirectiva;
use Illuminate\Http\Request;

class GestionDirectivaController extends Controller {

    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function store(GestionDirectivaRequest $request, int $institutionId) {
        $gestionDirectiva = $request->all(); 
        $gestionDirectiva['institution_id'] = $institutionId;

        // anexo_gobierno_escolar
        if ($request->hasFile('anexo_gobierno_escolar')) {
            $storeAnexoGobiernoEscolar = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_gobierno_escolar'),
                "institucion/{$institutionId}/anexo_gobierno_escolar",
                'public'
            );
    
            if ($storeAnexoGobiernoEscolar->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoGobiernoEscolar->msg);
            }
            $gestionDirectiva['anexo_gobierno_escolar'] = $storeAnexoGobiernoEscolar->data->id;
        }

        // Valida y almacena anexo_cultura_institucional (si es requerido)
        if ($request->hasFile('anexo_cultura_institucional')) {
            $storeAnexoCultura = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_cultura_institucional'),
                "institucion/{$institutionId}/anexo_cultura_institucional",
                'public'
            );

            if ($storeAnexoCultura->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoCultura->msg);
            }
            $gestionDirectiva['anexo_cultura_institucional'] = $storeAnexoCultura->data->id;
        }

        // Valida y almacena manual_convivencia (si es requerido)
        if ($request->hasFile('manual_convivencia')) {
            $storeManualConvivencia = $this->adjuntoService->storeAdjunto(
                $request->file('manual_convivencia'),
                "institucion/{$institutionId}/manual_convivencia",
                'public'
            );

            if ($storeManualConvivencia->success == false) {
                return redirect()->back()->with('flash_error_message', $storeManualConvivencia->msg);
            }
            $gestionDirectiva['manual_convivencia'] = $storeManualConvivencia->data->id;
        }

        // Valida y almacena anexo_alianzas_instituciones (si es requerido)
        if ($request->hasFile('anexo_alianzas_instituciones')) {
            $storeAnexoAlianzas = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_alianzas_instituciones'),
                "institucion/{$institutionId}/anexo_alianzas_instituciones",
                'public'
            );

            if ($storeAnexoAlianzas->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoAlianzas->msg);
            }
            $gestionDirectiva['anexo_alianzas_instituciones'] = $storeAnexoAlianzas->data->id;
        }

        // Valida y almacena anexo_alianzas_sector_productivo (si es requerido)
        if ($request->hasFile('anexo_alianzas_sector_productivo')) {
            $storeAnexoSector = $this->adjuntoService->storeAdjunto(
                $request->file('anexo_alianzas_sector_productivo'),
                "institucion/{$institutionId}/anexo_alianzas_sector_productivo",
                'public'
            );

            if ($storeAnexoSector->success == false) {
                return redirect()->back()->with('flash_error_message', $storeAnexoSector->msg);
            }
            $gestionDirectiva['anexo_alianzas_sector_productivo'] = $storeAnexoSector->data->id;
        }

        $modelDirectiva = GestionDirectiva::where('institution_id', $institutionId)->first();
        if ($modelDirectiva) {
            $modelDirectiva->update($gestionDirectiva);
        } else {
            $modelDirectiva = GestionDirectiva::create($gestionDirectiva);
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
