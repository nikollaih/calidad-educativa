<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Models\RedesAprendizaje;
use App\Models\Adjunto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

class RedesAprendizajeController extends Controller {

    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function index() {
        // Se carga la relación con el representante para mostrar su nombre en la tabla.
        $redAprendizaje = RedesAprendizaje::with(['representante', 'actoAdministrativo'])->get();
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

    public function create() {
        $permissions = Permission::all();
        // Se corrige el nombre de la vista y la variable.
        return view('redesAprendizajes.create', compact('permissions'));
    }

    public function store(Request $request) {
        // Se agregan las reglas de validación para todos los campos de la solicitud, incluyendo el archivo.
        // Se ha modificado la regla 'mimes' para aceptar formatos de imagen.
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string', 
            'representante_id' => 'required|exists:users,id', 
            'numero_contacto' => 'nullable|string',
            'acto_administrativo' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,svg,webp|max:10240',
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
}
