@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.show', 2) }}" class="btn btn-outline-primary btn-sm">Detalles</a>
            <a href="{{ route('institution.autoevaluaciones', 2) }}" class="btn btn-outline-info btn-sm">Autoevaluacion</a>
            <a href="{{ route('institution.pei', 2) }}" class="btn btn-outline-success  btn-sm">PEI</a>
            <a href="#" class="btn btn-secondary  btn-sm">PMI</a>
        </div>
    </div>
    <div
        data-component="IndexPMI"
        data-pmis='@json([[
        "rango_vigencia" => "2024 - 2026",
        "alias_estado" => "PROCESO",
        "created_at" => now()->ceilDays(365)->toDateString()
    ]])'
    >

    </div>
@endsection
