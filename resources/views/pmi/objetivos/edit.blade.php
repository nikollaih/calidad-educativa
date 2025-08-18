@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('objetivo-pmi.index') }}" data-is-container="{{false}}"></div>
    </div>
    <div
        data-component="FormObjetivoPMI"
        data-csrf-token="{{ csrf_token() }}"
        data-agregar-url="{{ route('objetivo-pmi.store') }}"
        data-objetivo-existente='@json($objetivo->toArray())'
        data-factores-criticos='@json($factoresCriticos)'
        data-unidades-medida='@json($unidadesMedida)'
    >
    </div>
@endsection
