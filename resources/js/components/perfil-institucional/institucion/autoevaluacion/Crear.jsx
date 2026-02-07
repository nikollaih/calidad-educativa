import { h } from 'preact';
import {useEffect, useState} from 'preact/hooks';
import { addLineBreaks } from '@utils/string.js';

export default function Crear({  agregarUrl = '#',
                                 institutionId = '#',
                                 gruposCalificaciones = [],
                                 csrfToken = '',
                                 aniosDisabled = []}) {

    const [activeTab, setActiveTab] = useState(0);
    const [notasSeleccionadas, setNotasSeleccionadas] = useState({});
    const [evidencias, setEvidencias] = useState({});
    const [aniosDisponibles, setAniosDisponibles] = useState([]);
    const anioPorDefecto = aniosDisponibles[Math.floor(aniosDisponibles.length / 2)];
    const [anioVigencia, setAnioVigencia] = useState(new Date().getFullYear()); // Estado para el año de vigencia

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
    const getAnios = () => {
        const currentYear = new Date().getFullYear();
        const anos = [];
        for (let i = currentYear - 5; i <= currentYear ; i++) {
            if (!aniosDisabled.includes(i)) {
                anos.push(i);
            }
        }
        return anos;
    };

    const handleEvidenciaChange = (calId, e) => {
        setEvidencias(prev => ({
            ...prev,
            [calId]: e.target.value
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
        setAniosDisponibles(getAnios);
        setAnioVigencia(aniosDisponibles[Math.floor(aniosDisponibles.length / 2)]);
    }, []);
    return (
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Agregar autoevaluación</h2>
            </div>
            <form method="POST" action={agregarUrl}>
                <input type="hidden" name="_token" value={csrfToken} />
                <input type="hidden" name="autoevaluacion[institucion_id]" value={institutionId} />

                <div class="mb-4">
                    <label className="block text-sm mb-2 ml-4" htmlFor="anio-vigencia">Año de Vigencia</label>
                    <select
                        id="anio-vigencia"
                        class="form-select"
                        name="autoevaluacion[anio_vigencia]"
                        value={anioVigencia}
                        onChange={(e) => setAnioVigencia(e.target.value)}
                    >
                        {aniosDisponibles.map((anio) => (
                            <option key={anio} value={anio}>
                                {anio}
                            </option>
                        ))}
                    </select>
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
                                    <div>
                                        <div>{grupo.nombre}</div>
                                        {grupo.hijos?.length > 0 && (
                                            <div className="badge bg-dark mt-1">
                                                Promedio: {calcularPromedioGrupo(grupo)}
                                            </div>
                                        )}
                                    </div>
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
                                                                                            title={nota.descripcion ? addLineBreaks(nota.descripcion) : 'sin descripcion'}
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
                                                                                       className="block text-sm mb-2 ml-4">Evidencia</label>
                                                                                <textarea
                                                                                    id={`evidencia-${cal.id}`}
                                                                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
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
