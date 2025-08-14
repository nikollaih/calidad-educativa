@extends('layouts.app')

@section('content')
    <div
        data-component="IndexObjetivoPMI"
        data-agregar-url="{{route('objetivo-pmi.create')}}"                                                                                                                                                                                                                                                                                                                                                      rl
        data-objetivos-paginated='@json($objetivos)'
    >
    </div>
@endsection
