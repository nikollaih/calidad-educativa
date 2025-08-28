<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Models\RedesAprendizaje;
use App\Models\Adjunto;
use App\Models\RedIntegrante;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

class RedesIntegrantesController extends Controller {

    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function index(Request $request) {
        $user = auth()->user();

        // Se verifica si hay un usuario autenticado para realizar el filtro.
        if ($user) {
            $redIntegrantes = RedIntegrante::with(['redAprendizaje'])
                ->whereHas('redAprendizaje', function ($query) use ($user) {
                    $query->where('representante_id', $user->id);
                })
                ->get();
        } else {
            $redIntegrantes = collect();
        }

        return view('redIntegrantes.index', ['integrantes' => $redIntegrantes]);
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
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'rol' => 'required|string|max:100',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe superar los 255 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no debe superar los 20 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser una dirección de correo electrónico válida.',
            'correo.max' => 'El correo no debe superar los 255 caracteres.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.string' => 'El rol debe ser una cadena de texto.',
            'rol.max' => 'El rol no debe superar los 100 caracteres.',
        ]);

        dd($request->all());
        $redAprendizaje = RedesAprendizaje::where('representante_id', $user->id)->first();

        // Crear la nueva actividad en la base de datos.
        $integrante = RedIntegrante::create([
            'red_aprendizaje_id' => $redAprendizaje->id,
            'nombre' => $request->input('nombre'),
            'telefono' => $request->input('telefono'),
            'correo' => $request->input('correo'),
            'rol' => $request->input('rol'),
        ]);

        return redirect()->route('red-integrantes.index')->with('flash_success_message', 'Integrante creado con éxito.');
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
        $actividad = RedIntegrante::findOrFail($actividadId);
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
        $redActividad = RedIntegrante::findOrFail($redActividadId);
        
        $redActividad->delete();
        return redirect()->route('red-integrantes.index')->with('flash_success_message', 'Red de Aprendizaje eliminada correctamente.');
    }
}
