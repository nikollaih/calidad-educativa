<?php

namespace App\Http\Controllers;

use App\Models\EducationalModel;
use Illuminate\Http\Request;

class ModeloEducacionalController extends Controller {
    public function index() {
        $modelosEducacionales = EducationalModel::paginate(10);
        return view('modelosEducacionales.index', ['modelosEducacionales' => $modelosEducacionales]);
    }
    public function create() {
        $permissions = [];
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
        ]);

        EducationalModel::create(['name' => $request->name]);

        return redirect()->route('modelos-educacionales.index')->with('flash_success_message', 'Modelo educacional creado correctamente.');
    }

    public function edit() {
    }

    public function update(Request $request, EducationalModel $modelos_educacionale) {
        $request->validate([
            'name' => 'required|string',
        ]);

        // Actualizar nombre del rol
        $modelos_educacionale->update(['name' => $request->name]);


        return redirect()->route('modelos-educacionales.index')->with('flash_success_message', 'Modelo educacional actualizado correctamente.');
    }


    public function destroy(EducationalModel $modelos_educacionale) {
        $modelos_educacionale->delete();
        return redirect()->route('modelos-educacionales.index')->with('flash_success_message', 'Modelo educacional eliminado correctamente.');
    }
}
