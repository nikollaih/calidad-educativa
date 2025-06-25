<?php

namespace App\Http\Controllers;

use App\Http\Services\AdjuntoService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AjustesController extends Controller
{
    public function __construct(
        private AdjuntoService $adjuntoService,
    ){}

    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('ajustes.index', compact('roles'));
    }
    public function actualizarImagenesSistema(Request $request)
    {
        $msg = '';
        if($request->hasFile('favicon')){
            // Intenta almacenar el Adjunto
            $storeFaviconResponse = $this->adjuntoService
                ->storeFavicon($request->file('favicon'));

            if ($storeFaviconResponse->success == false){
                return redirect()->route('ajustes.index')->with('flash_error_message', $storeFaviconResponse->msg);
            } else {
                $msg = $storeFaviconResponse->msg . '. ';
            }
        }
        if($request->hasFile('logo')){
            // Intenta almacenar el Adjunto
            $storeLogoResponse = $this->adjuntoService
                ->storeLogo($request->file('logo'));

            if ($storeLogoResponse->success == false){
                return redirect()->route('ajustes.index')->with('flash_error_message', $storeLogoResponse->msg);
            } else {
                $msg = $storeLogoResponse->msg . '. ';
            }
        }
        return redirect()->route('ajustes.index')->with('flash_success_message', $msg);

    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
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

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
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


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
