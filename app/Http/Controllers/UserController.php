<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Institucion;
use App\Models\Seguridad\Role\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        $allowedSorts = ['name', 'email', 'id'];
        if (! in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (! in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $usuarios = User::with('roles')->orderBy($sort, $direction)->paginate(10);

        return view('usuarios.index', compact('usuarios', 'sort', 'direction'));
    }

    public function all()
    {
        try {
            $usuarios = User::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $usuarios,
                'message' => 'Usuarios obtenidos correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos: '.$e->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
        $roles = Role::with('permissions')->whereNot('name', 'super_admin')->get();
        $institutionsWithoutRector = Institucion::whereNull('deleted_at')->whereNull('rector_id')->get();
        $institutions = Institucion::whereNull('deleted_at')->get();

        return view(
            'usuarios.create',
            [
                'roles' => $roles,
                'institutionsWithoutRector' => $institutionsWithoutRector,
                'institutions' => $institutions,
            ]
        );
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Asignar varios roles
        $user->syncRoles($validated['roles']);

        // Si el usuario es rector,
        if (isset($validated['institucion_id'])) {
            $institucion = Institucion::findOrFail($validated['institucion_id']);
            if (in_array('rector', $validated['roles'])) {
                $institucion->rector_id = $user->id;
                $institucion->save();
            } else {
                $canBelongInstitution = Role::whereIn('name', $validated['roles'])
                    ->whereHas('permissions', function ($query) {
                        $query->where('name', 's-institucion-pertenecer_una');
                    })
                    ->exists();
                if ($canBelongInstitution) {
                    $institucion->users()->attach($user->id);
                }
            }
        }

        return redirect()->route('usuarios.index')
            ->with('flash_success_message', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        // Carga los roles;
        $usuario->load('roles.permissions');
        $usuario->load('instituciones');
        if ($usuario->hasRole('rector')) {
            $usuario->institucion;
        }
        $roles = Role::with('permissions')->whereNot('name', 'super_admin')->get();
        $institutionsWithoutRector = Institucion::whereNull('deleted_at')
            ->where(function ($query) use ($usuario) {
                $query->whereNull('rector_id')
                    ->orWhere('rector_id', $usuario->id);
            })
            ->get();
        $institutions = Institucion::whereNull('deleted_at')->get();

        return view(
            'usuarios.edit',
            [
                'usuario' => $usuario,
                'roles' => $roles,
                'institutionsWithoutRector' => $institutionsWithoutRector,
                'institutions' => $institutions,
            ]
        );
    }

    public function update(UpdateUserRequest $request, User $usuario)
    {
        $validated = $request->validated();
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $usuario->password,
        ]);

        // Asignar varios roles
        $usuario->syncRoles($validated['roles']);

        // Si el usuario es rector,
        if (isset($validated['institucion_id'])) {
            $institucion = Institucion::findOrFail($validated['institucion_id']);
            if (in_array('rector', $validated['roles'])) {
                // se intenta obtener la institucion a la que el rector pertenece
                if ($usuario->institucion && ($usuario->institucion->id != $validated['institucion_id'])) {
                    // Se remueve la vinculacion a la institucion
                    $institucion = $usuario->institucion;
                    $institucion->rector_id = null;
                    $institucion->save();
                }
                $institucion->rector_id = $usuario->id;
                $institucion->save();
            } else {
                $canBelongInstitution = Role::whereIn('name', $validated['roles'])
                    ->whereHas('permissions', function ($query) {
                        $query->where('name', 's-institucion-pertenecer_una');
                    })
                    ->exists();
                if ($canBelongInstitution) {
                    // Desvincular todas las instituciones del usuario
                    $usuario->instituciones()->detach();
                    $institucion->users()->attach($usuario->id);
                }
            }
        }

        return redirect()->route('usuarios.index')->with('flash_success_message', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
