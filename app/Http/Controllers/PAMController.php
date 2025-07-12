<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePamRowRequest;
use App\Models\PamRow;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    public function store(StorePamRowRequest $request) {
        try {
            $pamRow = PamRow::create([
                'pam_id'               => $request->input('pam_id'),
                'user_id'              => $request->input('user_id') ?? auth()->id(),
                'componente'           => $request->input('componente'),
                'proceso'              => $request->input('proceso'),
                'subproceso'           => $request->input('subproceso'),
                'meta_plan_desarrollo' => $request->input('meta_plan_desarrollo'),
                'objetivo_estrategico' => $request->input('objetivo_estrategico'),
                'meta'                 => $request->input('meta'),
                'indicador'            => $request->input('indicador'),
                'accion'               => $request->input('accion'),
                'recursos'             => $request->input('recursos'),
                'fecha_inicio'         => $request->input('fecha_inicio'),
                'fecha_final'          => $request->input('fecha_final'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registro creado correctamente',
                'data' => $pamRow
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el registro',
                'error' => $e->getMessage()
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


