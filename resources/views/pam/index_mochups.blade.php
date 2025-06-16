@extends('layouts.app')

@section('title', 'Página de Inicio')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <h1 class="mb-4">Mockups para diligenciamiento de PAM</h1>

        <div class="d-grid gap-3">
            <a href="{{ route('pammockup1') }}" class="btn btn-secondary btn-lg">
                Listas desplegables
            </a>

            <a href="{{ route('pammockup2') }}" class="btn btn-secondary btn-lg">
                Tabla editable
            </a>
            <a href="{{ route('pammockup3') }}" class="btn btn-secondary btn-lg">
                Tabla botones
            </a>
            <a href="{{ route('pammockup4') }}" class="btn btn-secondary btn-lg">
                Tabs con editables
            </a>
        </div>
    </div>
</div>
@endsection
