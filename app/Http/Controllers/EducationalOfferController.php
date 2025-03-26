<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Http\Services\EducationalModelService;
use App\Http\Services\EducationalOfferService;
use App\Models\EducationalModel;
use App\Models\EducationalOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EducationalOfferController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
        private EducationalOfferService $educationalOfferService,
        private EducationalModelService $educationalModelService,
    ){}




    public function index()
    {
        $educationalOffers = EducationalOffer::with('educationalModels','validationAuthorizationAdjunto')->paginate(10);
        return view('institutional_profile.educational_offer.index',['paginate' => $educationalOffers ]);
    }

    public function create()
    {
       $eduactionalModels = EducationalModel::get();

        // Pasar el array de sedes a la vista
        return view(
            'institutional_profile.educational_offer.form',
            ['eduactionalModels' => $eduactionalModels]
        );
    }

    public function store(Request $request)
    {

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
        $educationalOfferResponse = $this->educationalOfferService->create($educationalOfferData);
        if($educationalOfferResponse->success == false)
                return redirect()->back()->with('flash_error_message', $educationalOfferResponse->msg);
        $this->educationalModelService->syncEducationalModel($educationalModelsData,$educationalOfferResponse->data->id);
        return redirect()->back()->with('success', 'Oferta educativa creada correctamente.');
    }

    public function edit( int $educational_offer = null)
    {
        $educationalOffer = EducationalOffer::where('id',$educational_offer)->with('educationalModels','validationAuthorizationAdjunto')->first();
        $eduactionalModels = EducationalModel::get();

        if(empty($educationalOffer))
            return redirect()->back()->with('flash_error_message', "Oferta educativa no encontrada");

        return view('institutional_profile.educational_offer.form_edit', ['educationalOffer' => $educationalOffer, 'eduactionalModels' => $eduactionalModels]);
    }

    public function update(Request $request, int $educational_offer = null)
    {

        $educationalOffer = EducationalOffer::where('id',$educational_offer)->with('educationalModels','validationAuthorizationAdjunto')->first();
        if(empty($educationalOffer)){
            return redirect()->back()->with('flash_error_message', 'Oferta educativa no encontrada');
        }

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
        return redirect()->back()->with('success', 'Oferta educativa actualizada correctamente.');
    }

    public function destroy(int $educational_offer = null)
    {
        $educationalOffer = EducationalOffer::find($educational_offer);
        if(empty($educationalOffer)){
            return redirect()->back()->with('flash_error_message', 'Oferta educativa no encontrada');
        }
        $educationalOffer->delete();
        return redirect()->back()->with('success', 'Oferta educativa eliminada correctamente.');
    }
}
