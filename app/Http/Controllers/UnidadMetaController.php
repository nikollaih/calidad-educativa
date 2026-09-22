<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class UnidadMetaController extends Controller {
    public function index() {
        $unidadMeta = Indicador::paginate(10);
        return view('unidadMeta.index', ['unidadMeta' => $unidadMeta]);
    }
    /**
         * Obtiene todas las unidades de meta con su código y descripción.
         *
         * @return JsonResponse
         */
    public function all(): JsonResponse {
        try {
            $unidadesMeta = Indicador::all();

            return response()->json($unidadesMeta, 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al obtener las unidades de meta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create() {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request) {
        Gate::authorize('s-parametro-editar');
        $request->validate([
            'unidad_parcial' => 'required|string',
            'unidad_total' => 'required|string',
        ]);

        Indicador::create($request->all());

        return redirect()->route('unidades-meta.index')->with('flash_success_message', 'Unidad de meta creado correctamente.');
    }

    public function edit(Indicador $unidadMeta) {
        return view('unidades-meta.edit', compact('unidadMeta'));
    }

    public function update(Request $request, int $unidadMetaId) {
        Gate::authorize('s-parametro-editar');
        $request->validate([
            'unidad_parcial' => 'required|string',
            'unidad_total' => 'required|string',
        ]);

        $unidadMeta = Indicador::findOrFail($unidadMetaId);
        // Actualizar nombre del rol
        $unidadMeta->update([
            'unidad_parcial' => $request->unidad_parcial,
            'unidad_total' => $request->unidad_total
        ]);

        return redirect()->route('unidades-meta.index')->with('flash_success_message', 'Unidad de meta actualizado correctamente.');
    }

    public function destroy(int $unidadMetaId) {
        Gate::authorize('s-parametro-editar');
        $unidadMeta = Indicador::findOrFail($unidadMetaId);
        $unidadMeta->delete();
        return redirect()->route('unidades-meta.index')->with('flash_success_message', 'Unidad de meta eliminado correctamente.');
    }
}
