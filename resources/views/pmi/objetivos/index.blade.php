@extends('layouts.app')

@section('content')
    <div
        data-component="IndexObjetivoPMI"
        data-agregar-url="{{route('objetivo-pmi.create')}}"
        data-objetivos-paginated='@json($objetivos)'
        data-can-edit-parametros="{{ auth()->user()->can('s-parametro-editar') ? 'true' : 'false' }}"
    >
    </div>
@endsection
