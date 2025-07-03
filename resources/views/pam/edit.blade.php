@extends('layouts.app')

@section('content')
    <div data-component="CNavigationButton"></div>
    <div
        data-component="PamForm"
        data-csrf-token="{{ csrf_token() }}"
        data-id="{{ $id }}"
    ></div>
    @vite('resources/js/app.js')
@endsection
