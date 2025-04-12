@extends('layouts.app')

@section('content')
    <div
        id="autoevaluacion"
        data-institution-id="{{ $institutionId }}"
        data-agregar-url="{{ route('institution.autoevaluaciones-crear', ['institution' => $institutionId]) }}">
    </div>
    @vite('resources/js/app.js')
@endsection
