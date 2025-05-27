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

                <!-- Horario -->
                <div class="mb-4">
                    <h4>Horario</h4>
                    <div class="mb-3">
                        <label class="form-label">Tipo de horario</label>
                        <select class="form-select" name="schedule[name]" required>
                            @foreach($educationalSchedules as $key => $value)
                                <option value="{{ $key }}" {{ $levelSede->schedule->name == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción breve</label>
                        <input type="text" class="form-control"
                               name="schedule[schedule]"
                               value="{{ $levelSede->schedule->schedule }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notas detalladas</label>
                        <textarea class="form-control" rows="3"
                                  name="schedule[notes]">{{ $levelSede->schedule->notes }}</textarea>
                    </div>

                    <!-- Anexo del horario -->
                    <div class="mb-3">
                        <label class="form-label">Documento del horario actual</label>
                        @if($levelSede->schedule->document_id)
                            <div class="mt-2">
                                <a href="{{ $levelSede->schedule->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver documento actual
                                </a>
                            </div>
                        @else
                            <p class="text-muted">No hay documento adjunto</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Actualizar documento del horario</label>
                        <input type="file" class="form-control" name="schedule_attachment" accept=".pdf,.doc,.docx">
                        <small class="text-muted">Dejar en blanco para mantener el documento actual</small>
                    </div>
                </div>

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
