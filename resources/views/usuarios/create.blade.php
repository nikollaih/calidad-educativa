@extends('layouts.app')

@section('content')
<div
    data-component="FormularioUsuario"
    data-roles='@json($roles)'
    data-institutions-without-rector='@json($institutionsWithoutRector)'
    data-store-url="{{ route('usuarios.store') }}"
    data-index-url="{{ route('usuarios.index') }}"
></div>

@endsection

