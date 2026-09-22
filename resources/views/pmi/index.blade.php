@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.index') }}"
        data-detail-url="{{ route('institution.show', $institucionId) }}"
        data-pei-url="{{ route('institution.pei.update-pei', $institucionId) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
        data-pmi-url="#"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institucionId) }}"
        data-institution-name="{{ $institucionNombre ?? '' }}"
    >
    </div>
    <div
        data-component="IndexPMI"
        data-agregar-url="{{route('pmi.create',$institucionId)}}"                                                                                                                                                                                                                                                                                                                                                      rl
        data-institucion-id="{{$institucionId}}"
        data-csrf-token="{{csrf_token()}}"
        data-pmis-paginated='@json($pmis)'
    >

    </div>
@endsection
