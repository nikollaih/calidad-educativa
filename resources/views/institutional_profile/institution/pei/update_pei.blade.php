@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.show', $institucionId) }}" class="btn btn-outline-primary btn-sm">Perfil</a>
            <a href="#" class="btn btn-success  btn-sm">PEI</a>
            <a href="{{ route('institution.autoevaluaciones', $institucionId) }}" class="btn btn-outline-info btn-sm">Autoevaluación</a>
            <a href="{{ route('pmi.index', $institucionId) }}" class="btn btn-outline-secondary  btn-sm">PMI</a>
            <a href="{{ route('proyectos_transversales.index', $institucionId) }}" class="btn btn-outline-warning btn-sm">PPT</a>
        </div>
    </div>
    <div
        data-component="ActualizarPei"
        data-csrf-token="{{ csrf_token() }}"
        data-institucion-id='{!! json_encode($institucionId) !!}'
        data-institucion-data='{!! json_encode($institucionData) !!}'
        data-institucion-nombre='{!! $institucionNombre !!}'
    ></div>
    @vite('resources/js/app.js')
@endsection
