@extends('layouts.app')

@section('content')
    <div
        data-component="ListaComponente"
        data-csrf-token="{{ csrf_token() }}"
        data-componentes='{!! json_encode($componente) !!}'
        data-agregar-url="{{ route('componentes.store') }}"
        data-can-edit-parametros="{{ auth()->user()->can('s-parametro-editar') ? 'true' : 'false' }}"
    ></div>
@endsection
