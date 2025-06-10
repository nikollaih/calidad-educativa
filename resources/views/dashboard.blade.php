@extends('layouts.app')

@section('content')
    @php
        $municipios = session('municipios');
    @endphp

    @if ($municipios)
        <ul>
            @foreach ($municipios as $municipio)
                <li>{{ $municipio->nombre }}</li>
            @endforeach
        </ul>
    @endif
@endsection
