<?php

namespace App\Http\Controllers\PMI;

use App\Http\Controllers\Controller;
use App\Http\Services\AdjuntoService;
use App\Models\Autoevaluacion;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PMIController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function index( int $institucionId = null) {
        return view('pmi.index', [
            'institucionId' => $institucionId,
        ]);
    }
    public function create(int $institucionId = null) {
        $autoevaluaciones = Autoevaluacion::where('institucion_id', $institucionId)
            ->where('alias_estado','VALIDACION')
            ->get();
        return view('pmi.create',
        [
            'autoevaluaciones' => $autoevaluaciones,
            'institucionId' => $institucionId,
        ]);
    }
}
