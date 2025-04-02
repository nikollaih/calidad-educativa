<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Http\Services\InventoryService;
use App\Http\Services\SedesService;
use App\Http\Services\SteamClassroomService;
use App\Http\Services\TitularitySedesService;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Enums\TitularityTypes;

class SedeController extends Controller
{
    public function __construct(
        private SedesService $sedesService,
        private AdjuntoService $adjuntoService,
        private TitularitySedesService $titularitySedesService,
        private SteamClassroomService $steamClassroomService,
        private InventoryService $inventoryService,
    ){}


    public function index()
    {
        return view('institutional_profile.sede.index');
    }

    public function create(int $institutionId = null)
    {
        $availableSedes = Sede::select('name','id')->get();
        return view('institutional_profile.sede.create',['institutionId' => $institutionId, 'availableSedes' => $availableSedes]);
    }

    public function store(Request $request)
    {
        $sedeData =  $request->input('sede');
        $titularityData = $request->input('titularity');
        $steamClassroomData = $request->input('steam_classroom');
        $inventoryData = $request->input('inventory');

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


        $sedeCreatedResponse = $this->sedesService->createSede($sedeData);

        if($sedeCreatedResponse->success == false)
                return redirect()->back()->with('flash_error_message', $sedeCreatedResponse->msg);

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
            'inventories'
        )->first();
        if (empty($sede))
                return redirect()->back()->with('flash_error_message', 'Sede no encontrada');
        return view('institutional_profile.sede.edit',['sede' => $sede]);
    }

    public function update(Request $request, int $sede = null)
    {
        $sedeToUpdate = Sede::find($sede);
        if(empty($sedeToUpdate)){
            return redirect()->back()->with('flash_error_message', 'Sede no encontrada');
        }
        $sedeData =  $request->input('sede');
        unset($sedeData['institution_id']);

        if( !isset($sedeData['is_new_school']) )
            $sedeData['is_new_school'] = false ;

        $titularityData = $request->input('titularity');
        $steamClassroomData = $request->input('steam_classroom');
        $inventoryData = $request->input('inventory');

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
        }

        $sedeToUpdate->fill($sedeData);
        $sedeToUpdate->save();
        $titularityData['sede_id'] = $sedeToUpdate->id;
        $sedeToUpdate->titularidadSede->fill($titularityData);
        $sedeToUpdate->titularidadSede->save();
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
        return redirect()->back()->with('success', 'Sede actualizada correctamente.');
    }

    public function destroy(int $sede = null)
    {
        $sedeToDel = Sede::find($sede);
        if(empty($sedeToDel)){
            return redirect()->back()->with('flash_error_message', 'Sede no encontrada');
        }
        $sedeToDel->delete();
        return redirect()->back()->with('success', 'Sede eliminada correctamente.');
    }
}
