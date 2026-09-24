<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMunicipioRequest;
use App\Http\Requests\UpdateMunicipioRequest;
use App\Models\Municipio;
use Illuminate\Support\Facades\Gate;

class MunicipioController extends Controller {
    public function index() {
        $municipalities = Municipio::paginate(10);
        return view('municipality.index', compact('municipalities'));
    }

    public function create() {
        Gate::authorize('s-parametro-editar');
        return view('municipality.create');
    }

    public function store(StoreMunicipioRequest $request) {
        Municipio::create($request->validated());
        return redirect()->route('municipios.index')->with('flash_success_message', 'Municipio creado correctamente.');
    }

    public function edit(int $municipio) {
        Gate::authorize('s-parametro-editar');
        $municipio = Municipio::findOrFail($municipio);
        return view('municipality.edit', compact('municipio'));
    }

    public function update(UpdateMunicipioRequest $request, int $municipio) {
        $municipioToUpdate = Municipio::findOrFail($municipio);
        $municipioToUpdate->update($request->validated());
        return redirect()->route('municipios.index')->with('flash_success_message', 'Municipio actualizado correctamente.');
    }

    public function destroy(int $municipio) {
        Gate::authorize('s-parametro-editar');
        $municipioToDel = Municipio::findOrFail($municipio);
        $municipioToDel->delete();
        return redirect()->route('municipios.index')->with('flash_success_message', 'Municipio eliminado correctamente.');
    }
}

