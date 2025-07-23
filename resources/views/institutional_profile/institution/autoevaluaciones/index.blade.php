@extends('layouts.app')

@section('content')
    @if (Session::has('tiene_notas_pendientes'))
        <div class="alert alert-warning" role="alert">
            EXISTEN COMPONENTES PENDIENTES POR AUTOEVALUAR.
            <a href="#" data-bs-toggle="modal" data-bs-target="#notasPendientesModal">Haz clic aquí para verlos</a>
        </div>
    @endif
    @if (Session::has('tiene_notas_pendientes'))
        <!-- Modal -->
        <div class="modal fade" id="notasPendientesModal" tabindex="-1" aria-labelledby="notasPendientesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notasPendientesLabel">COMPONENTES PENDIENTES POR AUTOEVALUAR</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            @foreach (Session::get('tiene_notas_pendientes') as $nota)
                                <li class="list-group-item">
                                    {{ $nota->indice ?? 'Sin observación' }}
                                    {{-- Ajusta los campos según tu estructura --}}
                                    <strong>{{ $nota->nombre ?? 'Asignatura desconocida' }}</strong>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-between container">
        <div data-component="CBackButton" data-to="{{ route('institution.index') }}" data-is-container="{{false}}"></div>
        <div class="d-flex gap-2">
            <a href="{{ route('institution.show', $institutionId) }}" class="btn btn-outline-primary btn-sm">Perfil</a>
            <a href="{{ route('institution.pei', $institutionId) }}" class="btn btn-outline-success  btn-sm">PEI</a>
            <a href="#" class="btn btn-info btn-sm">Autoevaluacion</a>
            <a href="{{ route('pmi.index', $institutionId) }}" class="btn btn-outline-secondary  btn-sm">PMI</a>
        </div>
    </div>
    <div
        data-component="Lista"
        data-institution-id="{{ $institutionId }}"
        data-csrf-token="{{ csrf_token() }}"
        data-autoevaluaciones='{!! json_encode($autoevaluaciones) !!}'
        data-agregar-url="{{ route('institution.autoevaluaciones-crear', ['institution' => $institutionId]) }}">
    </div>
@endsection
