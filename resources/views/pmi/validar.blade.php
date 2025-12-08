@extends('layouts.app')

@section('content')
   <div
        data-component="CBackButton"
        data-to="{{asset("/pmi/validacion")}}"
    >
    </div>
    <div
        data-component="ValidarPmi"
        data-csrf-token="{{ csrf_token() }}"
        data-institucion-id="{{$institucionId??88}}"
        data-can-manage={{ auth()->user()->can('s-pmi-validar') }}
        data-exportar-url="{{ route('pmi.exportar', $pmi->id)  }}"
        data-pmi-data='@json($pmi->toArray())'
    >
    </div>
@endsection
