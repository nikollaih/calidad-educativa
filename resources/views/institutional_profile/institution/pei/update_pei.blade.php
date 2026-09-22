@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.pei.update-pei', $institucionId) }}"
        data-detail-url="{{ route('institution.show', $institucionId) }}"
        data-pei-url="#"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
        data-pmi-url="{{ route('pmi.index', $institucionId) }}"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institucionId) }}"
        data-institution-name="{{ $institucionNombre ?? '' }}"
    >
    </div>
    <div
        data-component="ActualizarPei"
        data-csrf-token="{{ csrf_token() }}"
        data-institucion-id='{!! json_encode($institucionId) !!}'
        data-institucion-data='{!! json_encode($institucionData) !!}'
        data-institucion-nombre='{!! $institucionNombre !!}'
    ></div>
    @vite('resources/js/app.js')
@endsection
