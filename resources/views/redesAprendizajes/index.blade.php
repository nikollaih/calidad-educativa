@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>
    <div
        data-component="ListaRedesAprendizaje"
        data-csrf-token="{{ csrf_token() }}"
        data-redes-aprendizajes='{!! json_encode($redesAprendizaje) !!}'
        data-agregar-url="{{ route('redes-aprendizajes.store') }}">
    </div>
@endsection
