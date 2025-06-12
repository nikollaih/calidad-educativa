@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Desarrollo Educativo - Editable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        .excel-table {
            min-width: 1200px;
            font-size: 0.9rem;
        }
        .excel-table th {
            background-color: #2c3e50;
            color: white;
            position: sticky;
            top: 0;
            text-align: center;
            vertical-align: middle;
            padding: 10px 5px;
        }
        .excel-table td {
            padding: 8px 5px;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }
        .excel-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .excel-table tr:hover {
            background-color: #e9ecef;
        }
        .editable-cell {
            min-height: 40px;
            padding: 5px !important;
        }
        .editable-cell:focus {
            outline: 2px solid #3498db;
            background-color: #fff;
        }
        .header {
            background-color: #3498db;
            color: white;
            padding: 15px 0;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .btn-add-row {
            margin-bottom: 15px;
        }
        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="header text-center">
            <h2>PLAN DE DESARROLLO - ACOMPAÑAMIENTO EDUCATIVO</h2>
        </div>
        
        <button id="addRowBtn" class="btn btn-primary btn-add-row">
            <i class="bi bi-plus-circle"></i> Agregar Nueva Fila
        </button>
        
        <div class="table-container">
            <table id="editableTable" class="excel-table table-bordered">
                <thead>
                    <tr>
                        <th width="10%">COMPONENTE</th>
                        <th width="10%">PROCESO</th>
                        <th width="10%">SUBPROCESO</th>
                        <th width="10%">META DEL PLAN DE DESARROLLO</th>
                        <th width="12%">OBJETIVO ESTRATÉGICO</th>
                        <th width="10%">META</th>
                        <th width="8%">INDICADOR</th>
                        <th width="8%">ACCIÓN</th>
                        <th width="8%">RESPONSABLE</th>
                        <th width="6%">RECURSOS (MILLONES)</th>
                        <th width="5%">FECHA INICIO</th>
                        <th width="5%">FECHA TERMINACIÓN</th>
                        <th width="3%">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fila 1 -->
                    <tr>
                        <td class="editable-cell" contenteditable="true">ACOMPAÑAMIENTO A ESTABLECIMIENTOS EDUCATIVOS</td>
                        <td class="editable-cell" contenteditable="true">GARANTIZAR EL MEJORAMIENTO CONTINUO DE LOS ESTABLECIMIENTOS EDUCATIVOS</td>
                        <td class="editable-cell" contenteditable="true">APOYAR LA GESTIÓN DEL PROYECTO EDUCATIVO</td>
                        <td class="editable-cell" contenteditable="true">Servicio de asistencia técnica en educación inicial, preescolar, básica y media</td>
                        <td class="editable-cell" contenteditable="true">Acompañamiento tecnico-pedagógico a las 54 instituciones educativas en los programas y proyectos enmarcados en la ruta de mejoramiento continuo para el fortalecimiento de la calidad en la prestación del servicio educativo</td>
                        <td class="editable-cell" contenteditable="true">Al finalizar el año lectivo 2021, el 100% de las instituciones educativas son asistidas técnicamente para la re-significación del Proyecto educativo institucional generadas por la implementación de las modalidades de educación en casa y alternancia educativa.</td>
                        <td class="editable-cell" contenteditable="true">Número de instituciones educativas asistidas tecnicamente en la re-significación del Proyecto educativo institucional durante la emergencia / Número de instituciones educativas, programadas para asistencia tecnica en re-significacion del proyecto educativo institucional durante la emergencia</td>
                        <td class="editable-cell" contenteditable="true">1. Asistencia técnica a las 54 instituciones educativas en la elaboración y socialización de los lineamientos pedagógicos de la flexibilización curricular en las modalidades de educación en casa y alternancia del servicio educativo 2. Recolectar, consolidar y validar los actos administrativos institucionales</td>
                        <td class="editable-cell" contenteditable="true">MARIA VICTORIA FERNANDEZ GARZÓN, MARÍA AMPARO LONDOÑO GUTIERREZ</td>
                        <td class="editable-cell" contenteditable="true">test recurso</td>
                        <td class="editable-cell" contenteditable="true">feb-21</td>
                        <td class="editable-cell" contenteditable="true">dic-21</td>
                        <td class="action-buttons">
                            <button class="btn btn-sm btn-danger delete-row">🗑️</button>
                        </td>
                    </tr>
                    
                    <!-- Fila 2 -->
                    <tr>
                        <td class="editable-cell" contenteditable="true">ACOMPAÑAMIENTO A ESTABLECIMIENTOS EDUCATIVOS</td>
                        <td class="editable-cell" contenteditable="true">D01. GESTIÓN DE LA EVALUACIÓN EDUCATIVA</td>
                        <td class="editable-cell" contenteditable="true">D01.03 ORIENTAR LA RUTA DE MEJORAMIENTO INSTITUCIONAL</td>
                        <td class="editable-cell" contenteditable="true">Servicio de asistencia técnica en educación inicial, preescolar, básica y media</td>
                        <td class="editable-cell" contenteditable="true">Acompañamiento tecnico-pedagógico a las 54 instituciones educativas en los programas y proyectos enmarcados en la ruta de mejoramiento continuo para el fortalecimiento de la calidad en la prestación del servicio educativo</td>
                        <td class="editable-cell" contenteditable="true">Al finalizar el año 2021 el 100% de las instituciones educativas serán acompañadas en los procesos de flexibilidad curricular, y ajustes al Sistema de Evaluación Institucional para el trabajo en casa y la implementación de la alternancia.</td>
                        <td class="editable-cell" contenteditable="true">Número de instituciones educativas acompañadas en los procesos de flexibilidad curricular y ajustes al Sistema de Evaluación Institucional / Número de instituciones educativas, programadas para el acompañamiento en los procesos de flexibilidad curricular, y ajustes al Sistema de Evaluación Institucional</td>
                        <td class="editable-cell" contenteditable="true">1. Socialización de documentos de lineamientos curriculares y de evaluación. 2. Acompañamiento a las instituciones educativas en la revisión, análisis y ajustes curriculares y del sistema institucional de evaluación de estudiantes. 3. Mecanismos de seguimiento y retroalimentación en los procesos curriculares y de evaluación. 4. Análisis y consolidación de la autoevaluación institucional. 5. Retroalimentación de la autoevaluación institucional 6. Seguimiento, evaluación y retroalimentación de los planes de mejoramiento institucional</td>
                        <td class="editable-cell" contenteditable="true">MARIA AMPARO LONDOÑO GUTIERREZ y DIRECTORAS DE NUCLEO</td>
                        <td class="editable-cell" contenteditable="true">test recurso</td>
                        <td class="editable-cell" contenteditable="true">feb-21</td>
                        <td class="editable-cell" contenteditable="true">dic-21</td>
                        <td class="action-buttons">
                            <button class="btn btn-sm btn-danger delete-row">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3 text-end">
            <button id="saveBtn" class="btn btn-success">
                <i class="bi bi-save"></i> Guardar Cambios
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar nueva fila
            document.getElementById('addRowBtn').addEventListener('click', function() {
                const tbody = document.querySelector('#editableTable tbody');
                const newRow = document.createElement('tr');
                
                // Crear celdas editables vacías
                for (let i = 0; i < 12; i++) {
                    const td = document.createElement('td');
                    td.className = 'editable-cell';
                    td.contentEditable = 'true';
                    newRow.appendChild(td);
                }
                
                // Agregar botón de eliminar
                const actionTd = document.createElement('td');
                actionTd.className = 'action-buttons';
                actionTd.innerHTML = '<button class="btn btn-sm btn-danger delete-row">🗑️</button>';
                newRow.appendChild(actionTd);
                
                tbody.appendChild(newRow);
            });
            
            // Eliminar fila
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-row')) {
                    if (confirm('¿Estás seguro de eliminar esta fila?')) {
                        e.target.closest('tr').remove();
                    }
                }
            });
            
            // Guardar cambios (simulado)
            document.getElementById('saveBtn').addEventListener('click', function() {
                const tableData = [];
                const rows = document.querySelectorAll('#editableTable tbody tr');
                
                rows.forEach(row => {
                    const rowData = {};
                    const cells = row.querySelectorAll('td');
                    
                    // Solo procesamos celdas editables (excluyendo la columna de acciones)
                    for (let i = 0; i < cells.length - 1; i++) {
                        const header = document.querySelector(`#editableTable thead th:nth-child(${i+1})`).textContent;
                        rowData[header] = cells[i].textContent;
                    }
                    
                    tableData.push(rowData);
                });
                
                // Aquí normalmente enviarías los datos al servidor
                console.log('Datos a guardar:', tableData);
                alert('Cambios guardados (consola para ver los datos)');
            });
        });
    </script>
</body>
</html>
@endsection
