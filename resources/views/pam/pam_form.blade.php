@extends('layouts.app')

@section('content')
    <div data-component="CBackButton" data-to="{{ route('pam.index', $pamGeneralId) }}"></div>
    <div
        data-component="PamForm"
        data-pam-general-id="{{ $pamGeneralId }}"
        data-csrf-token="{{ csrf_token() }}"
    ></div>
    @vite('resources/js/app.js')
@endsection
