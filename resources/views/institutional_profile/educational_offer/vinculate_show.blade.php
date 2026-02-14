@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('institution.edit', $selectedSede->institution->id) }}"
        data-detail-url="#"
        data-pei-url="{{ route('institution.pei.update-pei', $selectedSede->institution->id) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $selectedSede->institution->id) }}"
        data-pmi-url="{{ route('pmi.index', $selectedSede->institution->id) }}"
        data-proyectos-transversales-url="{{ route('proyectos_transversales.index', $selectedSede->institution->id) }}"
        data-institution-name="{{$selectedSede->institution->nombre}}"
    ></div>
<div class="m-6 !border border-custom-blue-light rounded-md bg-white p-3">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2>Ver vinculación de nivel educativo</h2>
        </div>
        <div class="card-body">
            <form>
                <!-- Información del nivel educativo -->
                <div class="mb-4">
                    <h4>Nivel educativo</h4>
                    <p class="mb-0"><strong>Nombre:</strong> {{ $levelSede->educationalLevel->name }}</p>
                    <p class="mb-0"><strong>Categoría:</strong> {{ $educationalCategories[$levelSede->educationalLevel->category] ?? $levelSede->educationalLevel->category }}</p>
                    <p class="mb-0"><strong>Sede:</strong> {{ $selectedSede->name }}</p>
                </div>

                <!-- Anexo del nivel educativo -->
                <div class="mb-4">
                    <h4>Anexo del nivel educativo</h4>
                    <div class="mb-3">
                        <label class="block text-sm mb-2 ml-4">Documento actual</label>
                        @if($levelSede->educationalLevel->document_id)
                            <div class="mt-2">
                                <a href="{{ $levelSede->educationalLevel->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver documento actual
                                </a>
                            </div>
                        @else
                            <p class="text-muted">No hay documento adjunto</p>
                        @endif
                    </div>
                </div>
                @foreach($levelSede->schedules as $key => $schedule)
                <!-- Horario -->
                <div class="mb-4">
                    <h4>Horario {{$schedule->name}}</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="block text-sm mb-2 ml-4">Hora de Inicio</label>
                                <input type="time" class="border-gray-100 bg-gray-100 cursor-not-allowed w-full px-3 py-2 rounded-pill"
                                       name="schedule[hora_inicio]"
                                       value="{{ $schedule->hora_inicio }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="block text-sm mb-2 ml-4">Hora de Final</label>
                                <input type="time" class="border-gray-100 bg-gray-100 cursor-not-allowed w-full px-3 py-2 rounded-pill"
                                       name="schedule[hora_fin]"
                                       value="{{ $schedule->hora_fin }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm mb-2 ml-4">Notas detalladas</label>
                        <textarea class="border-gray-100 bg-gray-100 cursor-not-allowed w-full px-3 py-2 rounded-xl" rows="3"
                                  name="schedule[notes]" disabled>{{ $schedule->notes }}</textarea>
                    </div>

                    <!-- Anexo del horario -->
                    <div class="mb-3">
                        <label class="block text-sm mb-2 ml-4">Documento del horario actual</label>
                        @if($schedule->document_id)
                            <div class="mt-2">
                                <a href="{{ $schedule->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver documento actual
                                </a>
                            </div>
                        @else
                            <p class="text-muted">No hay documento adjunto</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </form>
        </div>
    </div>
</div>
@endsection
