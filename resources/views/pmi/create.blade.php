@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('pmi.index', $institucionId) }}"
        data-detail-url="{{ route('institution.show', $institucionId) }}"
        data-pei-url="{{ route('institution.pei.update-pei', $institucionId) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
        data-pmi-url="#"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institucionId) }}"
        data-institution-name="{{ $institucionNombre ?? '' }}"
    >
    </div>
    <div
        data-component="CreatePMI"
        data-create-url="{{ route('pmi.store', $institucionId)}}"
        data-csrf-token="{{ csrf_token() }}"
        data-autoevaluaciones-disponibles='@json($autoevaluaciones)'
    >

    </div>
@endsection
