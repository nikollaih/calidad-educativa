@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>

    <div
        data-component="Ajustes"
        data-favicon-url="{{asset('assets/img/favicon/favicon.ico')}}"
        data-logo-url="{{asset('/imagenes/educacion_menu-nobg.png')}}"
        data-csrf-token=" {{ csrf_token() }}"
        data-actualizar-imagenes-url="{{ route('ajustes.actualizar_imagenes_sistema') }}"
        data-can-edit-parametros="{{ auth()->user()->can('s-parametro-editar') ? 'true' : 'false' }}"
    >
    </div>
@endsection
