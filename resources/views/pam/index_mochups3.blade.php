@extends('layouts.app')

@section('custom_css')
    <style>
        .nested-container {
            margin-left: 20px;
            border-left: 3px solid #e2e8f0;
            padding-left: 15px;
            margin-top: 10px;
        }

        .component-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
        }

        .proceso-card {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 6px;
            padding: 12px;
            margin: 8px 0;
        }

        .subproceso-card {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 10px;
            margin: 6px 0;
        }

        .objetivo-card {
            background: #fefce8;
            border: 1px solid #fde047;
            border-radius: 4px;
            padding: 8px;
            margin: 4px 0;
        }

        .btn-add {
            background: #10b981;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
            font-size: 14px;
        }

        .btn-add:hover {
            background: #059669;
        }

        .btn-remove {
            background: #ef4444;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            float: right;
        }

        .btn-remove:hover {
            background: #dc2626;
        }

        .input-field {
            width: 100%;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin: 5px 0;
        }

        .section-title {
            font-weight: bold;
            color: #374151;
            margin-bottom: 10px;
        }

        .level-1 { color: #1f2937; }
        .level-2 { color: #1e40af; }
        .level-3 { color: #059669; }
        .level-4 { color: #d97706; }

        .collapsible {
            cursor: pointer;
            user-select: none;
        }

        .collapsible:before {
            content: '▼ ';
            margin-right: 5px;
        }

        .collapsible.collapsed:before {
            content: '▶ ';
        }

        .content {
            display: block;
        }

        .content.hidden {
            display: none;
        }

        .title-preview {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Componentes</h1>

            <!-- Botón para agregar componente principal -->
            <button type="button" class="btn-add" onclick="agregarComponente()">
                + Agregar Componente
            </button>

            <!-- Contenedor principal de componentes -->
            <div id="componentes-container" class="mt-4">
                <!-- Los componentes se agregarán aquí dinámicamente -->
            </div>

            <!-- Botón para guardar todo -->
            <div class="mt-6 pt-4 border-t">
                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold" onclick="guardarTodo()">
                    Guardar Estructura Completa
                </button>
            </div>
        </div>
    </div>

    <script>
        let componenteCounter = 0;
        let procesoCounter = 0;
        let subprocesoCounter = 0;
        let objetivoCounter = 0;

        function actualizarTitulo(elementId, texto) {
            const tituloElement = document.getElementById(elementId);
            if (tituloElement) {
                tituloElement.textContent = texto || tituloElement.dataset.defaultText;
            }
        }

        function agregarComponente() {
            componenteCounter++;
            const container = document.getElementById('componentes-container');

            const componenteHtml = `
        <div class="component-card" id="componente-${componenteCounter}">
            <button type="button" class="btn-remove" onclick="eliminarElemento('componente-${componenteCounter}')">Eliminar</button>
            <div class="section-title level-1 collapsible" onclick="toggleCollapse(this)">
                <span id="componente-titulo-${componenteCounter}" data-default-text="Componente ${componenteCounter}">Componente ${componenteCounter}</span>
            </div>
            <div class="content">
                <div class="title-preview">Descripción:</div>
                <textarea class="input-field" placeholder="Ingrese la descripción del componente"
                          name="componentes[${componenteCounter}][descripcion]" rows="3"
                          oninput="actualizarTitulo('componente-titulo-${componenteCounter}', this.value)"></textarea>

                <button type="button" class="btn-add" onclick="agregarProceso(${componenteCounter})">
                    + Agregar Proceso
                </button>

                <div class="nested-container" id="procesos-container-${componenteCounter}">
                    <!-- Los procesos se agregarán aquí -->
                </div>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', componenteHtml);
        }

        function agregarProceso(componenteId) {
            procesoCounter++;
            const container = document.getElementById(`procesos-container-${componenteId}`);

            const procesoHtml = `
        <div class="proceso-card" id="proceso-${procesoCounter}">
            <button type="button" class="btn-remove" onclick="eliminarElemento('proceso-${procesoCounter}')">Eliminar</button>
            <div class="section-title level-2 collapsible" onclick="toggleCollapse(this)">
                <span id="proceso-titulo-${procesoCounter}" data-default-text="Proceso ${procesoCounter}">Proceso ${procesoCounter}</span>
            </div>
            <div class="content">
                <div class="title-preview">Descripción:</div>
                <textarea class="input-field" placeholder="Ingrese la descripción del proceso"
                          name="componentes[${componenteId}][procesos][${procesoCounter}][descripcion]" rows="2"
                          oninput="actualizarTitulo('proceso-titulo-${procesoCounter}', this.value)"></textarea>

                <button type="button" class="btn-add" onclick="agregarSubproceso(${componenteId}, ${procesoCounter})">
                    + Agregar Subproceso
                </button>

                <div class="nested-container" id="subprocesos-container-${procesoCounter}">
                    <!-- Los subprocesos se agregarán aquí -->
                </div>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', procesoHtml);
        }

        function agregarSubproceso(componenteId, procesoId) {
            subprocesoCounter++;
            const container = document.getElementById(`subprocesos-container-${procesoId}`);

            const subprocesoHtml = `
        <div class="subproceso-card" id="subproceso-${subprocesoCounter}">
            <button type="button" class="btn-remove" onclick="eliminarElemento('subproceso-${subprocesoCounter}')">Eliminar</button>
            <div class="section-title level-3 collapsible" onclick="toggleCollapse(this)">
                <span id="subproceso-titulo-${subprocesoCounter}" data-default-text="Subproceso ${subprocesoCounter}">Subproceso ${subprocesoCounter}</span>
            </div>
            <div class="content">
                <div class="title-preview">Descripción:</div>
                <textarea class="input-field" placeholder="Ingrese la descripción del subproceso"
                          name="componentes[${componenteId}][procesos][${procesoId}][subprocesos][${subprocesoCounter}][descripcion]" rows="2"
                          oninput="actualizarTitulo('subproceso-titulo-${subprocesoCounter}', this.value)"></textarea>

                <button type="button" class="btn-add" onclick="agregarObjetivo(${componenteId}, ${procesoId}, ${subprocesoCounter})">
                    + Agregar Objetivo Estratégico
                </button>

                <div class="nested-container" id="objetivos-container-${subprocesoCounter}">
                    <!-- Los objetivos se agregarán aquí -->
                </div>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', subprocesoHtml);
        }

        function agregarObjetivo(componenteId, procesoId, subprocesoId) {
            objetivoCounter++;
            const container = document.getElementById(`objetivos-container-${subprocesoId}`);

            const objetivoHtml = `
        <div class="objetivo-card" id="objetivo-${objetivoCounter}">
            <button type="button" class="btn-remove" onclick="eliminarElemento('objetivo-${objetivoCounter}')">Eliminar</button>
            <div class="section-title level-4">
                <span id="objetivo-titulo-${objetivoCounter}" data-default-text="Objetivo Estratégico ${objetivoCounter}">Objetivo Estratégico ${objetivoCounter}</span>
            </div>
            <div class="title-preview">Descripción:</div>
            <textarea class="input-field" placeholder="Ingrese la descripción del objetivo estratégico"
                      name="componentes[${componenteId}][procesos][${procesoId}][subprocesos][${subprocesoId}][objetivos][${objetivoCounter}][descripcion]" rows="2"
                      oninput="actualizarTitulo('objetivo-titulo-${objetivoCounter}', this.value)"></textarea>
            <div class="title-preview">Indicador de medición:</div>
            <input type="text" class="input-field" placeholder="Ingrese el indicador de medición"
                   name="componentes[${componenteId}][procesos][${procesoId}][subprocesos][${subprocesoId}][objetivos][${objetivoCounter}][indicador]">
        </div>
    `;

            container.insertAdjacentHTML('beforeend', objetivoHtml);
        }

        function eliminarElemento(elementId) {
            const elemento = document.getElementById(elementId);
            if (elemento && confirm('¿Estás seguro de que deseas eliminar este elemento y todos sus elementos hijos?')) {
                elemento.remove();
            }
        }

        function toggleCollapse(element) {
        }

        function guardarTodo() {
            // Aquí puedes implementar la lógica para enviar los datos al servidor
            const formData = new FormData();

            // Recopilar todos los inputs
            const inputs = document.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (input.name && input.value.trim() !== '') {
                    formData.append(input.name, input.value);
                }
            });

            // Ejemplo de envío con fetch
            /*
            fetch('/guardar-componentes', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                alert('Datos guardados exitosamente');
                console.log(data);
            })
            .catch(error => {
                alert('Error al guardar');
                console.error(error);
            });
            */

            // Por ahora, solo mostrar los datos en consola
            console.log('Datos para guardar:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            alert('Revisa la consola para ver los datos que se enviarían');
        }

        // Inicializar con un componente de ejemplo
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar un componente inicial como ejemplo
            // agregarComponente();
        });
    </script>
@endsection
