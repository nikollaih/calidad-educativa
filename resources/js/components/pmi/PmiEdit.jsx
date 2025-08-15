import React from "react";
import { useState } from "preact/hooks";
import CNavigationButton from "@/components/shared/CNavigationButton.jsx";
import { h } from "preact";
import TextMultipleTags from "@/components/shared/TextMultipleTags.jsx";

const FactoresCriticosTable = (pmiData = {}, institucionId = -1) => {
    const [pmi] = useState(pmiData.pmiData);

    // Agrupar datos
    const groupedData = {};
    pmi.factores_criticos?.forEach(fc => {
        const gestion = fc.calificacion.grupo?.padre?.nombre || "Sin gestión";
        const componente = fc.calificacion?.nombre || "Sin componente";

        if (!groupedData[gestion]) groupedData[gestion] = {};
        if (!groupedData[gestion][componente]) groupedData[gestion][componente] = [];
        groupedData[gestion][componente].push(fc);
    });

    // Construir filas planas
// Construir filas planas (tolerante a vacíos)
// Construir filas planas (tolerante a vacíos)
    const buildRows = () => {
        const rows = [];

        Object.entries(groupedData).forEach(([gestion, componentes]) => {
            Object.entries(componentes).forEach(([componente, factores]) => {
                factores.forEach(fc => {
                    // Si no hay objetivos, ponemos null para que igual salga fila
                    const objetivos = fc.objetivos?.length ? fc.objetivos : [null];

                    objetivos.forEach(obj => {
                        const metas = obj?.metas?.length ? obj.metas : [null];

                        metas.forEach(meta => {
                            const actividades = meta?.actividades?.length ? meta.actividades : [null];

                            actividades.forEach(actividad => {
                                rows.push({
                                    gestion,
                                    componente,
                                    factorCritico: fc,
                                    objetivo: obj,
                                    meta,
                                    actividad
                                });
                            });
                        });
                    });
                });
            });
        });

        return rows;
    };

    const tableRows = buildRows();

    // Calcular rowSpans para cada bloque
    const getRowSpan = (index, key) => {
        const current = tableRows[index][key];
        let span = 0;
        for (let i = index; i < tableRows.length; i++) {
            if (tableRows[i][key] === current) span++;
            else break;
        }
        return span;
    };

    return (
        <div className="container-fluid mt-4">
            <div className="card shadow-sm">
                <div className="card-header text-black">
                    <div className="d-flex justify-content-between">
                        <div>
                            <h5 className="mb-0">Plan de mejoramiento institucional</h5>
                            <small>
                                Período: {pmi?.anio_inicio} - {pmi?.anio_fin}
                            </small>
                        </div>
                        <div class="d-flex gap-3">
                            <CNavigationButton label="Agregar avance" to="#" icon="fas fa-plus" />
                            <CNavigationButton label="Exportar tabla" to="#" icon="fas fa-file-excel" />
                        </div>
                    </div>
                </div>
                <div className="card-body p-0">
                    <div className="table-responsive" style={{ maxHeight: "600px", overflowY: "auto" }}>
                        <table className="table table-bordered mb-0">
                            <thead className="table-dark">
                            <tr>
                                <th className="text-center">Gestión</th>
                                <th className="text-center">Componente</th>
                                <th className="text-center">Factor Crítico</th>
                                <th className="text-center">Objetivo</th>
                                <th className="text-center">Meta</th>
                                <th className="text-center">Indicador</th>
                                <th className="text-center">Actividad</th>
                                <th className="text-center">Recurso ($)</th>
                                <th className="text-center">Responsable</th>
                            </tr>
                            </thead>
                            <tbody>
                            {tableRows.map((row, index) => (
                                <tr key={`${index}-${row.actividad?.id || "na"}`}>
                                    {index === 0 || tableRows[index - 1].gestion !== row.gestion ? (
                                        <td
                                            rowSpan={getRowSpan(index, "gestion")}
                                            className="align-middle fw-bold"
                                            style={{ verticalAlign: "middle" }}
                                        >
                                            {row.gestion}
                                        </td>
                                    ) : null}

                                    {index === 0 || tableRows[index - 1].componente !== row.componente ? (
                                        <td
                                            rowSpan={getRowSpan(index, "componente")}
                                            className="align-middle"
                                            style={{ verticalAlign: "middle" }}
                                        >
                                            {row.componente}
                                        </td>
                                    ) : null}

                                    {index === 0 || tableRows[index - 1].factorCritico !== row.factorCritico ? (
                                        <td
                                            rowSpan={getRowSpan(index, "factorCritico")}
                                            className="align-middle"
                                            style={{ verticalAlign: "middle" }}
                                        >
                                            <div className="d-flex justify-content-between align-items-center p-2">
                                                <div>
                                                    <small className="text-muted px-1">
                                                        {row.factorCritico.grupo_calificacion?.indice}
                                                    </small>
                                                    <div className="fw-semibold text-primary">
                                                        {row.factorCritico.descripcion || (
                                                            <span className="text-muted fst-italic">Sin descripción</span>
                                                        )}
                                                    </div>
                                                </div>

                                                <i
                                                    className="fas fa-edit text-warning fs-4 cursor-pointer"
                                                    onClick={() => (window.location.href = `edit/factor-critico/${row.factorCritico.id}`)}
                                                ></i>
                                            </div>
                                        </td>
                                    ) : null}

                                    {(index === 0 || tableRows[index - 1].objetivo !== row.objetivo) ? (
                                        <td
                                            rowSpan={getRowSpan(index, "objetivo")}
                                            className="align-middle"
                                            style={{ verticalAlign: "middle" }}
                                        >
                                            {row?.objetivo?.descripcion || "Sin descripción"}
                                        </td>
                                    ) : null}

                                    {(index === 0 || tableRows[index - 1].meta !== row.meta) ? (
                                        <td
                                            rowSpan={getRowSpan(index, "meta")}
                                            className="align-middle"
                                            style={{ verticalAlign: "middle" }}
                                        >
                                            <div className="">
                                                {row?.meta?.descripcion || "Sin descripción"}
                                            </div>
                                            {( ( row?.meta?.valor_requerido !== undefined && row?.meta?.unidad_medida !==undefined ) && (
                                                    <div className="d-flex flex-column">
                                                        <small className="text-muted">
                                                            <strong>Valor:</strong> {row?.meta?.valor_requerido || "N/A"}
                                                        </small>
                                                        <small className="text-muted">
                                                            <strong>Unidad de
                                                                medida:</strong> {row?.meta?.unidad_medida || ""}
                                                        </small>
                                                    </div>
                                                )
                                            )}
                                        </td>
                                    ) : null}
                                    {(index === 0 || tableRows[index - 1].meta !== row.meta) ? (
                                        <td
                                            rowSpan={getRowSpan(index, "meta")}
                                            className="align-middle"
                                            style={{verticalAlign: "middle"}}
                                        >
                                            {(row?.meta?.valor_requerido !== undefined && row?.meta?.indicador !== undefined) ? (
                                                <div >
                                                    {/* Columna de fracción */}
                                                    <div className="text-center" >
                                                        <div>{row?.meta?.indicador}</div>
                                                        <hr className="my-1" />
                                                        <div>{row?.meta?.valor_requerido}</div>
                                                    </div>
                                                </div>
                                            ) : (
                                                <div>Sin indicador</div>
                                            )}

                                        </td>
                                    ) : null}

                                    <td>
                                        {row.actividad ? (
                                            <>
                                                <div className="fw-semibold">
                                                    {row.actividad.descripcion || "Sin descripción"}
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <small className="text-muted">
                                                        <strong>Peso:</strong>  {row.actividad.peso || "N/A"}%

                                                    </small>
                                                    <small className="text-muted">
                                                        <strong>Inicio:</strong>
                                                        {row.actividad.fecha_inicio && (
                                                            new Date(row.actividad.fecha_inicio).toLocaleDateString("es-CO")
                                                         )}
                                                    </small>
                                                    <small className="text-muted">
                                                        <strong>Fin:</strong>
                                                        {row.actividad.fecha_fin && (
                                                            new Date(row.actividad.fecha_fin).toLocaleDateString("es-CO")
                                                        )}
                                                    </small>
                                                </div>
                                            </>
                                        ) : (
                                            <div >Sin actividades</div>
                                        )}
                                    </td>

                                    <td className="text-center">
                                        {row.actividad?.recursos ? (
                                            <span className="fw-bold text-success">
                                                    ${new Intl.NumberFormat("es-CO").format(row.actividad.recursos)}
                                                </span>
                                        ) : (
                                            <div>Sin recursos</div>
                                        )}
                                    </td>

                                    <td>
                                        {row.actividad?.responsables ? (
                                            <TextMultipleTags
                                                label={" "}
                                                spanClass={" p-2   d-flex align-items-center"}
                                                containerClass={" d-flex flex-wrap gap-2 p-2"}
                                                initialValue={row.actividad.responsables}
                                                isEditable={false}
                                            />
                                        ) : (
                                            <div>Sin asignar</div>
                                        )}
                                    </td>
                                </tr>
                            ))}
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
