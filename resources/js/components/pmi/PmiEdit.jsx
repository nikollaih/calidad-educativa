import { useState } from "preact/hooks";
import CNavigationButton from "@/components/shared/CNavigationButton.jsx";
import { h } from "preact";
import CrearAvancePMI from "@/components/pmi/CrearAvancePMI.jsx";
import VerAvancesPMI from "@/components/pmi/VerAvancesPMI.jsx";
const FactoresCriticosTable = ({csrfToken = '', pmiData = {}, institucionId = -1}) => {
    const [pmi] = useState(pmiData);
    const [showCrearAvance, setShowCrearAvance] = useState(false);
    const [showVerAvances, setShowVerAvances] = useState(false);
    const [selectedActividad, setSelectedActividad] = useState({});

    // Function to open the modal
    const openCrearAvance = () => {
        setShowCrearAvance(true);
    };
    // Function to open the modal
    const openVerAvances = () => {
        setShowVerAvances(true);
    };
    // Function to close the modal
    const closeCrearAvance = () => {
        setShowCrearAvance(false);
        // setSelectedPamId(null);
    };
    const closeVerAvance = () => {
        setShowVerAvances(false);
        // setSelectedPamId(null);
    };
    // Agrupar datos
    const groupedData = {};
    pmi?.factores_criticos?.forEach(fc => {
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
    // --- Calcular % completitud total por meta ---
    const calcularCompletitudMeta = (meta) => {
        if (!meta?.actividades?.length) return 0;

        return meta.actividades.reduce((total, act) => {
            const peso = act.peso || 0;          // en %
            const avance = act.accumulated || 0; // en %
            return total + (peso * avance) / 100;
        }, 0).toFixed(2); // redondeamos a 2 decimales
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
                            <CNavigationButton label="Exportar tabla" to="#" icon="fas fa-file-excel" />
                        </div>
                    </div>
                </div>
                <div className="card-body p-0">
                    <div className="table-responsive" style={{ maxHeight: "600px", overflowY: "auto" }}>
                        <table className="table table-bordered mb-0">
                            <thead className="table-dark" style={{ position: "sticky", top: 0, zIndex: 10 }}>
                            <tr>
                                <th className="text-center">Gestión</th>
                                <th className="text-center">Componente</th>
                                <th className="text-center">Factor Crítico</th>
                                <th className="text-center">Objective</th>
                                <th className="text-center">Meta</th>
                                <th className="text-center">Indicador</th>
                                <th className="text-center">Actividad</th>
                                <th className="text-center">Recurso ($)</th>
                                <th className="text-center">Responsables</th>
                                <th className="text-center">% Completitud</th>
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
                                                { Boolean(pmi?.estado == "Proceso") && (
                                                <i
                                                    className="fas fa-edit text-warning fs-4 cursor-pointer"
                                                    onClick={() => (window.location.href = `edit/factor-critico/${row.factorCritico.id}`)}
                                                ></i>
                                                )}
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
                                                    <div className="text-center">
                                                        <div className="d-flex align-items-center gap-2">
                                                            <small>{row?.meta?.indicador_info?.unidad_parcial}</small>
                                                            <div>{row?.meta?.indicador}</div>
                                                        </div>

                                                        <hr className="my-1"/>

                                                        <div className="d-flex align-items-center gap-2">
                                                            <small>{row?.meta?.indicador_info?.unidad_total}</small>
                                                            <div>{row?.meta?.valor_requerido}</div>
                                                        </div>

                                                    </div>
                                                </div>
                                            ) : (
                                                <div>Sin indicador</div>
                                            )}

                                            <div className="card mt-5 shadow-sm border-0" style={{ maxWidth: "16rem" }}>
                                                <div className="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                                    <small className="text-muted">Completitud total</small>
                                                    <span className="fw-bold text-success">
                                                      {calcularCompletitudMeta(row?.meta)}%
                                                    </span>
                                                </div>
                                            </div>

                                        </td>
                                    ) : null}

                                    <td>
                                        {row.actividad ? (
                                            <div className="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div className="fw-semibold">
                                                        {row.actividad.descripcion || "Sin descripción"}
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <small className="text-muted">
                                                            <strong>Estado:</strong> {row.actividad.slug_estado || "N/A"}
                                                        </small>
                                                        <small className="text-muted">
                                                            <strong>Porcentaje de completitud:</strong> {row.actividad?.accumulated}%
                                                        </small>
                                                        <small className="text-muted">
                                                            <strong>Peso:</strong> {row.actividad.peso || "N/A"}%
                                                        </small>
                                                        <small className="text-muted">
                                                            <strong>Inicio:</strong>{" "}
                                                            {row.actividad.fecha_inicio &&
                                                                new Date(row.actividad.fecha_inicio).toLocaleDateString("es-CO")}
                                                        </small>
                                                        <small className="text-muted">
                                                            <strong>Fin:</strong>{" "}
                                                            {row.actividad.fecha_fin &&
                                                                new Date(row.actividad.fecha_fin).toLocaleDateString("es-CO")}
                                                        </small>
                                                    </div>
                                                    <div className=" d-flex">
                                                        {Boolean(row.actividad?.slug_estado != 'Completada' && pmi.estado == "Presentado") && (
                                                            <button
                                                                type="button"
                                                                className="btn btn-sm btn-primary me-2"
                                                                onClick={() => {
                                                                    setSelectedActividad(row.actividad);
                                                                    openCrearAvance();
                                                                }}
                                                            >
                                                                <i className="fas fa-plus me-1"></i>
                                                                Agregar avance
                                                            </button>
                                                        )}
                                                        <button
                                                            type="button"
                                                            className="btn btn-sm btn-secondary"
                                                            onClick={() => {
                                                                setSelectedActividad(row.actividad);
                                                                openVerAvances();
                                                            }}
                                                        >
                                                            <i className="fas fa-eye me-1"></i>
                                                            Ver avances
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>


                                        ) : (
                                            <div>Sin actividades</div>
                                        )}
                                    </td>

                                    <td className="text-center">
                                        {row.actividad?.recursos ? (

                                            <span className=" ">
                                                    {row.actividad.recursos}
                                                </span>
                                        ) : (
                                            <div>Sin recursos</div>
                                        )}
                                    </td>

                                    <td>
                                        {row.actividad?.responsables ? (
                                            <span className=" ">
                                                    {row.actividad.responsables}
                                                </span>
                                        ) : (
                                            <div>Sin asignar</div>
                                        )}
                                    </td>
                                    <td>
                                        {row.actividad?.accumulated ? (
                                            <div className="d-flex flex-column text-center">
                                              <span className="fw-bold">
                                                {row.actividad?.accumulated}%
                                              </span>
                                                <span className="small text-muted">
                                                ( {row.actividad.slug_estado} )
                                              </span>
                                            </div>
                                        ) : (
                                            <div>Sin porcentaje de completitud</div>
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
            {/* Render the CrearAvance when showCrearAvance is true */}
            {Boolean(showCrearAvance) && (
                <CrearAvancePMI pmiId={pmi.id}
                                onClose={closeCrearAvance}
                                csrfToken={csrfToken}
                                actividad={selectedActividad}/>
            )}
            {Boolean(showVerAvances) && (
                <VerAvancesPMI  onClose={closeVerAvance}
                                actividad={selectedActividad}/>
            )}
        </div>
    );
};

export default FactoresCriticosTable;
