@extends('layouts.app')

@section('content')
    <div
        data-component="CNavigationButton"
    >
    </div>
    <div
        data-component="Ver"
        data-grupos-calificaciones='{!! json_encode($gruposCalificaciones) !!}'
        data-autoevaluacion='{!! json_encode($autoevaluacion) !!}'
        data-statistics='{!! json_encode($statistics) !!}'
    >
    </div>
@endsection
