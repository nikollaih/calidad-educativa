@extends('layouts.app')

@section('content')
    <div class="!border border-custom-blue-light rounded-md">
        <div class="card">
            <h1 class="p-2 px-3 text-custom-primary">Lista de usuarios</h1>
            <div class="px-3">
                <div class="col-md-12">
                    @role('rector')
                    <a href="{{ route('instituciones.usuarios_institucion-create') }}" class="inline-flex items-center mb-3 group cursor-pointer !border border-custom-blue-light overflow-hidden transition-all duration-300 rounded-full hover:no-underline" style="border-radius: 9999px;">
                        <!-- Icono visible siempre -->
                        <div class="flex items-center justify-center w-10 h-10 flex-shrink-0 transition-all duration-300">
                            <i class="fa fa-plus text-custom-blue-light text-xl" aria-hidden="true"></i>
                        </div>

                        <!-- Texto que aparece en hover -->
                        <span class="inline-block py-2 text-custom-blue-light font-medium whitespace-nowrap
                                  w-0 opacity-0 overflow-hidden px-0
                                  group-hover:w-32 group-hover:opacity-100 group-hover:px-4
                                  transition-all duration-300 ease-out">
                            Agregar
                        </span>
                    </a>
                    @endrole
                    <form method="GET" action="{{ route('instituciones.usuarios_institucion-index') }}" class="mt-3 mb-3">
                        <div class="input-group" style="max-width: 400px;">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre..." value="{{ $search ?? '' }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            @if(!empty($search))
                                <a href="{{ route('instituciones.usuarios_institucion-index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
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
                        @foreach($paginate as $usuario)
                            <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->roles->pluck('name_translated')->join(', ') }}</td>
                                <td>
                                    @role('rector')
                                    <a href="{{ route('instituciones.usuarios_institucion-edit', $usuario) }}">
                                        <i class="fa fa-pencil text-gray-500 hover:text-custom-primary cursor-pointer text-xl hover:border hover:rounded-md p-2 hover:border-custom-blue-dark hover:bg-gray-100" aria-hidden="true">
                                        </i>
                                    </a>
                                    @endrole

                                    @role('rector')
                                    <form action="{{ route('instituciones.usuarios_institucion-delete', $usuario) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar usuario?')">
                                            <i class="fa fa-trash text-gray-500 hover:text-red-600 cursor-pointer text-xl hover:border hover:rounded-md p-2 hover:border-custom-blue-dark hover:bg-gray-100" aria-hidden="true">
                                            </i>
                                        </button>
                                    </form>
                                    @endrole
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div
                        data-component="CPagination"
                        data-pagination='{!! json_encode($paginate) !!}'>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
