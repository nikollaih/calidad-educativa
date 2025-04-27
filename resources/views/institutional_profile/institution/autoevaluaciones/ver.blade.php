@extends('layouts.app')

@section('content')
    <div
        data-component="Ver"
        data-grupos-calificaciones='{!! json_encode($gruposCalificaciones) !!}'
        data-autoevaluacion='{!! json_encode($autoevaluacion) !!}'
        data-statistics='{!! json_encode($statistics) !!}'
    >
    </div>
    @vite('resources/js/app.js')
@endsection
