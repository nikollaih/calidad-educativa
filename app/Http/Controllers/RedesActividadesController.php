<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Models\RedesAprendizaje;
use App\Models\Adjunto;
use App\Models\RedesActividad;
use App\Models\RedIntegrante;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

class RedesActividadesController extends Controller {

    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function index(Request $request) {
        $user = auth()->user();

        // Se verifica si hay un usuario autenticado para realizar el filtro.
        if ($user) {
            $redActividades = RedesActividad::with(['redAprendizaje', 'adjuntos.adjunto'])
                ->whereHas('redAprendizaje', function ($query) use ($user) {
                    $query->where('representante_id', $user->id);
                })
                ->get();
                
            $redIntegrantes = RedIntegrante::with(['redAprendizaje'])
                ->whereHas('redAprendizaje', function ($query) use ($user) {
                    $query->where('representante_id', $user->id);
                })
                ->get();
        } else {
            $redActividades = collect();
            $redIntegrantes = collect();
        }

        // dd($redActividades);
        return view('redActividades.index', [
            'redActividades' => $redActividades,
            'integrantes' => $redIntegrantes
        ]);
    }

    /**
     * Obtiene todas las unidades de meta con su código y descripción.
     *
     * @return JsonResponse
     */
    // public function all(): JsonResponse {
    //     try {
    //         // Se carga la relación con el representante para el JSON.
    //         $redAprendizaje = RedesAprendizaje::with(['representante', 'actoAdministrativo'])->get();
    //         return response()->json($redAprendizaje, 200);

    //     } catch (\Exception $e) {
    //         // Manejo de errores
    //         return response()->json([
    //             'message' => 'Error al obtener las unidades de meta: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function create() {
        $permissions = Permission::all();
        // Se corrige el nombre de la vista y la variable.
        return view('redesAprendizajes.create', compact('permissions'));
    }

    public function store(Request $request) {
        $user = auth()->user();
        $request->validate([
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
            'adjuntos' => 'nullable|array',
            'adjuntos.*' => 'file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,svg,webp|max:10240',
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser un formato de fecha válido.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'adjuntos.array' => 'Los adjuntos deben ser un arreglo de archivos.',
            'adjuntos.*.file' => 'Cada adjunto debe ser un archivo válido.',
            'adjuntos.*.mimes' => 'El formato del archivo :attribute no es válido.',
            'adjuntos.*.max' => 'El tamaño del archivo :attribute no debe superar los 10MB.',
        ]);

        $redActividades = RedesAprendizaje::where('representante_id', $user->id)->first();

        // Crear la nueva actividad en la base de datos.
        $actividad = RedesActividad::create([
            'red_aprendizaje_id' => $redActividades->id,
            'fecha' => $request->input('fecha'),
            'descripcion' => $request->input('descripcion') ?? null,
        ]);

        // Manejar el almacenamiento de los archivos adjuntos.
        if ($request->hasFile('adjuntos')) {
            // Se asocia cada adjunto con la actividad creada.
            foreach ($request->file('adjuntos') as $adjunto) {
                // Se asume que el servicio devuelve una instancia del modelo del adjunto almacenado.
                $storedAdjunto = $this->adjuntoService->storeAdjunto(
                    adjunto: $adjunto,
                    ruta: 'evidencias_actividades',
                    disk: 'public'
                );
                // Si el almacenamiento fue exitoso, se asocia el adjunto con la actividad a través de la relación.
                if ($storedAdjunto) {
                    $actividad->adjuntos()->create([
                        'red_actividad_id' => $actividad->id,
                        'adjunto_id' => $storedAdjunto->data->id,
                    ]);
                }
            }
        }

        return redirect()->route('red-actividades.index')->with('flash_success_message', 'Actividad creada con éxito.');
    }

    public function edit(RedesAprendizaje $redAprendizaje) {
        // Se corrige la variable a 'redAprendizaje' para que coincida con el modelo.
        return view('redesAprendizajes.edit', compact('redAprendizaje'));
    }

    public function update(Request $request, int $actividadId) {
        $request->validate([
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
            'adjuntos' => 'nullable|array',
            'adjuntos.*' => 'file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,svg,webp|max:10240',
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser un formato de fecha válido.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'adjuntos.array' => 'Los adjuntos deben ser un arreglo de archivos.',
            'adjuntos.*.file' => 'Cada adjunto debe ser un archivo válido.',
            'adjuntos.*.mimes' => 'El formato del archivo no es válido.',
            'adjuntos.*.max' => 'El tamaño del archivo no debe superar los 10MB.',
        ]);

        // Se actualizan los campos básicos de la actividad.
        $actividad = RedesActividad::findOrFail($actividadId);
        $actividad->update([
            'fecha' => $request->input('fecha'),
            'descripcion' => $request->input('descripcion') ?? null,
        ]);

        // Manejo de adjuntos
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $adjunto) {
                // Se almacena el nuevo adjunto.
                $storedAdjunto = $this->adjuntoService->storeAdjunto(
                    adjunto: $adjunto,
                    ruta: 'evidencias_actividades',
                    disk: 'public'
                );

                // Si el almacenamiento fue exitoso, se asocia el adjunto con la actividad.
                if ($storedAdjunto) {
                    $actividad->adjuntos()->create([
                        'adjunto_id' => $storedAdjunto->data->id,
                    ]);
                }
            }
        }

        // Se retorna una respuesta de éxito.
        return response()->json([
            'message' => 'Actividad actualizada con éxito.'
        ], 200);
    }


    public function destroy(int $redActividadId) {
        $redActividad = RedesActividad::findOrFail($redActividadId);
        
        $redActividad->delete();
        return redirect()->route('red-actividades.index')->with('flash_success_message', 'Red de Aprendizaje eliminada correctamente.');
    }
}
