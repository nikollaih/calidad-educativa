<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use App\Http\Services\AutoevaluacionService;
use App\Http\Services\RedesSocialesService;
use App\Models\Adjunto;
use App\Models\Institucion;
use App\Models\Municipio;
use App\Models\ProyectosTransversal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProyectoTransversalController extends Controller {
    public function __construct(
        private AdjuntoService $adjuntoService,
        private RedesSocialesService $redesSocialesService,
        private AutoevaluacionService $autoevaluacionService,
    ) {
    }

    public function index(int $institucionId) {
        $usuarioActual = auth()->user()->load('roles');

        // Verifica si el usuario tiene el rol de 'rector'
        $esRector = $usuarioActual->roles->contains('name', 'rector');
        $proyectosTransversales = ProyectosTransversal::with(['representante', 'actoAdministrativo'])->whereHas('institucion', function ($query) use ($institucionId) {
            $query->where('id', $institucionId);
        })->paginate(10);

        return view('proyectoTransversal.index', [
            'institucionId' => $institucionId,
            'proyectosTransversales' => $proyectosTransversales,
            'esRector' => $esRector,
            'institucionNombre' => Institucion::find($institucionId)?->nombre,
        ]);
    }

    public function store(Request $request, int $institucion) {
        // Se agregan las reglas de validaci?n para todos los campos de la solicitud, incluyendo el archivo.
        // Se ha modificado la regla 'mimes' para aceptar formatos de imagen.
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'numero_contacto' => 'nullable|string',
            'representante_id' => [
                'required',
                'exists:users,id',
                'unique:proyectos_transversales,representante_id',
            ],
            'acto_administrativo' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,svg,webp|max:10240',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'representante_id.required' => 'El representante es obligatorio.',
            'representante_id.exists' => 'El representante seleccionado no es válido.',
            'representante_id.unique' => 'El representante seleccionado ya está relacionado con otro proyecto transversal.',
            'numero_contacto.string' => 'El número de contacto debe ser una cadena de texto.',
            'acto_administrativo.required' => 'El archivo del acto administrativo es obligatorio.',
            'acto_administrativo.file' => 'El acto administrativo debe ser un archivo.',
            'acto_administrativo.mimes' => 'El archivo del acto administrativo debe ser de tipo: pdf, doc, docx, jpeg, jpg, png, gif, svg, webp.',
            'acto_administrativo.max' => 'El tama?o del archivo no debe superar los 10MB.',
        ]);

        // Se agrega la l?gica para guardar el archivo.
        if ($request->hasFile('acto_administrativo')) {
            $actoAdministrativo = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('acto_administrativo'),
                ruta: 'actos_administrativos',
                disk: 'public'
            );
        }

        ProyectosTransversal::create([
            'institucion_id' => $institucion,
            'acto_administrativo_id' => $actoAdministrativo?->data?->id,
            'representante_id' => $request?->representante_id,
            'nombre' => $request?->nombre,
            'descripcion' => $request?->descripcion,
            'numero_contacto' => $request?->numero_contacto,
        ]);

        return redirect()->route('proyectos-transversales.index', ['institucionId' => $institucion])->with('flash_success_message', 'Proyecto transversal creada correctamente.');
    }

    public function edit(int $institucion) {
        $municipios = Municipio::get();
        $institucion = Institucion::with(
            'licenciaFuncionamiento',
            'redesSociales',
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
        return view('institutional_profile.institution.edit', ['institution' => $institucion , 'municipios' => $municipios]);
    }

    public function update(Request $request, int $institucion, int $proyectoTransversal) {
        $request->validate([
            'nombre' => 'required|string',
            'representante_id' => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
            'numero_contacto' => 'nullable|string',
            'acto_administrativo' => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png,gif,svg,webp|max:10240',
        ]);

        // CAMBIO: Se busca el proyecto transversal por el ID en la URL.
        $proyectoTransversalModel = ProyectosTransversal::with('institucion')->findOrFail($proyectoTransversal);
        // Se carga el usuario en sesion para hacer validaciones
        $authUser = Auth::user();
        // En caso de que sea rector, se valida que sea el rector de la institucion
        $isRector = $authUser->hasRole('Rector') && $authUser->id == $proyectoTransversalModel->institucion->institucions;
        // En caso de que tenga permiso de gestionar PPT se valida que sea el lider
        $isLeader = $authUser->can('s-PPT-gestionar') && $authUser->id == $proyectoTransversalModel->representante_id;
        // Bandera para definir si el usuario en sesion puede hacer ediciones
        $canEdit = $authUser->hasRole('super_admin') ||
            $authUser->can('s-institucion-editar') ||
            $isRector ||
            $isLeader;
        if ( !$canEdit) {
            return redirect()
                ->back()
                ->with('flash_error_message', 'No tienes permisos para editar este proyecto transversal, debes ser el rector de la institución o ser el lider del proyecto o tener permisos para editar instituciones.');
        }
        // Se inicializa el ID del adjunto actual.
        $acto_administrativo_id = $proyectoTransversalModel->acto_administrativo_id;

        if ($request->hasFile('acto_administrativo')) {
            // Guarda el nuevo archivo usando el servicio.
            $newAdjunto = $this->adjuntoService->storeAdjunto(
                adjunto: $request->file('acto_administrativo'),
                ruta: 'actos_administrativos',
                disk: 'public'
            );

            // Actualiza el ID del adjunto para el registro.
            $acto_administrativo_id = $newAdjunto?->data?->id;

            if ($proyectoTransversalModel->acto_administrativo) {
                Storage::disk('public')->delete($proyectoTransversalModel->acto_administrativo->ruta);
                $proyectoTransversalModel->acto_administrativo->delete();
            }
        }

        // CAMBIO: Se actualizan los datos del proyecto, incluyendo el nuevo ID del adjunto si se subi? uno.
        $proyectoTransversalModel->update([
            'institucion_id' => $institucion,
            'representante_id' => $request->representante_id,
            'acto_administrativo_id' => $acto_administrativo_id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'numero_contacto' => $request->numero_contacto,
        ]);

        // CAMBIO: Se redirecciona a la ruta de proyectos transversales con el ID de la instituci?n.
        return redirect()->route('proyectos-transversales.index', ['institucionId' => $institucion])->with('flash_success_message', 'Proyecto Transversal actualizado correctamente.');
    }

    public function destroy(int $institucion, int $proyectoTransversal) {
        $proyectoTransversal = ProyectosTransversal::findOrFail($proyectoTransversal);

        $proyectoTransversal->delete();
        return redirect()->route('proyectos-transversales.index', ['institucionId' => $institucion])->with('flash_success_message', 'Proyecto Transversal eliminada correctamente.');
    }
}
