@extends('layouts.app')

@section('content')
    <div
        data-component="ListaRedesAprendizaje"
        data-csrf-token="{{ csrf_token() }}"
        data-redes-aprendizajes='{!! json_encode($redesAprendizaje) !!}'
        data-agregar-url="{{ route('redes-aprendizajes.store') }}"
        data-can-edit-parametros="{{ auth()->user()->can('s-parametro-editar') ? 'true' : 'false' }}"
    ></div>
@endsection
