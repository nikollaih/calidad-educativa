@extends('layouts.app')

@section('content')
    <div
        id="autoevaluacion-crear"
        data-institution-id="{{ $institutionId }}"
        data-agregar-url="{{ route('institution.autoevaluaciones', ['institution' => $institutionId]) }}"
        data-grupos-calificaciones="{{ json_encode($gruposCalificaciones) }}">
    </div>
    @vite('resources/js/app.js')
@endsection
