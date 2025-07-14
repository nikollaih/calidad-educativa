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

    public function create(): View {
        return view('pam.pam_form');
    }

    /**
     * Mostrar la vista del formulario de edición
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id) {
        return view('pam.edit', compact('id'));
    }

    public function all() {
        try {
            // $rows = PamRow::with('responsable')->get();
            
            return response()->json([
                'success' => true,
                'data' => [],
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
     */
    public function store(Request $request) {
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

    public function destroy(int $id) {
        try {
            $pam = PamrOW::findOrFail($id);
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
        try {
            // Validar que el ID sea válido
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de registro no válido'
                ], 400);
            }

            // Buscar el registro por ID
            $pam = PamRow::find($id);

            if (!$pam) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registro no encontrado'
                ], 404);
            }

            // Actualizar el registro
            $pam->update($request->all());

            // Retornar respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Registro actualizado exitosamente',
                'data' => [
                    'id' => $pam->id,
                    'componente' => $pam->componente,
                    'proceso' => $pam->proceso,
                    'subproceso' => $pam->subproceso,
                    'meta_plan_desarrollo' => $pam->meta_plan_desarrollo,
                    'objetivo_estrategico' => $pam->objetivo_estrategico,
                    'meta' => $pam->meta,
                    'indicador' => $pam->indicador,
                    'accion' => $pam->accion,
                    'responsable' => $pam->responsable,
                    'user_id' => $pam->user_id,
                    'recursos' => $pam->recursos,
                    'fecha_inicio' => $pam->fecha_inicio,
                    'fecha_final' => $pam->fecha_final,
                    'updated_at' => $pam->updated_at
                ]
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al actualizar registro PAM: ' . $e->getMessage(), [
                'id' => $id,
                'data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al actualizar el registro'
            ], 500);
        }
    }
    
    /**
     * Obtener un registro específico para edición
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse {
        try {
            // Validar que el ID sea válido
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de registro no válido'
                ], 400);
            }

            // Buscar el registro por ID
            $pam = PamRow::find($id);


            // Verificar si el registro existe
            if (!$pam) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registro no encontrado'
                ], 404);
            }

            // Retornar los datos del registro
            return response()->json([
                'success' => true,
                'message' => 'Registro encontrado exitosamente',
                'data' => [
                    'id' => $pam->id,
                    'componente' => $pam->componente,
                    'proceso' => $pam->proceso,
                    'subproceso' => $pam->subproceso,
                    'meta_plan_desarrollo' => $pam->meta_plan_desarrollo,
                    'objetivo_estrategico' => $pam->objetivo_estrategico,
                    'meta' => $pam->meta,
                    'indicador' => $pam->indicador,
                    'accion' => $pam->accion,
                    'responsable' => $pam->responsable,
                    'user_id' => $pam->user_id,
                    'recursos' => $pam->recursos,
                    'fecha_inicio' => Carbon::parse($pam->fecha_inicio)->format('Y-m-d'),
                    'fecha_final' => Carbon::parse($pam->fecha_final)->format('Y-m-d'),
                    'created_at' => $pam->created_at,
                    'updated_at' => $pam->updated_at
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener registro PAM: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al obtener el registro'
            ], 500);
        }
    }
}


