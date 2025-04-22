import { h } from 'preact';
import {useEffect, useState} from 'preact/hooks';

export default function Editar({  editarUrl = '#',
                                  gruposCalificaciones = [],
                                  csrfToken = '',
                                  autoevaluacion = {}
                        }) {

    const [activeTab, setActiveTab] = useState(0);
    const [notasSeleccionadas, setNotasSeleccionadas] = useState({});
    const [evidencias, setEvidencias] = useState({});

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
        console.log(autoevaluacion);
    }, [autoevaluacion]);

    return (
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Editar Autoevaluación</h2>
            </div>
            <form method="POST" action={editarUrl}>
                <input type="hidden" name="_token" value={csrfToken} />

                <div class="mb-4 d-flex row">
                    <label className="form-label" htmlFor="anio-vigencia">Año de Vigencia: {autoevaluacion?.anio_vigencia}</label>
                    <label className="form-label" htmlFor="estado">Estado: {autoevaluacion?.alias_estado}</label>
                </div>
                <div class="mb-4">
                    <ul class="nav nav-tabs border" id="gruposTabs" role="tablist">
                        {gruposCalificaciones.map((grupo, index) => (
                            <li class="nav-item" key={`tab-${grupo.id}`}>
                                <button
                                    className={`nav-link ${activeTab === index ? 'active' : ''}`}
                                    onClick={() => setActiveTab(index)}
                                    type="button"
                                    role="tab"
                                >
                                    <span>{grupo.indice} {grupo.nombre}</span>
                                    {grupo.hijos?.length > 0 && (
                                        <span class="badge bg-dark ms-2">
                                            Total: {calcularPromedioGrupo(grupo)}
                                    </span>
                                    )}
                                </button>
                            </li>
                        ))}
                    </ul>

                    <div class="border border-top-0 rounded-bottom p-3">
                        {gruposCalificaciones.map((grupo, index) => (
                            <div
                                key={`content-${grupo.id}`}
                                style={{display: activeTab === index ? 'block' : 'none'}}
                            >
                                {grupo.calificaciones?.length > 0 && (
                                    <>
                                        <h6 class="text-muted">Calificaciones</h6>
                                        <ul class="list-group mb-3">
                                            {grupo.calificaciones.map((calificacion) => (
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center"
                                                    key={calificacion.id}
                                                >
                                                    {calificacion.nombre}
                                                    <span class="badge bg-secondary">
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
                                            <div class="mb-4 p-3 border rounded" key={hijo.id}>
                                                <div class="fw-bold mb-2">{hijo.indice} {hijo.nombre}</div>
                                                {hijo.calificaciones?.length > 0 ? (
                                                    <>
                                                        <ul class="list-group">
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
                                                                            <div className="col-12 col-md-3 d-flex justify-content-center align-items-center" >
                                                                                <div className="d-flex flex-row gap-2 align-items-center justify-content-center">
                                                                                    {cal.notas_calificacion
                                                                                        .sort((a, b) => a.valor - b.valor)
                                                                                        .map(nota => (
                                                                                            <div
                                                                                                key={nota.id}
                                                                                                className={`badge ${getColorClass(nota.valor)} text-white ${notaSeleccionada?.id === nota.id ? 'border border-2 border-dark' : ''}`}
                                                                                                style={{ cursor: 'pointer' }}
                                                                                                onClick={() => handleNotaClick(cal.id, nota)}
                                                                                            >
                                                                                                {nota.valor}
                                                                                            </div>
                                                                                        ))}
                                                                                </div>
                                                                            </div>


                                                                            {/* Categoría y valor */}
                                                                            <div className="col-12 col-md-3 d-flex justify-content-center align-items-center text-center" >
                                                                                {notaSeleccionada ? (
                                                                                    <>
                                                                                        <span className={`badge ${getColorClass(notaSeleccionada.valor)} text-white me-2`}>
                                                                                            {notaSeleccionada.valor}
                                                                                        </span>
                                                                                        <div>
                                                                                            <small className="text-muted">Categoría:</small> {getCategoria(notaSeleccionada.valor)}
                                                                                        </div>
                                                                                    </>
                                                                                ) : (
                                                                                    <div className="text-muted">No seleccionado</div>
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
                                                                                    onInput={(e) => handleEvidenciaChange(cal.id, e)}
                                                                                ></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                );
                                                            })}
                                                        </ul>

                                                        {/* Total proceso siempre visible */}
                                                        <div class="mt-3 p-3 bg-light rounded border">
                                                            <strong>Total proceso:</strong>{' '}
                                                            <span class="badge bg-dark">
                                                                {calcularPromedio(hijo)}
                                                            </span>
                                                        </div>
                                                    </>
                                                ) : (
                                                    <small class="text-muted">Sin calificaciones</small>
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


                <button type="submit" className="btn btn-primary mt-4">
                    Guardar Autoevaluación
                </button>
            </form>
        </div>
    );
}
