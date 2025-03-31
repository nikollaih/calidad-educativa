@extends('layouts.app')

@section('content')

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="vinculationForm" action="{{ route('educational-offer.make-vinculation', $allSedes->first()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Selección de sede -->
        <div class="mb-4">
            <label for="sede" class="form-label fw-bold">Selecciona una sede <span class="text-danger fw-bold">*</span></label>
            <select class="form-select" name="sede_educational[sede_id]" id="sede">
                @foreach($allSedes as $sede)
                    <option value="{{ $sede->id }}"
                        {{ $loop->first ? 'selected' : '' }}>
                        {{ $sede->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Selección de oferta educativa -->
        <div class="mb-4">
            <label for="educational_offer" class="form-label fw-bold">Oferta Educativa <span class="text-danger fw-bold">*</span> </label>
            <select class="form-select" name="sede_educational[educational_offer_id][" id="educational_offer">
                @foreach($allEducationalOffers as $offer)
                    <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Contenedor dinámico para niveles educativos -->
        <div class="mb-4">
            <label class="form-label fw-bold">Niveles Educativos <span class="text-danger fw-bold">*</span> </label>
            <select class="form-select" name="educational_levels[]" id="select2Multiple" multiple>
                @foreach($educationalLevels as $educationalLevel)
                    <option value="{{ $educationalLevel->id }}">{{ $educationalLevel->full_hierarchy }}</option>
                @endforeach
            </select>
        </div>

        <!-- Card para información de horario -->
        <div class=" mb-4">
            <label class="form-label fw-bold">Información de Horario</label>
            <div class=" card card-body">

                <!-- Selección de horario -->
                <div class="mb-3">
                    <label for="schedule" class="form-label fw-bold">Horario <span class="text-danger fw-bold">*</span></label>
                    <select class="form-select" name="schedule[name]" id="schedule" required>
                        @foreach($educationalSchedules as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Campo de texto para describir el horario -->
                <div class="mb-3">
                    <label for="schedule_description" class="form-label fw-bold ">Descripción breve del horario  <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control" name="schedule[schedule]" id="schedule_description" placeholder="Ej: Horario matutino de 8 AM a 12 PM" required>
                </div>

                <!-- Área de texto para descripción detallada -->
                <div class="mb-3">
                    <label for="full_description" class="form-label fw-bold">Descripción Detallada (opcional)</label>
                    <textarea class="form-control" name="schedule[notes]" id="full_description" rows="4" placeholder="Detalles adicionales sobre el horario y estructura educativa..."></textarea>
                </div>
                 <!-- Adjuntar archivo -->
                <div class="mb-4">
                    <label for="attachment" class="form-label fw-bold">Adjuntar Anexo de horario</label>
                    <input type="file" class="form-control" name="schedule_adjunto" id="attachment">
                </div>
            </div>
        </div>

        <!-- Botón para guardar -->
        <button type="submit" class="btn btn-primary w-100">Guardar Vinculación</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Configuración inicial - toma la primera sede por defecto
    const sedeSelect = document.getElementById('sede');
    const vinculationForm = document.getElementById('vinculationForm');
    const firstSedeId = sedeSelect.options[0].value;

    // Actualizar la URL del formulario cuando cambia la selección de sede
    sedeSelect.addEventListener('change', function() {
        const selectedSedeId = this.value;
        const baseRoute = "{{ route('educational-offer.make-vinculation', '') }}";
        vinculationForm.action = baseRoute + '/' + selectedSedeId;
    });

    // Manejo de niveles educativos
    let container = document.getElementById("educational-levels-container");

    container.addEventListener("change", function (event) {
        if (event.target.classList.contains("level-checkbox")) {
            let parentCheckbox = event.target;
            let childrenData = parentCheckbox.getAttribute("data-children");
            let category = parentCheckbox.getAttribute("data-category");
            let parentId = parentCheckbox.getAttribute("data-parent");

            if (childrenData && childrenData !== "[]") {
                let children = JSON.parse(childrenData);
                let subContainerId = `sublevels-${parentCheckbox.value}`;
                let existingSubContainer = document.getElementById(subContainerId);

                if (parentCheckbox.checked) {
                    if (!existingSubContainer) {
                        let subContainer = document.createElement("div");
                        subContainer.classList.add("card", "p-3", "mb-3", "ms-3");
                        subContainer.setAttribute("id", subContainerId);

                        let title = document.createElement("strong");
                        title.classList.add("mb-2");
                        title.textContent = parentCheckbox.nextElementSibling.textContent;

                        subContainer.appendChild(title);

                        children.forEach(child => {
                            let div = document.createElement("div");
                            div.classList.add("form-check");

                            let input = document.createElement("input");
                            input.classList.add("form-check-input", "level-checkbox");
                            input.type = "checkbox";
                            input.id = `level-${child.id}`;
                            input.value = child.id;
                            input.setAttribute("data-children", JSON.stringify(child.children));
                            input.setAttribute("data-category", category);
                            input.setAttribute("data-parent", parentId);

                            let label = document.createElement("label");
                            label.classList.add("form-check-label");
                            label.setAttribute("for", `level-${child.id}`);
                            label.textContent = child.name;

                            div.appendChild(input);
                            div.appendChild(label);
                            subContainer.appendChild(div);

                            if (child.name === "Énfasis" || child.name === "Convenio") {
                                let addContainer = document.createElement("div");
                                addContainer.classList.add("mt-2");

                                let inputNew = document.createElement("input");
                                inputNew.type = "text";
                                inputNew.classList.add("form-control", "mb-2");
                                inputNew.placeholder = "Agregar nuevo ítem...";

                                let btnAdd = document.createElement("button");
                                btnAdd.type = "button";
                                btnAdd.classList.add("btn", "btn-outline-primary", "btn-sm");
                                btnAdd.textContent = "Agregar";

                                btnAdd.addEventListener("click", function () {
                                    if (inputNew.value.trim() !== "") {
                                        let newItem = document.createElement("div");
                                        newItem.classList.add("form-check", "mt-2");

                                        let newInput = document.createElement("input");
                                        newInput.classList.add("form-check-input");
                                        newInput.type = "checkbox";
                                        newInput.value = inputNew.value;
                                        newInput.setAttribute("data-category", category);
                                        newInput.setAttribute("data-parent", parentId);

                                        let newLabel = document.createElement("label");
                                        newLabel.classList.add("form-check-label");
                                        newLabel.textContent = inputNew.value;

                                        newItem.appendChild(newInput);
                                        newItem.appendChild(newLabel);
                                        subContainer.appendChild(newItem);

                                        inputNew.value = "";
                                    }
                                });
                                addContainer.appendChild(inputNew);
                                addContainer.appendChild(btnAdd);
                                subContainer.appendChild(addContainer);
                            }
                        });

                        parentCheckbox.closest(".card").appendChild(subContainer);
                    }
                } else {
                    if (existingSubContainer) {
                        existingSubContainer.remove();
                    }
                }
            }
        }
    });
});
</script>

@endsection
