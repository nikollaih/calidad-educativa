@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.autoevaluaciones', $autoevaluacion->institucion_id) }}"
        data-detail-url="{{ route('institution.show', $autoevaluacion->institucion_id) }}"
        data-pei-url="{{ route('institution.pei', $autoevaluacion->institucion_id) }}"
        data-autevaluacion-url="#"
        data-pmi-url="{{ route('pmi.index', $autoevaluacion->institucion_id) }}"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $autoevaluacion->institucion_id) }}"
        data-institution-name="{{ $institucionNombre ?? '' }}"
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
