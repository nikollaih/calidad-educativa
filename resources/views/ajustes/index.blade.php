@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>

    <div
        data-component="Ajustes"
        data-favicon-url="{{asset('favicon.ico')}}"
        data-logo-url="{{asset('/imagenes/educacion_menu-nobg.png')}}"
    >
    </div>
@endsection
