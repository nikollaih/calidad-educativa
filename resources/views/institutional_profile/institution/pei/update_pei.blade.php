@extends('layouts.app')

@section('content')
    <div
        data-component="ActualizarPei"
        data-csrf-token="{{ csrf_token() }}"
        data-institucion-id='{!! json_encode($institucionId) !!}'
        data-institucion-data='{!! json_encode($institucionData) !!}'
    ></div>
    @vite('resources/js/app.js')
@endsection
