@extends('layouts.app')

@section('content')
    <div
        data-component="ValidacionPMI"
        data-agregar-url="{{route('pmi.create',$institucionId??1)}}"                                                                                                                                                                                                                                                                                                                                                      rl
        data-institucion-id="{{$institucionId??1}}"
        data-csrf-token="{{csrf_token()}}"
        data-pmis-paginated='@json($pmis)'
    >

    </div>
@endsection
