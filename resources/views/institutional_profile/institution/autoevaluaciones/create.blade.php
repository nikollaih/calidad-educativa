@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.autoevaluaciones', $institutionId) }}"
        data-detail-url="{{ route('institution.show', $institutionId) }}"
        data-pei-url="{{ route('institution.pei', $institutionId) }}"
        data-autevaluacion-url="#"
        data-pmi-url="{{ route('pmi.index', $institutionId) }}"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institutionId) }}"
        data-institution-name="{{ $institucionNombre ?? '' }}"
    >
    </div>
    <div
        data-component="Crear"
        data-institution-id="{{ $institutionId }}"
        data-csrf-token="{{ csrf_token() }}"
        data-agregar-url="{{ route('institution.autoevaluaciones-almacenar', ['institution' => $institutionId]) }}"
        data-grupos-calificaciones='{!! json_encode($gruposCalificaciones) !!}'
        data-anios-disabled='{!! json_encode($aniosDisabled) !!}'
    >
    </div>
@endsection
