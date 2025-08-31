<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Models\ProyectoIntegrante;
use App\Models\ProyectosActividad;
use App\Models\ProyectosTransversal;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ProyectoTransversalIntegrantesController extends Controller {

    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function index(Request $request, int $proyectoTransversalId) {
        $user = auth()->user();

        $isRelatedToProyecto = false;
        
        // Se verifica si hay un usuario autenticado para realizar el filtro.
        if ($user) {
            $proyectoActividades = ProyectosActividad::with(['proyectoTransversal', 'adjuntos.adjunto'])
                ->whereHas('proyectoTransversal', function ($query) use ($user) {
                    $query->where('representante_id', $user->id);
                })
                ->get();

            $proyectoTransversal = ProyectosTransversal::find($proyectoTransversalId);

            $isRelatedToProyecto = $proyectoTransversal && $proyectoTransversal->representante_id === $user->id;

            $proyectoIntegrantes = ProyectoIntegrante::with(['proyectoTransversal'])
                ->whereHas('proyectoTransversal', function ($query) use ($user) {
                    $query->where('representante_id', $user->id);
                })
                ->get();
        } else {
            $proyectoActividades = collect();
            $proyectoIntegrantes = collect();
        }

        return view('proyectoTransversal.actividades.index', [
            'actividades' => $proyectoActividades,
            'integrantes' => $proyectoIntegrantes,
            'proyectoTransversal' => $proyectoTransversalId,
            'isRelatedToProyecto' => $isRelatedToProyecto,
        ]);
    }

    public function create() {
        $permissions = Permission::all();
        // Se corrige el nombre de la vista y la variable.
        return view('redesAprendizajes.create', compact('permissions'));
    }

    public function store(Request $request, int $proyectoTransversalId) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'rol' => 'required|max:100',
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
            'rol.max' => 'El rol no debe superar los 100 caracteres.',
        ]);

        $institucionId = ProyectosTransversal::find($proyectoTransversalId)?->institucion_id;

        // Crear la nueva actividad en la base de datos.
        ProyectoIntegrante::create([
            'proyecto_transversal_id' => $proyectoTransversalId,
            'institucion_id' => $institucionId,
            'nombre' => $request->input('nombre'),
            'telefono' => $request->input('telefono'),
            'correo' => $request->input('correo'),
            'rol' => (int) $request->input('rol'),
        ]);

        return redirect()->route('proyecto-transversal-integrantes.index', $proyectoTransversalId)->with('flash_success_message', 'Integrante creado con éxito.');
    }

    
    public function update(Request $request, int $proyectoTransversalId, int $integranteId) {
        // Se valida la petición con las reglas para el modelo de integrantes.
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'rol' => 'required|max:100',
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
            'rol.max' => 'El rol no debe superar los 100 caracteres.',
        ]);

        try {
            // Se busca el integrante por su ID.
            $integrante = ProyectoIntegrante::findOrFail($integranteId);
            
            // Se actualizan los campos del integrante con los datos de la petición.
            $integrante->update([
                'nombre' => $request->input('nombre'),
                'telefono' => $request->input('telefono'),
                'correo' => $request->input('correo'),
                'rol' => (int) $request->input('rol'),
            ]);

            // Se retorna una respuesta de éxito con código 200.
            return response()->json([
                'message' => 'Integrante actualizado con éxito.'
            ], 200);

        } catch (\Exception $e) {
            // Se retorna una respuesta de error en caso de fallo.
            return response()->json([
                'message' => 'Error al actualizar el integrante.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy(int $proyectoTransversalId, int $proyectoIntegranteId) {
        $proyectoIntegrante = ProyectoIntegrante::findOrFail($proyectoIntegranteId);
        
        $proyectoIntegrante->delete();
        return redirect()->route('proyecto-transversal-integrantes.index', $proyectoTransversalId)->with('flash_success_message', 'Integrante eliminado correctamente.');
    }
}
