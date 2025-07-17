<?php

namespace App\Http\Controllers;

use App\Exports\PamExport;
use App\Http\Requests\StorePamRowRequest;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

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
                'message' => 'Error al cargar el registro PAM: ' . $e->getMessage()
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
    public function update(Request $request, $id) {
        // Reglas de validación para la estructura anidada (consistente con store)
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
            // Recupera la acción existente para iniciar la actualización de la jerarquía
            $accion = PamAccion::find($id);
            if (!$accion) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Acción no encontrada.'], 404);
            }

            // Accede a los datos siguiendo la estructura del store
            $compData = $request->input('componentes')[0];
            $procData = $compData['procesos'][0];
            $subprocData = $procData['subprocesos'][0];
            $metaPlanData = $subprocData['metas_plan_desarrollo'][0];
            $objData = $metaPlanData['objetivos'][0];
            $metaData = $objData['metas'][0];
            $indicadorData = $metaData['indicadores'][0];
            $accionData = $indicadorData['accion'];

            // Seguir la cadena de relaciones desde la acción hacia arriba
            $indicador = $accion->indicador;
            $meta = $indicador->meta;
            $objetivoEstrategico = $meta->objetivoEstrategico;
            $metaPlanDesarrollo = $objetivoEstrategico->metaPlanDesarrollo()->first();
            
            // Obtener subproceso desde metaPlanDesarrollo
            $subproceso = $metaPlanDesarrollo ? $metaPlanDesarrollo->subproceso : null;
            $proceso = $subproceso ? $subproceso->proceso : null;
            $componente = $proceso ? $proceso->componente : null;

            // Verificar que tenemos toda la cadena de relaciones
            if (!$componente || !$proceso || !$subproceso || !$metaPlanDesarrollo) {
                DB::rollBack();
                return response()->json([
                    'success' => false, 
                    'message' => 'Error: No se pudo obtener la cadena completa de relaciones'
                ], 500);
            }

            // Actualizar Componente
            $componente->update([
                'descripcion' => $compData['descripcion'],
                'nombre' => $compData['descripcion'], // Consistente con store
            ]);

            // Actualizar Proceso
            $proceso->update(['descripcion' => $procData['descripcion']]);

            // Actualizar Subproceso
            $subproceso->update(['descripcion' => $subprocData['descripcion']]);

            // Actualizar Meta Plan Desarrollo
            // Basándose en el store, metaPlanDesarrollo está bajo objetivoEstrategico
            // pero mantiene subproceso_id como referencia
            $metaPlanDesarrollo->update([
                'descripcion' => $metaPlanData['descripcion'],
                'subproceso_id' => $subproceso->id
            ]);

            // Actualizar Objetivo Estratégico
            // En el store, se crea directamente sin referencia a subproceso
            $objetivoEstrategico->update([
                'descripcion' => $objData['descripcion']
            ]);

            // Actualizar Meta
            // En el store, las metas están bajo objetivoEstrategico
            $meta->update([
                'descripcion' => $metaData['descripcion']
            ]);

            // Actualizar Indicador
            // En el store, los indicadores están bajo meta
            $indicador->update([
                'descripcion' => $indicadorData['descripcion']
            ]);

            // Actualizar Acción
            // En el store, las acciones están bajo indicador
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
     * Guarda avances por accion
     */
    public function storeAvance(Request $request) {

        try {
            // 1. Validate the incoming request data
            $validatedData = $request->validate([
                'fecha_avance' => ['required', 'date'],
                'meta_id' => ['required', 'integer', 'exists:pam_metas,id'],
                'accion_id' => ['required', 'integer', 'exists:pam_acciones,id'],
                'cantidad_ejecutada' => ['required', 'integer', 'min:0'],
                'observacion' => ['nullable', 'string', 'max:1000'],
                'archivos_adjuntos.*' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png'], // Max 10MB per file, specific mimes
            ]);

            // Using a database transaction to ensure data consistency
            // If anything fails during saving, everything is rolled back.
            DB::beginTransaction();
            
            // 2. Create the PamAvance record
            $avance = PamAvance::create([
                'fecha_avance' => $validatedData['fecha_avance'],
                'meta_id' => $validatedData['meta_id'],
                'accion_id' => $validatedData['accion_id'],
                'cantidad_ejecutada' => $validatedData['cantidad_ejecutada'],
                'observacion' => $validatedData['observacion'],
            ]);

            // 3. Handle file uploads (if any)
            // if ($request->hasFile('archivos_adjuntos')) {
            //     foreach ($request->file('archivos_adjuntos') as $file) {
            //         // Generate a unique file name
            //         $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            //         // Store the file in the 'public/avances_adjuntos' directory
            //         // The 'public' disk often maps to storage/app/public,
            //         // which needs to be symlinked to public/storage for web access.
            //         $filePath = $file->storeAs('avances_adjuntos', $fileName, 'public');

            //         // RECOMMENDATION: Store file paths in a separate table
            //         // If you haven't created the `pam_avance_archivos` table and model yet,
            //         // you can temporarily store the paths in the 'observacion' field (not ideal for production)
            //         // or just skip this part until you have the dedicated table.

            //         // For now, let's just log it or add a placeholder comment
            //         // In a real application, you'd save this path to your `PamAvanceArchivo` model
            //         // $avance->archivosAdjuntos()->create([
            //         //     'nombre_original' => $file->getClientOriginalName(),
            //         //     'ruta_archivo' => $filePath,
            //         //     'tipo_mime' => $file->getClientMimeType(),
            //         //     'tamano' => $file->getSize(),
            //         // ]);
            //          // For demonstration, we'll just acknowledge the upload
            //         // dd("File stored at: " . $filePath); // For testing file uploads
            //     }
            // }

            DB::commit();

            return response()->json(['message' => 'Avance guardado exitosamente!', 'avance' => $avance], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors specifically
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422); // HTTP 422 Unprocessable Entity
        } catch (Exception $e) {
            // Catch any other unexpected errors
            DB::rollBack(); // Rollback transaction on error
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
        $avances = PamAvance::where('accion_id', $accionId)
                            ->with(['meta', 'accion']) // Load related meta and accion for display
                            ->orderBy('fecha_avance', 'desc') // Order by most recent advances
                            ->get();

        // 3. Transform the data for frontend (optional, but good for consistent display)
        $formattedAvances = $avances->map(function ($avance) {
            return [
                'id' => $avance->id,
                'fecha_avance' => $avance->fecha_avance->format('Y-m-d'), // Format date
                'cantidad_ejecutada' => $avance->cantidad_ejecutada,
                'observacion' => $avance->observacion,
                'meta_descripcion' => $avance->meta->descripcion ?? 'N/A', // Access meta description
                'accion_descripcion' => $avance->accion->descripcion ?? 'N/A', // Access accion description
                // If you have attachments, include them here:
                // 'archivos_adjuntos' => $avance->archivosAdjuntos->map(function($file) {
                //     return [
                //         'id' => $file->id,
                //         'nombre' => $file->nombre_original,
                //         'url' => Storage::url($file->ruta_archivo), // Generate public URL
                //     ];
                // })->toArray(),
            ];
        });

        return response()->json($formattedAvances);
    }

    /**
     * Exportar PAM a Excel
     */
    public function export() {
        $fileName = 'pam_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new PamExport, $fileName);
    }

    // --------------------
    //  Obtencion de registros para selectores
    // --------------------
    
    public function getMetas(Request $request): JsonResponse {
        $query = PamMeta::query();

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

        // Start the query on PamAccion
        $query = PamAccion::query();

        // Join with the 'indicadores' table and then filter by the meta_id
        // Assuming:
        // - PamAccion has an 'indicador_id' foreign key
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


