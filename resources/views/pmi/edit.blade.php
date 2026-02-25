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
        data-component="PmiEdit"
        data-csrf-token="{{ csrf_token() }}"
        data-institucion-id="{{$institucionId}}"
        data-exportar-url="{{ route('pmi.exportar', $pmi->id)  }}"
        data-sintesis-url="{{ route('pmi.exportar-sintesis', $pmi->id)  }}"
        data-evaluacion-url="{{ route('pmi.exportar-evaluacion', $pmi->id)  }}"
        data-cumplimiento-url="{{ route('pmi.exportar-cumplimiento', $pmi->id)  }}"

        data-pmi-data='@json($pmi->toArray())'
    >
    </div>
@endsection
