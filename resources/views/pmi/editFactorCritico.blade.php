@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmiId ]) }}"
        data-detail-url="{{ route('institution.show', $institucionId) }}"
        data-pei-url="{{ route('institution.pei.update-pei', $institucionId) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
        data-pmi-url="#"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institucionId) }}"
        data-institution-name="{{ $institucionNombre ?? '' }}"
    >
    </div>
    <div
        data-component="FactorCriticoEdit"
        data-factor-critico='@json($factorCritico)'
        data-objetivos-generales='@json($objetivos)'
        data-indicadores='@json($indicadores)'
        data-frecuencias-recoleccion='@json($frecuenciasRecoleccion)'
        data-agregar-url="{{ route('pmi.actualizar-factor-critico',['institucionId'=>$institucionId,'pmi'=>$pmiId,'factorCriticoId'=>$factorCritico->id])  }}"
        data-pmi-id="{{$pmiId}}"
        data-institucion-id="{{$institucionId}}"
        data-csrf-token="{{ csrf_token() }}"
    ></div>

@endsection
