<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePamRowRequest;
use App\Models\PamRow;
use Illuminate\Http\Request;

class PamController extends Controller {
    public function index() {
        return view('pam.index');
    }

    /**
     * Crea registros del pam
     */
    public function store(StorePamRowRequest $request) {
        try {
            $pamRow = PamRow::create([
                'pam_id'               => $request->input('pam_id'),
                'user_id'              => $request->input('user_id', auth()->id()),
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
}
