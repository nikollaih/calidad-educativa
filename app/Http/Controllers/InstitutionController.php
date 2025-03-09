<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class InstitutionController extends Controller
{


    public function index()
    {
        return view('institutional_profile.institution.index');
    }

    public function create()
    {
       // $roles = Role::all();
        return view('institutional_profile.institution.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('institution.index')->with('success', 'Institución creada correctamente.');
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('institutional_profile.institution.edit');
    }

    public function update(Request $request, User $usuario)
    {
        return redirect()->route('institutional_profile.institution.index')->with('success', 'Institución actualizada correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('institutional_profile.institution.index')->with('success', 'Institución eliminada correctamente.');
    }
}
