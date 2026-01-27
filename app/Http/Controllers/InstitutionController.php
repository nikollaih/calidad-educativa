<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstitucionRequest;
use App\Http\Resources\UpdatePeiResource;
use App\Http\Services\AdjuntoService;
use App\Http\Services\AutoevaluacionService;
use App\Http\Services\RedesSocialesService;
use App\Models\Adjunto;
use App\Models\Autoevaluacion;
use App\Models\FactorCritico;
use App\Models\FactorCriticoCalificacion;
use App\Models\GrupoCalificacion;
use App\Models\Institucion;
use App\Models\Municipio;
use App\Models\PeiHistorial;
use App\Models\Seguridad\Role\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InstitutionController extends Controller {
    public function __construct(
        private AdjuntoService $adjuntoService,
        private RedesSocialesService $redesSocialesService,
        private AutoevaluacionService $autoevaluacionService,
    ) {
    }

    public function index(InstitucionRequest $request) {
        $municipioId = request()->query('municipio_id');
        $paginate = Institucion::with('licenciaFuncionamiento','redesSociales')
            ->when($municipioId, function ($query, $municipioId) {
                $query->where('municipio_id', $municipioId);
            })
            ->filters($request->filters())
            ->paginate('10');
        return view(
            'institutional_profile.institution.index',
            [
                'paginate' =>$paginate
            ]
        );
    }
    public function usuariosInstitucionByRector(InstitucionRequest $request) {
        $institucion = Auth::user()->institucion;
        if (empty($institucion)) {
            return redirect()->back()->with('flash_error_message', 'Debes estar asociado a una institucion.');
        }

        $paginate = User::whereHas('instituciones', function($query) use ($institucion) {
            $query->where('institucions.id', $institucion->id);
        })->paginate(10);

        // Agregar is_active directamente a cada usuario
        $paginate->getCollection()->transform(function($user) use ($institucion) {
            $pivot = \DB::table('institucion_user')
                ->where('user_id', $user->id)
                ->where('institucion_id', $institucion->id)
                ->first();

            $user->is_active = $pivot ? $pivot->is_active : null;
            return $user;
        });
        return view(
            'usuarios_institucion.index',
            [
                'paginate' =>$paginate
            ]
        );
    }
    public function createUsuariosInstitucion() {
        $roles = Role::with('permissions')->whereIn('name',['Docente','Administrativo'])->get();
        return view(
            'usuarios_institucion.create',
            [
                'roles'=> $roles,
            ]
        );
    }
    public function editUsuarioInstitucion(Request $request, int $userId) {
        $user = User::where('id', $userId)->with('roles')->first();
        if (empty($user)) {
            return redirect()->back()->with('flash_error_message', 'Usuario no encontrado.');
        }
        $roles = Role::with('permissions')->whereIn('name',['Docente','Administrativo'])->get();
        return view(
            'usuarios_institucion.edit',
            [
                'roles'=> $roles,
                'user' => $user,
            ]
        );
    }
    public function storeUsuariosInstitucion(InstitucionRequest $request) {
        /**
         * @var Institucion|null $institution
         */
        $institution = Auth::user()?->institucion;
        if (empty($institution)) {
            return redirect()->back()->with('flash_error_message', 'Error al obtener la institución del rector.');
        }
        $userData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
        ]);
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);
        // Asignar varios roles
        $user->syncRoles($userData['roles']);
        $institution->users()->attach($user->id);
        return redirect()->route('instituciones.usuarios_institucion-index')
            ->with('flash_success_message', 'Usuario creado correctamente.');
    }
    public function updateUsuariosInstitucion(InstitucionRequest $request, User $user) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Asignar varios roles
        $user->syncRoles($validated['roles']);
        return redirect()->route('instituciones.usuarios_institucion-index')
            ->with('flash_success_message', 'Usuario creado correctamente.');
    }
    public function deleteUsuarioInstitucion(Request $request, User $user) {
        /**
         * @var Institucion|null $institution
         */
        $institution = Auth::user()?->institucion;
        if (empty($institution)) {
            return redirect()->back()->with('flash_error_message', 'Error al obtener la institución del rector.');
        }
        if ($institution->users()->where('users.id', $user->id)->exists()) {
            $user->delete();
            return redirect()->route('instituciones.usuarios_institucion-index')
                ->with('flash_success_message', 'Usuario creado correctamente.');
        }
        return redirect()->back()->with('flash_error_message', 'El usuario no pertenece a la institución.');
    }

    /**
     * Obtiene todas las instituciones
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse {
        try {
            $instituciones = Institucion::all();

            return response()->json($instituciones, 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al obtener las instituciones: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(int $institucion) {
        $municipios = Municipio::get();
        $institucion = Institucion::with(
            'licenciaFuncionamiento',
            'redesSociales',
            'rector',
            'sedes.levelSedeEducational.educationalLevel',
            'sedes.levelSedeEducational.schedules',
            'sedes.levelSedeEducational.schedules.anexo',
            'sedes.educationalOffer'
        )
            ->where('id',$institucion)
            ->first();
        if (!$institucion) {
            return redirect()->route('institution.index')->with('flash_error_message', "No se encontró la institución.");
        }
        return view('institutional_profile.institution.show', ['institution' => $institucion, 'municipios' => $municipios]);
    }
    public function fortalezasDebilidades(int $autoevaluacionId) {
        $fortalezasDebilidades = $this->autoevaluacionService->getFortalezasDebilidades(autoevaluacionId:$autoevaluacionId);
        $autoevaluacionOwner = Autoevaluacion::find($autoevaluacionId);
        $institucionNombre = null;
        if ($autoevaluacionOwner) {
            $institucionNombre = Institucion::find($autoevaluacionOwner->institucion_id)?->nombre;
        }
        return view(
            'institutional_profile.institution.resultados.form',
            array_merge($fortalezasDebilidades, [
                'institucionNombre' => $institucionNombre,
            ])
        );
    }

    public function sincronizarFactoresCriticos(Request $request, $autoevaluacionId) {
        $factores = $request->input('factores');
        $institucionId = $request->input('institucionId');
        // Recolectar los registros v?lidos que vamos a mantener
        $idsParaMantener = [];
        foreach ($factores as $factor) {
            $descripcion = $factor['descripcion'] ?? null;
            $valor = (int) $factor['valor'];
            $autoevaluacionId = (int) $factor['autoevaluacion_id'];
            $calificacionIndice = $factor['calificacion_indice'];

            // Buscar si ya existe uno igual
            $factorCritico = FactorCritico::firstOrCreate(
                [
                    'calificacion_indice' => $calificacionIndice,
                    'autoevaluacion_id' => $autoevaluacionId,
                    'descripcion' => $descripcion,
                    'valor' => $valor,
                ]
            );

            // Verificar si ya existe uno con mismo descripcion + indice_calificacion
            // con institucion_id NULL o exactamente el mismo institucion_id
            $existe = FactorCriticoCalificacion::where('descripcion', $descripcion)
                ->where('indice_calificacion', $calificacionIndice)
                ->where(function ($q) use ($institucionId) {
                    $q->whereNull('institucion_id')
                      ->orWhere('institucion_id', $institucionId);
                })
                ->exists();

            // Si no existe, lo creamos
            if (! $existe) {
                FactorCriticoCalificacion::create([
                    'descripcion' => $descripcion,
                    'indice_calificacion' => $calificacionIndice,
                    'institucion_id' => $institucionId,
                ]);
            }


            $idsParaMantener[] = $factorCritico->id;
        }

        FactorCritico::where('autoevaluacion_id', $autoevaluacionId)
            ->whereNotIn('id', $idsParaMantener)
            ->delete();
        // Redirigir usando el primer autoevaluacion_id
        return redirect()->route('institution.fort_deb', ['autoevaluacionId' => $autoevaluacionId])
            ->with('flash_success_message', "Resultados actualizados correctamente");
    }
    public function autoevaluaciones(InstitucionRequest $request, int $institution ) {
        $autoevaluaciones = Autoevaluacion::where('institucion_id',$institution)->paginate(10);
        $institucionNombre = Institucion::find($institution)?->nombre;
        return view('institutional_profile.institution.autoevaluaciones.index', [
            'institutionId' => $institution,
            'autoevaluaciones' => $autoevaluaciones,
            'institucionNombre' => $institucionNombre,
        ]);
    }
    public function autoevaluacionesCrear(InstitucionRequest $request, int $institution ) {
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
    public function autoevaluacionesEditar(InstitucionRequest $request, int $autoevaluacionId = null) {
        $autoevaluacion = Autoevaluacion::with('notas','notas.calificacion')->where('id', $autoevaluacionId)->first();
        if (empty($autoevaluacionId)) {
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
    public function autoevaluacionesVer(int $autoevaluacionId = null) {
        $autoevaluacion = Autoevaluacion::with('notas','notas.calificacion', 'notas.calificacion.grupo','notas.calificacion.grupo.padre')
            ->where('id', $autoevaluacionId)->first();
        if (empty($autoevaluacionId)) {
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
                $subGruposFormateados = $baseGroup->hijos->map( function ( $subGrupo) use ($formattedNotes) {
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
        return view('institutional_profile.institution.autoevaluaciones.ver', [
            'gruposCalificaciones' => $gruposCalificaciones,
            'autoevaluacion' => $autoevaluacion,
            'statistics' => $statistics,
            'institucionId' => $autoevaluacion->institucion_id,
            'institucionNombre' => Institucion::find($autoevaluacion->institucion_id)?->nombre,
        ]);
    }
    public function autoevaluacionesAlmacenar(Request $request) {
        $autoevaluacionData =  $request->input('autoevaluacion');
        $autoevaluacionData['alias_estado'] = "PROCESO";
        $notas = $request->input('notas');

        $autoevaluacionOld = Autoevaluacion::where($autoevaluacionData)->first();
        if ($autoevaluacionOld) {
            return redirect()->route('institution.autoevaluaciones',  ['institution' => $autoevaluacionOld->institucion_id])->with('flash_error_message', "Error! ya existe una  autoevaluación con esa vigencia");
        }

        $autoevaluacion = Autoevaluacion::create($autoevaluacionData);

        if ($notas) {
            $syncData = [];

            foreach ($notas as $nota) {
                $syncData[$nota['nota_calificacion_id']] = ['evidencia' => $nota['evidencia']];
            }
            $autoevaluacion->notas()->sync($syncData);
        }
        return redirect()->route('institution.autoevaluaciones',  ['institution' => $autoevaluacion->institucion_id])->with('flash_success_message', "Autoevaluación creada correctamente");
    }
    public function autoevaluacionesValidar(Request $request, int $autoevaluacionId = null) {
        $autoevaluacion = Autoevaluacion::find($autoevaluacionId);

        if (!$autoevaluacion) {
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');
        }
        $notasPendientes = $this->autoevaluacionService->obtenerNotasPendientes(autoevaluacion: $autoevaluacion);
        if ($notasPendientes->count() != 0) {
            return redirect()->route('institution.autoevaluaciones',  ['institution' => $autoevaluacion->institucion_id])->with('tiene_notas_pendientes', $notasPendientes);
        }
        $this->autoevaluacionService->getFortalezasDebilidades(autoevaluacionId:$autoevaluacionId);
        $cantidadFactoresCriticosPriorizados = $autoevaluacion->factoresCriticos->where('valor', '>','3')->count();
        if ($cantidadFactoresCriticosPriorizados < 2 ) {
            return redirect()
                ->route('institution.autoevaluaciones',  ['institution' => $autoevaluacion->institucion_id])
                ->with('flash_error_message','Debe tener almenos dos factores crítico priorizados');
        }
        $autoevaluacion->alias_estado = "VALIDACION";
        $autoevaluacion->save();
        return redirect()->route(
            'institution.autoevaluaciones',
            ['institution' => $autoevaluacion->institucion_id]
        )->with('flash_success_message', 'Autoevaluación enviada a validación correctamente');
    }
    public function autoevaluacionesAlmacenarActualizacion(Request $request, int $autoevaluacionId = null) {
        $autoevaluacion = Autoevaluacion::find($autoevaluacionId);
        $notas = $request->input('notas');

        if (!$autoevaluacion) {
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');
        }

        if ($notas) {
            $syncData = [];

            foreach ($notas as $nota) {
                $syncData[$nota['nota_calificacion_id']] = ['evidencia' => $nota['evidencia']];
            }
            $autoevaluacion->notas()->sync($syncData);
        }
        return redirect()->route('institution.autoevaluaciones',  ['institution' => $autoevaluacion->institucion_id])->with('flash_success_message', "Autoevaluación actualizada correctamente");
    }

    public function autoevaluacionesActualizarHijo(Request $request, int $autoevaluacionId, int $hijoId) {
        $autoevaluacion = Autoevaluacion::find($autoevaluacionId);
        $notas = $request->input('notas');

        if (!$autoevaluacion) {
            return redirect()->back()->with('flash_error_message', 'Autoevaluación no encontrada.');
        }

        // Obtener el hijo (grupo) para validar
        $hijo = GrupoCalificacion::with('calificaciones')->find($hijoId);

        if (!$hijo) {
            return redirect()->back()->with('flash_error_message', 'Componente no encontrado.');
        }

        // Obtener los IDs de las calificaciones que pertenecen a este hijo
        $calificacionesDelHijo = $hijo->calificaciones->pluck('id')->toArray();

        if ($notas) {
            $syncData = [];

            foreach ($notas as $nota) {
                // Verificar que la nota pertenece a una calificación de este hijo
                $notaCalificacion = \App\Models\NotaCalificacion::with('calificacion')->find($nota['nota_calificacion_id']);

                if ($notaCalificacion && in_array($notaCalificacion->calificacion->id, $calificacionesDelHijo)) {
                    $syncData[$nota['nota_calificacion_id']] = ['evidencia' => $nota['evidencia']];
                }
            }

            // Sincronizar solo las notas de este hijo (sin desconectar las demás)
            if (!empty($syncData)) {
                $autoevaluacion->notas()->syncWithoutDetaching($syncData);
            }
        }

        return redirect()->route('institution.autoevaluaciones-editar', ['autoevaluacionId' => $autoevaluacionId])
            ->with('flash_success_message', "Componente '{$hijo->nombre}' actualizado correctamente");
    }
    public function create() {
        $municipios = Municipio::get();
        // Lista de rectores disponibles
        $availableRectors = User::whereHas('roles', function ($query) {
            $query->where('name', 'rector');
        })
        ->where(function ($query) {
            $query->whereDoesntHave('institucion');
        })
        ->get();
        // $roles = Role::all();
        return view('institutional_profile.institution.create', ['municipios' => $municipios, 'availableRectors' => $availableRectors]);
    }
    public function store(Request $request) {
        if ($request->rector_id == null) {
            return redirect()->route('institution.create')->with('flash_error_message', 'Se debe seleccionar un rector.');
        }

        // Intenta almacenar el Adjunto
        $storeAdjuntoResponse = $this->adjuntoService->storeAdjunto($request->file('licencia_funcionamiento'),'institucion/licencia_funcionamiento','public');

        if ($storeAdjuntoResponse->success == false) {
            return redirect()->route('institution.create')->with('flash_error_message', $storeAdjuntoResponse->msg);
        }
        $institutionData = $request->all();
        $institutionData['licencia_funcionamiento'] = $storeAdjuntoResponse->data->id;
        // Crea la institucion
        $institutionCreated = Institucion::create($institutionData);
        // crea las gestiones de PEI
        Institucion::createEmptyPeiFor($institutionCreated->id);
        if (isset($institutionData['redes_sociales'])) {
            // Sincroniza las redes sociales de la institucion
            $this->redesSocialesService->syncRedesSociales($institutionData['redes_sociales'],$institutionCreated);
        }
        return redirect()->route('institution.index')->with('flash_success_message', "Institución creada correctamente.");
    }
    public function edit(int $institucion) {
        $municipios = Municipio::get();
        $institucion = Institucion::with(
            'licenciaFuncionamiento',
            'redesSociales',
            'rector',
            'sedes.levelSedeEducational.educationalLevel',
            'sedes.levelSedeEducational.schedules',
            'sedes.levelSedeEducational.schedules.anexo',
            'sedes.educationalOffer'
        )
            ->where('id',$institucion)
            ->first();
        if (!$institucion) {
            return redirect()->back()->with('flash_error_message', 'Institución no encontrada.');
        }
        // ID del rector actual de la institución (si existe)
        $rectorActualId = $institucion->rector?->id;
        // Lista de rectores disponibles
        $availableRectors = User::whereHas('roles', function ($query) {
            $query->where('name', 'rector');
        })
        ->where(function ($query) use ($rectorActualId) {
            $query->whereDoesntHave('institucion')
                  ->orWhere('id', $rectorActualId);
        })
        ->get();

        return view('institutional_profile.institution.edit',
            [
                'institution' => $institucion ,
                'municipios' => $municipios,
                'availableRectors' => $availableRectors
            ]);
    }
    public function update(Request $request, int $institucion) {
        $institucionToUpdate = Institucion::with('redesSociales')
           ->where('id', $institucion)
           ->first();

        if (!$institucionToUpdate) {
            return redirect()->back()->with('flash_error_message', 'Institución no encontrada.');
        }
        if ($request->rector_id == null) {
            return redirect()->back()->with('flash_error_message', 'Se debe seleccionar un rector.');
        }
        $institutionData = $request->all();

        if ($request->hasFile('licencia_funcionamiento')) {
            $storeAdjuntoResponse = $this->adjuntoService->storeAdjunto($request->file('licencia_funcionamiento'),'institucion/licencia_funcionamiento','public');
            if ($storeAdjuntoResponse->success == false) {
                return redirect()->route('institution.create')->with('flash_error_message', $storeAdjuntoResponse->msg);
            }
            $institutionData['licencia_funcionamiento'] = $storeAdjuntoResponse->data->id;
        }
        $institucionToUpdate->fill($institutionData);
        $institucionToUpdate->save();
        if (isset($institutionData['redes_sociales'])) {
            // Sincroniza las redes sociales de la institucion
            $this->redesSocialesService->syncRedesSociales($institutionData['redes_sociales'],$institucionToUpdate);
        }

        return redirect()->route('institution.edit',$institucion)->with('success', 'Institución actualizada correctamente.');
    }
    public function destroy(int $institucion) {
        $institucionToDel = Institucion::find($institucion);
        if (!$institucionToDel) {
            return redirect()->route('institution.index')->with('flash_error_message', "No se encontró la institución.");
        }

        $institucionToDel->redesSociales()->delete();
        $institucionToDel->delete();
        return redirect()->route('institution.index')->with('flash_success_message', "Institución Eliminada correctamente.");
    }

    public function pei(int $institucion) {
        $institucionData = Institucion::with([
                'gestionDirectiva',
                'gestionAcademica',
                'gestionComunidad',
                'gestionAdministrativa',
                'resenaHistorica',
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
            'resena_historica' => $institucionData->resenaHistorica ?? null,
            'gestion_administrativa' => $institucionData->gestionAdministrativa ?? null,
            'institucionId' => $institucion,
            'institucionNombre' => $institucionData->nombre,
        ]);
    }

    public function peiManageInformation(int $institucion) {
        $institucionData = Institucion::with([
                'gestionDirectiva',
                'gestionAcademica',
                'gestionComunidad',
                'gestionAdministrativa',
                'resenaHistorica',
            ])
            ->where('id', $institucion)
            ->first();

        return view('institutional_profile.institution.pei.update_pei', [
            'institucionData' => new UpdatePeiResource($institucionData),
            'institucionId' => $institucion,
            'institucionNombre' => $institucionData->nombre,
        ]);
    }

    public function updatePei(Request $request, int $institutionId) {
        DB::beginTransaction();

        try {
            // Validar los datos recibidos
            $validated = $request->validate([
                'tipo_codificacion' => 'required|integer',
                'fecha' => 'required',
                'observacion' => 'nullable|string|max:500',
                'relation_name' => 'required|string',
                'documento_adicional' => 'file',
            ]);

            $input = $request->all();

            // Obtener la instituci?n con relaciones
            $institucion = Institucion::with([
                'gestionDirectiva',
                'gestionAcademica',
                'gestionComunidad',
                'gestionAdministrativa',
                'resenaHistorica',
            ])->findOrFail($institutionId);

            // Definir propiedades a eliminar del input
            $propiedadesAEliminar = [
                'relation_name',
                'tipo_codificacion',
                'fecha',
                'observacion',
                'institucion_id',
                'documento_adicional',
                'hijo_index'
            ];
            $documentos = array_filter($input, function($value, $key) {
                // Incluir solo las claves que contienen "anexo" y excluir "documento_adicional"
                return $key !== 'documento_adicional' &&
                    $value instanceof \Illuminate\Http\UploadedFile;
            }, ARRAY_FILTER_USE_BOTH);

            // Filtrar datos para actualizaci?n
            $dataToUpdate = array_diff_key($input, array_flip($propiedadesAEliminar));
            // Obtener el modelo objetivo
            $relationPath = str_replace('->', '.', $input['relation_name']);
            $model = data_get($institucion, $relationPath);

            // Almacena los documentos nuevos
            foreach ($documentos as $key => $value) {
                $adjuntoInfo = [];

                // Obtener la extensi?n original del archivo
                $adjuntoInfo['extension']        = $value->getClientOriginalExtension();
                // Obtiene el nombre del archivo
                $adjuntoInfo['nombre']           =  pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);
                // Obtiene el nombre completo del archivo
                $adjuntoInfo['nombre_completo']  =  $value->getClientOriginalName();
                // Obtiene el tipo MIME del archivo
                $adjuntoInfo['tipo_mime']             = $value->getClientMimeType();
                // Obtiene el disco del archivo
                $adjuntoInfo['disco']             = 'public';

                // Generar un nombre ?nico
                $nombreUnico = $adjuntoInfo['nombre'] . '_' . uniqid() . '.' . $adjuntoInfo['extension'];

                // Guardar archivo
                $rutaArchivo = $value->storeAs("institucion/{$institutionId}/pei_attachments", $nombreUnico, 'public');

                if ($rutaArchivo) {
                    $adjuntoInfo['ruta'] = $rutaArchivo;
                    $adjuntoGuardado = Adjunto::create($adjuntoInfo);
                    $snakeKey = Str::snake($key);
                    $dataToUpdate[$snakeKey] = $adjuntoGuardado->id;
                }
            }

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
            $guardaArchivoAdicional = null;
            // Guarda documento de edicion
            if ($request->hasFile('documento_adicional')) {
                $guardaArchivoAdicional = $this->adjuntoService->storeAdjunto($request->file('documento_adicional'),"institucion/{$institutionId}/edicion_pei",'public');
            }
            // Crear registro de historial
            $historial = PeiHistorial::create([
                'model_id' => $model->getKey(),
                'model_type' => get_class($model),
                'attachment_id' => $guardaArchivoAdicional?->data?->id,
                'tipo_codificacion' => (int) $input['tipo_codificacion'],
                'date' => Carbon::parse($input['fecha']),
                'observation' => !empty($input['observacion']) ? $input['observacion'] : null,
                'old_data' => $filteredOldData,
                'new_data' => $newData,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'PEI actualizado correctamente',
                'changes' => count($changedFields),
                'historial_id' => $historial->id,
                'validated_data' => $validated // A?adimos esto
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
