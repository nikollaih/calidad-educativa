<?php

namespace App\Http\Controllers;

use App\Helpers\SelectorOrder;
use App\Models\TemaEnsenanzaObligatoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TemaEnsenanzaObligatoriaController extends Controller
{
    public function index()
    {
        $temas = TemaEnsenanzaObligatoria::orderBy('nombre')->paginate(10);

        return view('temasEnsenanzaObligatoria.index', [
            'temas' => $temas,
            'csrfToken' => csrf_token(),
            'storeUrl' => route('temas-ensenanza-obligatoria.store'),
            'canEditParametros' => auth()->user()->can('s-parametro-editar'),
        ]);
    }

    public function all(Request $request): JsonResponse
    {
        $temas = TemaEnsenanzaObligatoria::orderBy('nombre')->get();
        $temas = SelectorOrder::sortIfRequested($temas, $request, fn (TemaEnsenanzaObligatoria $tema) => $tema->nombre);

        return response()->json($temas);
    }

    public function show(TemaEnsenanzaObligatoria $tema)
    {
        return view('temasEnsenanzaObligatoria.show', compact('tema'));
    }

    public function store(Request $request)
    {
        Gate::authorize('s-parametro-editar');

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:temas_ensenanza_obligatoria,nombre'],
        ]);

        TemaEnsenanzaObligatoria::create($validated);

        return redirect()->route('temas-ensenanza-obligatoria.index')
            ->with('flash_success_message', 'Tema de enseñanza obligatoria creado correctamente.');
    }

    public function update(Request $request, TemaEnsenanzaObligatoria $tema)
    {
        Gate::authorize('s-parametro-editar');

        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('temas_ensenanza_obligatoria', 'nombre')->ignore($tema->id),
            ],
        ]);

        $tema->update($validated);

        return redirect()->route('temas-ensenanza-obligatoria.index')
            ->with('flash_success_message', 'Tema de enseñanza obligatoria actualizado correctamente.');
    }

    public function destroy(TemaEnsenanzaObligatoria $tema)
    {
        Gate::authorize('s-parametro-editar');

        if ($tema->proyectosTransversales()->exists()) {
            return redirect()->route('temas-ensenanza-obligatoria.index')
                ->with('flash_error_message', 'No se puede eliminar el tema porque está asociado a uno o más proyectos pedagógicos transversales.');
        }

        $tema->delete();

        return redirect()->route('temas-ensenanza-obligatoria.index')
            ->with('flash_success_message', 'Tema de enseñanza obligatoria eliminado correctamente.');
    }
}
