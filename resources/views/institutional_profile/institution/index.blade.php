@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h1 class="card-header">Instituciones</h1>
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{ route('institution.create') }}" class="btn btn-primary mb-3">Crear institución</a>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>NIT</th>
                            <th>DANE</th>
                            <th>EMAIL</th>
                            <th>NOMBRE DEL RECTOR</th>
                            <th>ACCIONES</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($paginate as $institucion)
                            <tr>
                                <td>{{$institucion->nombre}}</td>
                                <td>{{$institucion->nit}}</td>
                                <td>{{$institucion->dane}}</td>
                                <td>{{$institucion->email}}</td>
                                <td>{{$institucion->nombre_rector}}</td>
                                <td>
                                    <a href="{{ route('institution.edit', $institucion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('institution.destroy', $institucion->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta institución?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $paginate->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
