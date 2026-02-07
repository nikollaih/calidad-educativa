@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card">
        <h1 class="card-header">Crear Permiso</h1>
        <div class="card-body">
            <div class="col-md-12">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="block text-sm mb-2 ml-4">Nombre del Permiso</label>
                        <input type="text" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="guard_name" class="block text-sm mb-2 ml-4">Guard Name</label>
                        <input type="text" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" id="guard_name" name="guard_name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
