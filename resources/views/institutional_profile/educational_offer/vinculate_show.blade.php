@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
    ></div>
<div class="container">
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
                        <label class="form-label">Documento actual</label>
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
                    <h4>Horario</h4>
                    <div class="mb-3">
                        <label class="form-label">Tipo de horario</label>
                        <select class="form-select" name="schedule[name]" disabled>
                            @foreach($educationalSchedules as $key => $value)
                                <option value="{{ $key }}" {{ $schedule->name == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control"
                                       name="schedule[hora_inicio]"
                                       value="{{ $schedule->hora_inicio }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Hora de Final</label>
                                <input type="time" class="form-control"
                                       name="schedule[hora_fin]"
                                       value="{{ $schedule->hora_fin }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notas detalladas</label>
                        <textarea class="form-control" rows="3"
                                  name="schedule[notes]" disabled>{{ $schedule->notes }}</textarea>
                    </div>

                    <!-- Anexo del horario -->
                    <div class="mb-3">
                        <label class="form-label">Documento del horario actual</label>
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
