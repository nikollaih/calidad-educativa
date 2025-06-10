@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>
    <div
        data-component="ListaMunicipios"
        data-csrf-token="{{ csrf_token() }}"
        data-municipios='{!! json_encode($municipalities) !!}'
        data-agregar-url="{{ route('municipios.store') }}">
    </div>
@endsection
