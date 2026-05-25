<?php

use App\Http\Controllers\AjustesController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\EducationalOfferController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ModeloEducacionalController;
use App\Http\Controllers\ModeloPedagogicoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PAMController;
use App\Http\Controllers\PAMGeneralController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PMI\IndicadoresController;
use App\Http\Controllers\PMI\PMIController;
use App\Http\Controllers\PMI\PMIObjetivoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectoTransversalActividadesController;
use App\Http\Controllers\ProyectoTransversalController;
use App\Http\Controllers\ProyectoTransversalIntegrantesController;
use App\Http\Controllers\RedesActividadesController;
use App\Http\Controllers\RedesAprendizajeController;
use App\Http\Controllers\RedesIntegrantesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\UnidadMetaController;
use App\Http\Controllers\UserController;
use App\Models\Municipio;
use App\Models\Institucion;
use App\Models\Sede;
use App\Models\Pmi;
use App\Models\Autoevaluacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/dashboard', function () {
    $user = Auth::user();
    $isRector = $user->hasRole('rector');
    $canSeeAll = $user->hasRole('super_admin') || $user->hasRole('administrador');

    if (!$canSeeAll && !$isRector) {
       return redirect()->route('institution.index');
    }

    if ($isRector) {
        $institucion = $user->institucion;

        if (!$institucion) {
            return redirect()->route('institution.index')
                ->with('flash_error_message', 'No tienes una institución asociada.');
        }

        $institucionId = $institucion->id;

        $institucionesCount = 1;
        $sedesCount = Sede::where('institution_id', $institucionId)->count();
        $avgSedesPorInstitucion = $sedesCount;

        $pmiTotal = Pmi::whereHas('autoevaluacion', fn($q) => $q->where('institucion_id', $institucionId))->count();
        $pmiPorEstado = Pmi::select('estado', DB::raw('count(*) as total'))
            ->whereHas('autoevaluacion', fn($q) => $q->where('institucion_id', $institucionId))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $topMunicipiosInstituciones = collect([
            ['nombre' => $institucion->municipio?->nombre ?? 'Sin municipio', 'total' => 1],
        ]);

        $autoevaluacionesTotal = Autoevaluacion::where('institucion_id', $institucionId)->count();
        $autoevaluacionesPorEstado = Autoevaluacion::select('alias_estado', DB::raw('count(*) as total'))
            ->where('institucion_id', $institucionId)
            ->groupBy('alias_estado')
            ->pluck('total', 'alias_estado');

        $topMunicipiosSedes = DB::table('sedes')
            ->join('institucions', 'sedes.institution_id', '=', 'institucions.id')
            ->join('municipios', 'institucions.municipio_id', '=', 'municipios.id')
            ->where('sedes.institution_id', $institucionId)
            ->select('municipios.nombre as nombre', DB::raw('count(sedes.id) as total'))
            ->groupBy('municipios.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    } else {
        $institucionesCount = Institucion::count();
        $sedesCount = Sede::count();
        $avgSedesPorInstitucion = $institucionesCount > 0 ? round($sedesCount / $institucionesCount, 2) : 0;

        $pmiTotal = Pmi::count();
        $pmiPorEstado = Pmi::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $topMunicipiosInstituciones = Institucion::select('municipio_id', DB::raw('count(*) as total'))
            ->with('municipio')
            ->groupBy('municipio_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                return [
                    'nombre' => $row->municipio?->nombre ?? 'Sin municipio',
                    'total' => (int) $row->total,
                ];
            });

        $autoevaluacionesTotal = Autoevaluacion::count();
        $autoevaluacionesPorEstado = Autoevaluacion::select('alias_estado', DB::raw('count(*) as total'))
            ->groupBy('alias_estado')
            ->pluck('total', 'alias_estado');

        $topMunicipiosSedes = DB::table('sedes')
            ->join('institucions', 'sedes.institution_id', '=', 'institucions.id')
            ->join('municipios', 'institucions.municipio_id', '=', 'municipios.id')
            ->select('municipios.nombre as nombre', DB::raw('count(sedes.id) as total'))
            ->groupBy('municipios.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }

    $pmiAprobados = $pmiPorEstado['Aprobado'] ?? 0;
    $pmiPresentados = $pmiPorEstado['Presentado'] ?? 0;
    $pmiProceso = $pmiPorEstado['Proceso'] ?? 0;

    $porcAprobados = $pmiTotal > 0 ? round(($pmiAprobados / $pmiTotal) * 100, 1) : 0;
    $porcPresentados = $pmiTotal > 0 ? round(($pmiPresentados / $pmiTotal) * 100, 1) : 0;
    $porcProceso = $pmiTotal > 0 ? round(($pmiProceso / $pmiTotal) * 100, 1) : 0;

    $autoProceso = $autoevaluacionesPorEstado['PROCESO'] ?? 0;
    $autoValidacion = $autoevaluacionesPorEstado['VALIDACION'] ?? 0;

    $municipios = Municipio::get();

    return view('dashboard', [
        'municipios' => $municipios,
        'stats' => [
            'instituciones' => $institucionesCount,
            'sedes' => $sedesCount,
            'promedio_sedes_por_institucion' => $avgSedesPorInstitucion,
            'pmi_total' => $pmiTotal,
            'pmi_aprobados' => $pmiAprobados,
            'pmi_presentados' => $pmiPresentados,
            'pmi_proceso' => $pmiProceso,
            'porc_aprobados' => $porcAprobados,
            'porc_presentados' => $porcPresentados,
            'porc_proceso' => $porcProceso,
            'autoevaluaciones_total' => $autoevaluacionesTotal,
            'autoevaluaciones_proceso' => $autoProceso,
            'autoevaluaciones_validacion' => $autoValidacion,
        ],
        'charts' => [
            'pmi_por_estado' => [
                'labels' => array_values(['Proceso','Presentado','Aprobado']),
                'series' => [
                    (int) ($pmiPorEstado['Proceso'] ?? 0),
                    (int) ($pmiPorEstado['Presentado'] ?? 0),
                    (int) ($pmiPorEstado['Aprobado'] ?? 0),
                ],
            ],
            'instituciones_por_municipio' => [
                'labels' => $topMunicipiosInstituciones->pluck('nombre')->values(),
                'series' => $topMunicipiosInstituciones->pluck('total')->values(),
            ],
            'autoevaluaciones_por_estado' => [
                'labels' => array_values($autoevaluacionesPorEstado->keys()->toArray()),
                'series' => array_values($autoevaluacionesPorEstado->toArray()),
            ],
            'sedes_por_municipio' => [
                'labels' => $topMunicipiosSedes->pluck('nombre')->values(),
                'series' => $topMunicipiosSedes->pluck('total')->values(),
            ],
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::prefix('usuarios-institucion')->group(function () {
        Route::get('/', [InstitutionController::class, 'usuariosInstitucionByRector'])->name('instituciones.usuarios_institucion-index');
        Route::get('/create', [InstitutionController::class, 'createUsuariosInstitucion'])->name('instituciones.usuarios_institucion-create');
        Route::post('/', [InstitutionController::class, 'storeUsuariosInstitucion'])->name('instituciones.usuarios_institucion-store');
        Route::get('/{userId}', [InstitutionController::class, 'editUsuarioInstitucion'])->name('instituciones.usuarios_institucion-edit');
        Route::patch('/{user}', [InstitutionController::class, 'updateUsuariosInstitucion'])->name('instituciones.usuarios_institucion-update');
        Route::delete('/{user}', [InstitutionController::class, 'deleteUsuarioInstitucion'])->name('instituciones.usuarios_institucion-delete');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/get-usuarios', [UserController::class, 'all'])->name('usuarios.all');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::get('/get-componentes', [ComponenteController::class, 'all'])->name('componentes.all');
    Route::get('/get-instituciones', [InstitutionController::class, 'all'])->name('instituciones.all');
    Route::get('/get-roles', [RoleController::class, 'all'])->name('roles.all');
    Route::get('/get-redes-aprendizajes', [RedesAprendizajeController::class, 'all'])->name('redesAprendizajes.all');
    Route::get('/get-unidades-meta', [UnidadMetaController::class, 'all'])->name('unidades-meta.all');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::patch('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{role}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::patch('/permissions/{role}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{role}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::prefix('institutional_profile')->group(function () {
        // Rutas para la gestion de fortalezas y debilidades
        Route::get('institution/{autoevaluacionId}/fort_deb'             , [InstitutionController::class, 'fortalezasDebilidades'])->name('institution.fort_deb');
        Route::post('institution/{autoevaluacionId}/fort_deb'             , [InstitutionController::class, 'sincronizarFactoresCriticos'])->name('institution.fort_deb-save');

        // Rutas para la gestion de instituciones
        Route::get('institution/{institution}/autoevaluaciones'             , [InstitutionController::class, 'autoevaluaciones'])->name('institution.autoevaluaciones');
        Route::get('institution/{institution}/autoevaluaciones-crear'             , [InstitutionController::class, 'autoevaluacionesCrear'])->name('institution.autoevaluaciones-crear');
        Route::get('institution/{autoevaluacionId}/autoevaluaciones-editar'            , [InstitutionController::class, 'autoevaluacionesEditar'])->name('institution.autoevaluaciones-editar');
        Route::get('institution/{autoevaluacionId}/autoevaluaciones-ver'            , [InstitutionController::class, 'autoevaluacionesVer'])->name('institution.autoevaluaciones-ver');
        Route::post('institution/{institution}/autoevaluaciones-almacenar'        , [InstitutionController::class, 'autoevaluacionesAlmacenar'])->name('institution.autoevaluaciones-almacenar');
        Route::post('institution/{autoevaluacionId}/autoevaluaciones-actualizar/' , [InstitutionController::class, 'autoevaluacionesAlmacenarActualizacion'])->name('institution.autoevaluaciones-actualizar');
        Route::post('institution/{autoevaluacionId}/autoevaluaciones-actualizar-hijo/{hijoId}' , [InstitutionController::class, 'autoevaluacionesActualizarHijo'])->name('institution.autoevaluaciones-actualizar-hijo');
        Route::post('institution/{autoevaluacionId}/autoevaluaciones-validar/' , [InstitutionController::class, 'autoevaluacionesValidar'])->name('institution.autoevaluaciones-validar');

        Route::resource('institution'             , InstitutionController::class);
        Route::get('{institutionId}/proyectos-transversales', [ProyectoTransversalController::class, 'index'])->name('proyectos_transversales.index');
        Route::get('institution/{institutionId}/pei', [InstitutionController::class, 'pei'])->name('institution.pei');
        Route::get('institution/{institutionId}/update-pei', [InstitutionController::class, 'peiManageInformation'])->name('institution.pei.update-pei');
        Route::post('institution/{institutionId}/save-new-pei', [InstitutionController::class, 'updatePei'])
     ->name('update.pei');
        // Rutas para la gestion de sedes
        Route::resource('{institutionId}/sede-with-institution'             , SedeController::class);
        Route::resource('sede', SedeController::class);
        // Rutas para la gestion de ofertas educativas
        Route::get('educational-offer/vinculate/{institutionId}/{sedeId}', [EducationalOfferController::class,'vinculationView'])->name('educational-offer.vinculate');
        Route::get('educational-offer/vinculate-show/{levelSedeId}', [EducationalOfferController::class,'vinculationShow'])->name('educational-offer.vinculate-show');
        Route::get('educational-offer/vinculate-edit/{levelSedeId}', [EducationalOfferController::class,'vinculationEdit'])->name('educational-offer.vinculate-edit');
        Route::delete('educational-offer/vinculate-destroy/{levelSedeId}', [EducationalOfferController::class,'vinculationDestroy'])->name('educational-offer.vinculate-destroy');
        Route::post('educational-offer/makeVinculation/{sedeId}', [EducationalOfferController::class,'makeVinculation'])->name('educational-offer.make-vinculation');
        Route::put('/educational-offer/vinculation/{levelSede}', [EducationalOfferController::class, 'updateVinculation'])->name('educational-offer.update-vinculation');
        Route::resource('educational-offer'             , EducationalOfferController::class);

        /*Route::resource('institution/{institutionId}/pei/executive-management', GestionDirectivaController::class);
        Route::resource('institution/{institutionId}/pei/academic-management', GestionAcademicaController::class);
        Route::resource('institution/{institutionId}/pei/community-management', GestionComunidadController::class);
        Route::resource('institution/{institutionId}/pei/administrative-management', GestionAdministrativaController::class);
        */
    });
    Route::prefix('pam')->group(function () {
        // Vistas ------------------
        // Visualiza formulario para crear filas del pam
        // Visualiza el index del pam
        Route::get('/{pamId}/pam-form', [PAMController::class, 'create'])->name('pam.create');
        Route::get('/pam-form/{id}', [PAMController::class, 'show'])->name('pam.show');
        Route::get('/{pamId}/index', [PAMController::class, 'index'])->name('pam.index');

        Route::get('/{pamId}/get-pam', [PAMController::class, 'all'])->name('pam.all');
        // Ruta para obtener un registro específico
        Route::get('/get-pam/{id}', [PAMController::class, 'edit'])->name('pam.edit');
        Route::get('/get-metas', [PAMController::class, 'getMetas'])->name('pam.get-metas');
        Route::get('/get-acciones', [PAMController::class, 'getAcciones'])->name('pam.get-acciones');
        Route::get('/get-avances-by-accion/{accionId}', [PAMController::class, 'getAvancesPorAccion'])->name('pam.get-acciones');
        Route::get('/{pamGeneralId}/export', [PAMController::class, 'export'])->name('pam.export');
        // Ruta para actualizar un registro específico
        Route::put('/update-pam/{id}', [PAMController::class, 'update'])->name('pam.update');
        Route::delete('/{id}', [PAMController::class, 'destroy'])->name('pam.destroy');
        Route::post('/{pamGeneralId}/pam-row-store', [PAMController::class, 'store'])->name('pam.store');
        Route::post('/store-advance', [PAMController::class, 'storeAvance'])->name('pam.store-avance');
        Route::get('/{pamGeneralId}/tabla-completa-pam', [PAMController::class, 'vistaCompleta'])->name('pam.vista-completa');
    });
    Route::prefix('pams')->group(function () {
        // Vistas ------------------
        // Visualiza formulario para crear filas del pam
        // Visualiza el index del pam
        Route::get('/create', [PAMGeneralController::class, 'create'])->name('pams.create');
        Route::get('/index', [PAMGeneralController::class, 'index'])->name('pams.index');

        Route::delete('/{id}', [PAMGeneralController::class, 'destroy'])->name('pams.destroy');
        Route::post('/store', [PAMGeneralController::class, 'store'])->name('pams.store');
        Route::get('/{id}/edit', [PAMGeneralController::class, 'edit'])->name('pams.edit');
        Route::put('/{id}', [PAMGeneralController::class, 'update'])->name('pams.update');
        Route::post('/{pamId}/presentar', [PAMGeneralController::class, 'presentarPam'])
        ->name('pam.presentar-pam');
    });
    Route::prefix('pei')->group(function () {
        // Route::get('/autoevaluation'             , [PEIController::class, 'autoevaluation']);
    });

    // Rutas relacionadas a municipios
    Route::resource('municipios', MunicipioController::class);
    // Rutas relacionadas a modelos educacionales
    Route::resource('modelos-educacionales', ModeloEducacionalController::class);
    // Rutas relacionadas a unidades de meta
    Route::resource('unidades-meta', UnidadMetaController::class);
    // Rutas relacionadas a componentes
    Route::resource('componentes', ComponenteController::class);
    // Rutas relacionadas a modelos pedagogicos
    Route::resource('modelos-pedagogicos', ModeloPedagogicoController::class);
    // Rutas relacionadas a redes de aprendizaje
    Route::resource('redes-aprendizajes', RedesAprendizajeController::class);
    // Rutas relacionadas a las actividades de redes
    Route::resource('red-actividades', RedesActividadesController::class);
    // Rutas relacionadas a las actividades de redes
    Route::resource('{proyectoTransversalId}/proyecto-transversal-actividades', ProyectoTransversalActividadesController::class);
    // Rutas relacionadas a los integrantes de redes
    Route::resource('{proyectoTransversalId}/proyecto-transversal-integrantes', ProyectoTransversalIntegrantesController::class);
    // Rutas relacionadas a los integrantes de redes
    Route::resource('red-integrantes', RedesIntegrantesController::class);
    // Rutas relacionadas a ajustes
    Route::post('/ajustes/actualizar_imagenes_sistema', [AjustesController::class, 'actualizarImagenesSistema'])->name('ajustes.actualizar_imagenes_sistema');
    Route::resource('ajustes', AjustesController::class);
    // Ruta para obtener las actividades e integrantes de una red de aprendizaje para ver en detalle
    Route::get('/get-actividades-integrantes/{redAprendizajeId}',[RedesAprendizajeController::class, 'getActividadesIntegrantes'])->name('red-aprendizaje.get-all');
    // Ruta para ver la lista de pmis en estado de validacion (vista para el rol de secretaria)
    Route::get('/pmi/validacion',[PMIController::class, 'pmiValidacion'])->name('pmi.validacion');
    // Ruta para ver el detalle de un pmi y enfocado a validarlo
    Route::get('/pmi/validacion/{pmiId}',[PMIController::class, 'pmiValidar'])->name('pmi.validar');
    // Ruta para marcar un comentario pmi como resuelto
    Route::post('/pmi/validacion/{pmiId}/marcar-resuelto/{comentarioId}',[PMIController::class, 'pmiMarcarComentarioResuelto'])->name('pmi.comentario-marcar_resuelto');
    // Ruta para registrar comentarios en un pmi
    Route::post('/pmi/validacion/{pmiId}/almacenar-comentario',[PMIController::class, 'pmiAlmacenarComentario'])->name('pmi.validar');
    // Ruta para eliminar el comentario de un pmi
    Route::post('/pmi/validacion/{pmiId}/eliminar-comentario/{comentarioId}',[PMIController::class, 'pmiEliminarComentario'])->name('pmi.eliminar');
    // Ruta para cambiar el estado de un pmi
    Route::post('/pmi/validacion/{pmiId}/cambiar-estado',[PMIController::class, 'pmiCambiarEstado'])->name('pmi.cambiar_estado');
    // Ruta para exportar un pmi a excel
    Route::get('/pmi/exportar/{pmiId}',[PMIController::class, 'exportarPmi'])->name('pmi.exportar');
    // Ruta para exportar un pmi a excel
    Route::get('/pmi/exportar/{pmiId}',[PMIController::class, 'exportarPmi'])->name('pmi.exportar');
    // Ruta para exportar  la sintesis de seguimiento  de un pmi a excel
    Route::get('/pmi/exportar/sintesis/{pmiId}',[PMIController::class, 'exportarSintesisPmi'])->name('pmi.exportar-sintesis');
    // Ruta para exportar  la evaluacion de resultados  de un pmi a excel
    Route::get('/pmi/exportar/evaluacion/{pmiId}',[PMIController::class, 'exportarEvaluacionPmi'])->name('pmi.exportar-evaluacion');
    // Ruta para exportar  el cumplimiento de objetivos  de un pmi a excel
    Route::get('/pmi/exportar/cumplimiento/{pmiId}',[PMIController::class, 'exportarCumplimientoPmi'])->name('pmi.exportar-cumplimiento');
    // Ruta que obtiene las actividades de un pmi
    Route::get('/pmi/get-actividades/{pmiId}',[PMIController::class, 'actividadesByPmi'])->name('pmi.get-actividades');
    // Ruta que obtiene la lista de avances de una actividad
    Route::get('/pmi/get-avances-actividad/{actividadId}',[PMIController::class, 'avancesActividadByActividadId'])->name('pmi.get-avances-actividad');
    // Ruta para registrar un avance de pmi
    Route::post('/pmi/guardar-avance-actividad', [PMIController::class, 'storeActividadAvance'])->name('pmi.guardar-avance-actividad');
    Route::post('/{institucionId}/pmi/{pmi}/edit/factor-critico/{factorCriticoId}',[PMIController::class, 'actualizarFactorCritico'])
        ->name('pmi.actualizar-factor-critico');
    Route::get('/{institucionId}/pmi/{pmi}/edit/factor-critico/{factorCriticoId}',[PMIController::class, 'editFactorCritico'])
        ->name('pmi.edit-factor-critico');
    Route::post('/{institucionId}/pmi/{pmiId}/presentar', [PMIController::class, 'presentarPmi'])
        ->name('pmi.presentar-pmi');

    Route::resource('/{institucionId}/pmi', PMIController::class);
    Route::resource('objetivo-pmi', PMIObjetivoController::class);
    Route::resource('indicadores-pmi',IndicadoresController::class);
    // Gestion de proyectos transversales
    Route::resource('/{institucionId}/proyectos-transversales', ProyectoTransversalController::class);
});

require __DIR__.'/auth.php';
