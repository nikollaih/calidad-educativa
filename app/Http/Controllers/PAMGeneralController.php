<?php

namespace App\Http\Controllers;

use App\Exports\PamGeneralExport;
use App\Http\Requests\StorePamGeneralRowRequest;
use App\Models\Pam;
use App\Models\PamGeneralAccion;
use App\Models\PamGeneralAvance;
use App\Models\PamGeneralComponente;
use App\Models\PamGeneralMeta;
use App\Models\PamGeneralObjetivoEstrategico;
use App\Models\PamGeneralRow;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PAMGeneralController extends Controller {
    /**
     * Mostrar la vista principal del PAMGeneral
     *
     */
    public function index() {
        $pams = Pam::paginate(10);

        return view('pamGeneral.index', [
            'pams' => $pams,
        ]);
    }

    public function create() {
        return view('pamGeneral.create');
    }

    /**
     * Mostrar la vista del formulario de edición
     *
     * @param int $id
     */
    public function show($id): View {
        return view('pamGeneral.edit', compact('id'));
    }

    // --------------------
    //  Manejo de datos
    // --------------------

    /**
     * Obtener un registro específico para edición
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id) {
        try {
            // Carga la acción con todas sus relaciones anidadas en el nuevo orden
            $accion = PamGeneralAccion::with([
                'indicador.meta.objetivoEstrategico.metaPlanDesarrollo.subproceso.proceso.componente',
                'indicador.meta.objetivoEstrategico.metaPlanDesarrollo',
                'user'
            ])->find($id);

            if (!$accion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registro PAMGeneral no encontrado.'
                ], 404);
            }

            $objetivo = $accion->indicador->meta->objetivoEstrategico ?? null;
            $subproceso = $objetivo?->metaPlanDesarrollo?->first()->subproceso ?? null;
            $proceso = $subproceso->proceso ?? null;
            $componente = $proceso->componente ?? null;

            // Para simplificar la carga en el frontend, se toma la primera MetaPlanDesarrollo asociada al Objetivo
            // Si hay múltiples, necesitarías una lógica más compleja en el frontend para manejar un array.
            $firstMetaPlanDesarrollo = $objetivo && $objetivo->metaPlanDesarrollo->isNotEmpty()
                ? $objetivo->metaPlanDesarrollo->first()
                : null;

            $data = [
                'componente_id' => $componente->id ?? null,
                'componente_descripcion' => $componente->descripcion ?? '',
                'proceso_id' => $proceso->id ?? null,
                'proceso_descripcion' => $proceso->descripcion ?? '',
                'subproceso_id' => $subproceso->id ?? null,
                'subproceso_descripcion' => $subproceso->descripcion ?? '',

                // Ahora objetivo_estrategico_id es directo de subproceso
                'objetivo_estrategico_id' => $objetivo->id ?? null,
                'objetivo_estrategico_descripcion' => $objetivo->descripcion ?? '',

                // Meta Plan Desarrollo ahora es hijo de Objetivo Estratégico (y también tiene subproceso_id)
                'meta_plan_desarrollo_id' => $firstMetaPlanDesarrollo->id ?? null,
                'meta_plan_desarrollo_descripcion' => $firstMetaPlanDesarrollo->descripcion ?? '',

                'meta_id' => $accion->indicador->meta->id ?? null,
                'meta_descripcion' => $accion->indicador->meta->descripcion ?? '',
                'indicador_id' => $accion->indicador->id ?? null,
                'indicador_descripcion' => $accion->indicador->descripcion ?? '',
                'accion_id' => $accion->id,
                'accion_descripcion' => $accion->descripcion,
                'user_id' => $accion->user_id,
                'responsable_nombre' => $accion->user->name ?? $accion->nombre_responsable,
                'recursos_descripcion' => $accion->recursos,
                'fecha_inicio' => Carbon::parse($accion->fecha_inicio)->format('Y-m-d'),
                'fecha_final' => Carbon::parse($accion->fecha_final)->format('Y-m-d'),
            ];

            return response()->json(['success' => true, 'data' => $data]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el registro PAMGeneral: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crea registros del pam
     *
     * @param Request $request Datos del formulario
     */
    public function store(Request $request) {
        $pamData = $request->input('pam');

        Pam::create($pamData);

        return redirect()
            ->route('pams.index')
            ->with('flash_success_message', 'Pam creado correctamente.');
    }

    /**
     * Elimina un registro especifico
     *
     * @param int $id id de la accion
     */
    public function destroy(int $id): JsonResponse {
        try {
            $pam = Pam::findOrFail($id);
            $pam->delete();

            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un registro específico
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse {
        // Reglas de validación para la estructura anidada.
        // Son idénticas a las del método 'store' para asegurar consistencia.
        $validator = Validator::make($request->all(), [
            'componentes' => 'required|array|min:1',
            'componentes.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos' => 'required|array|min:1',
            'componentes.*.procesos.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.descripcion' => 'required',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.accion' => 'required|array',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.accion.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.accion.user_id' => 'required|exists:users,id',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.accion.responsable_nombre' => 'required|string|max:255',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.accion.recursos_descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.accion.fecha_inicio' => 'required|date',
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.accion.fecha_final' => 'required|date|after_or_equal:componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.indicadores.*.accion.fecha_inicio',
        ]);

        if ($validator->fails()) {
            // Si la validación falla, retorna los errores
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422); // Código 422 para "Unprocessable Entity"
        }

        // Inicia una transacción de base de datos para asegurar la atomicidad de las actualizaciones
        DB::beginTransaction();
        try {
            // 1. Recupera la acción existente usando el ID proporcionado
            $accion = PamGeneralAccion::find($id);
            if (!$accion) {
                // Si la acción no se encuentra, revierte y retorna un error 404
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Acción PAMGeneral no encontrada.'], 404);
            }

            // 2. Accede a los datos de entrada de la solicitud, asumiendo una única rama de la jerarquía
            // Estas líneas extraen el primer elemento de cada array anidado,
            // lo que es consistente con la idea de actualizar una sola jerarquía.

            $compData = $request->input('componentes')[0];
            $procData = $compData['procesos'][0];
            $subprocData = $procData['subprocesos'][0];
            $metaPlanData = $subprocData['metas_plan_desarrollo'][0];
            $objData = $metaPlanData['objetivos'][0];
            $metaData = $objData['metas'][0];
            $indicadorData = $metaData['indicadores'][0];
            $accionData = $indicadorData['accion'];

            // 3. Asciende en la cadena de relaciones de Eloquent para obtener los modelos padre
            // Esto es crucial para poder actualizar los registros correctos en la base de datos.
            $indicador = $accion->indicador;
            $meta = $indicador->meta;
            $objetivoEstrategico = $meta->objetivoEstrategico;
            
            // La relación de PamGeneralMetaPlanDesarrollo con PamGeneralObjetivoEstrategico es uno a muchos,
            // pero en tu 'store' parece que se crea una 'meta_plan_desarrollo' por 'objetivo'.
            // Tomamos la primera o ajusta si sabes qué 'meta_plan_desarrollo' específica actualizar.
            $metaPlanDesarrollo = $objetivoEstrategico->metaPlanDesarrollo()->first();
            
            // Obtener subproceso, proceso y componente a través de sus relaciones
            $subproceso = $metaPlanDesarrollo ? $metaPlanDesarrollo->subproceso : null;
            $proceso = $subproceso ? $subproceso->proceso : null;
            $componente = $proceso ? $proceso->componente : null;

            // 4. Verificar que se pudieron obtener todos los modelos de la cadena
            // Si falta alguno, significa que la estructura esperada no se encontró, lo cual es un error.
            if (!$componente || !$proceso || !$subproceso || !$metaPlanDesarrollo || !$objetivoEstrategico || !$meta || !$indicador) {
                DB::rollBack();
                return response()->json([
                    'success' => false, 
                    'message' => 'Error: No se pudo obtener la cadena completa de relaciones para la actualización.'
                ], 500);
            }

            dd($procData['descripcion'],
                $subprocData['descripcion'],
                $metaPlanData['descripcion'],
                $objData['descripcion'],
                $metaData['descripcion'],
                $indicadorData['descripcion'],
                $accionData['descripcion']);
            // 5. Realiza las actualizaciones de cada modelo con los datos de la solicitud
            // Actualizar Componente
            $componente->update([
                'descripcion' => $compData['descripcion'],
                'nombre' => $compData['descripcion'], // Consistente con el 'store'
            ]);

            // Actualizar Proceso
            $proceso->update(['descripcion' => $procData['descripcion']]);

            // Actualizar Subproceso
            $subproceso->update(['descripcion' => $subprocData['descripcion']]);

            // Actualizar Objetivo Estratégico (se actualiza directamente ya que PamGeneralObjetivoEstrategico
            // se crea directamente en el 'store' sin una relación directa padre con Subproceso,
            // pero 'metas_plan_desarrollo' lo referencia).
            $objetivoEstrategico->update([
                'descripcion' => $objData['descripcion']
            ]);

            // Actualizar Meta Plan Desarrollo
            // Se actualiza la descripción y se asegura que el 'subproceso_id' sea el correcto.
            $metaPlanDesarrollo->update([
                'descripcion' => $metaPlanData['descripcion'],
                'subproceso_id' => $subproceso->id // Re-asigna para asegurar consistencia
            ]);

            // Actualizar Meta (que está bajo Objetivo Estratégico)
            $meta->update([
                'descripcion' => $metaData['descripcion']
            ]);

            // Actualizar Indicador (que está bajo Meta)
            $indicador->update([
                'descripcion' => $indicadorData['descripcion']
            ]);

            // Actualizar Acción (que está bajo Indicador)
            $accion->update([
                'descripcion' => $accionData['descripcion'],
                'user_id' => $accionData['user_id'],
                'nombre_responsable' => $accionData['responsable_nombre'],
                'recursos' => $accionData['recursos_descripcion'],
                'fecha_inicio' => $accionData['fecha_inicio'],
                'fecha_final' => $accionData['fecha_final'],
            ]);

            // 6. Confirma la transacción si todas las actualizaciones fueron exitosas
            DB::commit();
            
            // 7. Retorna una respuesta de éxito
            return response()->json([
                'success' => true,
                'message' => 'Registro PAMGeneral actualizado correctamente',
                'id' => $accion->id // Retorna el ID de la acción actualizada
            ], 200); // Código 200 para "OK"

        } catch (Exception $e) {
            // Si ocurre algún error durante el proceso, revierte la transacción
            DB::rollBack();
            // Retorna una respuesta de error con el mensaje de la excepción
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el registro PAMGeneral: ' . $e->getMessage()
            ], 500); // Código 500 para "Internal Server Error"
        }
    }

    /**
     * Guarda avances por accion
     */
    public function storeAvance(Request $request) {
        try {
            // Validar los datos de la solicitud entrante
            $validatedData = $request->validate([
                'fecha_avance' => ['required', 'date'],
                'meta_id' => ['required', 'integer', 'exists:pam_metas,id'],
                'accion_id' => ['required', 'integer', 'exists:pam_acciones,id'],
                'cantidad_ejecutada' => ['required', 'integer', 'min:0'],
                'observacion' => ['nullable', 'string', 'max:1000'],
                'archivos_adjuntos.*' => [
                    'nullable',
                    'file',
                    'max:10240',
                ],
            ]);

            DB::beginTransaction();

            // Crear el registro PamGeneralAvance
            $avance = PamGeneralAvance::create([
                'fecha_avance' => $validatedData['fecha_avance'],
                'meta_id' => $validatedData['meta_id'],
                'accion_id' => $validatedData['accion_id'],
                'cantidad_ejecutada' => $validatedData['cantidad_ejecutada'],
                'observacion' => $validatedData['observacion'],
            ]);

            // Verificar si la solicitud contiene archivos en el campo 'archivos_adjuntos'
            if ($request->hasFile('archivos_adjuntos')) {
                // Iterar sobre cada archivo adjunto recibido
                foreach ($request->file('archivos_adjuntos') as $file) {
                    // Generar un nombre único para el archivo para evitar colisiones
                    // Se usa time() para la marca de tiempo, uniqid() para una cadena única,
                    // y getClientOriginalExtension() para mantener la extensión original.
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Almacenar el archivo en el disco 'public' dentro del subdirectorio 'avances_adjuntos'.
                    // El disco 'public' generalmente mapea a 'storage/app/public' y necesita un enlace simbólico
                    // a 'public/storage' para ser accesible vía web.
                    $filePath = $file->storeAs('avances_adjuntos', $fileName, 'public');

                    // Guardar la información del archivo en la tabla 'pam_avance_archivos'.
                    // Se utiliza la relación definida en el modelo PamGeneralAvance para crear el registro.
                    $avance->archivosAdjuntos()->create([
                        'nombre_original' => $file->getClientOriginalName(), // Nombre original del archivo subido por el usuario
                        'ruta_archivo' => $filePath, // Ruta donde se almacenó el archivo en el servidor
                        'tipo_mime' => $file->getClientMimeType(), // Tipo MIME del archivo (ej. application/pdf)
                        'tamano' => $file->getSize(), // Tamaño del archivo en bytes
                    ]);
                }
            }

            // Si todo fue exitoso, confirmar la transacción en la base de datos
            DB::commit();

            // Devolver una respuesta JSON de éxito
            return response()->json(['message' => 'Avance guardado exitosamente!', 'avance' => $avance], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capturar errores de validación específicamente
            // Revertir la transacción si hay errores de validación
            DB::rollBack();
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422); // HTTP 422 Unprocessable Entity
        } catch (Exception $e) {
            // Capturar cualquier otro error inesperado
            // Revertir la transacción en caso de cualquier excepción
            DB::rollBack();
            return response()->json([
                'message' => 'Error al guardar el avance. ' . $e->getMessage(),
                'error_code' => $e->getCode()
            ], 500); // HTTP 500 Internal Server Error
        }
    }

    /**
     * Obtiene los avances por accion
     *
     * @param int $accionId
     */
    public function getAvancesPorAccion(int $accionId) {
        $avances = PamGeneralAvance::where('accion_id', $accionId)
                            ->with(['meta', 'accion', 'archivosAdjuntos'])
                            ->orderBy('fecha_avance', 'desc')
                            ->get();

        // 3. Transform the data for frontend (optional, but good for consistent display)
        $formattedAvances = $avances->map(function ($avance) {
            return [
                'id' => $avance->id,
                'fecha_avance' => $avance->fecha_avance->format('Y-m-d'),
                'cantidad_ejecutada' => $avance->cantidad_ejecutada,
                'observacion' => $avance->observacion,
                'meta_descripcion' => $avance->meta->descripcion ?? 'N/A',
                'accion_descripcion' => $avance->accion->descripcion ?? 'N/A',
                'archivos_adjuntos' => $avance->archivosAdjuntos->map(function($file) {
                    return [
                        'id' => $file->id,
                        'nombre' => $file->nombre_original,
                        'url' => Storage::url($file->ruta_archivo),
                    ];
                })->toArray(),
            ];
        });

        return response()->json($formattedAvances);
    }

    /**
     * Exportar PAMGeneral a Excel
     */
    public function export() {
        $fileName = 'pam_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new PamGeneralExport, $fileName);
    }

    // --------------------
    //  Obtencion de registros para selectores
    // --------------------

    public function getMetas(Request $request): JsonResponse {
        $query = PamGeneralMeta::query();

        // Puedes agregar lógica de filtrado si deseas un término de búsqueda inicial
        // Aunque el frontend ya maneja el filtrado, esto es útil si quieres
        // un filtrado del lado del servidor para grandes volúmenes de datos.
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('descripcion', 'like', '%' . $searchTerm . '%');
        }

        // Selecciona solo los campos 'id' y 'nombre' para optimizar la respuesta
        // Cambia 'nombre' al nombre real de tu columna descriptiva en la tabla 'metas'
        $metas = $query->select('id', 'descripcion')->get();

        return response()->json($metas);
    }

    public function getAcciones(Request $request): JsonResponse {

        $metaId = (int) $request->input('meta_id');

        // Start the query on PamGeneralAccion
        $query = PamGeneralAccion::query();

        // Join with the 'indicadores' table and then filter by the meta_id
        // Assuming:
        // - PamGeneralAccion has an 'indicador_id' foreign key
        // - Your 'indicadores' table has a 'meta_id' foreign key
        // - 'indicadores' is the name of your indicators table
        // - 'indicador_id' is the column in pam_acciones that links to indicadores.id
        $query->whereHas('indicador', function ($q) use ($metaId) {
            $q->where('meta_id', $metaId);
        });


        // You can add server-side filtering by search term here if needed
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('descripcion', 'like', '%' . $searchTerm . '%');
        }

        // Select only the 'id' and 'descripcion' fields for optimized response
        $acciones = $query->select('id', 'descripcion')->get();

        return response()->json($acciones);
    }
}


