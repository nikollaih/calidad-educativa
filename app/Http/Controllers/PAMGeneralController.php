<?php

namespace App\Http\Controllers;

use App\Exports\PamGeneralExport;
use App\Http\Requests\StorePamGeneralRowRequest;
use App\Models\Pam;
use App\Models\PamGeneralAccion;
use App\Models\PamGeneralAvance;
use App\Models\PamGeneralComponente;
use App\Models\PamGeneralMeta;
use App\Models\PamGeneralObjetivoEstrategico;
use App\Models\PamGeneralRow;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PAMGeneralController extends Controller {
    /**
     * Mostrar la vista principal del PAMGeneral
     *
     */
    public function index() {
        $pams = Pam::paginate(10);

        return view('pamGeneral.index', [
            'pams' => $pams,
        ]);
    }

    public function create() {
        return view('pamGeneral.create');
    }

    /**
     * Mostrar la vista del formulario de edición
     *
     * @param int $id
     */
    public function show($id): View {
        return view('pamGeneral.edit', compact('id'));
    }

    // --------------------
    //  Manejo de datos
    // --------------------

    /**
     * Obtener un registro específico para edición
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id) {
        try {
            // Carga la acción con todas sus relaciones anidadas en el nuevo orden
            $pam = Pam::find($id);

            return view('pamGeneral.edit',
                [
                    'pam' => $pam,
                    'pamId' => $id,
                ]);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el registro PAMGeneral: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crea registros del pam
     *
     * @param Request $request Datos del formulario
     */
    public function store(Request $request) {
        $pamData = $request->input('pam');
        // Generar consecutivo unico

        Pam::create($pamData);

        return redirect()
            ->route('pams.index')
            ->with('flash_success_message', 'Pam creado correctamente.');
    }

    /**
     * Elimina un registro especifico
     *
     * @param int $id id de la accion
     */
    public function destroy(int $id): JsonResponse {
        try {
            $pam = Pam::findOrFail($id);
            $pam->delete();

            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un registro específico
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request,int $id) {
        $data = $request->all()['pam'];
        $pam = Pam::findOrFail($id);
        $pam->update($data);

        return redirect()->route('pams.index')->with('success', 'Pam actualizado correctamente.');
    }
}


