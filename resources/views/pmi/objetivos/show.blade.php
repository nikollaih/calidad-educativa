@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('objetivo-pmi.index') }}" data-is-container="{{false}}"></div>
    </div>
    <div
        data-component="FormObjetivoPMI"
        data-csrf-token="{{ csrf_token() }}"
        data-editable="{{ false }}"
        data-objetivo-existente='@json($objetivo->toArray())'
    >
    </div>
@endsection
