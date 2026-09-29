@extends('layouts.guest') {{-- o el layout que uses --}}

@section('title', 'Demasiados intentos')

@section('content')
    <a href="{{ url('login')}}" class="text-center items-center">
        <img src="{{ asset('imagenes/educacion_menu-nobg.png')}}" alt="Secretaría de Educación" width="100%">
    </a>

    <h1 style="color:#dc3545;"><strong>Demasiados intentos</strong></h1>

    <p style="color:#dc3545;">
        {{ __("Has hecho demasiados intentos, por favor espera :minutes minutos. Luego haz clic en el logo para redirigirte al inicio de sesión ", ['minutes' => $minutes ?? 15]) }}
    </p>
@endsection
