@extends('layouts.app')

@section('content')
    <div
        data-component="ListaUnidadMeta"
        data-csrf-token="{{ csrf_token() }}"
        data-unidades-meta='{!! json_encode($unidadMeta) !!}'
        data-agregar-url="{{ route('unidades-meta.store') }}"
        data-can-edit-parametros="{{ auth()->user()->can('s-parametro-editar') ? 'true' : 'false' }}"
    ></div>
@endsection
