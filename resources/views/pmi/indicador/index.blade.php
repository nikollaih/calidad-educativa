@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>
    <div
        data-component="ListaIndicadores"
        data-csrf-token="{{ csrf_token() }}"
        data-indicadores='{!! json_encode($indicadores) !!}'
        data-agregar-url="{{ route('indicadores-pmi.store') }}"
        data-can-edit-parametros="{{ auth()->user()->can('s-parametro-editar') ? 'true' : 'false' }}"
    >
    </div>
@endsection
