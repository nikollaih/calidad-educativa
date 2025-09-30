<?php

namespace App\Http\Controllers;

use App\Models\Enums\PamEstadoEnum;
use App\Models\Pam;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PAMGeneralController extends Controller {
    /**
     * Mostrar la vista principal del PAMGeneral
     *
     */
    public function index() {
        // Ordenar los registros por fecha de creación descendente
        $pams = Pam::orderBy('created_at', 'desc')->paginate(10);

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

        // Obtiene el último consecutivo
        $lastPam = Pam::latest('id')->first();

        $nextConsecutivo = 1;
        if ($lastPam) {
            $lastConsecutivoNum = (int) $lastPam->consecutivo;
            $nextConsecutivo = $lastConsecutivoNum + 1;

            // Manejo de reinicio si se llega a 99 y quieres volver a 01 o un límite
            if ($nextConsecutivo > 99) {
                $nextConsecutivo = 1;
            }
        }

        // Formatear a 2 dígitos con ceros a la izquierda
        $pamData['consecutivo'] = str_pad($nextConsecutivo, 2, '0', STR_PAD_LEFT);
        $pamData['estado'] = PamEstadoEnum::Proceso->value;

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


    public function presentarPam(Request $request, int $pamId) {
        $pam = Pam::findOrFail($pamId);
        $pam->estado = PamEstadoEnum::Presentado->value;
        $pam->save();

        return  redirect()
            ->route('pams.index')
            ->with('flash_success_message', 'Pam presentado correctamente.');
    }
}
