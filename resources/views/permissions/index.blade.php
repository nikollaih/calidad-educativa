@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card">
        <h1 class="card-header">Permisos</h1>
        <div class="card-body">
            <div class="col-md-12">


                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Guard</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name_translated }}</td>
                                <td>{{ $permission->guard_name }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div
                    data-component="CPagination"
                    data-pagination='{!! json_encode($permissions) !!}'>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
