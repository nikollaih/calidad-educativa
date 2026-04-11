<?php

namespace App\Http\Controllers\PMI;

use App\DTOs\Result;
use App\Exports\PmiCumplimientoExport;
use App\Exports\PmiEvaluacionExport;
use App\Exports\PmiExport;
use App\Exports\PmiSintesisExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\PMI\GestionValidarPMI;
use App\Http\Services\AdjuntoService;
use App\Http\Services\AutoevaluacionService;
use App\Http\Services\MailService;
use App\Http\Services\PMI\PmiObjetivoVinculadoService;
use App\Http\Services\PmiService;
use App\Models\Autoevaluacion;
use App\Models\Enums\PmiActividad\FrecuenciaRecoleccionEnum;
use App\Models\FactorCritico;
use App\Models\FactorCriticoCalificacion;
use App\Models\Pmi;
use App\Models\PMI\ActividadEstadoEnum;
use App\Models\PMI\Enums\PmiEstadoEnum;
use App\Models\PMI\PmiComentarioFactor\Enums\PmiEstadoComentario;
use App\Models\PMI\PmiComentarioFactor\PmiComentarioFactor;
use App\Models\PMI\PmiIndicador;
use App\Models\PMI\PmiObjetivo;
use App\Models\PmiActividadAvance;
use App\Models\PmiActividadAvanceFiles;
use App\Models\PmiActividadVinculada;
use App\Models\PmiMetaVinculada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;


class PMIController extends Controller {
    public function __construct(
        private AdjuntoService $adjuntoService,
        private AutoevaluacionService $autoevaluacionService,
        private PmiObjetivoVinculadoService $objetivoVinculadoService,
        private PmiService $pmiService,
        private MailService $mailService,
    ) {
    }

    public function index( int $institucionId = null) {
        $pmis = Pmi::with('comentarios','comentarios.autor','comentarios.factor')
            ->whereHas('autoevaluacion', function ($query) use ($institucionId) {
                $query->where('institucion_id', $institucionId);
            })
            ->orderBy('anio_inicio', 'asc')
            ->paginate(20);

        return view('pmi.index', [
            'institucionId' => $institucionId,
            'pmis' => $pmis,
            'institucionNombre' => \App\Models\Institucion::find($institucionId)?->nombre,
        ]);
    }
    /*
    * Obtiene los pmis en estado de validacion, y renderiza la vista de pmis en estado de validacion
    */
    public function pmiValidacion(GestionValidarPMI $request) {
        $pmis = Pmi::with('institucion')
            ->whereIn('estado', [
                PmiEstadoEnum::Presentado->value,
                PmiEstadoEnum::Aprobado->value,
            ])
            ->orderByRaw("
                CASE
                    WHEN estado = ? THEN 1
                    WHEN estado = ? THEN 2
                    ELSE 3
                END
            ", [PmiEstadoEnum::Presentado->value, PmiEstadoEnum::Aprobado->value])
            ->paginate(20);
        return view('pmi.validacion', [
            'pmis' => $pmis,
        ]);
    }

    public function actividadesByPmi(Request $request, int $pmiId) {
        $actividades = PmiActividadVinculada::whereHas('indicador', function ($query) use ($pmiId) {
            $query->whereHas('meta', function ($query) use ($pmiId) {
                $query->whereHas('objetivo', function ($query) use ($pmiId) {
                    $query->whereHas('factor', function ($query) use ($pmiId) {
                        $query->where('pmi_id', $pmiId);
                    });
                });
            });
        })
        ->with('indicador.meta')
        ->get();
        return response()->json($actividades);
    }

    public function create(int $institucionId ) {
        $autoevaluaciones = Autoevaluacion::where('institucion_id', $institucionId)
            ->where('alias_estado', 'VALIDACION')
            ->whereDoesntHave('pmi')
            ->get();
        return view('pmi.create', [
            'autoevaluaciones' => $autoevaluaciones,
            'institucionId' => $institucionId,
            'institucionNombre' => \App\Models\Institucion::find($institucionId)?->nombre,
        ]);
    }
    public function store(Request $request, int $institucionId ) {
        try {
            // Validación manual
            $this->validate($request, [
                'pmi.anio_inicio' => 'required|integer',
                'pmi.anio_fin' => 'required|integer|gte:pmi.anio_inicio',
                'pmi.descripcion' => 'nullable|string',
                'pmi.autoevaluacion_id' => 'required|integer|exists:autoevaluacions,id',
            ], [
                'pmi.anio_fin.gt' => 'El año de fin debe ser mayor que el año de inicio.',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', collect($e->errors())->flatten()->first());
        }
        $pmiData = $request->input('pmi');
        $anioInicio = (int) $pmiData['anio_inicio'];
        $anioFin = (int) $pmiData['anio_fin'];

        // Validar traslape de intervalos de PMIs
        $existeTraslape = Pmi::whereHas('autoevaluacion', function ($query) use ($institucionId) {
            $query->where('institucion_id', $institucionId);
        })
            ->where(function ($query) use ($anioInicio, $anioFin) {
                $query->where('anio_inicio', '<=', $anioFin)
                    ->Where('anio_fin', '=>', $anioInicio);
            })
            ->exists();

        if (false) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', 'El intervalo de años se cruza con otro PMI existente para esta institución.');
        }

        $pmiCreated = Pmi::create($pmiData);

        $autoevaluacion = $pmiCreated->autoevaluacion;
        $this->autoevaluacionService->asignarPmiFactoresCriticos(autoevaluacion: $autoevaluacion, pmiId: $pmiCreated->id);

        return redirect()
            ->route('pmi.edit', ['institucionId' => $institucionId, 'pmi' => $pmiCreated->id])
            ->with('flash_success_message', 'PMI creado correctamente.');
    }
    public function edit(Request $request, int $institucionId , int $pmi) {
        $pmi = PMI::where('id', $pmi)
            ->with(
                'factoresCriticos.calificacion.grupo.padre',
                'factoresCriticos.objetivos.metas.indicadores.actividades',
            )
            ->first();
        return view('pmi.edit', [
            'pmi' => $pmi,
            'institucionId' => $institucionId,
            'institucionNombre' => \App\Models\Institucion::find($institucionId)?->nombre,
        ]);
    }
    public function presentarPmi(Request $request, int $institucionId , int $pmiId) {
        $pmi = Pmi::find($pmiId);
        if (empty($pmi)) {
            return  redirect()
                ->route('pmi.index',  ['institucionId'=>$institucionId, 'pmi'=>$pmiId ])
                ->with('flash_error_message', 'PMI  no encontrado.');
        }
        $cantidadComentariosActivos = $pmi->comentarios->where('estado',PmiEstadoComentario::Activo->value)->count();
        if ($cantidadComentariosActivos>0) {
            return redirect()
                ->route('pmi.index',  ['institucionId'=>$institucionId, 'pmi'=>$pmiId ])
                ->with('flash_error_message', 'No se puede enviar a SED debido a que hay '.$cantidadComentariosActivos.' observaciones activas.');
        }
        $cantidadFactoresCriticosPriorizadosSinObjetivos = $pmi->autoevaluacion
            ->factoresCriticos()
            ->where('valor', '>', 3)
            ->doesntHave('objetivos')
            ->count();

        if ($cantidadFactoresCriticosPriorizadosSinObjetivos ) {
            return redirect()
                ->route('pmi.index',  ['institucionId'=>$institucionId, 'pmi'=>$pmiId ])
                ->with('flash_error_message', 'Todos los factores críticos deben contar con almenos un objetivo vinculado, actualmente hay '. $cantidadFactoresCriticosPriorizadosSinObjetivos . ' factores criticos sin un objetivo vinculado.');
        }
        $pmi->estado = PmiEstadoEnum::Presentado->value;
        $pmi->save();
        $pmi->comentarios->each(function ($comentario) {
            $comentario->estado=PmiEstadoComentario::Historico->value;
            $comentario->save();
        });
        // se envia el correo avisand del evento
        $this->pmiService->enviarCorreoPmiPresentado(pmi: $pmi);
        return  redirect()
            ->route('pmi.index',  ['institucionId'=>$institucionId, 'pmi'=>$pmiId ])
            ->with('flash_success_message', 'PMI presentado correctamente.');
    }
    public function exportarPmi(Request $request , int $pmiId) {
        $fileName = 'pmi_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new PmiExport($pmiId), $fileName);
    }
    public function exportarCumplimientoPmi(Request $request , int $pmiId) {
        $fileName = 'pmi_cumplimiento_objetivos_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new PmiCumplimientoExport($pmiId), $fileName);
    }
    public function exportarSintesisPmi(Request $request , int $pmiId) {
        $fileName = 'pmi_sintesis_seguimiento_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new PmiSintesisExport($pmiId), $fileName);
    }
    public function exportarEvaluacionPmi(Request $request , int $pmiId) {
        $fileName = 'pmi_evaluacion_de_resultados_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new PmiEvaluacionExport($pmiId), $fileName);
    }
    public function editFactorCritico(Request $request, int $institucionId , int $pmi, int $factorCriticoId) {
        $factorCritico = FactorCritico::where('id', $factorCriticoId)
            ->with([
                'calificacion.grupo.padre',
                'objetivos.metas.indicadores.actividades'
            ])
            ->firstOrFail();
        $factorCriticoCalificacion = FactorCriticoCalificacion::where('indice_calificacion',$factorCritico->calificacion_indice)
            ->firstOrFail();

        $objetivos = PmiObjetivo::with('metas')->where('factor_id',$factorCriticoCalificacion->id)->get();
        $indicadores = PmiIndicador::get();

        return view('pmi.editFactorCritico',
            [
                'factorCritico' => $factorCritico,
                'institucionId' => $institucionId,
                'pmiId' => $pmi,
                'objetivos' => $objetivos,
                'indicadores' => $indicadores,
                'institucionId' => $institucionId,
                'frecuenciasRecoleccion' => FrecuenciaRecoleccionEnum::cases()
            ]);
    }
    public function pmiValidar(GestionValidarPMI $request, int $pmiId ) {
        $pmi = PMI::with('institucion','comentarios')
            ->where('id', $pmiId)
            ->with(
                'factoresCriticos.calificacion.grupo.padre',
                'factoresCriticos.objetivos.metas.indicadores.actividades',
            )
            ->first();
        return view('pmi.validar',
            [
                'pmi' => $pmi,
            ]);
    }
    public function pmiAlmacenarComentario(GestionValidarPMI $request) {
        // se obtienen los datos
        $input = $request->all();
        $input['estado'] = PmiEstadoComentario::Activo->value;
        $comentarioId = data_get($input,'id');
        if ($comentarioId) {
            $comentario = PmiComentarioFactor::findOrFail($input['id']);
            $comentario->fill($input);
            $comentario->save();
            return redirect()->back()
                       ->withInput()
                       ->with('flash_success_message', 'Comentario editado correctamente.');
        } else {
            $input['autor_id'] = Auth::user()->id;
            $comentario = PmiComentarioFactor::create($input);
            return redirect()->back()
                       ->withInput()
                       ->with('flash_success_message', 'Comentario editado correctamente.');
        }
    }
    public function pmiEliminarComentario(Request $request, int $pmiId, int $comentarioId) {
        $comentario = PmiComentarioFactor::find($comentarioId);
        if ($comentario) {
            $comentario->delete();
            return redirect()->back()
                       ->withInput()
                       ->with('flash_success_message', 'Comentario eliminado correctamente.');
        }
        return redirect()->back()
                       ->withInput()
                ->with('flash_error_message', ' Comentario no encontrado.');
    }
    public function pmiMarcarComentarioResuelto(Request $request, int $pmiId, int $comentarioId) {
        $comentario = PmiComentarioFactor::find($comentarioId);
        if ($comentario) {
            $comentario->estado = PmiEstadoComentario::Resuelto->value;
            $comentario->save();
            return redirect()->back()
                       ->withInput()
                       ->with('flash_success_message', 'Comentario marcado como resuelto correctamente.');
        }
        return redirect()->back()
                       ->withInput()
                ->with('flash_error_message', ' Comentario no encontrado.');
    }
    public function pmiCambiarEstado(GestionValidarPMI $request, int $pmiId) {
        $pmi = Pmi::with('comentarios')->where('id',$pmiId)->first();
        if (!$pmi) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', ' PMI no encontrado.');
        }
        $input = $request->all();
        try {
            DB::beginTransaction();
            /** @var Result $resultado */
            $resultado = match ($input['estado']) {
                PmiEstadoEnum::Aprobado->value => $this->pmiService->aprobarPmi(pmi: $pmi),
                PmiEstadoEnum::Proceso->value => $this->pmiService->devolverPmi(pmi: $pmi),
                DEFAULT => Result::error(msg: 'El nuevo estado no es válido')
            };

            if ($resultado->success) {
                DB::commit();
                return redirect()->route('pmi.validacion')
                           ->withInput()
                           ->with('flash_success_message', $resultado->msg);
            }
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message',$resultado->msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message',$e->getMessage());
        }
    }
    public function storeActividadAvance(Request $request) {
        $pmi = Pmi::where('id', $request->input('pmi_id'))
            ->first();
        $actividad = PmiActividadVinculada::with('indicador.meta')
            ->where('id', $request->input('actividad_id'))
            ->first();


        if (empty($pmi)) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', 'No se encontró el PMI asociado a este avance.');
        }
        if ($pmi->estado != PmiEstadoEnum::Aprobado->value) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', 'El PMI debe estar aprobado por el SED.');
        }
        if (empty($actividad)) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', 'No se encontró el PMI asociado a este avance.');
        }

        $fechaAvance = $request->input('fecha_avance');
        if (empty($fechaAvance) || !strtotime($fechaAvance)) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', 'La fecha del avance es inválida.');
        }

        if ($fechaAvance > date('Y-m-d')) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', 'La fecha del avance no puede ser mayor a hoy.');
        }

        // 2. Validar suma al indicador
        $maxPermitido = $actividad->max_suma_indicador - $actividad->indicador_acumulado;
        $suma = (int) $request->input('suma_al_indicador');

        if ($suma < 0) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', 'El valor de unidades no puede ser negativo.');
        }

        if ($suma > $maxPermitido) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', "El valor de unidades no puede ser mayor a $maxPermitido.");
        }
        $avanceData = $request->all();

        $cantidadTotalAvanzada = $actividad->indicador_acumulado + $avanceData['suma_al_indicador'];


        if ($cantidadTotalAvanzada > $actividad->max_suma_indicador) {
            return redirect()->back()
                ->withInput()
                ->with('flash_error_message', "El valor del avance total no puede se mayor a " . $actividad->max_suma_indicador . " actualmente es" . $cantidadTotalAvanzada);
        }

        $accumulated = $actividad->afecta_indicador
            ? ( $cantidadTotalAvanzada / $actividad->max_suma_indicador) * 100
            : 100;
        DB::beginTransaction();
        try {
            $actividad->accumulated = $accumulated;
            $actividad->indicador_acumulado = $cantidadTotalAvanzada;
            $avanceData['porcentaje_ejecutado'] = $accumulated;
            $avance = PmiActividadAvance::create($avanceData);

            if ($avance->porcentaje_ejecutado == 100) {
                $actividad->slug_estado= ActividadEstadoEnum::COMPLETADA->value;
            }
            if ($actividad->slug_estado == ActividadEstadoEnum::SIN_INICIAR->value) {
                $actividad->slug_estado= ActividadEstadoEnum::EN_PROGRESO->value;
            }
            $avance->save();
            $actividad->save();
            if ($avance->suma_al_indicador !== 0 ) {
                $indicador  = $actividad->indicador;
                $indicador->valor_obtenido += $avance->suma_al_indicador;
                $indicador->save();
            }
            // Procesar los archivos
            if ($request->hasFile('adjuntos')) {
                foreach ($request->file('adjuntos') as $file) {
                    if (!$file->isValid()) {
                        Log::error("Archivo inválido", [
                            'nombre' => $file->getClientOriginalName(),
                            'error' => $file->getError()
                        ]);
                    }

                    $storeAdjuntoResponse = $this->adjuntoService->storeAdjunto(
                        adjunto: $file,
                        ruta: 'pmi/actividades/avances/'. $avance->pmi_id . '/' . $avance->id,
                        disk: 'public');
                    if ($storeAdjuntoResponse->success) {
                        $adjuntoId = $storeAdjuntoResponse->data->id;

                        PmiActividadAvanceFiles:: create([
                            'avance_id' => $avance->id,
                            'file_id' => $adjuntoId,
                        ]);
                    } else {
                        return redirect()->back()->with('flash_error_message', $storeAdjuntoResponse->msg);
                    }
                }
            }
            DB::commit();
            return redirect()->back()
                ->withInput()
                ->with('flash_success_message', 'Avance guardado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    public function show(Request $request, int $institucionId , int $pmi) {
        $pmi = PMI::where('id', $pmi)
            ->with(
                'factoresCriticos.calificacion.grupo.padre',
                'factoresCriticos.objetivos.metas.indicadores.actividades',
            )
            ->first();
        return view('pmi.show', [
            'pmi' => $pmi,
            'institucionId' => $institucionId,
            'institucionNombre' => \App\Models\Institucion::find($institucionId)?->nombre,
        ]);
    }
    public function avancesActividadByActividadId(Request $request, int $actividadId = null) {
        $meta = PmiMetaVinculada::with('indicadores')
            ->whereHas(relation:  'indicadores',
                callback: function ($query) use ($actividadId) {
                    $query->whereHas(relation:  'actividades',
                        callback: function ($query) use ($actividadId) {
                            $query->where('id', $actividadId);
                        });
                })
            ->first();

        $avances = PmiActividadAvance::with('actividad.indicador.meta', 'adjuntos')
            ->where('actividad_id', $actividadId)
            ->get();

        return response()->json(['avances'=>$avances, 'meta'=>$meta]);
    }
    public function actualizarFactorCritico(Request $request, int $institucionId , int $pmi,  int $factorCriticoId) {
        try {
            $pmiOwner = Pmi::find($pmi);
            if (!$pmiOwner) {
                return redirect()
                    ->route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmi ])
                    ->with('flash_error_message', 'El pmi asociado no fue encontrado.');
            }
            if ($pmiOwner->estado == PmiEstadoEnum::Presentado->value) {
                return redirect()
                    ->route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmi ])
                    ->with('flash_error_message', 'No se pueden editar los factores criticos de un pmi presentado.');
            }
            $factorCritico = FactorCritico::where('id', $factorCriticoId)
                ->with('calificacion.grupo.padre')
                ->first();

            if (!$factorCritico) {
                return redirect()
                    ->route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmi ])
                    ->with('flash_error_message', 'Factor critico no encontrado.');
            }
            $this->objetivoVinculadoService
                ->syncObjetivosVinculados( objetivosArray: $request->input('objetivos'), idFactorCritico: $factorCritico->id );

            return redirect()
                ->route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmi ])
                ->with('flash_success_message', 'Factor critico actualizad correctamente.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmi ])
                ->with('flash_error_message', 'Ocurrió un error al actualizar el factor crítico: '. $e->getMessage());
        }
    }
}
