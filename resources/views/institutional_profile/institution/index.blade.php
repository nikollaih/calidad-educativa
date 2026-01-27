@extends('layouts.app')

@section('content')
    <div class="!border border-custom-blue-light rounded-md">
        <div class="card">
            <h1 class="p-2 px-3 text-custom-primary">Instituciones</h1>
            <div class="card-body">
                <div class="col-md-12">
                        @php
                            $user = auth()->user();
                        @endphp
                        @if($user->hasAnyRole(['super_admin', 'administrador']) ||
                            ($user->hasRole('rector') && $user->institucion === null))
                            @include('layouts.app.components.buttons.add', ['route' => 'instituciones.usuarios_institucion-create'])
                        @endif
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
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($paginate as $institucion)
                            <tr>
                                <td><a href="{{ route('institution.show', $institucion->id) }}">{{$institucion->nombre}}</a></td>
                                <td>{{$institucion->nit}}</td>
                                <td>{{$institucion->dane}}</td>
                                <td>{{$institucion->email}}</td>
                                <td>{{$institucion->rector?->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Paginación -->
                    <div
                        data-component="CPagination"
                        data-pagination='{!! json_encode($paginate) !!}'>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
