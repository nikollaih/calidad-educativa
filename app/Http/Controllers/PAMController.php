<?php

namespace App\Http\Controllers;

use App\Exports\PamExport;
use App\Http\Requests\StorePamRowRequest;
use App\Models\Enums\PamEstadoEnum;
use App\Models\Indicador;
use App\Models\Pam;
use App\Models\PamAccion;
use App\Models\PamAvance;
use App\Models\PamComponente;
use App\Models\PamMeta;
use App\Models\PamObjetivoEstrategico;
use App\Models\PamRow;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PAMController extends Controller {

    // --------------------
    // Vistas
    // --------------------

    /**
     * Mostrar la vista principal del PAM
     *
     */
    public function index(int $pamId): View {
        Gate::authorize('s-pam-gestionar');
        $isInProceso = Pam::find($pamId)->estado === PamEstadoEnum::Proceso->value;

        return view('pam.index', [
            'pamGeneralId' => $pamId,
            'isInProceso' => $isInProceso,
        ]);
    }

    /**
     * Mostrar la vista del formulario de creación
     *
     */
    public function create(int $pamId): View {
        Gate::authorize('s-pam-gestionar');
        return view('pam.pam_form', ['pamGeneralId' => $pamId]);
    }

    /**
     * Mostrar la vista del formulario de edición
     *
     * @param int $id
     */
    public function show($id): View {
        Gate::authorize('s-pam-gestionar');
        return view('pam.edit', compact('id'));
    }

    /**
     * Mostrar la vista del formulario de edición
     *
     * @param int $id
     */
    public function vistaCompleta($id): View {
        Gate::authorize('s-pam-gestionar');
        return view('pam.vista_completa', compact('id'));
    }

    // --------------------
    //  Manejo de datos
    // --------------------

    /**
     * Obtiene todos los registros PAM, cargando todas sus relaciones anidadas.
     */
    public function all(int $pamId): JsonResponse {
        Gate::authorize('s-pam-gestionar');
        try {
            // Carga todas las acciones con sus relaciones completas y anidadas
            $actions = PamAccion::where('pam_id', $pamId)->with([
                'user',
                'indicador.meta.unidadMeta',
                'indicador.meta.avances',
                'indicador.meta.objetivoEstrategico.metaPlanDesarrollo.subproceso.proceso.componente',
                'indicador.meta.objetivoEstrategico.metaPlanDesarrollo'
            ])->get();

            // Aplanar la estructura de datos para el frontend
            $flattenedData = $actions->map(function ($accion) {
                $objetivoEstrategico = $accion?->indicador?->meta?->objetivoEstrategico ?? null;
                $subproceso = $objetivoEstrategico?->metaPlanDesarrollo?->first()->subproceso ?? null;
                $proceso = $subproceso?->proceso ?? null;
                $componente = $proceso?->componente ?? null;

                // Obtener la descripción de la primera MetaPlanDesarrollo si existe
                $metaPlanDesarrolloDescripcion = $objetivoEstrategico && $objetivoEstrategico->metaPlanDesarrollo->isNotEmpty()
                    ? $objetivoEstrategico->metaPlanDesarrollo->first()->descripcion
                    : null;

                $valorMeta = optional($accion->indicador->meta)->valor_meta ?? 0;
                $totalAvance = optional($accion->indicador->meta->avances)->sum('cantidad_ejecutada') ?? 0;
                
                $porcentajeMeta = ($valorMeta > 0) 
                    ? round(($totalAvance / $valorMeta) * 100, 2) . '%' 
                    : '0%';

                return [
                    'id' => $accion->id,
                    'componente' => $componente->componente?->descripcion ?? null,
                    'proceso' => $proceso->descripcion ?? null,
                    'subproceso' => $subproceso->descripcion ?? null,
                    'objetivo_estrategico' => $objetivoEstrategico->descripcion ?? null,
                    'meta_plan_desarrollo' => $metaPlanDesarrolloDescripcion,
                    'meta' => [
                        'descripcion' => $accion->indicador->meta->descripcion ?? null,
                        'valor_meta' => $valorMeta,
                        'unidad_meta_id' => $accion->indicador->meta->unidad_meta_id ?? null,
                        'unidad_meta' => $accion->indicador->meta->unidadMeta->descripcion ?? null,
                        'porcentaje_meta' => $porcentajeMeta,
                    ],
                    'indicador' => $accion->indicador->descripcion ?? null,
                    'accion' => $accion->descripcion,
                    'dias_restantes' => $accion->fecha_final 
                        ? (Carbon::parse($accion->fecha_final)->isFuture() 
                            ? Carbon::parse($accion->fecha_final)->diffInDays(Carbon::now()) . ' días restantes' 
                            : 'Finalizado')
                        : null,
                    'responsable' => $accion->user ? ['name' => $accion->user->name] : null,
                    'recursos' => $accion->recursos,
                    'fecha_inicio' => $accion->fecha_inicio ? Carbon::parse($accion->fecha_inicio)->format('d/m/Y') : null,
                    'fecha_final' => $accion->fecha_final ? Carbon::parse($accion->fecha_final)->format('d/m/Y') : null,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $flattenedData,
                'message' => 'Datos del plan de desarrollo obtenidos correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un registro específico para edición
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id) {
        Gate::authorize('s-pam-gestionar');
        try {
            // Carga la acción con todas sus relaciones anidadas en el nuevo orden
            $accion = PamAccion::with([
                'indicador.meta.objetivoEstrategico.metaPlanDesarrollo.subproceso.proceso.componente',
                'indicador.meta.objetivoEstrategico.metaPlanDesarrollo',
                'user'
            ])->find($id);

            if (!$accion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registro PAM no encontrado.'
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
                'componente' => $componente->componente?->id ?? null,
                'componente_descripcion' => $componente->descripcion ?? '',
                'proceso_id' => 'proceso_id' . $proceso->id ?? null,
                'proceso_descripcion' => $proceso->descripcion ?? '',
                'subproceso_id' => 'subproceso_id' . $subproceso->id ?? null,
                'subproceso_descripcion' => $subproceso->descripcion ?? '',

                // Ahora objetivo_estrategico_id es directo de subproceso
                'objetivo_estrategico_id' => 'objetivo_id' .$objetivo->id ?? null,
                'objetivo_estrategico_descripcion' => $objetivo->descripcion ?? '',

                // Meta Plan Desarrollo ahora es hijo de Objetivo Estratégico (y también tiene subproceso_id)
                'meta_plan_desarrollo_id' => 'meta_plan_id' . $firstMetaPlanDesarrollo->id ?? null,
                'meta_plan_desarrollo_descripcion' => $firstMetaPlanDesarrollo->descripcion ?? '',

                'meta_id' => 'meta_id' . $accion->indicador->meta->id ?? null,
                'meta_descripcion' => $accion->indicador->meta->descripcion ?? '',
                'valor_meta' => $accion->indicador->meta->valor_meta ?? '',
                'unidad_meta_id' => $accion->indicador->meta->unidad_meta_id ?? null,
                'indicador_id' => 'indicador_id' . $accion->indicador->id ?? null,
                'indicador_descripcion' => $accion->indicador->descripcion ?? '',
                'accion_id' => 'accion_id' . $accion->id,
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
                'message' => 'Error al cargar el registro PAM: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crea registros del pam
     *
     * @param Request $request Datos del formulario
     */
    public function store(Request $request, int $pamGeneralId): JsonResponse {
        Gate::authorize('s-pam-gestionar');
        // Reglas de validación para la estructura anidada
        $validator = Validator::make($request->all(), [
            'componentes' => 'required|array|min:1',
            // 'componentes.*.id' => 'required|integer',
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
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $createdPamIds = [];

            foreach ($request->input('componentes') as $compData) {
                $componente = PamComponente::create([
                    'componente_id' => $compData['componente_id'],
                ]);

                foreach ($compData['procesos'] as $procData) {
                    $proceso = $componente->procesos()->create(['descripcion' => $procData['descripcion']]);

                    foreach ($procData['subprocesos'] as $subprocData) {
                        $subproceso = $proceso->subprocesos()->create(['descripcion' => $subprocData['descripcion']]);

                        // Nuevo orden: Crear Objetivo Estratégico bajo Subproceso
                        foreach ($subprocData['metas_plan_desarrollo'][0]['objetivos'] as $objData) {
                            $objetivoEstrategico = PamObjetivoEstrategico::create(['descripcion' => $objData['descripcion']]);

                            // Crear Meta Plan Desarrollo bajo Objetivo Estratégico,
                            // pero también asignando subproceso_id
                            foreach ($subprocData['metas_plan_desarrollo'] as $metaPlanData) {
                                $metaPlanDesarrollo = $objetivoEstrategico->metaPlanDesarrollo()->create([
                                    'descripcion' => $metaPlanData['descripcion'],
                                    'subproceso_id' => $subproceso->id // Asignar manualmente subproceso_id
                                ]);
                            }

                            // Crear Meta bajo Objetivo Estratégico
                            foreach ($objData['metas'] as $metaData) {
                                $meta = $objetivoEstrategico->metas()->create([
                                    'descripcion' => $metaData['descripcion'],
                                    'valor_meta' => $metaData['valor_meta'] ?? null,
                                    'unidad_meta_id' => $metaData['unidad_meta_id'] ?? null,
                                ]);

                                foreach ($metaData['indicadores'] as $indicadorData) {
                                    $indicador = $meta->indicadores()->create(['descripcion' => $indicadorData['descripcion']]);

                                    // La acción es un objeto único por indicador
                                    if (isset($indicadorData['accion'])) {
                                        $accionData = $indicadorData['accion'];
                                        $accion = $indicador->accion()->create([
                                            'descripcion' => $accionData['descripcion'],
                                            'pam_id' => $pamGeneralId,
                                            'user_id' => $accionData['user_id'],
                                            'nombre_responsable' => $accionData['responsable_nombre'],
                                            'recursos' => $accionData['recursos_descripcion'],
                                            'fecha_inicio' => $accionData['fecha_inicio'],
                                            'fecha_final' => $accionData['fecha_final'],
                                        ]);
                                        $createdPamIds[] = $accion->id; // Almacena el ID de la acción final
                                    }
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Registro(s) PAM creado(s) correctamente',
                'ids' => $createdPamIds
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el registro PAM: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un registro especifico
     *
     * @param int $id id de la accion
     */
    public function destroy(int $id): JsonResponse {
        Gate::authorize('s-pam-gestionar');
        try {
            $pam = PamAccion::findOrFail($id);
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
    public function update(Request $request, int $id): JsonResponse {
        Gate::authorize('s-pam-gestionar');
        // Reglas de validación para la estructura anidada.
        // Son idénticas a las del método 'store' para asegurar consistencia.
        $validator = Validator::make($request->all(), [
            'componentes' => 'required|array|min:1',
            // 'componentes.*.id' => 'required|integer',
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
            $accion = PamAccion::find($id);
            if (!$accion) {
                // Si la acción no se encuentra, revierte y retorna un error 404
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Acción PAM no encontrada.'], 404);
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
            
            // La relación de PamMetaPlanDesarrollo con PamObjetivoEstrategico es uno a muchos,
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

            // 5. Realiza las actualizaciones de cada modelo con los datos de la solicitud
            // Actualizar Componente
            $componente->update([
                'componente_id' => $compData['componente_id'], // Consistente con el 'store'
            ]);

            // Actualizar Proceso
            $proceso->update(['descripcion' => $procData['descripcion']]);

            // Actualizar Subproceso
            $subproceso->update(['descripcion' => $subprocData['descripcion']]);

            // Actualizar Objetivo Estratégico (se actualiza directamente ya que PamObjetivoEstrategico
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
                'descripcion' => $metaData['descripcion'],
                'valor_meta' => $metaData['valor_meta'] ?? null,
                'unidad_meta_id' => $metaData['unidad_meta_id'] ?? null,
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
                'message' => 'Registro PAM actualizado correctamente',
                'id' => $accion->id // Retorna el ID de la acción actualizada
            ], 200); // Código 200 para "OK"

        } catch (Exception $e) {
            // Si ocurre algún error durante el proceso, revierte la transacción
            DB::rollBack();
            // Retorna una respuesta de error con el mensaje de la excepción
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el registro PAM: ' . $e->getMessage()
            ], 500); // Código 500 para "Internal Server Error"
        }
    }

    /**
     * Guarda avances por accion
     */
    public function storeAvance(Request $request) {
        Gate::authorize('s-pam-gestionar');
        try {
            // Validar los datos de la solicitud entrante
            $validatedData = $request->validate([
                'fecha_avance' => ['required', 'date'],
                'meta_id' => ['required', 'integer', 'exists:pam_metas,id'],
                'cantidad_ejecutada' => ['required', 'integer', 'min:0'],
                'observacion' => ['nullable', 'string', 'max:1000'],
                'archivos_adjuntos.*' => [
                    'nullable',
                    'file',
                    'max:10240',
                ],
            ]);

            DB::beginTransaction();

            $metaId = $validatedData['meta_id'];

            $meta = PamMeta::with('indicador.accionHasOne')->find($metaId);

            // Crear el registro PamAvance
            $avance = PamAvance::create([
                'fecha_avance' => $validatedData['fecha_avance'],
                'meta_id' => $validatedData['meta_id'],
                'accion_id' => $meta?->Indicador?->accionHasOne?->id,
                'cantidad_ejecutada' => $validatedData['cantidad_ejecutada'],
                'observacion' => $validatedData['observacion'],
            ]);

            // Verificar si la solicitud contiene archivos en el campo 'archivos_adjuntos'
            if ($request->hasFile('archivos_adjuntos')) {
                // Iterar sobre cada archivo adjunto recibido
                foreach ($request->file('archivos_adjuntos') as $file) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    $filePath = $file->storeAs('avances_adjuntos', $fileName, 'public');

                    $avance->archivosAdjuntos()->create([
                        'nombre_original' => $file->getClientOriginalName(),
                        'ruta_archivo' => $filePath,
                        'tipo_mime' => $file->getClientMimeType(),
                        'tamano' => $file->getSize(),
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
        Gate::authorize('s-pam-gestionar');
        try {
            $avances = PamAvance::where('accion_id', $accionId)
                ->with(['meta', 'accion', 'archivosAdjuntos'])
                ->orderBy('fecha_avance', 'desc')
                ->get();

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
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los avances: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar PAM a Excel
     */
    public function export(int $pamGeneralId) {
        Gate::authorize('s-pam-gestionar');
        try {
            $fileName = 'pam_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            return Excel::download(new PamExport($pamGeneralId), $fileName);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar el PAM: ' . $e->getMessage()
            ], 500);
        }
    }

    // --------------------
    //  Obtencion de registros para selectores
    // --------------------

    public function getMetas(Request $request): JsonResponse {
        Gate::authorize('s-pam-gestionar');
        try {
            $query = PamMeta::query();

            $pamGeneralId = (int) $request->input('pam_general_id');

            if ($request->has('search')) {
                $searchTerm = $request->input('search');
                $query->where('descripcion', 'like', '%' . $searchTerm . '%');
            }

            $metas = $query->whereHas('indicador', function ($q) use ($pamGeneralId) {
                $q->whereHas('meta.objetivoEstrategico.metaPlanDesarrollo.subproceso.proceso.componente', function ($query) use ($pamGeneralId) {
                    $query->where('pam_id', $pamGeneralId);
                });
            })->with(['indicador'])->get();

            return response()->json([
                'success' => true,
                'data' => $metas
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las metas: ' . $e->getMessage()
            ], 500);
        }
    }

}
