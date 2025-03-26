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

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('institutional_profile.sede.edit');
    }

    public function update(Request $request, User $usuario)
    {
        return redirect()->route('institutional_profile.sede.index')->with('success', 'Institución actualizada correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('institutional_profile.sede.index')->with('success', 'Institución eliminada correctamente.');
    }
}
