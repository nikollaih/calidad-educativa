<?php

namespace App\Http\Controllers\PMI;

use App\Http\Controllers\Controller;
use App\Http\Services\AdjuntoService;
use App\Http\Services\AutoevaluacionService;
use App\Models\Autoevaluacion;
use App\Models\Pmi;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PMIController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
        private AutoevaluacionService $autoevaluacionService,
    ){}

    public function index( int $institucionId = null) {
        $pmis = Pmi::whereHas('autoevaluacion', function ($query) use ($institucionId) {
            $query->where('institucion_id', $institucionId);
        })->paginate(20);

        return view('pmi.index', [
            'institucionId' => $institucionId,
            'pmis' => $pmis,
        ]);
    }
    public function create(int $institucionId = null) {

        $autoevaluaciones = Autoevaluacion::where('institucion_id', $institucionId)
            ->where('alias_estado', 'VALIDACION')
            ->whereDoesntHave('pmi')
            ->whereDoesntHave('institucion.autoevaluaciones.pmi', function ($query) {
                $query->whereColumn('autoevaluacions.anio_vigencia', '>=', 'pmis.anio_inicio')
                    ->whereColumn('autoevaluacions.anio_vigencia', '<', 'pmis.anio_fin');
            })
            ->get();
        return view('pmi.create',
        [
            'autoevaluaciones' => $autoevaluaciones,
            'institucionId' => $institucionId,
        ]);
    }
    public function store(Request $request, int $institucionId = null) {
        $pmiData = $request->input('pmi');

        $pmiCreated = Pmi::create($pmiData);

        $autoevaluacion = $pmiCreated->autoevaluacion;
        $this->autoevaluacionService->asignarPmiFactoresCriticos(autoevaluacion: $autoevaluacion, pmiId: $pmiCreated->id);

        return redirect()
            ->route('pmi.edit', ['institucionId' => $institucionId, 'pmi' => $pmiCreated->id])
            ->with('flash_success_message', 'Modelo educacional creado correctamente.');
    }
    public function edit(Request $request, int $institucionId , int $pmi){
         $pmi = PMI::where('id', $pmi)
             ->with(
                 'factoresCriticos.grupoCalificacion.padre'
             )
             ->first();
        return  $pmi;

    }
}
