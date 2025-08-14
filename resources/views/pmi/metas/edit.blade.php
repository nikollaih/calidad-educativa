@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('metas-pmi.index') }}" data-is-container="{{false}}"></div>
    </div>
    <div
        data-component="EditarMetaPMI"
        data-csrf-token="{{ csrf_token() }}"
        data-agregar-url="{{ route('metas-pmi.store') }}"
        data-meta='@json($meta->toArray())'
    >
    </div>
@endsection
