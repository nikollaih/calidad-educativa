import { h } from 'preact';
import { useEffect, useRef, useState } from 'preact/hooks';
import Chart from 'chart.js/auto';

export default function Editar({  gruposCalificaciones = [],
                                  autoevaluacion = {},
                                   statistics = []
                               }) {

    const [activeTab, setActiveTab] = useState(0);
    const [activeStatisticTab, setActiveStatisticTab] = useState(0);

    const [notasSeleccionadas, setNotasSeleccionadas] = useState({});
    const [evidencias, setEvidencias] = useState({});
    const chartRef = useRef(null);
    const chartInstance = useRef(null);

    // Función para crear o actualizar el gráfico
    // Función para crear o actualizar el gráfico
    const updateChart = (statisticData) => {
        if (!statisticData) return;

        const ctx = chartRef.current.getContext('2d');

        // Preparar datos para el gráfico
        const labels = statisticData.sub_grupos.map(sub => sub.nombre);
        const data = statisticData.sub_grupos.map(sub => sub.promedio);

        // Colores basados en el valor (0-4)
        const backgroundColors = data.map(val => {
            if (val >= 4) return 'rgba(40, 167, 69, 0.7)'; // Verde para 4
            if (val >= 3) return 'rgba(23, 162, 184, 0.7)'; // Azul para 3-3.99
            if (val >= 2) return 'rgba(255, 193, 7, 0.7)'; // Amarillo para 2-2.99
            return 'rgba(220, 53, 69, 0.7)'; // Rojo para 0-1.99
        });

        // Destruir el gráfico anterior si existe
        if (chartInstance.current) {
            chartInstance.current.destroy();
        }

        // Crear nuevo gráfico
        chartInstance.current = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: `${statisticData.nombre} - Promedio de ${statisticData.promedio}`,
                    data: data,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors.map(color => color.replace('0.7', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 4,
                        ticks: {
                            stepSize: 0.5
                        },
                        grid: {
                            color: function(context) {
                                // Líneas horizontales más destacadas para valores enteros
                                if (context.tick.value === 1 ||
                                    context.tick.value === 2 ||
                                    context.tick.value === 3 ||
                                    context.tick.value === 4) {
                                    return 'rgba(0, 0, 0, 0.5)'; // Líneas más oscuras para valores clave
                                }
                                return 'rgba(0, 0, 0, 0.1)'; // Líneas normales para otros valores
                            },
                            lineWidth: function(context) {
                                // Líneas más gruesas para valores enteros
                                if (context.tick.value === 1 ||
                                    context.tick.value === 2 ||
                                    context.tick.value === 3 ||
                                    context.tick.value === 4) {
                                    return 2;
                                }
                                return 1;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false // Eliminar líneas verticales
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const promedio = context.raw.toFixed(2);
                                let leyenda = '';
                                if (context.raw >= 4) {
                                    leyenda = 'Mejoramiento';
                                } else if (context.raw >= 3) {
                                    leyenda = 'Apropiación';
                                } else if (context.raw >= 2) {
                                    leyenda = 'Pertinencia';
                                } else {
                                    leyenda = 'Existencia';
                                }
                                return `Promedio: ${promedio} - ${leyenda}`;
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            generateLabels: function(chart) {
                                const dataset = chart.data.datasets[0];
                                return [{
                                    text: dataset.label,
                                    fillStyle: dataset.backgroundColor[0],
                                    strokeStyle: dataset.borderColor[0],
                                    lineWidth: 1,
                                    hidden: false,
                                    index: 0
                                }];
                            }
                        }
                    },
                }
            }
        });
    };
    // Efecto para actualizar el gráfico cuando cambia la pestaña activa
    useEffect(() => {
        if (statistics.length > 0 && chartRef.current) {
            updateChart(statistics[activeStatisticTab]);
        }
    }, [activeStatisticTab, statistics]);
    const getColorClass = (valor) => {
        switch (valor) {
            case 1: return 'bg-danger';
            case 2: return 'bg-warning';
            case 3: return 'bg-primary';
            case 4: return 'bg-success';
            default: return 'bg-secondary';
        }
    };

    const getCategoria = (valor) => {
        switch (valor) {
            case 1: return 'Existencia';
            case 2: return 'Pertinencia';
            case 3: return 'Apropiación';
            case 4: return 'Mejoramiento';
            default: return 'Null';
        }
    };

    const handleNotaClick = (calId, nota) => {
        setNotasSeleccionadas(prev => {
            const notaActual = prev[calId];
            if (notaActual?.id === nota.id) {
                const newNotas = { ...prev };
                delete newNotas[calId];
                return newNotas;
            }
            return {
                ...prev,
                [calId]: nota
            };
        });
    };

    const handleEvidenciaChange = (calId, e) => {
        setEvidencias(prev => ({
            ...prev,
            [calId]: e
        }));
    };

    const calcularPromedio = (hijo) => {
        if (!hijo.calificaciones?.length) return null;

        const total = hijo.calificaciones.reduce((acc, cal) => {
            const nota = notasSeleccionadas[cal.id]?.valor || 0;
            return acc + nota;
        }, 0);

        const promedio = total / hijo.calificaciones.length;
        return promedio.toFixed(2);
    };
    const calcularPromedioGrupo = (grupo) => {
        if (!grupo.hijos?.length) return null;

        const promedios = grupo.hijos.map(hijo => {
            if (!hijo.calificaciones?.length) return null;

            const total = hijo.calificaciones.reduce((acc, cal) => {
                const nota = notasSeleccionadas[cal.id]?.valor || 0;
                return acc + nota;
            }, 0);
            return total / hijo.calificaciones.length;
        }).filter(p => p !== null);

        if (!promedios.length) return null;

        const totalPromedios = promedios.reduce((acc, val) => acc + val, 0);
        return (totalPromedios / promedios.length).toFixed(2);
    };

    useEffect(() => {
        if (autoevaluacion?.notas?.length) {
            autoevaluacion.notas.forEach(nota => {
                handleNotaClick(nota?.calificacion?.id,nota);
                handleEvidenciaChange(nota?.calificacion?.id, nota?.pivot?.evidencia);
            });
        }
        console.log(statistics);
    }, [autoevaluacion]);

    return (
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Ver Autoevaluación</h2>
            </div>
            <form>

                <div className="mb-4 d-flex row">
                    <label className="form-label" htmlFor="anio-vigencia">Año de
                        Vigencia: {autoevaluacion?.anio_vigencia}</label>
                    <label className="form-label" htmlFor="estado">Estado: {autoevaluacion?.alias_estado}</label>
                </div>
                <div className="mb-4">

                    <ul className="nav nav-tabs border" id="statisticTabs" role="tablist">
                        {statistics.map((statistic, index) => (
                            <li className="nav-item" key={`tab-${statistic.indice}`}>
                                <button
                                    className={`nav-link ${activeStatisticTab === index ? 'active' : ''}`}
                                    onClick={() => setActiveStatisticTab(index)}
                                    type="button"
                                    role="tab"
                                >
                                    <span>{statistic.nombre} - Promedio de la gestión {statistic.promedio}</span>
                                </button>
                            </li>
                        ))}
                    </ul>


                    <div className="border border-top-0 rounded-bottom p-3">
                        {/* Aquí está el Canvas del Chart */}
                        <div style={{ height: '400px' }}>
                            <canvas ref={chartRef} id="acquisitions"></canvas>
                        </div>
                    </div>
                </div>


                <div className="mb-4">
                    <ul className="nav nav-tabs border" id="gruposTabs" role="tablist">
                        {gruposCalificaciones.map((grupo, index) => (
                            <li className="nav-item" key={`tab-${grupo.id}`}>
                                <button
                                    className={`nav-link ${activeTab === index ? 'active' : ''}`}
                                    onClick={() => setActiveTab(index)}
                                    type="button"
                                    role="tab"
                                >
                                    <span>{grupo.indice} {grupo.nombre}</span>
                                    {grupo.hijos?.length > 0 && (
                                        <span className="badge bg-dark ms-2">
                                            Total: {calcularPromedioGrupo(grupo)}
                                    </span>
                                    )}
                                </button>
                            </li>
                        ))}
                    </ul>

                    <div className="border border-top-0 rounded-bottom p-3">
                        {gruposCalificaciones.map((grupo, index) => (
                            <div
                                key={`content-${grupo.id}`}
                                style={{display: activeTab === index ? 'block' : 'none'}}
                            >
                                {grupo.calificaciones?.length > 0 && (
                                    <>
                                        <h6 className="text-muted">Calificaciones</h6>
                                        <ul className="list-group mb-3">
                                            {grupo.calificaciones.map((calificacion) => (
                                                <li
                                                    className="list-group-item d-flex justify-content-between align-items-center"
                                                    key={calificacion.id}
                                                >
                                                    {calificacion.nombre}
                                                    <span className="badge bg-secondary">
                                                        {calificacion.valor ?? 'N/A'}
                                                    </span>
                                                </li>
                                            ))}
                                        </ul>
                                    </>
                                )}

                                {grupo.hijos?.length > 0 && (
                                    <div>
                                        {grupo.hijos.map((hijo) => (
                                            <div className="mb-4 p-3 border rounded" key={hijo.id}>
                                                <div className="fw-bold mb-2">{hijo.indice} {hijo.nombre}</div>
                                                {hijo.calificaciones?.length > 0 ? (
                                                    <>
                                                        <ul className="list-group">
                                                            {hijo.calificaciones.map((cal) => {
                                                                const notaSeleccionada = notasSeleccionadas[cal.id];
                                                                return (
                                                                    <li className="list-group-item">
                                                                        <div className="row g-3">
                                                                            {/* Nombre de calificación */}
                                                                            <div className="col-12 col-md-3">
                                                                                <strong>{cal.indice}</strong>
                                                                                <div>{cal.nombre}</div>
                                                                            </div>

                                                                            {/* Notas seleccionables */}
                                                                            <div
                                                                                className="col-12 col-md-3 d-flex justify-content-center align-items-center">
                                                                                <div
                                                                                    className="d-flex flex-row gap-2 align-items-center justify-content-center">
                                                                                    {cal.notas_calificacion
                                                                                        .sort((a, b) => a.valor - b.valor)
                                                                                        .map(nota => (
                                                                                            <div
                                                                                                key={nota.id}
                                                                                                className={`badge ${getColorClass(nota.valor)} text-white ${notaSeleccionada?.id === nota.id ? 'border border-2 border-dark' : ''}`}
                                                                                                style={{cursor: 'pointer'}}
                                                                                            >
                                                                                                {nota.valor}
                                                                                            </div>
                                                                                        ))}
                                                                                </div>
                                                                            </div>


                                                                            {/* Categoría y valor */}
                                                                            <div
                                                                                className="col-12 col-md-3 d-flex justify-content-center align-items-center text-center">
                                                                                {notaSeleccionada ? (
                                                                                    <>
                                                                                        <span
                                                                                            className={`badge ${getColorClass(notaSeleccionada.valor)} text-white me-2`}>
                                                                                            {notaSeleccionada.valor}
                                                                                        </span>
                                                                                        <div>
                                                                                            <small
                                                                                                className="text-muted">Categoría:</small> {getCategoria(notaSeleccionada.valor)}
                                                                                        </div>
                                                                                    </>
                                                                                ) : (
                                                                                    <div className="text-muted">No
                                                                                        seleccionado</div>
                                                                                )}
                                                                            </div>


                                                                            {/* Evidencia */}
                                                                            <div className="col-12 col-md-3">
                                                                                <label htmlFor={`evidencia-${cal.id}`}
                                                                                       className="form-label">Evidencia</label>
                                                                                <textarea
                                                                                    id={`evidencia-${cal.id}`}
                                                                                    className="form-control"
                                                                                    rows="1"
                                                                                    maxLength="400"
                                                                                    value={evidencias[cal.id] || ''}
                                                                                    disabled
                                                                                ></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                );
                                                            })}
                                                        </ul>

                                                        {/* Total proceso siempre visible */}
                                                        <div className="mt-3 p-3 bg-light rounded border">
                                                            <strong>Total proceso:</strong>{' '}
                                                            <span className="badge bg-dark">
                                                                {calcularPromedio(hijo)}
                                                            </span>
                                                        </div>
                                                    </>
                                                ) : (
                                                    <small className="text-muted">Sin calificaciones</small>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>
                </div>
                {Object.entries(notasSeleccionadas).map(([calId, nota], index) => (
                    <div key={`nota-hidden-${calId}`}>
                        <input
                            type="hidden"
                            name={`notas[${index}][nota_calificacion_id]`}
                            value={nota.id}
                        />
                        <input
                            type="hidden"
                            name={`notas[${index}][evidencia]`}
                            value={evidencias[calId] || ''}
                        />
                    </div>
                ))}
            </form>
        </div>
    );
}
