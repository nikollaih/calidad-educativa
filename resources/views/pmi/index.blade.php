@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('institution.index') }}" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.show', $institucionId) }}" class="btn btn-outline-primary btn-sm">Detalles</a>
            <a href="{{ route('institution.pei', $institucionId) }}" class="btn btn-outline-success  btn-sm">PEI</a>
            <a href="{{ route('institution.autoevaluaciones', $institucionId) }}" class="btn btn-outline-info btn-sm">Autoevaluacion</a>
            <a href="#" class="btn btn-secondary  btn-sm">PMI</a>
        </div>
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
