@extends('layouts.app')

@section('content')
<div class="col-md-12 bg-white rounded-xl !border border-custom-blue-light">
    <div class="p-3">
        <h1 class="text-custom-blue-dark">Roles del sistema</h1>
        <div class="card-body">
            <div class="col-md-12">
                @can('s-role-crear')
                    <div data-component="CAddButton"
                         data-route="{{ route('roles.create') }}"
                    ></div>
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
                            <td class="flex">
                                @can('s-role-editar')
                                    <div data-component="CTableActionButton"
                                         data-title="Editar"
                                         data-route="{{ route('roles.edit', $role) }}"
                                         data-icon-class="fas fa-pencil"
                                         data-hover-icon-color="text-custom-primary"
                                    ></div>
                                @endcan
                                @can('s-role-eliminar')
                                    <form id="delete-form-{{$role}}" action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <div
                                            data-form-ref="#delete-form-{{$role}}"
                                            data-component="CTableActionButton"
                                            data-title="Eliminar"
                                            data-icon-class="fa fa-trash"
                                            data-confirm-message="¿Está seguro de eliminar este rol?"
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
                    data-pagination='{!! json_encode($roles) !!}'>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
