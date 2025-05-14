@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
    >
    </div>
    <div
        data-component="AutoevaluacionResultados"
        data-fortalezas='{!! json_encode($fortalezas) !!}'
        data-oportunidades-mejora='{!! json_encode($oportunidadesMejora) !!}'
        data-gestiones='{!! json_encode($gestiones) !!}'
        data-autoevaluacion-id ='{{ $autoevaluacionId }}'
        data-csrf-token="{{ csrf_token() }}"
        data-sincronizar-url="{{ route('institution.fort_deb-save', ['autoevaluacionId' => $autoevaluacionId]) }}"
        data-factores-criticos-existentes='{!! json_encode($factoresCriticosExistentes) !!}'
        data-puede-editar="{{$puedeEditar}}"
    >
    </div>
@endsection
