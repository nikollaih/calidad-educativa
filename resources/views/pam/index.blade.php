@extends('layouts.app')

@section('content')
    <div
        data-component="PamIndex"
        data-csrf-token="{{ csrf_token() }}"
    ></div>
    
    @vite('resources/js/app.js')
@endsection