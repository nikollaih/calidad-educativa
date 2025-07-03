@extends('layouts.app')

@section('content')
    <div class="d-flex gap-2 mb-4">
        <div data-component="CNavigationButton" class="me-2"></div>
        <div data-component="CNavigationButton"
            data-label="Crear registro" 
            data-to="pam-form"
            data-icon="fas fa-plus"
        ></div>
    </div>
    
    <div
        data-component="PamIndex"
        data-csrf-token="{{ csrf_token() }}"
    ></div>
    
    @vite('resources/js/app.js')
@endsection