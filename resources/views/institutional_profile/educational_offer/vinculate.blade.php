@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{ route('sede-with-institution.edit', ['institutionId' => $institutionId, 'sede_with_institution' => $sedeId])}}"
    ></div>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="vinculationForm" action="{{ route('educational-offer.make-vinculation', $sedeId ?? -1) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sede_educational[sede_id]" id="sede" value="{{$sedeId}}">

            <!-- Contenedor para niveles educativos -->
            <div class="mb-4">
                <label class="form-label fw-bold">Niveles educativos <span class="text-danger fw-bold">*</span></label>
                <div id="educational-levels-container" class="card p-3">
                    <!-- Sección para Preescolar -->
                    <div class="mb-3">
                        <h5>Preescolar</h5>
                        @foreach($educationalLevels->where('category', App\Models\Enums\EducationalOfferLevelCategoryEnum::PreSchool->value) as $preescolar)
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input level-checkbox" type="checkbox"
                                       id="preescolar-{{ $preescolar->id }}"
                                       value="{{ $preescolar->id }}"
                                       data-category="preescolar">
                                <label class="form-check-label" for="preescolar-{{ $preescolar->id }}">
                                    {{ $preescolar->name }}
                                </label>
                                @if($preescolar->document_id)
                                    <a href="{{ $preescolar->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                        <i class="fas fa-eye"></i> Ver anexo
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

                    <!-- Sección para Primaria -->
                    <div class="mb-3">
                        <h5>Primaria</h5>
                        @foreach($educationalLevels->where('category', App\Models\Enums\EducationalOfferLevelCategoryEnum::Primary->value) as $primaria)
                            <div class="form-check d-flex align-items-center  gap-2">
                                <input class="form-check-input level-checkbox" type="checkbox"
                                       id="primaria-{{ $primaria->id }}"
                                       value="{{ $primaria->id }}"
                                       data-category="primaria">
                                <label class="form-check-label" for="primaria-{{ $primaria->id }}">
                                    {{ $primaria->name }}
                                </label>
                                @if($primaria->document_id)
                                    <a href="{{ $primaria->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                        <i class="fas fa-eye"></i> Ver anexo
                                    </a>
                                @endif
                            </div>
                        @endforeach
                        <div id="custom-primaria-container" class="mt-2" style="display: none;">
                            <input type="text" class="form-control mb-2" placeholder="Nombre del grado de primaria">
                            <div class="mb-2">
                                <label class="form-label">Anexo (opcional)</label>
                                <input type="file" class="form-control primaria-anexo" accept="application/pdf">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addCustomLevel('primaria')">Agregar</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-link mt-1" onclick="toggleCustomInput('primaria')">
                            + Agregar otro nivel de primaria
                        </button>
                    </div>

                    <!-- Sección para Secundaria -->
                    <div class="mb-3">
                        <h5>Básica y Media</h5>
                        @foreach($educationalLevels->where('category', App\Models\Enums\EducationalOfferLevelCategoryEnum::Secondary->value) as $secundaria)
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input level-checkbox" type="checkbox"
                                       id="secundaria-{{ $secundaria->id }}"
                                       value="{{ $secundaria->id }}"
                                       data-category="secundaria">
                                <label class="form-check-label" for="secundaria-{{ $secundaria->id }}">
                                    {{ $secundaria->name }}
                                </label>
                                @if($secundaria->document_id)
                                    <a href="{{ $secundaria->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                        <i class="fas fa-eye"></i> Ver Anexo
                                    </a>
                                @endif
                            </div>
                        @endforeach
                        <div id="custom-secundaria-container" class="mt-2" style="display: none;">
                            <input type="text" class="form-control mb-2" placeholder="Nombre del grado de secundaria">
                            <div class="mb-2">
                                <label class="form-label">Anexo (opcional)</label>
                                <input type="file" class="form-control secundaria-anexo" accept="application/pdf">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addCustomLevel('secundaria')">Agregar</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-link mt-1" onclick="toggleCustomInput('secundaria')">
                            + Agregar otro nivel de secundaria
                        </button>
                    </div>

                    <!-- Sección para Énfasis -->
                    <div class="mb-3">
                        <h5>Énfasis</h5>
                        @foreach($educationalLevels->where('category', App\Models\Enums\EducationalOfferLevelCategoryEnum::Emphasis->value) as $emphasis)
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input level-checkbox" type="checkbox"
                                       id="emphasis-{{ $emphasis->id }}"
                                       value="{{ $emphasis->id }}"
                                       data-category="emphasis">
                                <label class="form-check-label" for="emphasis-{{ $emphasis->id }}">
                                    {{ $emphasis->name }}
                                </label>
                                @if($emphasis->document_id)
                                    <a href="{{ $emphasis->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                        <i class="fas fa-eye"></i> Ver anexo
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
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input level-checkbox" type="checkbox"
                                       id="agreement-{{ $agreement->id }}"
                                       value="{{ $agreement->id }}"
                                       data-category="agreement">
                                <label class="form-check-label" for="agreement-{{ $agreement->id }}">
                                    {{ $agreement->name }}
                                </label>
                                @if($agreement->document_id)
                                    <a href="{{ $agreement->anexo->url }}" target="_blank" class="btn btn-outline-info btn-sm ms-2">
                                        <i class="fas fa-eye"></i> Ver anexo
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
            <div id="schedules-container" class="mb-4">
                <h4 class="fw-bold mb-3">Horarios por Nivel Educativo</h4>
                <!-- Los horarios se agregarán aquí dinámicamente -->
            </div>

            <!-- Botón para guardar -->
            <button type="submit" class="btn btn-primary w-100">Guardar vinculación</button>
        </form>
    </div>

    <!-- Plantilla para el formulario de horario normal (hidden) -->
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
                <input type="hidden" class="schedule-notes">
                <input type="hidden" class="schedule-hora_inicio">
                <input type="hidden" class="schedule-hora_fin">
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
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Hora de Inicio</label>
                        <input type="time" class="form-control schedule-hora_inicio-input" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Hora de Final</label>
                        <input type="time" class="form-control schedule-hora_fin-input"  required>
                    </div>
                </div>
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

    <!-- Plantilla para el formulario de horario de educación para adultos (hidden) -->
    <div id="adultEducationScheduleTemplate" class="card mb-4" style="display: none;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Horarios para: <span class="level-name"></span></h5>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeSchedule(this)">Eliminar</button>
        </div>
        <div class="card-body">
            <input type="hidden" class="schedule-index">
            <div class="level-info-group">
                <input type="hidden" class="level-id">
                <input type="hidden" class="is-custom">
                <input type="hidden" class="custom-category">
            </div>

            <!-- Mensaje de ayuda -->
            <div class="alert alert-info mb-3">
                <i class="fas fa-info-circle"></i> Selecciona al menos uno de los horarios para educación de adultos
            </div>

            <!-- Horarios específicos para educación de adultos -->
            <div class="row">
                <!-- Horario Nocturno -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-check">
                                <input class="form-check-input adult-schedule-checkbox" type="checkbox" id="nocturno" value="nocturno">
                                <label class="form-check-label fw-bold" for="nocturno">
                                    Nocturno
                                </label>
                            </div>
                        </div>
                        <div class="card-body adult-schedule-inputs" style="display: none;">
                            <div class="mb-2">
                                <label class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control adult-hora-inicio" data-schedule="nocturno">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Hora de Fin</label>
                                <input type="time" class="form-control adult-hora-fin" data-schedule="nocturno">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Descripción (opcional)</label>
                                <textarea class="form-control adult-notes" rows="2" data-schedule="nocturno" placeholder="Detalles del horario nocturno..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horario Sabatino -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-check">
                                <input class="form-check-input adult-schedule-checkbox" type="checkbox" id="sabatino" value="sabatino">
                                <label class="form-check-label fw-bold" for="sabatino">
                                    Sabatino
                                </label>
                            </div>
                        </div>
                        <div class="card-body adult-schedule-inputs" style="display: none;">
                            <div class="mb-2">
                                <label class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control adult-hora-inicio" data-schedule="sabatino">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Hora de Fin</label>
                                <input type="time" class="form-control adult-hora-fin" data-schedule="sabatino">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Descripción (opcional)</label>
                                <textarea class="form-control adult-notes" rows="2" data-schedule="sabatino" placeholder="Detalles del horario sabatino..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horario Dominical -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-check">
                                <input class="form-check-input adult-schedule-checkbox" type="checkbox" id="dominical" value="dominical">
                                <label class="form-check-label fw-bold" for="dominical">
                                    Dominical
                                </label>
                            </div>
                        </div>
                        <div class="card-body adult-schedule-inputs" style="display: none;">
                            <div class="mb-2">
                                <label class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control adult-hora-inicio" data-schedule="dominical">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Hora de Fin</label>
                                <input type="time" class="form-control adult-hora-fin" data-schedule="dominical">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Descripción (opcional)</label>
                                <textarea class="form-control adult-notes" rows="2" data-schedule="dominical" placeholder="Detalles del horario dominical..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Adjuntar archivo general -->
            <div class="mt-3">
                <label class="form-label fw-bold">Adjuntar Anexo de horario</label>
                <input type="file" class="form-control schedule-attachment" name="schedule_attachments[]">
            </div>

            <!-- Campos ocultos para almacenar los datos -->
            <div class="hidden-fields"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Configuración inicial
            const sedeSelect = document.getElementById('sede');
            const vinculationForm = document.getElementById('vinculationForm');

            // Actualizar la URL del formulario cuando cambia la selección de sede
            sedeSelect.addEventListener('change', function() {
                const selectedSedeId = this.value;
                const baseRoute = "{{ route('educational-offer.make-vinculation', '') }}";
                vinculationForm.action = baseRoute + '/' + selectedSedeId;
            });

            // Manejar cambios en los checkboxes de niveles educativos
            document.querySelectorAll('.level-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSchedules();
                });
            });

            // Validación del formulario
            vinculationForm.addEventListener('submit', function(e) {
                if ( !validateAdultEducationSchedules()) {
                    e.preventDefault();
                    alert('Debes seleccionar al menos un horario para cada nivel de educación de adultos.');
                }
            });
        });

        // Objeto para almacenar los niveles seleccionados
        const selectedLevels = {
            preescolar: [],
            primaria: [],
            secundaria: [],
            emphasis: [],
            agreement: []
        };

        // Función para mostrar/ocultar los inputs personalizados
        function toggleCustomInput(category) {
            const container = document.getElementById(`custom-${category}-container`);
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
        }

        // Función para determinar si un horario es para educación de adultos
        function isAdultEducationSchedule(scheduleValue) {
            // Asume que el valor del select contiene 'adultos' o 'adult' para educación de adultos
            // Ajusta esta condición según tu implementación
            return scheduleValue && (scheduleValue.toLowerCase().includes('adultos') || scheduleValue.toLowerCase().includes('adult'));
        }

        // Función para actualizar los formularios de horario
        function updateSchedules() {
            const schedulesContainer = document.getElementById('schedules-container');
            const scheduleTemplate = document.getElementById('scheduleTemplate');
            const adultScheduleTemplate = document.getElementById('adultEducationScheduleTemplate');

            // Limpiar contenedor
            schedulesContainer.innerHTML = '<h4 class="fw-bold mb-3">Horarios por Nivel Educativo</h4>';

            // Recoger todos los niveles seleccionados
            const allSelectedLevels = [];

            // Agregar niveles predefinidos seleccionados
            document.querySelectorAll('.level-checkbox:checked').forEach(checkbox => {
                const category = checkbox.dataset.category;
                const value = checkbox.value;

                // Solo agregar si no es un nivel personalizado (los personalizados ya están en selectedLevels)
                if (!value.startsWith('custom-')) {
                    allSelectedLevels.push({
                        id: value,
                        name: checkbox.nextElementSibling.textContent.replace(' (personalizado)', ''),
                        isCustom: false,
                        category: category
                    });
                }
            });

            // Agregar niveles personalizados seleccionados
            for (const category in selectedLevels) {
                selectedLevels[category].forEach(level => {
                    if (document.getElementById(level.id)?.checked) {
                        allSelectedLevels.push(level);
                    }
                });
            }

            // Crear un horario para cada nivel seleccionado
            allSelectedLevels.forEach((level, index) => {
                // Determinar qué plantilla usar basándose en el tipo de horario
                // Por ahora, asumimos que todos los horarios usan la plantilla normal
                // excepto cuando se detecte específicamente educación de adultos
                const useAdultTemplate = false; // Cambiar esta lógica según tus necesidades

                // Clonar la plantilla apropiada
                const scheduleCard = useAdultTemplate ?
                    adultScheduleTemplate.cloneNode(true) :
                    scheduleTemplate.cloneNode(true);

                scheduleCard.style.display = 'block';

                // Actualizar los datos del nivel
                scheduleCard.querySelector('.level-name').textContent = level.name;
                scheduleCard.querySelector('.level-id').value = level.id;
                scheduleCard.querySelector('.is-custom').value = level.isCustom ? '1' : '0';
                scheduleCard.querySelector('.custom-category').value = level.category;
                scheduleCard.querySelector('.schedule-index').value = index;

                // Agregar campo oculto para el nombre del nivel personalizado
                const customNameInput = document.createElement('input');
                customNameInput.type = 'hidden';
                customNameInput.name = `level_schedules[${index}][level_info][name]`;
                customNameInput.value = level.name;
                scheduleCard.querySelector('.level-info-group').appendChild(customNameInput);

                // Agregar campo de anexo para niveles personalizados
                if (level.isCustom && level.anexo) {
                    const anexoInput = document.createElement('input');
                    anexoInput.type = 'file';
                    anexoInput.name = `level_attachments[${index}]`;
                    anexoInput.style.display = 'none';
                    anexoInput.dataset.file = level.anexo.name;

                    // Crear un nuevo FileList con el archivo
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(level.anexo);
                    anexoInput.files = dataTransfer.files;

                    scheduleCard.querySelector('.card-body').appendChild(anexoInput);
                }

                // Actualizar los nombres de los campos para usar el índice
                const levelInfoGroup = scheduleCard.querySelector('.level-info-group');
                levelInfoGroup.querySelector('.level-id').name = `level_schedules[${index}][level_info][id]`;
                levelInfoGroup.querySelector('.is-custom').name = `level_schedules[${index}][level_info][is_custom]`;
                levelInfoGroup.querySelector('.custom-category').name = `level_schedules[${index}][level_info][category]`;

                if (useAdultTemplate) {
                    setupAdultEducationSchedule(scheduleCard, index);
                } else {
                    setupNormalSchedule(scheduleCard, index);
                }

                // Agregar al contenedor
                schedulesContainer.appendChild(scheduleCard);
            });
        }

        // Función para configurar horario normal
        function setupNormalSchedule(scheduleCard, index) {
            const scheduleInfoGroup = scheduleCard.querySelector('.schedule-info-group');

            scheduleInfoGroup.querySelector('.schedule-name').name = `level_schedules[${index}][schedule][name]`;
            scheduleInfoGroup.querySelector('.schedule-hora_fin').name = `level_schedules[${index}][schedule][hora_fin]`;
            scheduleInfoGroup.querySelector('.schedule-hora_inicio').name = `level_schedules[${index}][schedule][hora_inicio]`;
            scheduleInfoGroup.querySelector('.schedule-notes').name = `level_schedules[${index}][schedule][notes]`;

            // Agregar eventos para actualizar los campos ocultos
            const scheduleSelect = scheduleCard.querySelector('.schedule-select');
            const scheduleNotes = scheduleCard.querySelector('.schedule-notes-input');
            const scheduleHoraInicio = scheduleCard.querySelector('.schedule-hora_inicio-input');
            const scheduleHoraFin = scheduleCard.querySelector('.schedule-hora_fin-input');

            // Detectar si es educación de adultos y cambiar la plantilla
            scheduleSelect.addEventListener('change', function() {
                if (isAdultEducationSchedule(this.value)) {
                    // Reemplazar con plantilla de educación de adultos
                    replaceWithAdultEducationTemplate(scheduleCard, index);
                } else {
                    scheduleCard.querySelector('.schedule-name').value = this.value;
                }
            });

            // Seleccionar el primer valor por defecto y actualizar el campo oculto
            scheduleSelect.value = scheduleSelect.options[0].value;
            scheduleCard.querySelector('.schedule-name').value = scheduleSelect.value;

            scheduleNotes.addEventListener('input', function() {
                scheduleCard.querySelector('.schedule-notes').value = this.value;
            });

            scheduleHoraInicio.addEventListener('input', function() {
                scheduleCard.querySelector('.schedule-hora_inicio').value = this.value;
            });

            scheduleHoraFin.addEventListener('input', function() {
                scheduleCard.querySelector('.schedule-hora_fin').value = this.value;
            });
        }

        // Función para configurar horario de educación de adultos
        function setupAdultEducationSchedule(scheduleCard, index) {
            const checkboxes = scheduleCard.querySelectorAll('.adult-schedule-checkbox');
            const hiddenFieldsContainer = scheduleCard.querySelector('.hidden-fields');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const scheduleType = this.value;
                    const inputsContainer = this.closest('.card').querySelector('.adult-schedule-inputs');

                    if (this.checked) {
                        inputsContainer.style.display = 'block';
                        // Hacer required los campos de hora
                        const horaInicio = inputsContainer.querySelector('.adult-hora-inicio');
                        const horaFin = inputsContainer.querySelector('.adult-hora-fin');
                        horaInicio.required = true;
                        horaFin.required = true;
                    } else {
                        inputsContainer.style.display = 'none';
                        // Quitar required de los campos de hora
                        const horaInicio = inputsContainer.querySelector('.adult-hora-inicio');
                        const horaFin = inputsContainer.querySelector('.adult-hora-fin');
                        horaInicio.required = false;
                        horaFin.required = false;
                    }

                    updateAdultScheduleHiddenFields(scheduleCard, index);
                });
            });

            // Agregar eventos a los inputs de hora y descripción
            scheduleCard.querySelectorAll('.adult-hora-inicio, .adult-hora-fin, .adult-notes').forEach(input => {
                input.addEventListener('input', function() {
                    updateAdultScheduleHiddenFields(scheduleCard, index);
                });
            });

            updateAdultScheduleHiddenFields(scheduleCard, index);
        }

        // Función para actualizar los campos ocultos del horario de educación de adultos
        function updateAdultScheduleHiddenFields(scheduleCard, index) {
            const hiddenFieldsContainer = scheduleCard.querySelector('.hidden-fields');
            const checkboxes = scheduleCard.querySelectorAll('.adult-schedule-checkbox:checked');

            // Limpiar campos ocultos existentes
            hiddenFieldsContainer.innerHTML = '';

            checkboxes.forEach((checkbox, scheduleIndex) => {
                const scheduleType = checkbox.value;
                const inputsContainer = checkbox.closest('.card').querySelector('.adult-schedule-inputs');

                const horaInicio = inputsContainer.querySelector('.adult-hora-inicio').value;
                const horaFin = inputsContainer.querySelector('.adult-hora-fin').value;
                const notes = inputsContainer.querySelector('.adult-notes').value;

                // Crear campos ocultos para cada horario seleccionado
                const scheduleData = [
                    { name: `level_schedules[${index}][adult_schedules][${scheduleIndex}][name]`, value: scheduleType },
                    { name: `level_schedules[${index}][adult_schedules][${scheduleIndex}][hora_inicio]`, value: horaInicio },
                    { name: `level_schedules[${index}][adult_schedules][${scheduleIndex}][hora_fin]`, value: horaFin },
                    { name: `level_schedules[${index}][adult_schedules][${scheduleIndex}][notes]`, value: notes }
                ];

                scheduleData.forEach(field => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = field.name;
                    hiddenInput.value = field.value;
                    hiddenFieldsContainer.appendChild(hiddenInput);
                });
            });
        }

        // Función para reemplazar plantilla de adultos con horario normal
        function replaceWithNormalTemplate(currentCard, index) {
            const scheduleTemplate = document.getElementById('scheduleTemplate');
            const newCard = scheduleTemplate.cloneNode(true);
            newCard.style.display = 'block';

            // Copiar datos básicos
            const levelName = currentCard.querySelector('.level-name').textContent;
            const levelId = currentCard.querySelector('.level-id').value;
            const isCustom = currentCard.querySelector('.is-custom').value;
            const customCategory = currentCard.querySelector('.custom-category').value;

            newCard.querySelector('.level-name').textContent = levelName;
            newCard.querySelector('.level-id').value = levelId;
            newCard.querySelector('.is-custom').value = isCustom;
            newCard.querySelector('.custom-category').value = customCategory;
            newCard.querySelector('.schedule-index').value = index;

            // Actualizar nombres de campos
            const levelInfoGroup = newCard.querySelector('.level-info-group');
            levelInfoGroup.querySelector('.level-id').name = `level_schedules[${index}][level_info][id]`;
            levelInfoGroup.querySelector('.is-custom').name = `level_schedules[${index}][level_info][is_custom]`;
            levelInfoGroup.querySelector('.custom-category').name = `level_schedules[${index}][level_info][category]`;

            // Agregar campo oculto para el nombre del nivel
            const customNameInput = document.createElement('input');
            customNameInput.type = 'hidden';
            customNameInput.name = `level_schedules[${index}][level_info][name]`;
            customNameInput.value = levelName;
            levelInfoGroup.appendChild(customNameInput);

            // Configurar la nueva plantilla
            setupNormalSchedule(newCard, index);

            // Reemplazar en el DOM
            currentCard.parentNode.replaceChild(newCard, currentCard);
        }

        // Función para reemplazar plantilla normal con educación de adultos
        function replaceWithAdultEducationTemplate(currentCard, index) {
            const adultScheduleTemplate = document.getElementById('adultEducationScheduleTemplate');
            const newCard = adultScheduleTemplate.cloneNode(true);
            newCard.style.display = 'block';

            // Copiar datos básicos
            const levelName = currentCard.querySelector('.level-name').textContent;
            const levelId = currentCard.querySelector('.level-id').value;
            const isCustom = currentCard.querySelector('.is-custom').value;
            const customCategory = currentCard.querySelector('.custom-category').value;

            newCard.querySelector('.level-name').textContent = levelName;
            newCard.querySelector('.level-id').value = levelId;
            newCard.querySelector('.is-custom').value = isCustom;
            newCard.querySelector('.custom-category').value = customCategory;
            newCard.querySelector('.schedule-index').value = index;

            // Actualizar nombres de campos
            const levelInfoGroup = newCard.querySelector('.level-info-group');
            levelInfoGroup.querySelector('.level-id').name = `level_schedules[${index}][level_info][id]`;
            levelInfoGroup.querySelector('.is-custom').name = `level_schedules[${index}][level_info][is_custom]`;
            levelInfoGroup.querySelector('.custom-category').name = `level_schedules[${index}][level_info][category]`;

            // Agregar campo oculto para el nombre del nivel
            const customNameInput = document.createElement('input');
            customNameInput.type = 'hidden';
            customNameInput.name = `level_schedules[${index}][level_info][name]`;
            customNameInput.value = levelName;
            levelInfoGroup.appendChild(customNameInput);

            // Agregar botón para volver al horario normal
            const backButton = document.createElement('button');
            backButton.type = 'button';
            backButton.className = 'btn btn-sm btn-outline-secondary ms-2';
            backButton.innerHTML = '<i class="fas fa-undo"></i> Cambiar horario';
            backButton.addEventListener('click', function() {
                replaceWithNormalTemplate(newCard, index);
            });

            const cardHeader = newCard.querySelector('.card-header');
            cardHeader.querySelector('button').insertAdjacentElement('beforebegin', backButton);


            // Configurar la nueva plantilla
            setupAdultEducationSchedule(newCard, index);

            // Reemplazar en el DOM
            currentCard.parentNode.replaceChild(newCard, currentCard);
        }

        // Función para validar horarios de educación de adultos
        // Función para validar horarios de educación de adultos
        function validateAdultEducationSchedules() {
            const adultScheduleCards = document.querySelectorAll('#schedules-container .card');
            let hasAdultEducation = false;
            let allValid = true;

            for (let card of adultScheduleCards) {
                const adultCheckboxes = card.querySelectorAll('.adult-schedule-checkbox');
                const scheduleSelect = card.querySelector('.schedule-select');

                // Verificar si este es un horario de educación de adultos
                const isAdultEducation = adultCheckboxes.length > 0 ||
                    (scheduleSelect && isAdultEducationSchedule(scheduleSelect.value));

                if (isAdultEducation) {
                    hasAdultEducation = true;

                    // Solo validar si es educación de adultos
                    if (adultCheckboxes.length > 0) {
                        // Validar que al menos un checkbox esté seleccionado
                        const checkedCount = card.querySelectorAll('.adult-schedule-checkbox:checked').length;
                        if (checkedCount === 0) {
                            allValid = false;
                            // Resaltar el card como error
                            card.classList.add('border', 'border-danger');
                            // Mostrar mensaje de error
                            const errorMsg = document.createElement('div');
                            errorMsg.className = 'alert alert-danger mt-2';
                            errorMsg.textContent = 'Debes seleccionar al menos un horario para educación de adultos.';
                            if (!card.querySelector('.alert-danger')) {
                                card.querySelector('.card-body').appendChild(errorMsg);
                            }
                        } else {
                            // Remover estilos de error si está válido
                            card.classList.remove('border', 'border-danger');
                            const errorMsg = card.querySelector('.alert-danger');
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                    }
                }
            }

            // Si no hay educación de adultos, retornar true
            if (!hasAdultEducation) {
                return true;
            }

            return allValid;
        }

        // Función para eliminar un horario
        function removeSchedule(button) {
            const scheduleCard = button.closest('.card');
            const levelId = scheduleCard.querySelector('.level-id').value;

            // Eliminar del DOM
            scheduleCard.remove();

            // Desmarcar el checkbox correspondiente si existe
            const checkbox = document.getElementById(levelId);
            if (checkbox) {
                checkbox.checked = false;
            }

            // Eliminar de selectedLevels si es un nivel personalizado
            if (levelId.startsWith('custom-')) {
                const category = levelId.split('-')[1];
                selectedLevels[category] = selectedLevels[category].filter(level => level.id !== levelId);
            }
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
                    'primaria': 'primaria',
                    'secundaria': 'secundaria',
                    'emphasis': 'énfasis',
                    'agreement': 'convenio'
                };

                // Crear un objeto File si hay un archivo seleccionado
                let anexoFile = null;
                if (anexoInput && anexoInput.files[0]) {
                    anexoFile = anexoInput.files[0];
                }

                // Agregar al objeto de niveles seleccionados
                selectedLevels[category].push({
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

                // Agregar evento al nuevo checkbox
                newCheckbox.querySelector('input').addEventListener('change', function() {
                    updateSchedules();
                });

                // Actualizar horarios
                updateSchedules();
            }
        }
    </script>

@endsection
