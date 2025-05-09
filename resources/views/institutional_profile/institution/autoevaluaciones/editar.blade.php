@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
    >
    </div>
    <div
        data-component="Editar"
        data-csrf-token="{{ csrf_token() }}"
        data-editar-url="{{ route('institution.autoevaluaciones-actualizar', ['autoevaluacionId' => $autoevaluacion->id]) }}"
        data-grupos-calificaciones='{!! json_encode($gruposCalificaciones) !!}'
        data-autoevaluacion='{!! json_encode($autoevaluacion) !!}'
    >
    </div>
@endsection
