@extends('layouts.app')

@section('content')
    <div
        data-component="Ver"
        data-grupos-calificaciones='{!! json_encode($gruposCalificaciones) !!}'
        data-autoevaluacion='{!! json_encode($autoevaluacion) !!}'
    >
    </div>
    @vite('resources/js/app.js')
@endsection
