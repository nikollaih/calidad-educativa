@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>
    <div
        data-component="ListaModelosPedagogicos"
        data-csrf-token="{{ csrf_token() }}"
        data-modelos-pedagogicos='{!! json_encode($modelosPedagogicos) !!}'
        data-agregar-url="{{ route('modelos-pedagogicos.store') }}">
    </div>
@endsection
