<?php

namespace App\Http\Controllers\PMI;

use App\Http\Controllers\Controller;
use App\Http\Services\AdjuntoService;
use App\Http\Services\AutoevaluacionService;
use App\Http\Services\PMI\PmiObjetivoVinculadoService;
use App\Models\Autoevaluacion;
use App\Models\FactorCritico;
use App\Models\Pmi;
use App\Models\PMI\PmiObjetivo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PMIController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
        private AutoevaluacionService $autoevaluacionService,
        private PmiObjetivoVinculadoService $objetivoVinculadoService,
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
                 'factoresCriticos.calificacion.grupo.padre',
                 'factoresCriticos.objetivos.metas.actividades'
             )
             ->first();
        return view('pmi.edit',
            [
                'pmi' => $pmi,
                'institucionId' => $institucionId,
            ]);

    }
    public function editFactorCritico(Request $request, int $institucionId , int $pmi, int $factorCriticoId){
        $objetivos = PmiObjetivo::with('metas.actividades')->get();
        $factorCritico = FactorCritico::where('id', $factorCriticoId)
            ->with([
                'calificacion.grupo.padre',
                'objetivos.metas.actividades'
            ])
            ->firstOrFail();
        return view('pmi.editFactorCritico',
            [
                'factorCritico' => $factorCritico,
                'institucionId' => $institucionId,
                'pmiId' => $pmi,
                'objetivos' => $objetivos,
            ]);

    }
    public function actualizarFactorCritico(Request $request, int $institucionId , int $pmi,  int $factorCriticoId){
        $factorCritico = FactorCritico::where('id', $factorCriticoId)
            ->with('calificacion.grupo.padre')
            ->first();

        if (!$factorCritico) {
            return redirect()
                ->route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmi ])
                ->with('flash_error_message', 'Factor critico no encontrado.');
        }
        $this->objetivoVinculadoService
            ->syncObjetivosVinculados( objetivosArray: $request->input('objetivos'), idFactorCritico: $factorCritico->id );

        return redirect()
            ->route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmi ])
            ->with('flash_success_message', 'Factor critico actualizad correctamente.');
    }
}
