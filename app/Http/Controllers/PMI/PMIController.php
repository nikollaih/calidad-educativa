<?php

namespace App\Http\Controllers\PMI;

use App\Http\Controllers\Controller;
use App\Http\Services\AdjuntoService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PMIController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function index()
    {
        return view('pmi.index');
    }
}
