@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{  route('pmi.index', $institucionId) }}" data-is-container="{{false}}"></div>
    </div>
    <div
        data-component="CreatePMI"
        data-autoevaluaciones-disponibles='@json($autoevaluaciones)'
    >

    </div>
@endsection
