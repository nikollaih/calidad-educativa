@extends('layouts.app')

@section('content')
    <div
        data-component="IndexPAMS"
        data-agregar-url="{{route('pams.create')}}"
        data-pams-paginated='@json($pams)'
        data-csrf-token="{{ csrf_token() }}"
    >

    </div>
@endsection
