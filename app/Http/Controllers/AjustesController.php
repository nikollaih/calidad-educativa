<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Clase AjustesController
 *
 * Este controlador se utiliza para gestionar los ajustes del sistema, incluyendo la administración
 * de roles, permisos y configuraciones relacionadas con las imágenes del sistema.
 *
 * @package App\Http\Controllers
 * @author Juan Sebastian Rojas
 * @version 1.0.0
 */
class AjustesController extends Controller {
    public function __construct(
        private AdjuntoService $adjuntoService,
    ) {
    }

    /**
         * Muestra la página principal de ajustes del sistema.
         *
         * @return \Illuminate\View\View Vista de la página de ajustes con los roles obtenidos.
         */
    public function index() {
        $roles = Role::with('permissions')->paginate(10);
        return view('ajustes.index', compact('roles'));
    }
    /**
         * Actualiza las imágenes del sistema, como el favicon y el logo.
         *
         * @param \Illuminate\Http\Request $request Solicitud HTTP con los archivos de imagen.
         * @return \Illuminate\Http\RedirectResponse Redirección a la página de ajustes con mensaje de éxito o error.
         */
    public function actualizarImagenesSistema(Request $request) {
        $msg = '';
        if ($request->hasFile('favicon')) {
            // Intenta almacenar el Adjunto
            $storeFaviconResponse = $this->adjuntoService
                ->storeFavicon($request->file('favicon'));

            if ($storeFaviconResponse->success == false) {
                return redirect()->route('ajustes.index')->with('flash_error_message', $storeFaviconResponse->msg);
            } else {
                $msg = $storeFaviconResponse->msg . '. ';
            }
        }
        if ($request->hasFile('logo')) {
            // Intenta almacenar el Adjunto
            $storeLogoResponse = $this->adjuntoService
                ->storeLogo($request->file('logo'));

            if ($storeLogoResponse->success == false) {
                return redirect()->route('ajustes.index')->with('flash_error_message', $storeLogoResponse->msg);
            } else {
                $msg = $storeLogoResponse->msg . '. ';
            }
        }
        return redirect()->route('ajustes.index')->with('flash_success_message', $msg);
    }

    /**
         * Muestra el formulario para crear un nuevo rol.
         *
         * @return \Illuminate\View\View Vista del formulario de creación de roles.
         */
    public function create() {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
         * Almacena un nuevo rol en la base de datos.
         *
         * @param \Illuminate\Http\Request $request Solicitud HTTP con los datos del rol.
         * @return \Illuminate\Http\RedirectResponse Redirección a la lista de roles con mensaje de éxito.
         */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create(['name' => $request->name]);

        // Asegurarte de que los permisos estén en el guard `web`
        $permissions = Permission::whereIn('id', $request->permissions)
            ->where('guard_name', 'web')
            ->get();

        $role->givePermissionTo($permissions);

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    /**
         * Muestra el formulario para editar un rol existente.
         *
         * @param Role $role Instancia del rol a editar.
         * @return \Illuminate\View\View Vista del formulario de edición de roles.
         */
    public function edit(Role $role) {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
         * Actualiza los datos de un rol existente.
         *
         * @param \Illuminate\Http\Request $request Solicitud HTTP con los datos actualizados del rol.
         * @param Role $role Instancia del rol a actualizar.
         * @return \Illuminate\Http\RedirectResponse Redirección a la lista de roles con mensaje de éxito.
         */
    public function update(Request $request, Role $role) {
        $request->validate([
            'name' => "required|unique:roles,name,{$role->id}",
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id' // Asegurar que sean IDs válidos
        ]);

        // Actualizar nombre del rol
        $role->update(['name' => $request->name]);

        // Sincronizar permisos por ID
        $role->syncPermissions(Permission::whereIn('id', $request->permissions)->pluck('name'));

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }


    /**
         * Elimina un rol existente del sistema.
         *
         * @param Role $role Instancia del rol a eliminar.
         * @return \Illuminate\Http\RedirectResponse Redirección a la lista de roles con mensaje de éxito.
         */
    public function destroy(Role $role) {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
