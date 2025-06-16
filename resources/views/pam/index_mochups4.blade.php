@extends('layouts.app')

@section('custom_css')
    <style>
        /* Estilos para tabs */
        .tabs-container {
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .tabs {
            display: flex;
            gap: 0;
        }

        .tab {
            padding: 12px 24px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-bottom: none;
            cursor: pointer;
            font-weight: 500;
            color: #6b7280;
            transition: all 0.2s;
            border-radius: 8px 8px 0 0;
            margin-right: 2px;
        }

        .tab:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .tab.active {
            background: white;
            color: #1f2937;
            border-color: #d1d5db;
            font-weight: 600;
            border-bottom: 2px solid white;
            margin-bottom: -2px;
        }

        .tab-content {
            display: none;
            padding: 20px 0;
        }

        .tab-content.active {
            display: block;
        }

        /* Estilos estilo Asana */
        .asana-container {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .factor-item {
            background: white;
            border: 1px solid #e1e4e9;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }

        .factor-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-color: #d1d9e0;
        }

        .factor-header {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            user-select: none;
            border-radius: 8px;
        }

        .factor-header:hover {
            background: #f8f9fa;
        }

        .expand-icon {
            width: 16px;
            height: 16px;
            margin-right: 12px;
            transition: transform 0.2s ease;
            color: #9ca3af;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .expand-icon.expanded {
            transform: rotate(90deg);
        }

        .factor-content {
            flex: 1;
            min-width: 0;
        }

        .factor-title {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .factor-description {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.4;
        }

        .factor-actions {
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .factor-item:hover .factor-actions {
            opacity: 1;
        }

        .btn-asana {
            background: #f4f5f7;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            color: #5e6c84;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-asana:hover {
            background: #e4e6ea;
            color: #42526e;
        }

        .btn-add {
            background: #0052cc;
            color: white;
            border: none;
        }

        .btn-add:hover {
            background: #0065ff;
        }

        .btn-remove {
            background: #de350b;
            color: white;
            border: none;
        }

        .btn-remove:hover {
            background: #ff5630;
        }

        /* Contenido expandible */
        .expandable-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: #fafbfc;
        }

        .expandable-content.expanded {
            max-height: 2000px;
            border-top: 1px solid #e1e4e9;
        }

        .nested-content {
            padding: 16px;
            padding-left: 44px;
        }

        /* Niveles anidados */
        .objetivo-item {
            background: #f0f8ff;
            border: 1px solid #b3d9ff;
            margin-bottom: 8px;
            border-radius: 6px;
        }

        .indicador-item {
            background: #f0fff4;
            border: 1px solid #b3ffb3;
            margin-bottom: 6px;
            border-radius: 4px;
        }

        .actividad-item {
            background: #fffef0;
            border: 1px solid #ffe066;
            margin-bottom: 4px;
            border-radius: 4px;
        }

        .input-asana {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 13px;
            margin: 8px 0;
            transition: border-color 0.2s;
        }

        .input-asana:focus {
            outline: none;
            border-color: #0052cc;
            box-shadow: 0 0 0 2px rgba(0, 82, 204, 0.2);
        }

        .textarea-asana {
            resize: vertical;
            min-height: 60px;
            font-family: inherit;
        }

        .add-button-container {
            margin: 16px 0;
            padding-left: 28px;
        }

        .main-add-btn {
            background: #0052cc;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .main-add-btn:hover {
            background: #0065ff;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg p-6 asana-container">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Factores Críticos</h1>

            <!-- Tabs -->
            <div class="tabs-container">
                <div class="tabs">
                    <div class="tab active" onclick="cambiarTab('directiva')">Gestión Directiva</div>
                    <div class="tab" onclick="cambiarTab('academica')">Gestión Académica</div>
                    <div class="tab" onclick="cambiarTab('administrativa')">Gestión Administrativa y Financiera</div>
                    <div class="tab" onclick="cambiarTab('comunidad')">Gestión de la Comunidad</div>
                </div>
            </div>

            <!-- Contenido de tabs -->
            <div id="tab-directiva" class="tab-content active">
                <div class="add-button-container">
                    <button class="main-add-btn" onclick="agregarFactor('directiva')">+ Agregar Factor Crítico</button>
                </div>
                <div id="factores-directiva" class="factores-container"></div>
            </div>

            <div id="tab-academica" class="tab-content">
                <div class="add-button-container">
                    <button class="main-add-btn" onclick="agregarFactor('academica')">+ Agregar Factor Crítico</button>
                </div>
                <div id="factores-academica" class="factores-container"></div>
            </div>

            <div id="tab-administrativa" class="tab-content">
                <div class="add-button-container">
                    <button class="main-add-btn" onclick="agregarFactor('administrativa')">+ Agregar Factor Crítico</button>
                </div>
                <div id="factores-administrativa" class="factores-container"></div>
            </div>

            <div id="tab-comunidad" class="tab-content">
                <div class="add-button-container">
                    <button class="main-add-btn" onclick="agregarFactor('comunidad')">+ Agregar Factor Crítico</button>
                </div>
                <div id="factores-comunidad" class="factores-container"></div>
            </div>

            <!-- Botón para guardar -->
            <div class="mt-8 pt-4 border-t">
                <button type="button" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold" onclick="guardarTodo()">
                    Guardar Toda la Estructura
                </button>
            </div>
        </div>
    </div>

    <script>
        let contadores = {
            factor: 0,
            objetivo: 0,
            indicador: 0,
            actividad: 0
        };

        function cambiarTab(tabName) {
            // Ocultar todos los tabs
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Mostrar tab seleccionado
            document.getElementById(`tab-${tabName}`).classList.add('active');
            event.target.classList.add('active');
        }

        function agregarFactor(gestion) {
            contadores.factor++;
            const container = document.getElementById(`factores-${gestion}`);

            const factorHtml = `
        <div class="factor-item" id="factor-${contadores.factor}">
            <div class="factor-header" onclick="toggleExpand('factor-${contadores.factor}')">
                <div class="expand-icon">▶</div>
                <div class="factor-content">
                    <textarea class="input-asana factor-description" placeholder="Descripción del factor crítico" name="gestiones[${gestion}][factores][${contadores.factor}][descripcion]" style="border: none; background: transparent; resize: none; height: auto; padding: 0; font-size: 13px; color: #6b7280; line-height: 1.4;" onclick="event.stopPropagation()"></textarea>
                </div>
                <div class="factor-actions">
                    <button class="btn-asana btn-add" onclick="event.stopPropagation(); agregarObjetivo('${gestion}', ${contadores.factor})">+ Objetivo</button>
                    <button class="btn-asana btn-remove" onclick="event.stopPropagation(); eliminarElemento('factor-${contadores.factor}')">Eliminar</button>
                </div>
            </div>
            <div class="expandable-content" id="content-factor-${contadores.factor}">
                <div class="nested-content">
                    <div id="objetivos-${contadores.factor}"></div>
                </div>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', factorHtml);
        }

        function agregarObjetivo(gestion, factorId) {
            contadores.objetivo++;
            const container = document.getElementById(`objetivos-${factorId}`);

            const objetivoHtml = `
        <div class="objetivo-item factor-item" id="objetivo-${contadores.objetivo}">
            <div class="factor-header" onclick="toggleExpand('objetivo-${contadores.objetivo}')">
                <div class="expand-icon">▶</div>
                <div class="factor-content">
                    <textarea class="input-asana factor-description" placeholder="Descripción del objetivo" name="gestiones[${gestion}][factores][${factorId}][objetivo][descripcion]" style="border: none; background: transparent; resize: none; height: auto; padding: 0; font-size: 13px; color: #6b7280; line-height: 1.4;" onclick="event.stopPropagation()"></textarea>
                </div>
                <div class="factor-actions">
                    <button class="btn-asana btn-add" onclick="event.stopPropagation(); agregarIndicador('${gestion}', ${factorId}, ${contadores.objetivo})">+ Indicador</button>
                    <button class="btn-asana btn-remove" onclick="event.stopPropagation(); eliminarElemento('objetivo-${contadores.objetivo}')">Eliminar</button>
                </div>
            </div>
            <div class="expandable-content" id="content-objetivo-${contadores.objetivo}">
                <div class="nested-content">
                    <div id="indicadores-${contadores.objetivo}"></div>
                </div>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', objetivoHtml);
        }

        function agregarIndicador(gestion, factorId, objetivoId) {
            contadores.indicador++;
            const container = document.getElementById(`indicadores-${objetivoId}`);

            const indicadorHtml = `
        <div class="indicador-item factor-item" id="indicador-${contadores.indicador}">
            <div class="factor-header" onclick="toggleExpand('indicador-${contadores.indicador}')">
                <div class="expand-icon">▶</div>
                <div class="factor-content">
                    <textarea class="input-asana factor-description" placeholder="Descripción del indicador" name="gestiones[${gestion}][factores][${factorId}][objetivo][indicadores][${contadores.indicador}][descripcion]" style="border: none; background: transparent; resize: none; height: auto; padding: 0; font-size: 13px; color: #6b7280; line-height: 1.4;" onclick="event.stopPropagation()"></textarea>
                </div>
                <div class="factor-actions">
                    <button class="btn-asana btn-add" onclick="event.stopPropagation(); agregarActividad('${gestion}', ${factorId}, ${objetivoId}, ${contadores.indicador})">+ Actividad</button>
                    <button class="btn-asana btn-remove" onclick="event.stopPropagation(); eliminarElemento('indicador-${contadores.indicador}')">Eliminar</button>
                </div>
            </div>
            <div class="expandable-content" id="content-indicador-${contadores.indicador}">
                <div class="nested-content">
                    <input type="text" class="input-asana" placeholder="Métrica o unidad de medida" name="gestiones[${gestion}][factores][${factorId}][objetivo][indicadores][${contadores.indicador}][metrica]">
                    <div id="actividades-${contadores.indicador}"></div>
                </div>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', indicadorHtml);
        }

        function agregarActividad(gestion, factorId, objetivoId, indicadorId) {
            contadores.actividad++;
            const container = document.getElementById(`actividades-${indicadorId}`);

            const actividadHtml = `
        <div class="actividad-item factor-item" id="actividad-${contadores.actividad}">
            <div class="factor-header">
                <div class="expand-icon">•</div>
                <div class="factor-content">
                    <textarea class="input-asana factor-description" placeholder="Descripción de la actividad" name="gestiones[${gestion}][factores][${factorId}][objetivo][indicadores][${indicadorId}][actividades][${contadores.actividad}][descripcion]" style="border: none; background: transparent; resize: none; height: auto; padding: 0; font-size: 13px; color: #6b7280; line-height: 1.4;" onclick="event.stopPropagation()"></textarea>
                </div>
                <div class="factor-actions">
                    <button class="btn-asana btn-remove" onclick="eliminarElemento('actividad-${contadores.actividad}')">Eliminar</button>
                </div>
            </div>
            <div class="nested-content">
                <input type="text" class="input-asana" placeholder="Responsable" name="gestiones[${gestion}][factores][${factorId}][objetivo][indicadores][${indicadorId}][actividades][${contadores.actividad}][responsable]">
                <input type="date" class="input-asana" name="gestiones[${gestion}][factores][${factorId}][objetivo][indicadores][${indicadorId}][actividades][${contadores.actividad}][fecha_limite]">
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', actividadHtml);
        }

        function toggleExpand(elementId) {
            const element = document.getElementById(elementId);
            const content = document.getElementById(`content-${elementId}`);
            const icon = element.querySelector('.expand-icon');

            if (content.classList.contains('expanded')) {
                content.classList.remove('expanded');
                icon.classList.remove('expanded');
            } else {
                content.classList.add('expanded');
                icon.classList.add('expanded');
            }
        }

        function eliminarElemento(elementId) {
            if (confirm('¿Estás seguro de que deseas eliminar este elemento y todos sus elementos hijos?')) {
                document.getElementById(elementId).remove();
            }
        }

        function guardarTodo() {
            const formData = new FormData();

            // Recopilar todos los inputs y textareas
            const inputs = document.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (input.name && input.value.trim() !== '') {
                    formData.append(input.name, input.value);
                }
            });

            // Mostrar datos en consola (para desarrollo)
            console.log('Datos para guardar:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            alert('Revisa la consola para ver los datos que se enviarían al servidor');

            // Implementar envío real aquí
            /*
            fetch('/guardar-factores', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                alert('Datos guardados exitosamente');
            })
            .catch(error => {
                alert('Error al guardar');
                console.error(error);
            });
            */
        }
    </script>
@endsection
