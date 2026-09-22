@extends('layouts.app')

@section('content')
<div
    data-component="FormularioUsuarioInstitucion"
    data-roles='@json($roles)'
    data-store-url="{{ route('instituciones.usuarios_institucion-store') }}"
    data-index-url="{{ route('instituciones.usuarios_institucion-index') }}"
></div>

@endsection

