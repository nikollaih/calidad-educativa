<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Http\Services\MailService;
use App\Models\RedesAprendizaje;
use App\Models\ProyectoIntegrante;
use App\Models\ProyectosActividad;
use App\Models\ProyectosTransversal;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ProyectoTransversalActividadesController extends Controller {

    public function __construct(
        private AdjuntoService $adjuntoService,
        private MailService $mailService
    ){}

    public function index(Request $request, int $proyectoTransversalId) {
        $user = auth()->user();

        $isRelatedToProyecto = false;

        // Se verifica si hay un usuario autenticado para realizar el filtro.
        if ($user) {
            $proyectoActividades = ProyectosActividad::with(['proyectoTransversal.actoAdministrativo', 'adjuntos.adjunto'])
                ->whereHas('proyectoTransversal', function ($query) use ($user) {
                    $query->where('representante_id', $user->id);
                })
                ->get();

            $proyectoTransversal = ProyectosTransversal::with(['actoAdministrativo'])
                ->where('id', $proyectoTransversalId)->first();

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
            //obtenerlo directamente del modelo
            'detalleProyecto' => $isRelatedToProyecto ? $proyectoTransversal : null,
            'integrantes' => $proyectoIntegrantes,
            'institucionId' => $proyectoTransversal?->institucion_id,
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


        // Crear la nueva actividad en la base de datos.
        $actividad = ProyectosActividad::create([
            'proyecto_transversal_id' => $proyectoTransversalId,
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
                        'proyecto_transversal_id' => $actividad->id,
                        'adjunto_id' => $storedAdjunto->data->id,
                    ]);
                }
            }
        }

        return redirect()->route('proyecto-transversal-actividades.index', $proyectoTransversalId)->with('flash_success_message', 'Actividad creada con éxito.');
    }

    public function shareWithIntegrants(Request $request) {
        $input = $request->all();
        /**
         * @var ProyectosActividad proyectoActividad Actividad asociada con sus relaciones
         */
        $proyectoActividad = ProyectosActividad::with(['proyectoTransversal.representante', 'proyectoTransversal.integrantes'])
            ->find(data_get($input, 'activity.id'));

        if (!$proyectoActividad) {
            return response()->json([
                'message' => 'Actividad no encontrada.',
            ], 500);
        }
        /**
         * @var array $activityData Son los datos de la actividad que se mostrara'n en el correo
         */
        $activityData = [
            'fecha' => $proyectoActividad?->fecha,
            'descripcion' => $proyectoActividad?->descripcion,
        ];
        /**
         * @var array $proyectoTransversalData Es la informacion del proyecto transversal que se va a mandar
         */
        $proyectoTransversalData = [
            'nombre'      => $proyectoActividad?->proyectoTransversal?->nombre,
            'descripcion' => $proyectoActividad?->proyectoTransversal?->descripcion
        ];
        /**
         * @var ?string $mensaje Es el mensaje custom del compartir
         */
        $mensaje = data_get($input, 'description');
        $proyectoActividad->proyectoTransversal
            ->integrantes
            ->where('rol', '=', $input["role"])
            ->each(function ($integrante) use ($input, $activityData, $proyectoTransversalData, $mensaje) {
                // Enviar correo (retorna false si falla)
                $this->mailService->sendMail(
                    email: $integrante->correo,
                    subject: 'Notifiación proyecto transversal',
                    template: 'email.proyecto_transversal.actividad.share',
                    data:[
                        'nombre'              => $integrante->nombre,
                        'actividad'           => $activityData,
                        'proyectoTransversal' => $proyectoTransversalData,
                        'mensaje'         => $mensaje,
                    ]
                );
            });
        return response()->json([
            'message' => 'Correos enviados exitosamente.',
        ], 200);
    }
    public function edit(RedesAprendizaje $redAprendizaje) {
        // Se corrige la variable a 'redAprendizaje' para que coincida con el modelo.
        return view('redesAprendizajes.edit', compact('redAprendizaje'));
    }

    public function update(Request $request, int $proyectoTransversalId, int $actividadId) {
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
        $actividad = ProyectosActividad::findOrFail($actividadId);
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

    public function destroy(int $proyectoTransversalId, int $actividadId) {
        $proyectoActividad = ProyectosActividad::findOrFail($actividadId);

        $proyectoActividad->delete();
        return redirect()->route('proyecto-transversal-actividades.index', $proyectoTransversalId)->with('flash_success_message', 'Actividad eliminada correctamente.');
    }
}
