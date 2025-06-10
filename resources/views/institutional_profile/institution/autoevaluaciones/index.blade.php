@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.show', $institutionId) }}" class="btn btn-outline-primary btn-sm">Detalles</a>
            <a href="#" class="btn btn-info btn-sm">Autoevaluaciones</a>
            <a href="{{ route('institution.pei', $institutionId) }}" class="btn btn-outline-success  btn-sm">PEI</a>
        </div>
    </div>
    <div
        data-component="Lista"
        data-institution-id="{{ $institutionId }}"
        data-csrf-token="{{ csrf_token() }}"
        data-autoevaluaciones='{!! json_encode($autoevaluaciones) !!}'
        data-agregar-url="{{ route('institution.autoevaluaciones-crear', ['institution' => $institutionId]) }}">
    </div>
@endsection
