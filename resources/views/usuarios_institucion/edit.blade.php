@extends('layouts.app')

@section('content')
<div
    data-component="FormularioUsuarioInstitucion"
    data-roles='@json($roles)'
    data-states='@json($states)'
    data-user='@json($user)'
    data-store-url="{{ route('instituciones.usuarios_institucion-update', $user) }}"
    data-index-url="{{ route('instituciones.usuarios_institucion-index') }}"
></div>
@endsection
