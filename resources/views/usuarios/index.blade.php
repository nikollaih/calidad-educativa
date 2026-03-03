@extends('layouts.app')

@section('content')
<div class="col-md-12 bg-white rounded-xl !border border-custom-blue-light">
    <div class="p-3">
        <h1 class="text-custom-blue-dark">Lista de Usuarios</h1>
        <div class="card-body">
            <div class="col-md-12">
                @can('hr-usuario-crear')
                    <div data-component="CAddButton"
                         data-route="{{ route('usuarios.create') }}"
                    ></div>
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
                            <td class="flex">
                                @can('hr-usuario-editar')
                                <div data-component="CTableActionButton"
                                     data-title="Editar"
                                     data-route="{{ route('usuarios.edit', $usuario) }}"
                                     data-icon-class="fas fa-pencil"
                                     data-hover-icon-color="text-custom-primary"
                                ></div>
                                @endcan
                                @can('hr-usuario-eliminar')
                                <form id="delete-form-{{$usuario}}" action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <div
                                        data-form-ref="#delete-form-{{$usuario}}"
                                        data-component="CTableActionButton"
                                        data-title="Eliminar"
                                        data-icon-class="fa fa-trash"
                                        data-confirm-message="¿Está seguro de eliminar este usuario?"
                                        data-hover-icon-color="text-custom-primary"
                                    ></div>
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
