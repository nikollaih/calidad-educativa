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
            <h2>Editar vinculación de nivel educativo</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('educational-offer.update-vinculation', $levelSede->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                    <div class="mb-3">
                        <label class="form-label">Actualizar documento</label>
                        <input type="file" class="form-control" name="level_attachment" accept=".pdf,.doc,.docx">
                        <small class="text-muted">Dejar en blanco para mantener el documento actual</small>
                    </div>
                </div>
                @foreach($levelSede->schedules as $key => $schedule)
                <!-- Horario -->
                <div class="mb-4">
                    <h4>Horario {{$schedule->name}}</h4>
                    <input type="hidden" name="schedule[{{$key}}][id]" value="{{ $schedule->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control"
                                       name="schedule[{{$key}}][hora_inicio]"
                                       value="{{ $schedule->hora_inicio }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Hora de Final</label>
                                <input type="time" class="form-control"
                                       name="schedule[{{$key}}][hora_fin]"
                                       value="{{ $schedule->hora_fin }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notas detalladas</label>
                        <textarea class="form-control" rows="3"
                                  name="schedule[{{$key}}][notes]">{{ $schedule->notes }}</textarea>
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
                        <div class="mb-3">
                                <label class="form-label">Actualizar documento del horario</label>
                               <input type="file" class="form-control" name="schedule_attachment_{{$schedule->id}}" accept=".pdf,.doc,.docx">
                              <small class="text-muted">Dejar en blanco para mantener el documento actual</small>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Botones de acción -->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('institution.edit', ['institution' => $selectedSede->institution->id]) }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
