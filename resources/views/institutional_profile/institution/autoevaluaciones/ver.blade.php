@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
        data-detail-url="{{ route('institution.show', $institucionId) }}"
        data-pei-url="{{ route('institution.pei.update-pei', $institucionId) }}"
        data-autevaluacion-url="#"
        data-pmi-url="{{ route('pmi.index', $institucionId) }}"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institucionId) }}"
        data-institution-name="{{ $institucionNombre ?? '' }}"
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
