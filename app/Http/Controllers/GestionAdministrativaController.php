<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionAdministrativaRequest;
use App\Models\GestionAdministrativa;
use Illuminate\Http\Request;

class GestionAdministrativaController extends Controller {
    public function store(GestionAdministrativaRequest $request, int $institutionId) {
        $gestionAdministrativa = $request->all(); 
        $gestionAdministrativa['institution_id'] = $institutionId;

        $modelAdministrativa = GestionAdministrativa::where('institution_id', $institutionId)->first();
        if ($modelAdministrativa) {
            $modelAdministrativa->update($gestionAdministrativa);
        } else {
            $modelAdministrativa = GestionAdministrativa::create($gestionAdministrativa);
        }

        return redirect()->back()->with('flash_success_message', 'Gestion administrativa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
