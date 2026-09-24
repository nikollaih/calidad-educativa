@extends('layouts.app')

@section('content')
    <div
        data-component="IndexMetaPMI"
        data-agregar-url="{{route('metas-pmi.create')}}"                                                                                                                                                                                                                                                                                                                                                      rl
        data-metas-paginated='@json($metas)'
    >
    </div>
@endsection
