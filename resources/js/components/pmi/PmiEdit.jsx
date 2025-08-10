import React, { useEffect } from 'react';
import {useState} from "preact/hooks";
import CNavigationButton from "@/components/shared/CNavigationButton.jsx";
import {h} from "preact";

const FactoresCriticosTable = (pmiData = {}, institucionId = -1) => {
    const [pmi, setPmi] = useState(pmiData.pmiData);

    // Agrupar los datos correctamente
    const groupedData = {};

    pmi.factores_criticos?.forEach((fc) => {
        console.log(fc);
        const gestion = fc.calificacion.grupo?.padre?.nombre || 'Sin gestión';
        const componente = fc.calificacion?.nombre || 'Sin componente';

        if (!groupedData[gestion]) groupedData[gestion] = {};
        if (!groupedData[gestion][componente]) groupedData[gestion][componente] = [];

        groupedData[gestion][componente].push(fc);
    });

    // Crear las filas de la tabla con la lógica de fusión correcta
    const renderTableRows = () => {
        const rows = [];

        Object.entries(groupedData).forEach(([gestion, componentes]) => {
            const gestionRowSpan = Object.values(componentes).reduce(
                (sum, factores) => sum + factores.length,
                0
            );

            let isFirstRowOfGestion = true;

            Object.entries(componentes).forEach(([componente, factores]) => {
                const componenteRowSpan = factores.length;

                factores.forEach((fc, factorIndex) => {
                    rows.push(
                        <tr key={fc.id}>
                            {isFirstRowOfGestion && (
                                <td
                                    rowSpan={gestionRowSpan}
                                    className="align-middle bg-light fw-bold border-end"
                                    style={{ verticalAlign: 'middle' }}
                                >
                                    {gestion}
                                </td>
                            )}
                            {factorIndex === 0 && (
                                <td
                                    rowSpan={componenteRowSpan}
                                    className="align-middle border-end"
                                    style={{ verticalAlign: 'middle' }}
                                >
                                    <div className="d-flex">
                                        <small className="text-muted px-1">
                                            {fc.grupo_calificacion?.indice}
                                        </small>
                                        <div className="fw-semibold text-primary">
                                            {componente}
                                        </div>
                                    </div>
                                </td>
                            )}
                            <td className="p-3 d-flex justify-content-between align-items-center">
                                {fc.descripcion || (
                                    <span className="text-muted fst-italic">
                                        Sin descripción
                                    </span>
                                )}
                                <i className="fas fa-edit text-warning fs-4 cursor-pointer"
                                   onClick={() => (window.location.href = `edit/factor-critico/${fc.id}`)}
                                ></i>
                            </td>

                            {/* OBJETIVO */}
                            <td className="p-2">
                                {fc.objetivos && fc.objetivos.length > 0 ? (
                                    <div>
                                        {fc.objetivos.map((objetivo, index) => (
                                            <div key={objetivo.id} className={index > 0 ? "mt-2 pt-2 border-top" : ""}>
                                                <div className="fw-semibold text-dark">
                                                    {objetivo.descripcion || 'Sin descripción'}
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <span className="text-muted fst-italic">Sin objetivos</span>
                                )}
                            </td>

                            {/* META */}
                            <td className="p-2">
                                {fc.objetivos && fc.objetivos.length > 0 ? (
                                    <div>
                                        {fc.objetivos.map((objetivo, objIndex) => (
                                            <div key={`meta-${objetivo.id}`} className={objIndex > 0 ? "mt-2 pt-2 border-top" : ""}>
                                                {objetivo.metas && objetivo.metas.length > 0 ? (
                                                    objetivo.metas.map((meta, metaIndex) => (
                                                        <div key={meta.id} className={metaIndex > 0 ? "mt-1 pt-1 border-top border-light" : ""}>
                                                            <div className="fw-semibold">
                                                                {meta.descripcion || 'Sin descripción'}
                                                            </div>
                                                            <small className="text-muted">
                                                                Valor: {meta.valor_requerido || 'N/A'} {meta.unidad_medida || ''}
                                                            </small>
                                                        </div>
                                                    ))
                                                ) : (
                                                    <span className="text-muted fst-italic">Sin metas</span>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <span className="text-muted fst-italic">-</span>
                                )}
                            </td>

                            {/* ACTIVIDADES */}
                            <td className="p-2">
                                {fc.objetivos && fc.objetivos.length > 0 ? (
                                    <div>
                                        {fc.objetivos.map((objetivo, objIndex) => (
                                            <div key={`act-${objetivo.id}`} className={objIndex > 0 ? "mt-2 pt-2 border-top" : ""}>
                                                {objetivo.metas && objetivo.metas.length > 0 ? (
                                                    objetivo.metas.map((meta, metaIndex) => (
                                                        <div key={`act-${meta.id}`} className={metaIndex > 0 ? "mt-2 pt-1 border-top border-light" : ""}>
                                                            {meta.actividades && meta.actividades.length > 0 ? (
                                                                meta.actividades.map((actividad, actIndex) => (
                                                                    <div key={actividad.id} className={actIndex > 0 ? "mt-1 pt-1 border-top border-light" : ""}>
                                                                        <div className="fw-semibold">
                                                                            {actividad.descripcion || 'Sin descripción'}
                                                                        </div>
                                                                        <small className="text-muted">
                                                                            Peso: {actividad.peso || 'N/A'}%
                                                                            {actividad.fecha_inicio && (
                                                                                <span> | Inicio: {new Date(actividad.fecha_inicio).toLocaleDateString('es-CO')}</span>
                                                                            )}
                                                                            {actividad.fecha_fin && (
                                                                                <span> | Fin: {new Date(actividad.fecha_fin).toLocaleDateString('es-CO')}</span>
                                                                            )}
                                                                        </small>
                                                                    </div>
                                                                ))
                                                            ) : (
                                                                <span className="text-muted fst-italic">Sin actividades</span>
                                                            )}
                                                        </div>
                                                    ))
                                                ) : (
                                                    <span className="text-muted fst-italic">Sin metas</span>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <span className="text-muted fst-italic">-</span>
                                )}
                            </td>

                            {/* RECURSO ($) */}
                            <td className="p-2 text-center">
                                {fc.objetivos && fc.objetivos.length > 0 ? (
                                    <div>
                                        {fc.objetivos.map((objetivo, objIndex) => (
                                            <div key={`rec-${objetivo.id}`} className={objIndex > 0 ? "mt-2 pt-2 border-top" : ""}>
                                                {objetivo.metas && objetivo.metas.length > 0 ? (
                                                    objetivo.metas.map((meta, metaIndex) => (
                                                        <div key={`rec-${meta.id}`} className={metaIndex > 0 ? "mt-2 pt-1 border-top border-light" : ""}>
                                                            {meta.actividades && meta.actividades.length > 0 ? (
                                                                meta.actividades.map((actividad, actIndex) => (
                                                                    <div key={`rec-${actividad.id}`} className={actIndex > 0 ? "mt-1 pt-1 border-top border-light" : ""}>
                                                                        {actividad.recursos ? (
                                                                            <span className="fw-bold text-success">
                                                                                ${new Intl.NumberFormat('es-CO').format(actividad.recursos)}
                                                                            </span>
                                                                        ) : (
                                                                            <span className="text-muted">$0</span>
                                                                        )}
                                                                    </div>
                                                                ))
                                                            ) : (
                                                                <span className="text-muted fst-italic">-</span>
                                                            )}
                                                        </div>
                                                    ))
                                                ) : (
                                                    <span className="text-muted fst-italic">-</span>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <span className="text-muted fst-italic">-</span>
                                )}
                            </td>

                            {/* RESPONSABLE */}
                            <td className="p-2">
                                {fc.objetivos && fc.objetivos.length > 0 ? (
                                    <div>
                                        {fc.objetivos.map((objetivo, objIndex) => (
                                            <div key={`resp-${objetivo.id}`} className={objIndex > 0 ? "mt-2 pt-2 border-top" : ""}>
                                                {objetivo.metas && objetivo.metas.length > 0 ? (
                                                    objetivo.metas.map((meta, metaIndex) => (
                                                        <div key={`resp-${meta.id}`} className={metaIndex > 0 ? "mt-2 pt-1 border-top border-light" : ""}>
                                                            {meta.actividades && meta.actividades.length > 0 ? (
                                                                meta.actividades.map((actividad, actIndex) => (
                                                                    <div key={`resp-${actividad.id}`} className={actIndex > 0 ? "mt-1 pt-1 border-top border-light" : ""}>
                                                                        {actividad.responsables ? (
                                                                            <span className="badge bg-secondary">
                                                                                {actividad.responsables}
                                                                            </span>
                                                                        ) : (
                                                                            <span className="text-muted fst-italic">Sin asignar</span>
                                                                        )}
                                                                    </div>
                                                                ))
                                                            ) : (
                                                                <span className="text-muted fst-italic">-</span>
                                                            )}
                                                        </div>
                                                    ))
                                                ) : (
                                                    <span className="text-muted fst-italic">-</span>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <span className="text-muted fst-italic">-</span>
                                )}
                            </td>
                        </tr>
                    );

                    // Solo marcar como false después de la primera fila
                    if (isFirstRowOfGestion) {
                        isFirstRowOfGestion = false;
                    }
                });
            });
        });

        return rows;
    };

    return (
        <div className="container-fluid mt-4">
            <div className="card shadow-sm">
                <div className="card-header text-black">
                    <div className="d-flex justify-content-between">
                        <div>
                            <h5 className="mb-0">Plan de mejoramiento institucional</h5>
                            <small>Período: {pmi?.anio_inicio} - {pmi?.anio_fin}</small>
                        </div>
                        <div>
                            <CNavigationButton label="Exportar tabla" to="#" icon="fas fa-file-excel" />
                        </div>
                    </div>
                </div>

                <div className="card-body p-0">
                    <div className="table-responsive" style={{ maxHeight: '600px', overflowY: 'auto' }}>
                        <table className="table table-bordered mb-0">
                            <thead className="table-dark">
                            <tr>
                                <th style={{ width: '15%' }} className="text-center">
                                    Gestión
                                </th>
                                <th style={{ width: '18%' }} className="text-center">
                                    Componente
                                </th>
                                <th style={{ width: '22%' }} className="text-center">
                                    Factor Crítico
                                </th>
                                <th style={{ width: '18%' }} className="text-center">Objetivo</th>
                                <th style={{ width: '18%' }} className="text-center">Meta</th>
                                <th style={{ width: '30%' }} className="text-center">Actividades</th>
                                <th style={{ width: '10%' }} className="text-center">Recurso ($)</th>
                                <th style={{ width: '12%' }} className="text-center">Responsable</th>
                            </tr>
                            </thead>
                            <tbody>
                            {renderTableRows()}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div className="card-footer text-muted small">
                    Total de factores críticos: {pmi?.factores_criticos?.length || 0}
                </div>
            </div>
        </div>
    );
};

export default FactoresCriticosTable;
