@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card !border border-custom-blue-light rounded-xl bg-white">
            <div class="card-header">
                <h1 class="mb-0 text-custom-primary">Tema de enseñanza obligatoria</h1>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $tema->id }}</p>
                <p><strong>Nombre:</strong> {{ $tema->nombre }}</p>
                <a href="{{ route('temas-ensenanza-obligatoria.index') }}" class="border bg-blue-500 text-white p-2 rounded-pill">
                    Volver al listado
                </a>
            </div>
        </div>
    </div>
@endsection
