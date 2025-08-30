@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>
    <div
        data-component="ListaProyectoTransversalActividades"
        data-csrf-token="{{ csrf_token() }}"
        data-proyecto-transversal-id='{!! json_encode($proyectoTransversal) !!}'
        data-actividades='{!! json_encode($actividades) !!}'
        data-integrantes='{!! json_encode($integrantes) !!}'
        data-agregar-url="{{ route('proyecto-transversal-actividades.store', $proyectoTransversal) }}">
    </div>
@endsection
