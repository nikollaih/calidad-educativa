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
    >
    </div>
@endsection
