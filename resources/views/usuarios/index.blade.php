@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card">
        <h1 class="card-header">Lista de Usuarios</h1>
        <div class="card-body">
            <div class="col-md-12">
                @can('hr-usuario-crear')
                <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Crear Usuario</a>
                @endcan
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->roles->pluck('name_translated')->join(', ') }}</td>
                            <td>
                                @can('hr-usuario-editar')
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning btn-sm">Editar</a>
                                @endcan
                                @can('hr-usuario-eliminar')
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div
                    data-component="CPagination"
                    data-pagination='{!! json_encode($usuarios) !!}'>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
