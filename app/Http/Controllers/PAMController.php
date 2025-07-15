<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePamRowRequest;
use App\Models\PamAccion;
use App\Models\PamComponente;
use App\Models\PamObjetivoEstrategico;
use App\Models\PamRow;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PamController extends Controller {

    // --------------------
    // Vistas
    // --------------------
    
    /**
     * Mostrar la vista principal del PAM
     *
     */
    public function index(): View {
        return view('pam.index');
    }

    /**
     * Mostrar la vista del formulario de creación
     *
     */
    public function create(): View {
        return view('pam.pam_form');
    }

    /**
     * Mostrar la vista del formulario de edición
     *
     * @param int $id
     */
    public function show($id): View {
        return view('pam.edit', compact('id'));
    }

    // --------------------
    //  Manejo de datos
    // --------------------

    /**
     * Obtiene todos los registros PAM, cargando todas sus relaciones anidadas.
     */
    public function all(): JsonResponse {
        try {
            // Carga todas las acciones con sus relaciones completas y anidadas
            $actions = PamAccion::with([
                'user',
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

                return [
                    'id' => $accion->id,
                    'componente' => $componente->descripcion ?? null,
                    'proceso' => $proceso->descripcion ?? null,
                    'subproceso' => $subproceso->descripcion ?? null,
                    'objetivo_estrategico' => $objetivoEstrategico->descripcion ?? null,
                    'meta_plan_desarrollo' => $metaPlanDesarrolloDescripcion,
                    'meta' => $accion->indicador->meta->descripcion ?? null,
                    'indicador' => $accion->indicador->descripcion ?? null,
                    'accion' => $accion->descripcion,
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
     * Crea registros del pam
     * 
     * @param Request $request Datos del formulario
     */
    public function store(Request $request): JsonResponse {
        // Reglas de validación para la estructura anidada
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
            'componentes.*.procesos.*.subprocesos.*.metas_plan_desarrollo.*.objetivos.*.metas.*.descripcion' => 'required|string|max:1000',
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
            $createdPamIds = []; // Para almacenar los IDs de los PAMs creados si se crean múltiples

            foreach ($request->input('componentes') as $compData) {
                $componente = PamComponente::create([
                    'descripcion' => $compData['descripcion'],
                    'nombre' => $compData['descripcion'],
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
                                $meta = $objetivoEstrategico->metas()->create(['descripcion' => $metaData['descripcion']]);

                                foreach ($metaData['indicadores'] as $indicadorData) {
                                    $indicador = $meta->indicadores()->create(['descripcion' => $indicadorData['descripcion']]);

                                    // La acción es un objeto único por indicador
                                    if (isset($indicadorData['accion'])) {
                                        $accionData = $indicadorData['accion'];
                                        $accion = $indicador->accion()->create([
                                            'descripcion' => $accionData['descripcion'],
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
    
    public function update(Request $request, $id)
    {
        // Reglas de validación para la nueva estructura anidada completa
        $validator = Validator::make($request->all(), [
            'componentes' => 'required|array|min:1',
            'componentes.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos' => 'required|array|min:1',
            'componentes.*.procesos.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.objetivos' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas_plan_desarrollo' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas_plan_desarrollo.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores' => 'required|array|min:1',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.accion' => 'required|array',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.accion.descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.accion.user_id' => 'required|exists:users,id',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.accion.responsable_nombre' => 'required|string|max:255',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.accion.recursos_descripcion' => 'required|string|max:1000',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.accion.fecha_inicio' => 'required|date',
            'componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.accion.fecha_final' => 'required|date|after_or_equal:componentes.*.procesos.*.subprocesos.*.objetivos.*.metas.*.indicadores.*.accion.fecha_inicio',
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
            // Recupera la acción existente para iniciar la actualización de la jerarquía
            $accion = PamAccion::find($id);
            if (!$accion) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Acción no encontrada.'], 404);
            }

            // Accede a los datos de la primera jerarquía del request
            $compData = $request->input('componentes')[0];
            $procData = $compData['procesos'][0];
            $subprocData = $procData['subprocesos'][0];
            $objData = $subprocData['objetivos'][0]; // Objetivo ahora bajo Subproceso
            $metaPlanData = $objData['metas_plan_desarrollo'][0]; // Meta Plan Desarrollo bajo Objetivo
            $metaData = $objData['metas'][0]; // Meta bajo Objetivo
            $indicadorData = $metaData['indicadores'][0];
            $accionData = $indicadorData['accion'];

            // Actualizar Componente
            $componente = $accion->indicador->meta->objetivoEstrategico->subproceso->proceso->componente;
            $componente->update(['descripcion' => $compData['descripcion']]);

            // Actualizar Proceso
            $proceso = $accion->indicador->meta->objetivoEstrategico->subproceso->proceso;
            $proceso->update(['descripcion' => $procData['descripcion']]);

            // Actualizar Subproceso
            $subproceso = $accion->indicador->meta->objetivoEstrategico->subproceso;
            $subproceso->update(['descripcion' => $subprocData['descripcion']]);

            // Actualizar Objetivo Estratégico
            $objetivoEstrategico = $accion->indicador->meta->objetivoEstrategico;
            $objetivoEstrategico->update(['descripcion' => $objData['descripcion'], 'subproceso_id' => $subproceso->id]);

            // Actualizar Meta Plan Desarrollo
            // Esto es más complejo si hay múltiples MetaPlanDesarrollo por Objetivo.
            // Aquí se asume que se actualiza el primero encontrado o el que corresponde al ID.
            $metaPlanDesarrollo = $objetivoEstrategico->metaPlanDesarrollo()->firstOrCreate(
                ['id' => $metaPlanData['id'] ?? null], // Intenta encontrar por ID si existe
                ['descripcion' => $metaPlanData['descripcion'], 'subproceso_id' => $subproceso->id]
            );
            $metaPlanDesarrollo->update(['descripcion' => $metaPlanData['descripcion'], 'subproceso_id' => $subproceso->id]);


            // Actualizar Meta
            $meta = $accion->indicador->meta;
            $meta->update(['descripcion' => $metaData['descripcion'], 'objetivo_estrategico_id' => $objetivoEstrategico->id]);

            // Actualizar Indicador
            $indicador = $accion->indicador;
            $indicador->update(['descripcion' => $indicadorData['descripcion'], 'meta_id' => $meta->id]);

            // Actualizar Acción
            $accion->update([
                'descripcion' => $accionData['descripcion'],
                'user_id' => $accionData['user_id'],
                'nombre_responsable' => $accionData['responsable_nombre'],
                'recursos' => $accionData['recursos_descripcion'],
                'fecha_inicio' => $accionData['fecha_inicio'],
                'fecha_final' => $accionData['fecha_final'],
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Registro PAM actualizado correctamente',
                'id' => $accion->id
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el registro PAM: ' . $e->getMessage()
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

            // Aplanar la estructura para que coincida con el formato que tu frontend espera para la carga.
            // Es crucial que esta estructura aplanada coincida con cómo tu `useEffect` en el frontend
            // mapea los datos al estado `formData`.
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
                'fecha_inicio' => $accion->fecha_inicio,
                'fecha_final' => $accion->fecha_final,
            ];

            return response()->json(['success' => true, 'data' => $data]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el registro PAM: ' . $e->getMessage()
            ], 500);
        }
    }
}


