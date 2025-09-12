@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('pmi.index', $institucionId) }}"
        data-detail-url="{{ route('institution.show', $institucionId) }}"
        data-pei-url="{{ route('institution.pei', $institucionId) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
        data-pmi-url="#"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institucionId) }}"
    >

    </div>
    <div
        data-component="PmiEdit"
        data-csrf-token="{{ csrf_token() }}"
        data-institucion-id="{{$institucionId}}"
        data-exportar-url="{{ route('pmi.exportar', $pmi->id)  }}"
        data-pmi-data='@json($pmi->toArray())'
    >
    </div>
@endsection
