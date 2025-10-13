<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use App\Models\Seguridad\Role\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() {
        $usuarios = User::with('roles')->orderBy('id', 'desc')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function all() {
        try {
            $usuarios = User::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $usuarios,
                'message' => 'Usuarios obtenidos correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create() {
        $roles = Role::whereNot('name','super_admin')->get();
        $institutionsWithoutRector = Institucion::whereNull('deleted_at')->whereNull('rector_id')->get();
        return view('usuarios.create', ['roles'=> $roles, 'institutionsWithoutRector' => $institutionsWithoutRector]);
    }


    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
            'institucion_id' => 'nullable|exists:institucions,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Asignar varios roles
        $user->syncRoles($validated['roles']);

        // Si el usuario es rector,
        if (in_array('rector', $validated['roles']) && isset($validated['institucion_id'])) {
            $institucion = Institucion::findOrFail($validated['institucion_id']);
            $institucion->rector_id=$user->id;
            $institucion->save();
        }

        return redirect()->route('usuarios.index')
            ->with('flash_success_message', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario) {
        //Carga los roles;
        $usuario->roles;
        if ($usuario->hasRole('rector')) {
            $usuario->institucion;
        }
        $roles = Role::whereNot('name','super_admin')->get();
        $institutionsWithoutRector = Institucion::whereNull('deleted_at')
            ->where(function ($query) use ($usuario) {
                $query->whereNull('rector_id')
                        ->orWhere('rector_id', $usuario->id);
            })
            ->get();
        return view('usuarios.edit',['usuario'=>$usuario,'roles'=>$roles, 'institutionsWithoutRector'=>$institutionsWithoutRector]);
    }

    public function update(Request $request, User $usuario) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$usuario->id}",
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
            'institucion_id' => 'nullable|exists:institucions,id',
        ]);


        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $usuario->password,
        ]);

        // Asignar varios roles
        $usuario->syncRoles($validated['roles']);

        // Si el usuario es rector,
        if (in_array('rector', $validated['roles']) && isset($validated['institucion_id'])) {
            //se intenta obtener la institucion a la que el rector pertenece
            if ($usuario->institucion && ($usuario->institucion->id != $validated['institucion_id']) ) {
                // Se remueve la vinculacion a la institucion
                $institucion =$usuario->institucion;
                $institucion->rector_id=null;
                $institucion->save();
            }
            $institucion = Institucion::findOrFail($validated['institucion_id']);
            $institucion->rector_id=$usuario->id;
            $institucion->save();
        }


        return redirect()->route('usuarios.index')->with('flash_success_message', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario) {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
