@extends('layouts.app')

@section('content')
    <div
        data-component="Lista"
        data-institution-id="{{ $institutionId }}"
        data-autoevaluaciones='{!! json_encode($autoevaluaciones) !!}'
        data-agregar-url="{{ route('institution.autoevaluaciones-crear', ['institution' => $institutionId]) }}">
    </div>
    @vite('resources/js/app.js')
@endsection
