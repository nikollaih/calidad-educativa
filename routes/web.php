<?php

use \App\Http\Controllers\MunicipioController;
use App\Http\Controllers\ProfileController;
use App\Models\Municipio;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use \App\Http\Controllers\InstitutionController;
use \App\Http\Controllers\EducationalOfferController;
use App\Http\Controllers\PAMController;
use App\Http\Controllers\PMI\PMIController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\AjustesController;
use App\Http\Controllers\ModeloEducacionalController;
use App\Http\Controllers\ModeloPedagogicoController;

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
    $municipios = Municipio::get();
    return view('dashboard', ['municipios' => $municipios]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/get-usuarios', [UserController::class, 'all'])->name('usuarios.all');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
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
        Route::post('institution/{autoevaluacionId}/autoevaluaciones-validar/' , [InstitutionController::class, 'autoevaluacionesValidar'])->name('institution.autoevaluaciones-validar');

        Route::resource('institution'             , InstitutionController::class);
        Route::get('institution/{institutionId}/pei', [InstitutionController::class, 'pei'])->name('institution.pei');
        Route::get('institution/{institutionId}/update-pei', [InstitutionController::class, 'peiManageInformation'])->name('institution.pei.update-pei');
        Route::post('institution/{institutionId}/save-new-pei', [InstitutionController::class, 'updatePei'])
     ->name('update.pei');
        // Rutas para la gestion de sedes
        Route::resource('{institutionId}/sede-with-institution'             , SedeController::class);
        Route::resource('sede', SedeController::class);
        // Rutas para la gestion de ofertas educativas
        Route::get('educational-offer/vinculate/{institutionId}', [EducationalOfferController::class,'vinculationView'])->name('educational-offer.vinculate');
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
        Route::get('/pam-form', [PamController::class, 'create'])->name('pam.create');
        Route::get('/pam-form/{id}', [PamController::class, 'show'])->name('pam.show');
        Route::get('/index', [PamController::class, 'index'])->name('pam.index');

        // Rutas para API/AJAX
        // Route::put('/update-pam/{id}', [PamController::class, 'update'])->name('pam.update');

        Route::get('/get-pam', [PamController::class, 'all'])->name('pam.all');
        // Ruta para obtener un registro específico
        Route::get('/get-pam/{id}', [PamController::class, 'edit'])->name('pam.edit');
        // Ruta para actualizar un registro específico
        Route::put('/update-pam/{id}', [PamController::class, 'update'])->name('pam.update');
        Route::delete('/{id}', [PamController::class, 'destroy'])->name('pam.destroy');
        Route::post('/pam-row-store', [PamController::class, 'store'])->name('pam.store');
    });
    Route::prefix('pei')->group(function () {
        // Route::get('/autoevaluation'             , [PEIController::class, 'autoevaluation']);
    });

    // Rutas relacionadas a municipios
    Route::resource('municipios', MunicipioController::class);
    // Rutas relacionadas a modelos educacionales
    Route::resource('modelos-educacionales', ModeloEducacionalController::class);
    // Rutas relacionadas a modelos pedagogicos
    Route::resource('modelos-pedagogicos', ModeloPedagogicoController::class);
    // Rutas relacionadas a ajustes
    Route::post('/ajustes/actualizar_imagenes_sistema', [AjustesController::class, 'actualizarImagenesSistema'])->name('ajustes.actualizar_imagenes_sistema');
    Route::resource('ajustes', AjustesController::class);
    Route::resource('pmi', PMIController::class);

});

require __DIR__.'/auth.php';
