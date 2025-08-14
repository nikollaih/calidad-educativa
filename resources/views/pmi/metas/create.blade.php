@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('metas-pmi.index') }}" data-is-container="{{false}}"></div>
    </div>
    <div
        data-component="CreateMetaPMI"
        data-csrf-token="{{ csrf_token() }}"
        data-agregar-url="{{ route('metas-pmi.store') }}"
    >
    </div>
@endsection
