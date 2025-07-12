@extends('layouts.app')

@section('content')
    <div class="d-flex mb-4">
        <div data-component="CBackButton"
            data-label="Crear registro" 
            data-to="pam-form"
            data-icon="fas fa-plus"
        ></div>
        <div data-component="CBackButton"
            data-label="Crear avance" 
            data-to="pam-form"
            data-icon="fas fa-plus"
        ></div>
        <div data-component="CBackButton"
            data-label="Exportar tabla" 
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