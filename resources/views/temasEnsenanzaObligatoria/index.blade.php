@extends('layouts.app')

@section('content')
    <div
        data-component="ListaTemasEnsenanzaObligatoria"
        data-temas='@json($temas)'
        data-store-url="{{ route('temas-ensenanza-obligatoria.store') }}"
        data-csrf-token="{{ $csrfToken }}"
        data-can-edit-parametros="{{ $canEditParametros ? 'true' : 'false' }}"
    ></div>
@endsection
