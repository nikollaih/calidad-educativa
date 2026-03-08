<?php

namespace App\Http\Controllers\PMI;

use App\Http\Controllers\Controller;
use App\Models\PMI\PmiIndicador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class IndicadoresController extends Controller {
    public function index() {
        $indicadores = PmiIndicador::paginate(10);
        return view('pmi.indicador.index',['indicadores' => $indicadores]);
    }

    public function create() {
        //$permissions = Permission::all();
        // return view('roles.create', compact('permissions'));
    }

    public function store(Request $request) {
        Gate::authorize('s-parametro-editar');
        $indicador = $request->all();
        if ( PmiIndicador::where('unidad_total', $indicador['unidad_total'])->where('unidad_parcial',$indicador['unidad_parcial'])->first() ) {
            return redirect()->route('indicadores-pmi.index')->with('flash_error_message', 'El indicadoor ya existe.');
        } else {
            PmiIndicador::create($indicador);
            return redirect()->route('indicadores-pmi.index')->with('flash_success_message', 'Indicador creado correctamente.');
        }
    }

    public function edit(Role $role) {
        //permissions = Permission::all();
        //return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, int $id) {
        Gate::authorize('s-parametro-editar');
        $indicadorData = $request->all();
        $indicadorToUpdate = PmiIndicador::find($id);
        if ( $indicadorToUpdate ) {
            $indicadorToUpdate->fill($indicadorData);
            $indicadorToUpdate->save();
            return redirect()->route('indicadores-pmi.index')->with('flash_success_message', 'Indicador actualizado correctamente.');
        } else {
            return redirect()->route('indicadores-pmi.index')->with('flash_error_message', 'El indicador no existe.');
        }
    }


    public function destroy(int $id) {
        Gate::authorize('s-parametro-editar');
        $indicadorToDel = PmiIndicador::find($id);


        if ( $indicadorToDel ) {
            if ($indicadorToDel?->metas?->count() > 0) {
                return redirect()->route('indicadores-pmi.index')->with('flash_error_message', 'El indicador tiene metas vinculadas.');
            }
            $indicadorToDel->delete();
            return redirect()->route('indicadores-pmi.index')->with('flash_success_message', 'Indicador eliminado correctamente.');
        }
        return redirect()->route('indicadores-pmi.index')->with('flash_error_message', 'El indicador no existe.');
    }
}
