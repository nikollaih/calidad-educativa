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
                        <button type="button" class="border bg-blue-500  text-white p-2 rounded-pill" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.index') }}"
        data-detail-url="{{ route('institution.show', $institutionId) }}"
        data-pei-url="{{ route('institution.pei.update-pei', $institutionId) }}"
        data-autevaluacion-url="#"
        data-pmi-url="{{ route('pmi.index', $institutionId) }}"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $institutionId) }}"
        data-institution-name="{{ $institucionNombre ?? '' }}"
    >
    </div>
    <div
        data-component="Lista"
        data-institution-id="{{ $institutionId }}"
        data-csrf-token="{{ csrf_token() }}"
        data-autoevaluaciones='{!! json_encode($autoevaluaciones) !!}'
        data-agregar-url="{{ route('institution.autoevaluaciones-crear', ['institution' => $institutionId]) }}">
    </div>
@endsection
