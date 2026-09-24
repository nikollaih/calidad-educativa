@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{  route('pams.index') }}" data-is-container="{{false}}"></div>
    </div>
    <div
        data-component="CreatePAM"
        data-create-url="{{ route('pams.store')}}"
        data-csrf-token="{{ csrf_token() }}"
    >

    </div>
@endsection
