<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ComponenteController extends Controller {

    public function index() {
        $componente = Componente::get();
        return view('componente.index', ['componente' => $componente]);
    }
/**
     * Obtiene todas las unidades de meta con su código y descripción.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse {
        try {
            $componentes = Componente::all();

            return response()->json($componentes, 200);

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
            'descripcion' => 'required|string',
        ]);

        Componente::create([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('componentes.index')->with('flash_success_message', 'Componente creado correctamente.');
    }

    public function edit(Componente $componente) {
        return view('componente.edit', compact('componente'));
    }

    public function update(Request $request, int $componenteId) {
        $request->validate([
            'descripcion' => 'required|string',
        ]);

        $componente = Componente::findOrFail($componenteId);
        // Actualizar nombre del rol
        $componente->update([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('componentes.index')->with('flash_success_message', 'Componente actualizado correctamente.');
    }

    public function destroy(int $componenteId) {
        $componente = Componente::findOrFail($componenteId);
        $componente->delete();
        return redirect()->route('componentes.index')->with('flash_success_message', 'Componente eliminado correctamente.');
    }
}
