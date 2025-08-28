<?php

namespace App\Http\Controllers\PMI;

use App\Http\Controllers\Controller;
use App\Http\Services\AutoevaluacionService;
use App\Http\Services\PmiMetaService;
use App\Models\FactorCriticoCalificacion;
use App\Models\PMI\PmiActividad;
use App\Models\PMI\PmiIndicador;
use App\Models\PMI\PmiMeta;
use App\Models\PMI\PmiObjetivo;
use Illuminate\Http\Request;

class PMIObjetivoController extends Controller
{
    public function __construct(
        private PmiMetaService $pmiMetaService,
    ){}

    public function index() {
        $objetivos = PmiObjetivo::paginate(20);
        return view('pmi.objetivos.index', [
            'objetivos' => $objetivos,
        ]);
    }

    public function create() {
        $factoresCriticos = FactorCriticoCalificacion::get();
        $unidadesMedida = PmiIndicador::get();
        return view('pmi.objetivos.create',
            [
                'factoresCriticos' => $factoresCriticos,
                'unidadesMedida' => $unidadesMedida
            ]
        );
    }
    public function edit(int $objetivo_pmi){
        $objetivo = PmiObjetivo::with('metas.actividades')
            ->find($objetivo_pmi);
        if(!$objetivo){
            return redirect()
                ->route('objetivo-pmi.index')
                ->with('flash_error_message', 'objetivo no encontrado.');
        }
        $factoresCriticos = FactorCriticoCalificacion::get();
        $unidadesMedida = PmiIndicador::get();
        return view('pmi.objetivos.edit', [
            'objetivo' => $objetivo,
            'factoresCriticos' => $factoresCriticos,
            'unidadesMedida' => $unidadesMedida

        ]);
    }
    public function show(int $objetivo_pmi)
    {
        $objetivo = PmiObjetivo::with('metas.actividades')
            ->find($objetivo_pmi);
        if(!$objetivo){
            return redirect()
                ->route('objetivo-pmi.index')
                ->with('flash_error_message', 'objetivo no encontrado.');
        }
        $factoresCriticos = FactorCriticoCalificacion::get();
        $unidadesMedida = PmiIndicador::get();
        return view('pmi.objetivos.show', [
            'objetivo' => $objetivo,
            'factoresCriticos' => $factoresCriticos,
            'unidadesMedida' => $unidadesMedida
        ]);
    }
    public function store(Request $request) {
        $input =  $request->all();
        $objetivoData['descripcion'] = $input['descripcion'];
        $objetivoData['factor_id'] = $input['factor_id'];
        $metas = $input['metas'];
        if( isset ($input['id']) && !empty ($input['id'])  ){
            $objetivo = PmiObjetivo::find($input['id']);
            $objetivo->fill($objetivoData);
            $objetivo->save();
        }else{
            $objetivo = PmiObjetivo::create($objetivoData);
        }

        $this->pmiMetaService->syncMetas($metas, $objetivo->id);

        return redirect()
            ->route('objetivo-pmi.index')
            ->with('flash_success_message', 'objetivo creado correctamente.');
    }
}
