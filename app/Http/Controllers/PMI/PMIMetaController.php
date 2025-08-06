<?php

namespace App\Http\Controllers\PMI;

use App\Http\Controllers\Controller;
use App\Http\Services\AutoevaluacionService;
use App\Models\PMI\PmiActividad;
use App\Models\PMI\PmiMeta;
use Illuminate\Http\Request;

class PMIMetaController extends Controller
{
/*
    public function index() {
        $metas = PmiMeta::paginate(20);
        return view('pmi.metas.index', [
            'metas' => $metas,
        ]);
    }

    public function create() {
        return view('pmi.metas.create');
    }
    public function edit(int $metas_pmi){
        $meta = PmiMeta::with('indicadores.actividades')->findOrFail($metas_pmi);
        return view('pmi.metas.edit', ['meta' =>  $meta]);
    }
    public function store(Request $request) {
        $input =  $request->all();
        $metaData['descripcion'] = $input['descripcion'];
        $metaData['unidad_medida'] = $input['unidad_medida'];
        $metaData['valor_requerido'] = $input['valor_requerido'];
        $indicadores = $input['indicadores'];
        $meta = PmiMeta::create($metaData);
        $this->pmiIndicadorService->syncIndicadores($indicadores, $meta->id);

        return redirect()
            ->route('metas-pmi.index')
            ->with('flash_success_message', 'Meta creada correctamente.');
    }
    /*
    public function store(Request $request, int $institucionId = null) {
        try {
            // Validación manual
            $this->validate($request, [
                'pmi.anio_inicio' => 'required|integer',
                'pmi.anio_fin' => 'required|integer|gte:pmi.anio_inicio',
                'pmi.descripcion' => 'nullable|string',
                'pmi.autoevaluacion_id' => 'required|integer|exists:autoevaluacions,id',
            ], [
                'pmi.anio_fin.gt' => 'El año de fin debe ser mayor que el año de inicio.',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', collect($e->errors())->flatten()->first());
        }
        $pmiData = $request->input('pmi');
        $anioInicio = (int) $pmiData['anio_inicio'];
        $anioFin = (int) $pmiData['anio_fin'];

        // Validar traslape de intervalos de PMIs
        $existeTraslape = Pmi::whereHas('autoevaluacion', function ($query) use ($institucionId) {
            $query->where('institucion_id', $institucionId);
        })
            ->where(function ($query) use ($anioInicio, $anioFin) {
                $query->where('anio_inicio', '<=', $anioFin)
                    ->orWhere('anio_fin', '=>', $anioInicio);
            })
            ->exists();

        if ($existeTraslape) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', 'El intervalo de años se cruza con otro PMI existente para esta institución.');
        }

        $pmiCreated = Pmi::create($pmiData);

        $autoevaluacion = $pmiCreated->autoevaluacion;
        $this->autoevaluacionService->asignarPmiFactoresCriticos(autoevaluacion: $autoevaluacion, pmiId: $pmiCreated->id);

        return redirect()
            ->route('pmi.edit', ['institucionId' => $institucionId, 'pmi' => $pmiCreated->id])
            ->with('flash_success_message', 'PMI creado correctamente.');
    }
    public function edit(Request $request, int $institucionId , int $pmi){
         $pmi = PMI::where('id', $pmi)
             ->with(
                 'factoresCriticos.calificacion.grupo.padre'
             )
             ->first();
        return view('pmi.edit',
            [
                'pmi' => $pmi,
                'institucionId' => $institucionId,
            ]);

    }
    public function editFactorCritico(Request $request, int $institucionId , int $pmi, int $factorCriticoId){
        $factorCritico = FactorCritico::where('id', $factorCriticoId)
            ->with('calificacion.grupo.padre')
            ->firstOrFail();
        return view('pmi.editFactorCritico',
            [
                'factorCritico' => $factorCritico,
                'institucionId' => $institucionId,
                'pmiId' => $pmi,
            ]);

    }
*/
}
