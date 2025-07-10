<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Http\Services\InfraestructuraService;
use App\Http\Services\InventoryService;
use App\Http\Services\MobiliarioService;
use App\Http\Services\SedesService;
use App\Http\Services\SteamClassroomService;
use App\Http\Services\TitularitySedesService;
use App\Models\ModeloPedagogico;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Enums\TitularityTypes;
use App\Models\EducationalModel;
use App\Http\Services\EducationalOfferService;
use App\Http\Services\EducationalModelService;
use App\Models\EducationalOffer;
class SedeController extends Controller
{
    public function __construct(
        private SedesService $sedesService,
        private AdjuntoService $adjuntoService,
        private TitularitySedesService $titularitySedesService,
        private SteamClassroomService $steamClassroomService,
        private InventoryService $inventoryService,
        private InfraestructuraService  $infraestructuraService,
        private MobiliarioService $mobiliarioService,
        private EducationalOfferService $educationalOfferService,
        private EducationalModelService $educationalModelService,
    ){}


    public function index()
    {
        return view('institutional_profile.sede.index');
    }

    public function create(int $institutionId = null)
    {
        $eduactionalModels = EducationalModel::get();
        $modelosPedagogicos = ModeloPedagogico::get();
        $availableSedes = Sede::where('institution_id', $institutionId )->select('name','id')->get();
        return view(
            'institutional_profile.sede.create',
            [
                'institutionId' => $institutionId,
                'availableSedes' => $availableSedes,
                'eduactionalModels' => $eduactionalModels,
                'modelosPedagogicos' => $modelosPedagogicos,
            ]
        );
    }

    public function store(Request $request)
    {
        $sedeData =  $request->input('sede');
        $titularityData = $request->input('titularity');
        $steamClassroomData = $request->input('steam_classroom');
        $inventoryData = $request->input('inventory');
        $infraestructuraData = $request->input('infraestructura');
        $mobiliarioData = $request->input('mobiliario');
        $educationalOfferData =  $request->input('educational_offer');
        $educationalModelsData =  $request->input('educational_models');

        if($request->hasFile('administrative_act_file')){
                // Intenta almacenar el Adjunto
            $storeAdministrativeActResponse = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('administrative_act_file'),
                ruta: 'sedes/'.$sedeData['institution_id'],
                disk: 'public');
            if($storeAdministrativeActResponse->success){
                $sedeData['administrative_act'] = $storeAdministrativeActResponse->data->id;
            }else{
                return redirect()->back()->with('flash_error_message', $storeAdministrativeActResponse->msg);
            }
        }
        if($request->hasFile('titularity_certificate')){
                // Intenta almacenar el Adjunto
            $storeTitularityCertificateResponse = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('titularity_certificate'),
                ruta: 'sedes/'.$sedeData['institution_id'],
                disk: 'public');
            if($storeTitularityCertificateResponse->success){
                $titularityData['support_file_id'] = $storeTitularityCertificateResponse->data->id;
            }else{
                return redirect()->back()->with('flash_error_message', $storeAdministrativeActResponse->msg);
            }
        }else {
            if($titularityData['titularity_type'] != TitularityTypes::EN_ARRIENDO->value)
                return redirect()->back()->with('flash_error_message', "Este tipo de titularidad de sede debe tener un anexo");
        }

        if($request->hasFile('validation_authorization')){
            // Intenta almacenar el Adjunto
            $storeAuthorizationResponse = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('validation_authorization'),
                ruta: 'educational_offer/validation _authorization',
                disk: 'public');
            if($storeAuthorizationResponse->success){
                $educationalOfferData['validation_authorization'] = $storeAuthorizationResponse->data->id;
            }else{
                return redirect()->back()->with('flash_error_message', $storeAuthorizationResponse->msg);
            }
        }


        $sedeCreatedResponse = $this->sedesService->createSede($sedeData);

        if($sedeCreatedResponse->success == false)
                return redirect()->back()->with('flash_error_message', $sedeCreatedResponse->msg);

        $educationalOfferData['sede_id'] = $sedeCreatedResponse->data->id;
        $educationalOfferResponse = $this->educationalOfferService->create($educationalOfferData);

        if($educationalOfferResponse->success == false)
                return redirect()->back()->with('flash_error_message', $educationalOfferResponse->msg);

        $this->educationalModelService->syncEducationalModel($educationalModelsData,$educationalOfferResponse->data->id);
        $titularityData['sede_id'] = $sedeCreatedResponse->data->id;
        $titularityCreatedResponse = $this->titularitySedesService->create($titularityData);

        if($titularityCreatedResponse->success == false)
            return redirect()->back()->with('flash_error_message', $titularityCreatedResponse->msg);

        // Agrega el aula steam en caso de que exista
        if(!empty($steamClassroomData['phase']) && !empty($steamClassroomData['quantity'])){
            $steamClassroomData['sede_id'] = $sedeCreatedResponse->data->id ;
            $steamClassroomResponse =  $this->steamClassroomService->create($steamClassroomData);

            if($steamClassroomResponse->success == false)
                return redirect()->back()->with('flash_error_message', $steamClassroomResponse->msg);
        }
        $this->inventoryService->syncInventory(inventoryArray: $inventoryData, sedeId: $sedeCreatedResponse->data->id);
        $this->infraestructuraService->syncInfraestructura(infraestructuraArray: $infraestructuraData, sedeId: $sedeCreatedResponse->data->id);
        $this->mobiliarioService->syncMobiliarios(mobiliarioArray: $mobiliarioData, sedeId: $sedeCreatedResponse->data->id);
        return redirect()->back()->with('success', 'Sede creada correctamente.');
    }

    public function edit(int $institutionId = null,int $sede = null)
    {
        $sede = Sede::where('id',$sede)->with(
            'administrativeAct',
            'parentSede:id,name,dane',
            'institution:id,nombre,dane',
            'titularidadSede.adjunto',
            'steamClassroom',
            'inventories',
            'infraestructuras',
            'mobiliarios'
        )->first();

        if (empty($sede)){
            return redirect()->back()->with('flash_error_message', 'Sede no encontradaa');
        }
        $educationalOffer = EducationalOffer::where('sede_id',$sede->id)->with('educationalModels','validationAuthorizationAdjunto')->first();
        $eduactionalModels = EducationalModel::get();
        $modelosPedagogicos = ModeloPedagogico::get();

        $availableSedes = Sede::where('institution_id', $institutionId )->select('name','id')->get();

        return view('institutional_profile.sede.edit',
            [
                'sede' => $sede,
                'educationalOffer' => $educationalOffer,
                'eduactionalModels' => $eduactionalModels,
                'modelosPedagogicos' => $modelosPedagogicos,
                'availableSedes'=>$availableSedes
            ]);
    }
    public function show(int $institutionId = null,int $sede = null)
    {
        $sede = Sede::where('id',$sede)->with(
            'administrativeAct',
            'parentSede:id,name,dane',
            'institution:id,nombre,dane',
            'titularidadSede.adjunto',
            'steamClassroom',
            'inventories',
            'infraestructuras',
            'mobiliarios'
        )->first();

        if (empty($sede)){
            return redirect()->back()->with('flash_error_message', 'Sede no encontradaa');
        }
        $educationalOffer = EducationalOffer::where('sede_id',$sede->id)->with('educationalModels','validationAuthorizationAdjunto')->first();
        $eduactionalModels = EducationalModel::get();
        $modelosPedagogicos = ModeloPedagogico::get();
        $availableSedes = Sede::where('institution_id', $institutionId )->select('name','id')->get();

        return view('institutional_profile.sede.show',
            [
                'sede' => $sede,
                'modelosPedagogicos' => $modelosPedagogicos,
                'educationalOffer' => $educationalOffer,
                'eduactionalModels' => $eduactionalModels,
                'availableSedes'=>$availableSedes
            ]);
    }


    public function update(Request $request, int $sede = null)
    {
        $sedeToUpdate = Sede::find($sede);


        if(empty($sedeToUpdate)){
            return redirect()->back()->with('flash_error_message', 'Sede no encontrada');
        }
        $educationalOffer = EducationalOffer::where('sede_id', $sedeToUpdate->id)->with('educationalModels','validationAuthorizationAdjunto')->first();
        if(!empty($educationalOffer)){
            $educationalOfferData =  $request->input('educational_offer');
            $educationalModelsData =  $request->input('educational_models');

            if($request->hasFile('validation_authorization')){
                    // Intenta almacenar el Adjunto
                $storeAuthorizationResponse = $this->adjuntoService->storeAdjunto(
                    adjunto: $request->file('validation_authorization'),
                    ruta: 'educational_offer/validation _authorization',
                    disk: 'public');
                if($storeAuthorizationResponse->success){
                    $educationalOfferData['validation_authorization'] = $storeAuthorizationResponse->data->id;
                }else{
                    return redirect()->back()->with('flash_error_message', $storeAuthorizationResponse->msg);
                }
            }
            $educationalOffer->fill($educationalOfferData);
            $educationalOffer->save();

            $this->educationalModelService->syncEducationalModel($educationalModelsData, $educationalOffer->id);
        }
        $sedeData =  $request->input('sede');

        unset($sedeData['institution_id']);

        if( !isset($sedeData['is_new_school']) )
            $sedeData['is_new_school'] = false ;

        $titularityData = $request->input('titularity');
        $steamClassroomData = $request->input('steam_classroom');
        $inventoryData = $request->input('inventory');
        $infraestructuraData = $request->input('infraestructura');
        $mobiliarioData = $request->input('mobiliario');
        if($request->hasFile('administrative_act_file')){
                // Intenta almacenar el Adjunto
            $storeAdministrativeActResponse = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('administrative_act_file'),
                ruta: 'sedes/'.$sedeToUpdate->institution_id,
                disk: 'public');
            if($storeAdministrativeActResponse->success){
                $sedeData['administrative_act'] = $storeAdministrativeActResponse->data->id;
            }else{
                return redirect()->back()->with('flash_error_message', $storeAdministrativeActResponse->msg);
            }
        }
        if($request->hasFile('titularity_certificate')){
                // Intenta almacenar el Adjunto
            $storeTitularityCertificateResponse = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('titularity_certificate'),
                ruta: 'sedes/'.$sedeToUpdate->institution_id,
                disk: 'public');
            if($storeTitularityCertificateResponse->success){
                $titularityData['support_file_id'] = $storeTitularityCertificateResponse->data->id;
            }else{
                return redirect()->back()->with('flash_error_message', $storeAdministrativeActResponse->msg);
            }
        }

        $sedeToUpdate->fill($sedeData);
        $sedeToUpdate->save();
        $titularityData['sede_id'] = $sedeToUpdate->id;

        if ($sedeToUpdate->titularidadSede) {
            // Update existing record
            $sedeToUpdate->titularidadSede->fill($titularityData);
            $sedeToUpdate->titularidadSede->save();
        } else {
            // Create new related record
            $sedeToUpdate->titularidadSede()->create($titularityData);
        }

        // Agrega el aula steam en caso de que exista
        if(!empty($steamClassroomData['phase']) && !empty($steamClassroomData['quantity'])){
            $steamClassroomData['sede_id'] = $sedeToUpdate->id ;
            if($sedeToUpdate->steamClassroom == null){
                $steamClassroomResponse =  $this->steamClassroomService->create($steamClassroomData);

                if($steamClassroomResponse->success == false)
                    return redirect()->back()->with('flash_error_message', $steamClassroomResponse->msg);
            }else{
                $sedeToUpdate->steamClassroom->fill($steamClassroomData);
                $sedeToUpdate->steamClassroom->save();
            }

        }else{
            $sedeToUpdate?->steamClassroom?->delete();
        }
        $this->inventoryService->syncInventory(inventoryArray: $inventoryData, sedeId: $sedeToUpdate->id);
        $this->infraestructuraService->syncInfraestructura(infraestructuraArray: $infraestructuraData, sedeId: $sedeToUpdate->id);
        $this->mobiliarioService->syncMobiliarios(mobiliarioArray: $mobiliarioData, sedeId: $sedeToUpdate->id);
        return redirect()->route('sede-with-institution.edit', [
            'institutionId' => $sedeToUpdate->institution_id,
            'sede_with_institution' => $sedeToUpdate->id
        ])->with('success', 'Sede actualizada correctamente.');
        //return redirect()->route('sede.edit',['institution'=>$sedeToUpdate->institution_id,  'sede' => $sedeToUpdate->id])->with('success', 'Sede actualizada correctamente.');
    }

    public function destroy(int $sede = null)
    {
        $sedeToDel = Sede::find($sede);
        if(empty($sedeToDel)){
            return redirect()->back()->with('flash_error_message', 'Sede no encontrada');
        }
        $institutionId = $sedeToDel->institution_id;
        $sedeToDel->delete();
        return redirect()->route('institution.show',['institution'=>$institutionId])->with('success', 'Sede eliminada correctamente.');
    }
}
