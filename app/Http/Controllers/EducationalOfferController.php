<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EducationalOfferController extends Controller
{


    public function index()
    {
        return view('institutional_profile.educational_offer.index');
    }

    public function create()
    {
        // Array de sedes ficticias
        $sedes = [
            (object) [
                'id' => 1,
                'nombre' => 'Sede Norte',
                'direccion' => 'Calle 10 # 5-20',
                'zona' => 'Norte',
            ],
            (object) [
                'id' => 2,
                'nombre' => 'Sede Sur',
                'direccion' => 'Carrera 15 # 20-30',
                'zona' => 'Sur',
            ],
            (object) [
                'id' => 3,
                'nombre' => 'Sede Centro',
                'direccion' => 'Avenida 30 # 45-60',
                'zona' => 'Centro',
            ],
        ];

        // Pasar el array de sedes a la vista
        return view('institutional_profile.educational_offer.form', compact('sedes'));
    }

    public function store(Request $request)
    {
        return redirect()->route('educational_offer.index')->with('success', 'Oferta educativa creada correctamente.');
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('institutional_profile.educational_offer.form');
    }

    public function update(Request $request, User $usuario)
    {
        return redirect()->route('institutional_profile.educational_offer.index')->with('success', 'Oferta educativa actualizada correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('institutional_profile.institution.index')->with('success', 'Oferta educativa eliminada correctamente.');
    }
}
