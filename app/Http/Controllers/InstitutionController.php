<?php

namespace App\Http\Controllers;

use App\Http\Resources\UpdatePeiResource;
use App\Http\Services\AdjuntoService;
use App\Http\Services\RedesSocialesService;
use App\Models\Autoevaluacion;
use App\Models\GestionAcademica;
use App\Models\GestionAdministrativa;
use App\Models\GestionComunidad;
use App\Models\GestionDirectiva;
use App\Models\GrupoCalificacion;
use App\Models\Institucion;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
        private RedesSocialesService $redesSocialesService
    ){}

    public function index()
    {
        $paginate = Institucion::with('licenciaFuncionamiento','redesSociales')
            ->paginate('10');
        return view(
            'institutional_profile.institution.index',
            [
                'paginate' =>$paginate
            ]
        );
    }

    public function autoevaluaciones(int $institution = null)
    {
        $autoevaluaciones = Autoevaluacion::where('institucion_id',$institution)->get();
       // $roles = Role::all();
        return view('institutional_profile.institution.autoevaluaciones.index',
            ['institutionId' => $institution, 'autoevaluaciones' => $autoevaluaciones]);
    }
    public function autoevaluacionesCrear(int $institution = null)
    {
        $gruposCalificaciones = GrupoCalificacion::with(['hijos.calificaciones', 'hijos.calificaciones.notasCalificacion', 'calificaciones'])
            ->whereNull('padre_id')
            ->get();
        $autoevaluacionesAniosDisabled = Autoevaluacion::where('institucion_id',$institution)->pluck('anio_vigencia');
        // $roles = Role::all();
        return view('institutional_profile.institution.autoevaluaciones.create',
            [
                'institutionId' => $institution,
                'gruposCalificaciones' => $gruposCalificaciones,
                'aniosDisabled' => $autoevaluacionesAniosDisabled,
            ]
        );
    }
    public function autoevaluacionesEditar(int $autoevaluacionId = null)
    {
        $autoevaluacion = Autoevaluacion::with('notas','notas.calificacion')->where('id', $autoevaluacionId)->first();
        if(empty($autoevaluacionId)){
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');
        }
        $gruposCalificaciones = GrupoCalificacion::with(['hijos.calificaciones', 'hijos.calificaciones.notasCalificacion', 'calificaciones'])
            ->whereNull('padre_id')
            ->get();
        return view('institutional_profile.institution.autoevaluaciones.editar',
            [
                'gruposCalificaciones' => $gruposCalificaciones,
                'autoevaluacion' => $autoevaluacion,
            ]
        );
    }
    public function autoevaluacionesVer(int $autoevaluacionId = null)
    {
        $autoevaluacion = Autoevaluacion::with('notas','notas.calificacion')->where('id', $autoevaluacionId)->first();
        if(empty($autoevaluacionId)){
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');
        }
        $gruposCalificaciones = GrupoCalificacion::with(['hijos.calificaciones', 'hijos.calificaciones.notasCalificacion', 'calificaciones'])
            ->whereNull('padre_id')
            ->get();
        return view('institutional_profile.institution.autoevaluaciones.ver',
            [
                'gruposCalificaciones' => $gruposCalificaciones,
                'autoevaluacion' => $autoevaluacion,
            ]
        );
    }
    public function autoevaluacionesAlmacenar(Request $request)
    {
        $autoevaluacionData =  $request->input('autoevaluacion');
        $autoevaluacionData['alias_estado'] = "PROCESO";
        $notas = $request->input('notas');

        $autoevaluacionOld = Autoevaluacion::where($autoevaluacionData)->first();
        if($autoevaluacionOld)
            return redirect()->route('institution.autoevaluaciones',  ['institution' => $autoevaluacionOld->institucion_id])->with('flash_error_message', "Error! ya existe una  autoevaluación con esa vigencia");

        $autoevaluacion = Autoevaluacion::create($autoevaluacionData);

        if($notas){
            $syncData = [];

            foreach ($notas as $nota) {
                $syncData[$nota['nota_calificacion_id']] = ['evidencia' => $nota['evidencia']];
            }
            $autoevaluacion->notas()->sync($syncData);
        }
        return redirect()->route('institution.autoevaluaciones',  ['institution' => $autoevaluacion->institucion_id])->with('flash_success_message', "Autoevaluación creada correctamente");

    }
    public function autoevaluacionesAlmacenarActualizacion(Request $request, int $autoevaluacionId = null)
    {
        $autoevaluacion = Autoevaluacion::find($autoevaluacionId);
        $notas = $request->input('notas');

        if(!$autoevaluacion)
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');

        if($notas){
            $syncData = [];

            foreach ($notas as $nota) {
                $syncData[$nota['nota_calificacion_id']] = ['evidencia' => $nota['evidencia']];
            }
            $autoevaluacion->notas()->sync($syncData);
        }
        return redirect()->route('institution.autoevaluaciones',  ['institution' => $autoevaluacion->institucion_id])->with('flash_success_message', "Autoevaluación actualizada correctamente");

    }
    public function create()
    {
       // $roles = Role::all();
        return view('institutional_profile.institution.create');
    }

    public function store(Request $request)
    {

        // Valida si hay un file de licencia de funcionamiento
        if (!$request->hasFile('licencia_funcionamiento')) {
            return redirect()->route('institution.create')->with('flash_error_message', 'Se debe seleccionar una licencia de funcionamiento.');
        }

        // Intenta almacenar el Adjunto
        $storeAdjuntoResponse = $this->adjuntoService->storeAdjunto($request->file('licencia_funcionamiento'),'institucion/licencia_funcionamiento','public');

        if ($storeAdjuntoResponse->success == false){
            return redirect()->route('institution.create')->with('flash_error_message', $storeAdjuntoResponse->msg);
        }
        $institutionData = $request->all();
        $institutionData['licencia_funcionamiento'] = $storeAdjuntoResponse->data->id;
        // Crea la institucion
        $institutionCreated = Institucion::create($institutionData);
        $createPei = ['institution_id' => $institutionCreated->id];
        // crea las gestiones de PEI
        GestionAcademica::create($createPei);
        GestionComunidad::create($createPei);
        GestionDirectiva::create($createPei);
        GestionAdministrativa::create($createPei);
        // Sincroniza las redes sociales de la institucion
        $this->redesSocialesService->syncRedesSociales($institutionData['redes_sociales'],$institutionCreated);


        return redirect()->back()->with('flash_success_message', 'Institución creada correctamente.');
    }

    public function edit(int $institucion)
    {

        $institucion = Institucion::with(
            'licenciaFuncionamiento',
            'redesSociales',
            'sedes.levelSedeEducational.educationalLevel',
            'sedes.levelSedeEducational.schedule',
            'sedes.levelSedeEducational.schedule.anexo',
            'sedes.educationalOffer'
            )
            ->where('id',$institucion)
            ->first();
         if (!$institucion) {
            return redirect()->back()->with('flash_error_message', 'Institución no encontrada.');
         }
        return view('institutional_profile.institution.edit', ['institution' => $institucion]);
    }

    public function update(Request $request, int $institucion)
    {
         $institucionToUpdate = Institucion::with('redesSociales')
            ->where('id', $institucion)
            ->first();

         if (!$institucionToUpdate) {
            return redirect()->back()->with('flash_error_message', 'Institución no encontrada.');
         }

         $institutionData = $request->all();

         if ($request->hasFile('licencia_funcionamiento')) {
            $storeAdjuntoResponse = $this->adjuntoService->storeAdjunto($request->file('licencia_funcionamiento'),'institucion/licencia_funcionamiento','public');
             if ($storeAdjuntoResponse->success == false){
                return redirect()->route('institution.create')->with('flash_error_message', $storeAdjuntoResponse->msg);
             }
            $institutionData['licencia_funcionamiento'] = $storeAdjuntoResponse->data->id;
         }
         $institucionToUpdate->fill($institutionData);
         $institucionToUpdate->save();
         $this->redesSocialesService->syncRedesSociales($institutionData['redes_sociales'], $institucionToUpdate);

        return redirect()->route('institution.edit',$institucion)->with('success', 'Institución actualizada correctamente.');
    }

    public function destroy(int $institucion)
    {
         $institucionToDel = Institucion::find($institucion);
         if (!$institucionToDel) {
            return redirect()->back()->with('flash_error_message', 'Institución no encontrada.');
         }

         $institucionToDel->redesSociales()->delete();
         $institucionToDel->delete();
         return redirect()->back()->with('success', 'Institución Eliminada correctamente.');
    }

    public function show(int $institucion)
    {
        return redirect()->back()->with('success', 'Institución actualizada correctamente.');
    }

    public function pei(int $institucion) {
        $institucionData = Institucion::with([
                'gestionDirectiva',
                'gestionAcademica',
                'gestionComunidad',
                'gestionAdministrativa',
            ])
            ->where('id', $institucion)
            ->first();

         if (!$institucionData) {
            return redirect()->back()->with('flash_error_message', 'Institución no encontrada.');
         }

        return view('institutional_profile.institution.pei', [
            'gestion_directiva' => $institucionData->gestionDirectiva ?? null,
            'gestion_academica' => $institucionData->gestionAcademica ?? null,
            'gestion_comunidad' => $institucionData->gestionComunidad ?? null,
            'gestion_administrativa' => $institucionData->gestionAdministrativa ?? null,
        ]);
    }

    public function peiManageInformation(int $institucion) {
        $institucionData = Institucion::with([
                'gestionDirectiva',
                'gestionAcademica',
                'gestionComunidad',
                'gestionAdministrativa',
            ])
            ->where('id', $institucion)
            ->first();

        return view('institutional_profile.institution.pei.update_pei', [
            'institucionData' => new UpdatePeiResource($institucionData),
            'institucionId' => $institucion,
        ]);
    }
}
