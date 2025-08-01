<?php

namespace App\Http\Controllers;

use App\Models\UnidadMeta;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UnidadMetaController extends Controller {

    public function index() {
        $unidadMeta = UnidadMeta::get();
        return view('unidadMeta.index', ['unidadMeta' => $unidadMeta]);
    }

    public function create() {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request) {
        $request->validate([
            'codigo' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $unidadMeta = UnidadMeta::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('unidades-meta.index')->with('flash_success_message', 'Unidad de meta creado correctamente.');
    }

    public function edit(UnidadMeta $unidadMeta) {
        return view('unidades-meta.edit', compact('unidadMeta'));
    }

    public function update(Request $request, int $unidadMetaId) {
        $request->validate([
            'codigo' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $unidadMeta = UnidadMeta::findOrFail($unidadMetaId);
        // Actualizar nombre del rol
        $unidadMeta->update([
            'codigo' => $request->codigo,
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
