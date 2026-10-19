@extends('layouts.app')

@section('content')
    <div
        data-component="ValidacionPMI"
        data-agregar-url="{{ route('pmi.create', ['institucionId' => $institucionId??1, 'sort' => 'nombre', 'direction' => 'asc']) }}"
        data-institucion-id="{{$institucionId??1}}"
        data-can-manage={{ auth()->user()->can('s-pmi-validar') }}
        data-csrf-token="{{csrf_token()}}"
        data-pmis-paginated='@json($pmis)'
    >

    </div>
@endsection
