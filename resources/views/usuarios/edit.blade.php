@extends('layouts.app')

@section('content')
<div
    data-component="FormularioUsuario"
    data-roles='@json($roles)'
    data-user='@json($usuario)'
    data-institutions-without-rector='@json($institutionsWithoutRector)'
    data-institutions='@json($institutions)'
    data-store-url="{{ route('usuarios.update', $usuario) }}"
    data-index-url="{{ route('usuarios.index') }}"
></div>
@endsection
