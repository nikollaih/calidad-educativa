@extends('layouts.app')

@section('content')

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="vinculationForm" action="{{ route('educational-offer.update-vinculation', $sedeEducational->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="sede_educational[sede_id]" value="{{ $sedeEducational->sede_id }}">
        <input type="hidden" name="sede_educational[educational_offer_id]" value="{{ $sedeEducational->educational_offer_id }}">

        <!-- Selección de oferta educativa -->
        <div class="mb-4">
            <label for="educational_offer" class="form-label fw-bold">Oferta Educativa <span class="text-danger fw-bold">*</span></label>
            <select class="form-select" name="sede_educational[educational_offer_id]" id="educational_offer" disabled>
                @foreach($allEducationalOffers as $offer)
                    <option value="{{ $offer->id }}" {{ $offer->id == $sedeEducational->educational_offer_id ? 'selected' : '' }}>{{ $offer->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Contenedor para niveles educativos -->
        <div class="mb-4">
            <label class="form-label fw-bold">Niveles Educativos <span class="text-danger fw-bold">*</span></label>
            <div id="educational-levels-container" class="card p-3">
                <!-- Sección para Preescolar -->
                <div class="mb-3">
                    <h5>Preescolar</h5>
                    @foreach($educationalLevels->where('category', App\Models\Enums\EducationalOfferLevelCategoryEnum::PreSchool->value) as $preescolar)
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input level-checkbox" type="checkbox"
                                   id="preescolar-{{ $preescolar->id }}"
                                   value="{{ $preescolar->id }}"
                                   data-category="preescolar"
                                   {{ $sedeEducational->educationalLevels->contains($preescolar->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="preescolar-{{ $preescolar->id }}">
                                {{ $preescolar->name }}
                            </label>
                            @if($preescolar->document_id)
                                <a href="{{ $preescolar->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                    <i class="fas fa-eye"></i> Ver Anexo
                                </a>
                            @endif
                        </div>
                    @endforeach
                    <div id="custom-preescolar-container" class="mt-2" style="display: none;">
                        <input type="text" class="form-control mb-2" placeholder="Nombre del grado preescolar (ej: Prejardín, Jardín)">
                        <div class="mb-2">
                            <label class="form-label">Anexo (opcional)</label>
                            <input type="file" class="form-control preescolar-anexo" accept="application/pdf">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addCustomLevel('preescolar')">Agregar</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-link mt-1" onclick="toggleCustomInput('preescolar')">
                        + Agregar otro nivel de preescolar
                    </button>
                </div>

                <!-- Sección para Énfasis -->
                <div class="mb-3">
                    <h5>Énfasis</h5>
                    @foreach($educationalLevels->where('category', App\Models\Enums\EducationalOfferLevelCategoryEnum::Emphasis->value) as $emphasis)
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input level-checkbox" type="checkbox"
                                   id="emphasis-{{ $emphasis->id }}"
                                   value="{{ $emphasis->id }}"
                                   data-category="emphasis"
                                   {{ $sedeEducational->educationalLevels->contains($emphasis->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="emphasis-{{ $emphasis->id }}">
                                {{ $emphasis->name }}
                            </label>
                            @if($emphasis->document_id)
                                <a href="{{ $emphasis->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                    <i class="fas fa-eye"></i> Ver Anexo
                                </a>
                            @endif
                        </div>
                    @endforeach
                    <div id="custom-emphasis-container" class="mt-2" style="display: none;">
                        <input type="text" class="form-control mb-2" placeholder="Nuevo énfasis (ej: Música, Danza)">
                        <div class="mb-2">
                            <label class="form-label">Anexo (opcional)</label>
                            <input type="file" class="form-control emphasis-anexo" accept="application/pdf">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addCustomLevel('emphasis')">Agregar</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-link mt-1" onclick="toggleCustomInput('emphasis')">
                        + Agregar otro énfasis
                    </button>
                </div>

                <!-- Sección para Convenios -->
                <div class="mb-3">
                    <h5>Convenios</h5>
                    @foreach($educationalLevels->where('category', App\Models\Enums\EducationalOfferLevelCategoryEnum::Agreement->value) as $agreement)
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input level-checkbox" type="checkbox"
                                   id="agreement-{{ $agreement->id }}"
                                   value="{{ $agreement->id }}"
                                   data-category="agreement"
                                   {{ $sedeEducational->educationalLevels->contains($agreement->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="agreement-{{ $agreement->id }}">
                                {{ $agreement->name }}
                            </label>
                            @if($agreement->document_id)
                                <a href="{{ $agreement->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                    <i class="fas fa-eye"></i> Ver Anexo
                                </a>
                            @endif
                        </div>
                    @endforeach
                    <div id="custom-agreement-container" class="mt-2" style="display: none;">
                        <input type="text" class="form-control mb-2" placeholder="Nuevo convenio (ej: Universidad X)">
                        <div class="mb-2">
                            <label class="form-label">Anexo (opcional)</label>
                            <input type="file" class="form-control agreement-anexo" accept="application/pdf">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addCustomLevel('agreement')">Agregar</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-link mt-1" onclick="toggleCustomInput('agreement')">
                        + Agregar otro convenio
                    </button>
                </div>
            </div>
        </div>

        <!-- Contenedor para los horarios -->
        <div id="schedule-container" class="mt-3">
            @foreach($sedeEducational->educationalLevels as $level)
                @foreach($level->schedule as $schedule)
                    <div class="schedule-card card mb-3" data-level-id="{{ $level->id }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">{{ $level->name }}</h5>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeSchedule(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <input type="hidden" name="level_schedules[{{ $loop->parent->index }}][level_info][id]" value="{{ $level->id }}">
                            <input type="hidden" name="level_schedules[{{ $loop->parent->index }}][level_info][is_custom]" value="{{ $level->is_custom ? '1' : '0' }}">
                            <input type="hidden" name="level_schedules[{{ $loop->parent->index }}][level_info][category]" value="{{ $level->category }}">
                            @if($level->is_custom)
                                <input type="hidden" name="level_schedules[{{ $loop->parent->index }}][level_info][name]" value="{{ $level->name }}">
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Tipo de horario</label>
                                <select class="form-select" name="level_schedules[{{ $loop->parent->index }}][schedule][name]" required>
                                    @foreach($educationalSchedules as $key => $value)
                                        <option value="{{ $key }}" {{ $schedule->name == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción breve</label>
                                <input type="text" class="form-control" 
                                       name="level_schedules[{{ $loop->parent->index }}][schedule][schedule]"
                                       value="{{ $schedule->schedule }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Notas detalladas</label>
                                <textarea class="form-control" rows="3"
                                          name="level_schedules[{{ $loop->parent->index }}][schedule][notes]">{{ $schedule->notes }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Adjuntar documento</label>
                                <input type="file" class="form-control" 
                                       name="schedule_attachments[{{ $loop->parent->index }}]" 
                                       accept=".pdf,.doc,.docx">
                                @if($schedule->anexo)
                                    <div class="mt-2">
                                        <a href="{{ $schedule->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver documento actual
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

        <!-- Botón para guardar -->
        <button type="submit" class="btn btn-primary w-100">Guardar Vinculación</button>
    </form>
</div>

<!-- Plantilla para el formulario de horario (hidden) -->
<div id="scheduleTemplate" class="card mb-4" style="display: none;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Horario para: <span class="level-name"></span></h5>
        <button type="button" class="btn btn-sm btn-danger" onclick="removeSchedule(this)">Eliminar</button>
    </div>
    <div class="card-body">
        <input type="hidden" class="schedule-index">
        <div class="level-info-group">
            <input type="hidden" class="level-id">
            <input type="hidden" class="is-custom">
            <input type="hidden" class="custom-category">
        </div>
        <div class="schedule-info-group">
            <input type="hidden" class="schedule-name">
            <input type="hidden" class="schedule-value">
            <input type="hidden" class="schedule-notes">
        </div>

        <!-- Selección de horario -->
        <div class="mb-3">
            <label class="form-label fw-bold">Horario <span class="text-danger fw-bold">*</span></label>
            <select class="form-select schedule-select" required>
                @foreach($educationalSchedules as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <!-- Campo de texto para describir el horario -->
        <div class="mb-3">
            <label class="form-label fw-bold">Descripción breve del horario <span class="text-danger fw-bold">*</span></label>
            <input type="text" class="form-control schedule-description" placeholder="Ej: Horario matutino de 8 AM a 12 PM" required>
        </div>

        <!-- Área de texto para descripción detallada -->
        <div class="mb-3">
            <label class="form-label fw-bold">Descripción Detallada (opcional)</label>
            <textarea class="form-control schedule-notes-input" rows="4" placeholder="Detalles adicionales sobre el horario y estructura educativa..."></textarea>
        </div>

        <!-- Adjuntar archivo -->
        <div class="mb-3">
            <label class="form-label fw-bold">Adjuntar Anexo de horario</label>
            <input type="file" class="form-control schedule-attachment" name="schedule_attachments[]">
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Manejar cambios en los checkboxes de niveles educativos
    document.querySelectorAll('.level-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSchedules();
        });
    });
});

function updateSchedules() {
    const scheduleContainer = document.getElementById('schedule-container');
    const selectedLevels = document.querySelectorAll('.level-checkbox:checked');
    
    // Obtener los datos existentes de los horarios
    const existingSchedules = {};
    document.querySelectorAll('.schedule-card').forEach(card => {
        const levelId = card.dataset.levelId;
        const scheduleSelect = card.querySelector('select[name$="[schedule][name]"]');
        const scheduleInput = card.querySelector('input[name$="[schedule][schedule]"]');
        const scheduleNotes = card.querySelector('textarea[name$="[schedule][notes]"]');
        const scheduleFile = card.querySelector('input[type="file"]');
        const existingFileLink = card.querySelector('a[target="_blank"]');
        
        if (scheduleSelect && scheduleInput) {
            existingSchedules[levelId] = {
                scheduleType: scheduleSelect.value,
                description: scheduleInput.value,
                notes: scheduleNotes ? scheduleNotes.value : '',
                attachment: scheduleFile,
                existingFile: existingFileLink ? existingFileLink.href : null
            };
        }
    });
    
    // Limpiar contenedor
    scheduleContainer.innerHTML = '';
    
    // Crear tarjetas para cada nivel seleccionado
    selectedLevels.forEach((checkbox, index) => {
        const levelId = checkbox.value;
        const levelName = checkbox.nextElementSibling.textContent;
        const category = checkbox.dataset.category;
        
        const card = document.createElement('div');
        card.className = 'schedule-card card mb-3';
        card.dataset.levelId = levelId;
        
        card.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">${levelName}</h5>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeSchedule(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

                <input type="hidden" name="level_schedules[${index}][level_info][id]" value="${levelId}">
                <input type="hidden" name="level_schedules[${index}][level_info][is_custom]" value="0">
                <input type="hidden" name="level_schedules[${index}][level_info][category]" value="${category}">

                <div class="mb-3">
                    <label class="form-label">Tipo de horario</label>
                    <select class="form-select" name="level_schedules[${index}][schedule][name]" required>
                        @foreach($educationalSchedules as $key => $value)
                            <option value="{{ $key }}" {{ $schedule->name == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción breve</label>
                    <input type="text" class="form-control" 
                           name="level_schedules[${index}][schedule][schedule]" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notas detalladas</label>
                    <textarea class="form-control" rows="3"
                              name="level_schedules[${index}][schedule][notes]"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Adjuntar documento</label>
                    <input type="file" class="form-control" 
                           name="schedule_attachments[${index}]" 
                           accept=".pdf,.doc,.docx">
                </div>
            </div>
        `;
        
        // Restaurar datos existentes si hay
        if (existingSchedules[levelId]) {
            const existing = existingSchedules[levelId];
            card.querySelector('select[name$="[schedule][name]"]').value = existing.scheduleType;
            card.querySelector('input[name$="[schedule][schedule]"]').value = existing.description;
            card.querySelector('textarea[name$="[schedule][notes]"]').value = existing.notes;
            
            // Si hay un archivo adjunto existente, mostrar el enlace
            if (existing.existingFile) {
                const fileContainer = document.createElement('div');
                fileContainer.className = 'mt-2';
                fileContainer.innerHTML = `
                    <a href="${existing.existingFile}" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye"></i> Ver documento actual
                    </a>
                `;
                card.querySelector('.mb-3:last-child').appendChild(fileContainer);
            }
        }
        
        scheduleContainer.appendChild(card);
    });
}

function removeSchedule(button) {
    const card = button.closest('.card');
    const levelId = card.dataset.levelId;
    
    // Eliminar la tarjeta
    card.remove();
    
    // Desmarcar el checkbox correspondiente
    const checkbox = document.getElementById(levelId);
    if (checkbox) {
        checkbox.checked = false;
    }
}

// Función para mostrar/ocultar los inputs personalizados
function toggleCustomInput(category) {
    const container = document.getElementById(`custom-${category}-container`);
    container.style.display = container.style.display === 'none' ? 'block' : 'none';
}

// Función para agregar niveles personalizados
function addCustomLevel(category) {
    const input = document.querySelector(`#custom-${category}-container input[type="text"]`);
    const levelName = input.value.trim();
    const anexoInput = document.querySelector(`.${category}-anexo`);

    if (levelName) {
        // Generar un ID único para el nivel personalizado
        const customId = `custom-${category}-${Date.now()}`;

        // Mapear categorías en inglés a español
        const categoryMap = {
            'preescolar': 'preescolar',
            'emphasis': 'énfasis',
            'agreement': 'convenio'
        };

        // Crear un objeto File si hay un archivo seleccionado
        let anexoFile = null;
        if (anexoInput && anexoInput.files[0]) {
            anexoFile = anexoInput.files[0];
        }

        // Agregar al objeto de niveles seleccionados
        selectedLevels.push({
            id: customId,
            name: levelName,
            isCustom: true,
            category: categoryMap[category],
            anexo: anexoFile
        });

        // Crear el elemento en la lista
        const container = document.getElementById('educational-levels-container');
        const newCheckbox = document.createElement('div');
        newCheckbox.className = 'form-check';
        newCheckbox.innerHTML = `
            <input class="form-check-input level-checkbox" type="checkbox"
                   id="${customId}"
                   value="${customId}"
                   data-category="${category}"
                   checked>
            <label class="form-check-label" for="${customId}">
                ${levelName} (personalizado)
            </label>
            ${anexoFile ? `
                <span class="badge bg-info ms-2">Anexo: ${anexoFile.name}</span>
                <a href="#" class="btn btn-outline-info btn-sm ms-2 view-anexo" data-file="${anexoFile.name}" title="Ver anexo">
                    <i class="fas fa-eye"></i> Ver Anexo
                </a>
            ` : ''}
        `;

        // Insertar después del contenedor de inputs
        document.getElementById(`custom-${category}-container`).after(newCheckbox);

        // Limpiar los inputs
        input.value = '';
        if (anexoInput) {
            anexoInput.value = '';
        }

        // Ocultar el contenedor de inputs
        document.getElementById(`custom-${category}-container`).style.display = 'none';

        // Actualizar horarios
        updateSchedules();
    }
}
</script>

@endsection
