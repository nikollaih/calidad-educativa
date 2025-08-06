<?php

namespace App\Http\Controllers;

use App\Models\UnidadMeta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UnidadMetaController extends Controller {

    public function index() {
        $unidadMeta = UnidadMeta::get();
        return view('unidadMeta.index', ['unidadMeta' => $unidadMeta]);
    }
/**
     * Obtiene todas las unidades de meta con su código y descripción.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse {
        try {
            $unidadesMeta = UnidadMeta::all();

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
        $request->validate([
            'descripcion' => 'nullable|string',
        ]);

        // Obtiene el último codigo
        $lastUnidadMeta = UnidadMeta::latest('id')->first();

        $nextConsecutivo = 1;
        if ($lastUnidadMeta) {
            $lastConsecutivoNum = (int) $lastUnidadMeta->codigo;
            $nextConsecutivo = $lastConsecutivoNum + 1;

            // Manejo de reinicio si se llega a 99 y quieres volver a 01 o un límite
            if ($nextConsecutivo > 99) {
                $nextConsecutivo = 1; // O maneja un error si no quieres que se reinicie
            }
        }

        // Formatear a 2 dígitos con ceros a la izquierda
        $codigo = str_pad($nextConsecutivo, 2, '0', STR_PAD_LEFT);

        UnidadMeta::create([
            'codigo' => $codigo,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('unidades-meta.index')->with('flash_success_message', 'Unidad de meta creado correctamente.');
    }

    public function edit(UnidadMeta $unidadMeta) {
        return view('unidades-meta.edit', compact('unidadMeta'));
    }

    public function update(Request $request, int $unidadMetaId) {
        $request->validate([
            'descripcion' => 'nullable|string',
        ]);

        $unidadMeta = UnidadMeta::findOrFail($unidadMetaId);
        // Actualizar nombre del rol
        $unidadMeta->update([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('unidades-meta.index')->with('flash_success_message', 'Unidad de meta actualizado correctamente.');
    }

    public function destroy(int $unidadMetaId) {
        $unidadMeta = UnidadMeta::findOrFail($unidadMetaId);
        $unidadMeta->delete();
        return redirect()->route('unidades-meta.index')->with('flash_success_message', 'Unidad de meta eliminado correctamente.');
    }
}
