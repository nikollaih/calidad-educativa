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
use App\Models\PeiHistorial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    public function show(int $institucion)
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
        return view('institutional_profile.institution.show', ['institution' => $institucion]);
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
        $autoevaluacion = Autoevaluacion::with('notas','notas.calificacion', 'notas.calificacion.grupo','notas.calificacion.grupo.padre')
            ->where('id', $autoevaluacionId)->first();
        if(empty($autoevaluacionId)){
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');
        }
        $gruposCalificaciones = GrupoCalificacion::with(['hijos.calificaciones', 'hijos.calificaciones.notasCalificacion', 'calificaciones'])
            ->whereNull('padre_id')
            ->get();
        $formattedNotes = $autoevaluacion->notas->map(function ($nota) {
            return [
                'grupo_indice' => $nota->calificacion?->grupo?->indice,
                'grupo_name' => $nota->calificacion?->grupo?->nombre,
                'valor' => $nota->valor,
                'base_group_indice' => $nota->calificacion?->grupo?->padre?->indice,
                'base_group_name' => $nota->calificacion?->grupo?->padre?->nombre,
            ];
        });


        $statistics = GrupoCalificacion::with([
            'hijos' => function ($query) {
                $query->select('id', 'indice', 'padre_id', 'nombre')
                ->withCount('calificaciones');
            }
        ])
            ->withCount('hijos')
            ->whereNull('padre_id')
            ->get()
            ->map( function ( $baseGroup) use ($formattedNotes) {
                $subGruposFormateados = $baseGroup->hijos->map( function ( $subGrupo)  use ($formattedNotes) {
                    return [
                        'nombre' => $subGrupo->nombre,
                        'indice' => $subGrupo->indice,
                        'promedio' => round($formattedNotes
                            ->where('grupo_indice', $subGrupo->indice)
                            ->sum('valor') / max( 1,$subGrupo->calificaciones_count ),2 ),
                    ];
                });

                // Filtrar las notas que pertenecen a los subgrupos de este grupo base
                $notasDelGrupo = $formattedNotes->filter(function ($nota) use ($baseGroup) {
                    return $nota['base_group_indice'] === $baseGroup->indice;
                });

                $ponderados = [
                    'Existencia' => $notasDelGrupo->where('valor', 1)->count(),
                    'Pertinencia' => $notasDelGrupo->where('valor', 2)->count(),
                    'Apropiación' => $notasDelGrupo->where('valor', 3)->count(),
                    'Mejoramiento' => $notasDelGrupo->where('valor', 4)->count(),
                ];

                return [
                  'nombre' => $baseGroup->nombre,
                  'indice' => $baseGroup->indice,
                  'promedio' => round($subGruposFormateados->sum('promedio') / max(1, $baseGroup->hijos_count ), 2),
                  'sub_grupos' => $subGruposFormateados,
                    'ponderados' => $ponderados,
                ];
            });
        return view('institutional_profile.institution.autoevaluaciones.ver',
            [
                'gruposCalificaciones' => $gruposCalificaciones,
                'autoevaluacion' => $autoevaluacion,
                'statistics' => $statistics,
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
    public function autoevaluacionesValidar(Request $request, int $autoevaluacionId = null)
    {
        $autoevaluacion = Autoevaluacion::find($autoevaluacionId);

        if(!$autoevaluacion)
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');

        // De momento no hay logica para el envio a validar

        $autoevaluacion->alias_estado = "VALIDACION";
        $autoevaluacion->save();

        return redirect()->route('institution.autoevaluaciones',  ['institution' => $autoevaluacion->institucion_id])->with('flash_success_message', "Autoevaluación enviada a validación correctamente");

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
        // crea las gestiones de PEI
        Institucion::createEmptyPeiFor($institutionCreated->id);
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

    public function updatePei(Request $request, $institutionId) {
        DB::beginTransaction();

        try {
            // Validar los datos recibidos
            $validated = $request->validate([
                'tipo_codificacion' => 'required|integer',
                'fecha' => 'required|date',
                'observacion' => 'nullable|string|max:500',
                'relation_name' => 'required|string',
            ]);

            $input = $request->all();

            // Obtener la institución con relaciones
            $institucion = Institucion::with([
                'gestionDirectiva',
                'gestionAcademica', 
                'gestionComunidad',
                'gestionAdministrativa',
            ])->findOrFail($institutionId);

            // Definir propiedades a eliminar del input
            $propiedadesAEliminar = [
                'relation_name', 
                'tipo_codificacion',
                'fecha',
                'observacion',
                'institucion_id',
                'hijo_index'
            ];

            // Filtrar datos para actualización
            $dataToUpdate = array_diff_key($input, array_flip($propiedadesAEliminar));
            // Obtener el modelo objetivo
            $relationPath = str_replace('->', '.', $input['relation_name']);
            $model = data_get($institucion, $relationPath);
            
            if (!$model) {
                throw new \Exception("No se encontró el modelo para la relación: {$input['relation_name']}");
            }
            // Capturar datos originales
            $oldData = $model->getOriginal();
            // Actualizar el modelo
            $model->update($dataToUpdate);

            /** Guarda traza */
            // Obtener cambios
            $newData = $model->getChanges();
            // Filtrar solo campos modificados
            $changedFields = array_keys($newData);
            $filteredOldData = array_intersect_key($oldData, array_flip($changedFields));
            // Guarda documento de edicion
            $guardaArchivoAdicional = $this->adjuntoService->storeAdjunto($request->file('documento_adicional'),"institucion/{$institutionId}/edicion_pei",'public');
            // Crear registro de historial
            $historial = PeiHistorial::create([
                'model_id' => $model->getKey(),
                'model_type' => get_class($model),
                'attachment_id' => $guardaArchivoAdicional?->data?->id,
                'tipo_codificacion' => (int) $input['tipo_codificacion'],
                'date' => Carbon::parse($input['fecha']),
                'observation' => $input['observacion'],
                'old_data' => $filteredOldData,
                'new_data' => $newData,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'PEI actualizado correctamente',
                'changes' => count($changedFields),
                'historial_id' => $historial->id
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al actualizar PEI: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar el PEI: ' . $e->getMessage()
            ], 500);
        }
    }
}
