@extends('layouts.app')

@section('content')
    <div data-component="CBackButton" data-to="{{ route('pams.index') }}" data-is-container="{{false}}"></div>
    <div
        data-component="PamIndex"
        data-csrf-token="{{ csrf_token() }}"
        data-pam-general-id="{{ $pamGeneralId }}"
        data-is-in-proceso="{{ json_encode($isInProceso) }}"
        data-can-gestionar-pam="{{ auth()->user()->can('s-pam-gestionar') ? 'true' : 'false' }}"
        data-can-consultar-pam="{{ auth()->user()->can('s-pam-consultar') ? 'true' : 'false' }}"
    ></div>

    @vite('resources/js/app.js')
@endsection
