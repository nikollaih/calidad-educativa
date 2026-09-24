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
        data-institucion-id="{{ $institucionId }}"
        data-component="AutoevaluacionResultados"
        data-fortalezas='{!! json_encode($fortalezas) !!}'
        data-oportunidades-mejora='{!! json_encode($oportunidadesMejora) !!}'
        data-gestiones='{!! json_encode($gestiones) !!}'
        data-autoevaluacion-id ='{{ $autoevaluacionId }}'
        data-csrf-token="{{ csrf_token() }}"
        data-sincronizar-url="{{ route('institution.fort_deb-save', ['autoevaluacionId' => $autoevaluacionId]) }}"
        data-factores-criticos-por-defecto='@json($factoresCriticosPorDefecto)'
        data-factores-criticos-institucion='@json($factoresCriticosInstitucion)'
        data-puede-editar="{{$puedeEditar}}"
    >
    </div>
@endsection
