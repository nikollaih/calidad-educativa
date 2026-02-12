@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card">
        <h1 class="card-header">Edición del rol</h1>
        <div class="card-body">
            <div class="col-md-12">
                @can('s-role-crear')
                <a href="{{ route('roles.create') }}" class="border bg-blue-500  text-white p-2 rounded-pill">Crear rol</a>
                @endcan
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name_translated}}</td>
                            <td>{{ $role->permissions->pluck('name_translated')->join(', ') }}</td>
                            <td>
                                @can('s-role-editar')
                                <a href="{{ route('roles.edit', $role) }}" class="border bg-blue-500  text-white p-2 rounded-pill btn-sm">Editar</a>
                                @endcan
                                @can('s-role-eliminar')
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="border bg-blue-500  text-white p-2 rounded-pill btn-sm" onclick="return confirm('¿Eliminar rol?')">Eliminar</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div
                    data-component="CPagination"
                    data-pagination='{!! json_encode($roles) !!}'>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
