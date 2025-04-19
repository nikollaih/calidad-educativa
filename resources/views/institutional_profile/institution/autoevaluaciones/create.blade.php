@extends('layouts.app')

@section('content')
    <div
        data-component="Crear"
        data-institution-id="{{ $institutionId }}"
        data-csrf-token="{{ csrf_token() }}"
        data-agregar-url="{{ route('institution.autoevaluaciones-almacenar', ['institution' => $institutionId]) }}"
        data-grupos-calificaciones='{!! json_encode($gruposCalificaciones) !!}'
        data-anios-disabled='{!! json_encode($aniosDisabled) !!}'
    >
    </div>
    @vite('resources/js/app.js')
@endsection
