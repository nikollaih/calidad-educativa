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
                                    <div class="d-flex">
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
                                <i class="fas fa-edit text-warning fs-4 cursor-pointer"
                                   onClick={() => (window.location.href = `edit/factor-critico/${fc.id}`)}
                                ></i>
                            </td>
                            <td></td> {/* OBJETIVO */}
                            <td></td> {/* META */}
                            <td></td> {/* INDICADORES */}
                            <td></td> {/* MEDIDA DEL INDICADOR */}
                            <td></td> {/* ACTIVIDADES */}
                            <td></td> {/* RECURSO ($) */}
                            <td></td> {/* RESPONSABLE */}
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
                <div className="card-header  text-black">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 className="mb-0">Plan de mejoramiento institucional
                            </h5>
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
                                <th style={{ width: '25%' }} className="text-center">
                                    Gestión
                                </th>
                                <th style={{ width: '30%' }} className="text-center">
                                    Componente
                                </th>
                                <th style={{ width: '45%' }} className="text-center">
                                    Factor Crítico
                                </th>
                                <th className="text-center">Objetivo</th>
                                <th className="text-center">Meta</th>
                                <th className="text-center">Indicadores</th>
                                <th className="text-center">Medida del Indicador</th>
                                <th className="text-center">Actividades</th>
                                <th className="text-center">Recurso ($)</th>
                                <th className="text-center">Responsable</th>
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
