@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.show', $institucionId) }}"
        data-detail-url="{{ route('institution.show', $institucionId) }}"
        data-pei-url="{{ route('institution.pei', $institucionId) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
        data-pmi-url="{{ route('pmi.index', $institucionId) }}"
        data-proyectos-transversales-url="#"
        data-institution-name="{{ $institucionNombre ?? '' }}"
    >
    </div>
    <div
        data-component="ListaProyectoTransversal"
        data-agregar-url="{{route('proyectos-transversales.store', $institucionId)}}"                                                                                                                                                                                                                                                                                                                                                      rl
        data-institucion-id="{{$institucionId}}"
        data-csrf-token="{{csrf_token()}}"
        data-proyectos-transversales='@json($proyectosTransversales)'
        data-es-rector='@json($esRector)'
    >

    </div>
@endsection
