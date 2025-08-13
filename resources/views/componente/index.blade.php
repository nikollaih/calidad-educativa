@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>
    <div
        data-component="ListaComponente"
        data-csrf-token="{{ csrf_token() }}"
        data-componentes='{!! json_encode($componente) !!}'
        data-agregar-url="{{ route('componentes.store') }}">
    </div>
@endsection
