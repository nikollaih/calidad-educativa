@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>
    <div
        data-component="ListaModelosEducacionales"
        data-csrf-token="{{ csrf_token() }}"
        data-modelos-educacionales='{!! json_encode($modelosEducacionales) !!}'
        data-agregar-url="{{ route('modelos-educacionales.store') }}"
        data-can-edit-parametros="{{ auth()->user()->can('s-parametro-editar') ? 'true' : 'false' }}"
    ></div>
@endsection
