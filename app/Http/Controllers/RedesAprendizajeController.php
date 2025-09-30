<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Models\Adjunto;
use App\Models\RedesAprendizaje;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RedesAprendizajeController extends Controller {
    public function __construct(
        private AdjuntoService $adjuntoService,
    ) {
    }

    public function index() {
        // Se carga la relación con el representante para mostrar su nombre en la tabla.
        $redAprendizaje = RedesAprendizaje::with(['representante', 'actoAdministrativo'])->paginate(10);
        return view('redesAprendizajes.index', ['redesAprendizaje' => $redAprendizaje]);
    }

    /**
     * Obtiene todas las unidades de meta con su código y descripción.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse {
        try {
            // Se carga la relación con el representante para el JSON.
            $redAprendizaje = RedesAprendizaje::with(['representante', 'actoAdministrativo'])->get();
            return response()->json($redAprendizaje, 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al obtener las unidades de meta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request) {
        // Se agregan las reglas de validación para todos los campos de la solicitud, incluyendo el archivo.
        // Se ha modificado la regla 'mimes' para aceptar formatos de imagen.
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'representante_id' => [
                'required',
                'exists:users,id',
                // Se ha añadido la regla 'unique' para asegurar que el representante no esté en otra red,
                // con un mensaje de error personalizado en español.
                'unique:redes_aprendizaje,representante_id',
            ],
            'numero_contacto' => 'nullable|string',
            'correo' => 'required|string',
            'acto_administrativo' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,svg,webp|max:10240',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'representante_id.required' => 'El representante es obligatorio.',
            'correo.required' => 'El correo es obligatorio.',
            'representante_id.exists' => 'El representante seleccionado no es válido.',
            'representante_id.unique' => 'El representante seleccionado ya está relacionado con otra red de aprendizaje.',
            'numero_contacto.string' => 'El número de contacto debe ser una cadena de texto.',
            'acto_administrativo.required' => 'El archivo del acto administrativo es obligatorio.',
            'acto_administrativo.file' => 'El acto administrativo debe ser un archivo.',
            'acto_administrativo.mimes' => 'El archivo del acto administrativo debe ser de tipo: pdf, doc, docx, jpeg, jpg, png, gif, svg, webp.',
            'acto_administrativo.max' => 'El tamaño del archivo no debe superar los 10MB.',
        ]);

        // Se agrega la lógica para guardar el archivo.
        if ($request->hasFile('acto_administrativo')) {
            $actoAdministrativo = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('acto_administrativo'),
                ruta: 'actos_administrativos',
                disk: 'public'
            );
        }

        RedesAprendizaje::create([
            'nombre' => $request?->nombre,
            'correo' => $request?->correo,
            'descripcion' => $request?->descripcion,
            'representante_id' => $request?->representante_id,
            'numero_contacto' => $request?->numero_contacto,
            'acto_administrativo_id' => $actoAdministrativo?->data?->id,
        ]);

        return redirect()->route('redes-aprendizajes.index')->with('flash_success_message', 'Red de Aprendizaje creada correctamente.');
    }

    public function edit(RedesAprendizaje $redAprendizaje) {
        // Se corrige la variable a 'redAprendizaje' para que coincida con el modelo.
        return view('redesAprendizajes.edit', compact('redAprendizaje'));
    }

    public function update(Request $request, int $redAprendizaje) {
        // MODIFICACION: Se actualizan las reglas de validación. El archivo ahora es opcional.
        $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|string',
            'descripcion' => 'nullable|string',
            'representante_id' => 'required|exists:users,id',
            'numero_contacto' => 'nullable|string',
            'acto_administrativo' => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,svg,webp|max:10240',
        ]);

        $redAprendizaje = RedesAprendizaje::findOrFail($redAprendizaje);

        // MODIFICACION: Se inicializa el ID del adjunto actual.
        $acto_administrativo_id = $redAprendizaje->acto_administrativo_id;
        $old_adjunto = $redAprendizaje->actoAdministrativo;

        // MODIFICACION: Se agrega la lógica para actualizar el archivo si se carga uno nuevo.
        if ($request->hasFile('acto_administrativo')) {
            // Almacena el nuevo archivo usando el servicio.
            $newAdjunto = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('acto_administrativo'),
                ruta: 'actos_administrativos',
                disk: 'public'
            );

            // Actualiza el ID del adjunto para el registro de la red de aprendizaje.
            $acto_administrativo_id = $newAdjunto->data->id;

            // MODIFICACION: Se actualiza el registro de la red de aprendizaje primero para liberar la restricción.
            $redAprendizaje->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'correo' => $request->correo,
                'representante_id' => $request->representante_id,
                'numero_contacto' => $request->numero_contacto,
                'acto_administrativo_id' => $acto_administrativo_id,
            ]);

            // Ahora se puede eliminar el archivo anterior y su registro en la base de datos.
            if ($old_adjunto) {
                Storage::disk('public')->delete($old_adjunto->ruta);
                $old_adjunto->delete();
            }

            return redirect()->route('redes-aprendizajes.index')->with('flash_success_message', 'Red de Aprendizaje actualizada correctamente.');
        } else {
            // Si no se sube un nuevo archivo, solo se actualizan los demás campos.
            $redAprendizaje->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'correo' => $request->correo,
                'representante_id' => $request->representante_id,
                'numero_contacto' => $request->numero_contacto,
            ]);
            return redirect()->route('redes-aprendizajes.index')->with('flash_success_message', 'Red de Aprendizaje actualizada correctamente.');
        }
    }

    public function destroy(int $redAprendizaje) {
        $redAprendizaje = RedesAprendizaje::findOrFail($redAprendizaje);

        // Se agrega la lógica para eliminar el archivo relacionado antes de eliminar el registro.
        if ($redAprendizaje->acto_administrativo) {
            Storage::disk('public')->delete($redAprendizaje->acto_administrativo);
        }

        $redAprendizaje->delete();
        return redirect()->route('redes-aprendizajes.index')->with('flash_success_message', 'Red de Aprendizaje eliminada correctamente.');
    }

    /**
     * Obtiene las actividades e integrantes de una red de aprendizaje específica.
     *
     * @param int $redAprendizajeId
     * @return JsonResponse
     */
    public function getActividadesIntegrantes(int $redAprendizajeId): JsonResponse {
        try {
            // Buscar la red de aprendizaje con sus relaciones
            $redAprendizaje = RedesAprendizaje::with(['integrantes', 'actividades'])
                ->findOrFail($redAprendizajeId);

            // Estructurar la respuesta
            $response = [
                'red_aprendizaje' => [
                    'id' => $redAprendizaje->id,
                    'nombre' => $redAprendizaje->nombre,
                ],
                'actividades' => $redAprendizaje->actividades->map(function ($actividad) {
                    return [
                        'id' => $actividad->id,
                        'descripcion' => $actividad->descripcion ?? null,
                        'fecha' => $actividad->fecha ?? $actividad->created_at,
                    ];
                }),
                'integrantes' => $redAprendizaje->integrantes->map(function ($integrante) {
                    return [
                        'id' => $integrante->id,
                        'nombre' => $integrante->nombre ?? 'Sin nombre',
                        'email' => $integrante->correo ?? null,
                        'telefono' => $integrante->telefono ?? null,
                        // El rol es un numero, necesito que en el front obtengas el nombre
                        'rol' => $integrante->rol,
                        'fecha_vinculacion' => $integrante->created_at?->format('Y-m-d'),
                    ];
                })
            ];

            return response()->json($response, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Red de aprendizaje no encontrada.',
                'error' => 'La red de aprendizaje con ID ' . $redAprendizajeId . ' no existe.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las actividades e integrantes.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
