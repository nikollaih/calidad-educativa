<?php

namespace App\Http\Controllers;

use App\Models\Seguridad\Permission\Permission;
use App\Models\Seguridad\Role\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller {
    public function index() {
        $roles = Role::with('permissions')
            ->whereNot('name','super_admin')
            ->paginate(10);
        return view('roles.index', compact('roles'));
    }


    /**
     * Obtiene todas los roles
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse {
        try {
            // Se carga la relación con el representante para el JSON.
            $roles = Role::get();
            return response()->json($roles, 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al obtener los roles: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create() {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

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

    public function edit(Role $role) {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

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


    public function destroy(Role $role) {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
