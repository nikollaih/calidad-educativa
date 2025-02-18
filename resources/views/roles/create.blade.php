@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card">
        <h1 class="card-header">Crear Rol</h1>
        <div class="card-body">
            <div class="col-md-12">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Rol</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Permisos</label>
                        <div class="form-check">
                            @foreach($permissions as $permission)
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                            <label class="form-check-label">{{ $permission->name }}</label><br>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
