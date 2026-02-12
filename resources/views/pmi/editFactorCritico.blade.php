@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('pmi.edit',  ['institucionId'=>$institucionId, 'pmi'=>$pmiId ]) }}" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.show', $institucionId) }}" class="btn btn-outline-primary btn-sm">Perfil</a>
            <a href="{{ route('institution.pei', $institucionId) }}" class="btn btn-outline-success  btn-sm">PEI</a>
            <a href="{{ route('institution.autoevaluaciones', $institucionId) }}" class="btn btn-outline-info btn-sm">Autoevaluación</a>
            <a href="#" class="border bg-blue-500  text-white p-2 rounded-pill  btn-sm">PMI</a>
            <a href="{{ route('proyectos_transversales.index', $institucionId) }}" class="btn btn-outline-warning btn-sm">PPT</a>
        </div>
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
