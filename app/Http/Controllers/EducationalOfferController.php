<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Http\Services\EducationalModelService;
use App\Http\Services\EducationalOfferService;
use App\Models\EducationalModel;
use App\Models\EducationalOffer;
use App\Models\EducationalOfferLevel;
use App\Models\EducationalOfferSchedule;
use App\Models\Enums\EducationalOfferLevelCategoryEnum;
use App\Models\Enums\EducationalOfferScheduleEnum;
use App\Models\Sede;
use App\Models\SedeEducationalOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\LevelSedeEducational;

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
    public function vinculationView(int $institutionId = null)
    {
        $allSedes = Sede::where('institution_id', $institutionId)->select('id','name')->get();

        $allEducationalLevels =  EducationalOfferLevel::with('anexo')
            ->where('institution_id', $institutionId)
            ->whereIn('category',
            [
                EducationalOfferLevelCategoryEnum::Emphasis->value,
                EducationalOfferLevelCategoryEnum::Agreement->value,
                EducationalOfferLevelCategoryEnum::PreSchool->value,
                EducationalOfferLevelCategoryEnum::Primary->value,
                EducationalOfferLevelCategoryEnum::Secondary->value,
            ])
        ->get();
        $educationalCategories = EducationalOfferLevelCategoryEnum::toArray();
        $educationalSchedules = EducationalOfferScheduleEnum::toArray();
        return view('institutional_profile.educational_offer.vinculate',
        [
            'allSedes' => $allSedes,
            'educationalLevels' => $allEducationalLevels,
            'educationalCategories' => $educationalCategories,
            'educationalSchedules' => $educationalSchedules

        ]);
    }
    public function makeVinculation(Request $request) {
        try {
            \Log::info('Iniciando makeVinculation', [
                'request_data' => $request->all(),
                'files' => $request->allFiles()
            ]);

            $sedeEducationalData = $request->input('sede_educational');
            $levelSchedules = $request->input('level_schedules');
            $sede = Sede::where('id',$sedeEducationalData['sede_id'])->firstOrFail();



            // Procesar cada nivel y su horario
            foreach ($levelSchedules as $index => $levelSchedule) {
                $levelInfo = $levelSchedule['level_info'];
                $scheduleInfo = $levelSchedule['schedule'];

                // Si es un nivel personalizado, crear el nivel primero
                if ($levelInfo['is_custom'] == '1') {
                    $levelData = [
                        'name' => $levelInfo['name'],
                        'category' => $levelInfo['category'],
                        'institution_id' => $sede->institution_id
                    ];

                    // Procesar el anexo del nivel si existe
                    if ($request->hasFile("level_attachments.{$index}")) {
                        \Log::info('Procesando anexo del nivel', [
                            'index' => $index,
                            'file' => $request->file("level_attachments.{$index}")->getClientOriginalName(),
                            'mime_type' => $request->file("level_attachments.{$index}")->getMimeType(),
                            'size' => $request->file("level_attachments.{$index}")->getSize()
                        ]);

                        $storeLevelResponse = $this->adjuntoService->storeAdjunto(
                            adjunto: $request->file("level_attachments.{$index}"),
                            ruta: 'educational_offer/level_adjunto',
                            disk: 'public'
                        );

                        if ($storeLevelResponse->success) {
                            \Log::info('Anexo guardado exitosamente', [
                                'document_id' => $storeLevelResponse->data->id,
                                'path' => $storeLevelResponse->data->path
                            ]);
                            $levelData['document_id'] = $storeLevelResponse->data->id;
                        } else {
                            \Log::error('Error al guardar el anexo', [
                                'error' => $storeLevelResponse->msg
                            ]);
                            throw new \Exception($storeLevelResponse->msg);
                        }
                    }

                    $level = EducationalOfferLevel::create($levelData);
                    \Log::info('Nivel educativo creado', [
                        'level_id' => $level->id,
                        'level_data' => $levelData
                    ]);
                } else {
                    $level = EducationalOfferLevel::find($levelInfo['id']);
                }

                // Crear el horario
                $scheduleData = [
                    'name' => $scheduleInfo['name'],
                    'hora_inicio' => $scheduleInfo['hora_inicio'],
                    'hora_fin' => $scheduleInfo['hora_fin'],
                    'notes' => $scheduleInfo['notes'] ?? null
                ];

                // Procesar el anexo del horario si existe
                if ($request->hasFile("schedule_attachments.{$index}")) {
                    $storeScheduleResponse = $this->adjuntoService->storeAdjunto(
                        adjunto: $request->file("schedule_attachments.{$index}"),
                        ruta: 'educational_offer/schedule_adjunto',
                        disk: 'public'
                    );

                    if ($storeScheduleResponse->success) {
                        $scheduleData['document_id'] = $storeScheduleResponse->data->id;
                    } else {
                        throw new \Exception($storeScheduleResponse->msg);
                    }
                }

                // Crear el horario
                $schedule = EducationalOfferSchedule::create($scheduleData);

                // Crear la relación en la tabla pivote usando el modelo
                LevelSedeEducational::create([
                    'educational_level_id' => $level->id,
                    'educational_shedule_id' => $schedule->id,
                    'sede_id' => $sede->id
                ]);
            }

            return redirect()->back()->with('success', 'Oferta educativa vinculada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_error_message', 'Error al vincular la oferta educativa: ' . $e->getMessage());
        }
    }
    public function vinculationEdit(int $levelSedeId = null)
    {
        $levelSede = LevelSedeEducational::with([
            'educationalLevel',
            'schedule',
            'schedule.anexo',
            'sede:id,name,institution_id',
            'sede.institution:id'
        ])
        ->where('id',$levelSedeId)
        ->first();

        if(empty($levelSedeId))
            return redirect()->back()->with('flash_error_message', "Vinculación de oferta educativa no encontrada");

        $selectedSede = $levelSede->sede;
        $allSedes = Sede::select('id','name')->get();

        $allEducationalLevels =  EducationalOfferLevel::whereIn('category',[
            EducationalOfferLevelCategoryEnum::Emphasis->value,
            EducationalOfferLevelCategoryEnum::Agreement->value,
            EducationalOfferLevelCategoryEnum::PreSchool->value,
            EducationalOfferLevelCategoryEnum::Primary->value,
            EducationalOfferLevelCategoryEnum::Secondary->value
        ])
        ->get();
        $educationalCategories = EducationalOfferLevelCategoryEnum::toArray();
        $educationalSchedules = EducationalOfferScheduleEnum::toArray();
        return view('institutional_profile.educational_offer.vinculate_edit',
        [
            'levelSede' => $levelSede,
            'selectedSede' => $selectedSede,
            'educationalCategories' => $educationalCategories,
            'educationalSchedules' => $educationalSchedules
        ]);
    }
    public function vinculationShow(int $levelSedeId = null)
    {
        $levelSede = LevelSedeEducational::with([
            'educationalLevel',
            'schedule',
            'schedule.anexo',
            'sede:id,name,institution_id',
            'sede.institution:id'
        ])
            ->where('id',$levelSedeId)
            ->first();

        if(empty($levelSedeId))
            return redirect()->back()->with('flash_error_message', "Vinculación de oferta educativa no encontrada");

        $selectedSede = $levelSede->sede;
        $educationalCategories = EducationalOfferLevelCategoryEnum::toArray();
        $educationalSchedules = EducationalOfferScheduleEnum::toArray();
        return view('institutional_profile.educational_offer.vinculate_show',
            [
                'levelSede' => $levelSede,
                'selectedSede' => $selectedSede,
                'educationalCategories' => $educationalCategories,
                'educationalSchedules' => $educationalSchedules
            ]);
    }
    public function vinculationDestroy(int $levelSedeId = null)
    {
        $levelSede = LevelSedeEducational::where('id',$levelSedeId)->first();
        if(empty($levelSede))
            return redirect()->back()->with('flash_error_message', "Vinculación de oferta educativa no encontrada");

        $levelSede->schedule->delete();
        $levelSede->educationalLevel->delete();
        $levelSede->delete();

         return redirect()->back()->with('success', 'Vinculación de oferta educativa eliminada correctamente.');
    }
    public function updateVinculation(Request $request, int $levelSede = null)
    {
        try {
            DB::beginTransaction();
            $levelSedeToUpdate = LevelSedeEducational::where('id',$levelSede)->first();

            // Actualizar el horario
            $schedule = $levelSedeToUpdate->schedule;
            $schedule->name = $request->input('schedule.name');
            $schedule->notes = $request->input('schedule.notes');
            $schedule->hora_inicio = $request->input('schedule.hora_inicio');
            $schedule->hora_fin = $request->input('schedule.hora_fin');

            // Manejar el documento del horario si se subió uno nuevo
            if ($request->hasFile('schedule_attachment')) {
                $storeAdjuntoResponse = $this->adjuntoService->storeAdjunto(
                    $request->file('schedule_attachment'),
                    'educational_offer/schedule',
                    'public'
                );

                if (!$storeAdjuntoResponse->success) {
                    throw new \Exception($storeAdjuntoResponse->msg);
                }
                $schedule->document_id = $storeAdjuntoResponse->data->id;
            }

            $schedule->save();
            // Actualizar el anexo del nivel educativo si se subió uno nuevo
            if ($request->hasFile('level_attachment')) {
                $storeAdjuntoResponse = $this->adjuntoService->storeAdjunto(
                    $request->file('level_attachment'),
                    'educational_offer/level',
                    'public'
                );
                if (!$storeAdjuntoResponse->success) {
                    throw new \Exception($storeAdjuntoResponse->msg);
                }
                $levelSedeToUpdate->educationalLevel->document_id = $storeAdjuntoResponse->data->id;
                $levelSedeToUpdate->educationalLevel->save();
            }
            DB::commit();

            return redirect()->route('institution.edit', ['institution' => $levelSedeToUpdate->sede->institution_id])
                ->with('flash_success_message', 'Vinculación de oferta educativa actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('flash_error_message', 'Error al actualizar la vinculación: ' . $e->getMessage())
                ->withInput();
        }
    }


}
