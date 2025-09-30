<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MunicipioController extends Controller {
    public function index() {
        $municipalities = Municipio::paginate(10);
        return view('municipality.index', compact('municipalities'));
    }

    public function create() {
        //$permissions = Permission::all();
        // return view('roles.create', compact('permissions'));
    }

    public function store(Request $request) {
        $municipioData = $request->all();
        if ( Municipio::where('nombre', $municipioData['nombre'])->first() ) {
            return redirect()->route('municipios.index')->with('flash_error_message', 'El municipio ya existe.');
        } else {
            Municipio::create($municipioData);
            return redirect()->route('municipios.index')->with('flash_success_message', 'Municipio creado correctamente.');
        }
    }

    public function edit(Role $role) {
        //permissions = Permission::all();
        //return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, int $municipio) {
        $municipioData = $request->all();
        $municipioToUpdate = Municipio::find($municipio);
        if ( $municipioToUpdate ) {
            $municipioToUpdate->nombre = $municipioData['nombre'];
            $municipioToUpdate->save();
            return redirect()->route('municipios.index')->with('flash_success_message', 'Municipio actualizado correctamente.');
        } else {
            return redirect()->route('municipios.index')->with('flash_error_message', 'El municipio no existe.');
        }
    }


    public function destroy(int $municipio) {
        $municipioToDel = Municipio::find($municipio);
        if ( $municipioToDel ) {
            $municipioToDel->delete();
            return redirect()->route('municipios.index')->with('flash_success_message', 'Municipio eliminado correctamente.');
        }
        return redirect()->route('municipios.index')->with('flash_error_message', 'El municipio no existe.');
    }
}
