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
    public function vinculationView(int $sedeId = null)
    {
        $selectedSede = Sede::where('id', $sedeId)->select('id','name')->first();
        $allSedes = Sede::select('id','name')->get();
        $allEducationalOffers = EducationalOffer::select('id','name')->get();

        $allEducationalLevels =  EducationalOfferLevel::with('anexo')->whereIn('category',
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
            'selectedSede' => $selectedSede,
            'allSedes' => $allSedes,
            'allEducationalOffers' => $allEducationalOffers,
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

            // Crear o actualizar la vinculación sede-oferta educativa
            $sedeEducational = SedeEducationalOffer::updateOrCreate(
                [
                    'sede_id' => $sedeEducationalData['sede_id'],
                    'educational_offer_id' => $sedeEducationalData['educational_offer_id']
                ],
                $sedeEducationalData
            );

            // Procesar cada nivel y su horario
            foreach ($levelSchedules as $index => $levelSchedule) {
                $levelInfo = $levelSchedule['level_info'];
                $scheduleInfo = $levelSchedule['schedule'];

                // Si es un nivel personalizado, crear el nivel primero
                if ($levelInfo['is_custom'] == '1') {
                    $levelData = [
                        'name' => $levelInfo['name'],
                        'category' => $levelInfo['category']
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
                    'schedule' => $scheduleInfo['schedule'],
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
                    'sede_educational_offer_id' => $sedeEducational->id
                ]);
            }

            return redirect()->back()->with('success', 'Oferta educativa vinculada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_error_message', 'Error al vincular la oferta educativa: ' . $e->getMessage());
        }
    }
    public function vinculationEdit(int $sedeEducationalId = null)
    {
        $sedeEducational = SedeEducationalOffer::with([
            'educationalLevels',
            'educationalLevels.schedule',
            'educationalLevels.schedule.anexo',
            'educationalOffer',
        ])
        ->where('id',$sedeEducationalId)
        ->first();

        if(empty($sedeEducational))
            return redirect()->back()->with('flash_error_message', "Oferta educativa no encontrada");

        $selectedSede = Sede::where('id', $sedeEducational->sede_id)->select('id','name')->first();
        $allSedes = Sede::select('id','name')->get();
        $allEducationalOffers = EducationalOffer::select('id','name')->get();

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
            'sedeEducational' => $sedeEducational,
            'selectedSede' => $selectedSede,
            'allSedes' => $allSedes,
            'allEducationalOffers' => $allEducationalOffers,
            'educationalLevels' => $allEducationalLevels,
            'educationalCategories' => $educationalCategories,
            'educationalSchedules' => $educationalSchedules

        ]);
    }
    public function vinculationDestroy(int $sedeEducationalId = null)
    {
        try {
            $sedeEducational = SedeEducationalOffer::with([
                'educationalLevels',
                'educationalLevels.schedule',
                'educationalLevels.schedule.anexo',
                'educationalOffer',
            ])
            ->where('id',$sedeEducationalId)
            ->first();

            if(empty($sedeEducational)) {
                return redirect()->back()->with('flash_error_message', "Vinculación de oferta educativa no encontrada");
            }

            // Eliminar todas las relaciones en la tabla pivote
            DB::table('level_sede_educationals')
                ->where('sede_educational_offer_id', $sedeEducationalId)
                ->delete();

            // Eliminar la vinculación sede-oferta educativa
            $sedeEducational->delete();

            return redirect()->back()->with('success', 'Vinculación de oferta educativa eliminada correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error en vinculationDestroy', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('flash_error_message', 'Error al eliminar la vinculación: ' . $e->getMessage());
        }
    }
    public function updateVinculation(Request $request, int $sedeEducationalId = null)
    {
        try {
            \Log::info('Iniciando updateVinculation', [
                'request_data' => $request->all(),
                'files' => $request->allFiles(),
                'sede_educational_id' => $sedeEducationalId
            ]);

            $sedeEducational = SedeEducationalOffer::with([
                'educationalLevels',
                'educationalLevels.schedule',
                'educationalLevels.schedule.anexo',
                'educationalOffer',
            ])
            ->where('id', $sedeEducationalId)
            ->first();

            if(empty($sedeEducational)) {
                return redirect()->back()->with('flash_error_message', "Vinculación de oferta educativa no encontrada");
            }

            $sedeEducationalData = $request->input('sede_educational');
            $levelSchedules = $request->input('level_schedules');

            \Log::info('Datos recibidos', [
                'sede_educational_data' => $sedeEducationalData,
                'level_schedules' => $levelSchedules
            ]);

            // Actualizar datos básicos de la vinculación
            if (!empty($sedeEducationalData)) {
                $sedeEducational->update($sedeEducationalData);
            }

            // Si no hay niveles en la solicitud, eliminar todas las relaciones existentes
            if (empty($levelSchedules)) {
                \Log::info('No se proporcionaron nuevos niveles, eliminando todas las relaciones existentes');
                
                // Eliminar todas las relaciones existentes
                DB::table('level_sede_educationals')
                    ->where('sede_educational_offer_id', $sedeEducationalId)
                    ->delete();

                return redirect()->back()->with('success', 'Se han eliminado todos los niveles educativos vinculados.');
            }

            // Obtener los IDs de los niveles que vienen en la solicitud
            $requestedLevelIds = collect($levelSchedules)
                ->pluck('level_info.id')
                ->filter()
                ->values()
                ->toArray();

            // Eliminar las relaciones que ya no están en la solicitud
            DB::table('level_sede_educationals')
                ->where('sede_educational_offer_id', $sedeEducationalId)
                ->whereNotIn('educational_level_id', $requestedLevelIds)
                ->delete();

            // Procesar cada nivel y su horario
            foreach ($levelSchedules as $index => $levelSchedule) {
                $levelInfo = $levelSchedule['level_info'];
                $scheduleInfo = $levelSchedule['schedule'];

                // Si es un nivel personalizado, crear el nivel primero
                if ($levelInfo['is_custom'] == '1') {
                    $levelData = [
                        'name' => $levelInfo['name'],
                        'category' => $levelInfo['category']
                    ];

                    // Procesar el anexo del nivel si existe
                    if ($request->hasFile("level_attachments.{$index}")) {
                        $storeLevelResponse = $this->adjuntoService->storeAdjunto(
                            adjunto: $request->file("level_attachments.{$index}"),
                            ruta: 'educational_offer/level_adjunto',
                            disk: 'public'
                        );

                        if ($storeLevelResponse->success) {
                            $levelData['document_id'] = $storeLevelResponse->data->id;
                        } else {
                            throw new \Exception($storeLevelResponse->msg);
                        }
                    }

                    $level = EducationalOfferLevel::create($levelData);
                } else {
                    $level = EducationalOfferLevel::find($levelInfo['id']);
                }

                // Buscar si ya existe un horario para este nivel en esta sede
                $existingSchedule = DB::table('level_sede_educationals')
                    ->where('educational_level_id', $level->id)
                    ->where('sede_educational_offer_id', $sedeEducationalId)
                    ->first();

                if ($existingSchedule) {
                    // Actualizar el horario existente
                    $schedule = EducationalOfferSchedule::find($existingSchedule->educational_shedule_id);
                    if ($schedule) {
                        $scheduleData = [
                            'name' => $scheduleInfo['name'],
                            'schedule' => $scheduleInfo['schedule'],
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

                        $schedule->update($scheduleData);
                    }
                } else {
                    // Crear nuevo horario
                    $scheduleData = [
                        'name' => $scheduleInfo['name'],
                        'schedule' => $scheduleInfo['schedule'],
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

                    $schedule = EducationalOfferSchedule::create($scheduleData);

                    // Crear la relación en la tabla pivote
                    DB::table('level_sede_educationals')->insert([
                        'educational_level_id' => $level->id,
                        'educational_shedule_id' => $schedule->id,
                        'sede_educational_offer_id' => $sedeEducationalId
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Vinculación de oferta educativa actualizada correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error en updateVinculation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('flash_error_message', 'Error al actualizar la oferta educativa: ' . $e->getMessage());
        }
    }


}
