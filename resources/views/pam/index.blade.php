@extends('layouts.app')

@section('content')
    <div
        data-component="PamIndex"
        data-csrf-token="{{ csrf_token() }}"
        data-pam-general-id="{{ $pamGeneralId }}"
    ></div>
    
    @vite('resources/js/app.js')
@endsection