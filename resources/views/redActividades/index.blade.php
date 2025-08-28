@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>
    <div
        data-component="ListaRedActividades"
        data-csrf-token="{{ csrf_token() }}"
        data-redes-actividades='{!! json_encode($redActividades) !!}'
        data-integrantes='{!! json_encode($integrantes) !!}'
        data-agregar-url="{{ route('red-actividades.store') }}">
    </div>
@endsection
