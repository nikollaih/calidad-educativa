<?php

namespace App\Http\Controllers;

use App\Models\ModeloPedagogico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ModeloPedagogicoController extends Controller {
    public function index() {
        $modelosPedagogicos = ModeloPedagogico::paginate(10);
        return view('modelosPedagogicos.index', ['modelosPedagogicos' => $modelosPedagogicos]);
    }
    public function create() {
    }

    public function store(Request $request) {
        Gate::authorize('s-parametro-editar');
        $request->validate([
            'nombre' => 'required|string',
        ]);

        $modeloPedagogico = ModeloPedagogico::create(['nombre' => $request->nombre]);

        return redirect()->route('modelos-pedagogicos.index')->with('flash_success_message', 'Modelo pedagógico creado correctamente.');
    }

    public function edit() {
    }

    public function update(Request $request, ModeloPedagogico $modelos_pedagogico) {
        Gate::authorize('s-parametro-editar');
        $request->validate([
            'nombre' => 'required|string',
        ]);

        // Actualizar nombre del modelo pedagogico
        $modelos_pedagogico->update(['nombre' => $request->nombre]);


        return redirect()->route('modelos-pedagogicos.index')->with('flash_success_message', 'Modelo pedagógico actualizado correctamente.');
    }


    public function destroy(ModeloPedagogico $modelos_pedagogico) {
        Gate::authorize('s-parametro-editar');
        $modelos_pedagogico->delete();
        return redirect()->route('modelos-pedagogicos.index')->with('flash_success_message', 'Modelo pedagógico eliminado correctamente.');
    }
}
