import { useState } from 'preact/hooks';
import CNavigationButton from '@/components/shared/CNavigationButton.jsx';
import FormularioComentarioFactor from '@/components/pmi/FormularioComentarioFactor.jsx';
const FactoresCriticosTable = ({
    csrfToken = '',
    pmiData = {},
    institucionId = -1,
    exportarUrl = '',
}) => {
    const [pmi] = useState(pmiData);
    const [showFormularioComentario, setShowFormularioComentario] = useState(false);
    const [selectedComentario, setSelectedComentario] = useState({});
    const [selectedFactorCritico, setSelectedFactorCritico] = useState({});

    // Function to open the modal
    const openCrearAvance = () => {
        setShowFormularioComentario(true);
    };

    // Function to close the modal
    const closeCrearAvance = () => {
        setShowFormularioComentario(false);
        // setSelectedPamId(null);
    };

    // Agrupar datos
    const groupedData = {};
    pmi?.factores_criticos?.forEach((fc) => {
        const gestion = fc.calificacion.grupo?.padre?.nombre || 'Sin gestión';
        const componente = fc.calificacion?.nombre || 'Sin componente';

        if (!groupedData[gestion]) groupedData[gestion] = {};
        if (!groupedData[gestion][componente]) groupedData[gestion][componente] = [];
        groupedData[gestion][componente].push(fc);
    });
    const devolverPmi = () => {
        if (!pmi?.id) return;

        const confirmar = window.confirm('¿Estás seguro de que deseas devolver este pmi?');
        if (!confirmar) return;

        // Crear formulario dinámico
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pmi/validacion/${pmi.id}/cambiar-estado`;

        // Token CSRF
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        // Nuevo estado
        const estadoInput = document.createElement('input');
        estadoInput.type = 'hidden';
        estadoInput.name = 'estado';
        estadoInput.value = 'Proceso';
        form.appendChild(estadoInput);
        form.appendChild(tokenInput);

        // Agregar el formulario al DOM temporalmente
        document.body.appendChild(form);

        // Enviar formulario (HTML request)
        form.submit();
    };
    const aprobarPmi = () => {
        if (!pmi?.id) return;

        const confirmar = window.confirm('¿Estás seguro de que deseas aprobar este pmi?');
        if (!confirmar) return;

        // Crear formulario dinámico
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pmi/validacion/${pmi.id}/cambiar-estado`;

        // Token CSRF
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        // Nuevo estado
        const estadoInput = document.createElement('input');
        estadoInput.type = 'hidden';
        estadoInput.name = 'estado';
        estadoInput.value = 'Aprobado';
        form.appendChild(tokenInput);
        form.appendChild(estadoInput);

        // Agregar el formulario al DOM temporalmente
        document.body.appendChild(form);

        // Enviar formulario (HTML request)
        form.submit();
    };
    // Construir filas planas
    // Construir filas planas (tolerante a vacíos)
    // Construir filas planas (tolerante a vacíos)
    const buildRows = () => {
        const rows = [];

        Object.entries(groupedData).forEach(([gestion, componentes]) => {
            Object.entries(componentes).forEach(([componente, factores]) => {
                factores.forEach((fc) => {
                    // Si no hay objetivos, ponemos null para que igual salga fila
                    const objetivos = fc.objetivos?.length ? fc.objetivos : [null];

                    objetivos.forEach((obj) => {
                        const metas = obj?.metas?.length ? obj.metas : [null];

                        metas.forEach((meta) => {
                            const actividades = meta?.actividades?.length
                                ? meta.actividades
                                : [null];

                            actividades.forEach((actividad) => {
                                rows.push({
                                    gestion,
                                    componente,
                                    factorCritico: fc,
                                    objetivo: obj,
                                    meta,
                                    actividad,
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
                            <h5 className="mb-0">Plan de Mejoramiento Institucional</h5>
                            <small>
                                Período: {pmi?.anio_inicio} - {pmi?.anio_fin}
                            </small>
                        </div>
                        <div class="d-flex gap-3">
                            <button class="btn btn-warning" onClick={devolverPmi}>
                                <i class="fa-solid fa-rotate-left me-2"></i>
                                Devolver PMI
                            </button>

                            <button class="btn btn-success" onClick={aprobarPmi}>
                                <i class="fa-solid fa-check me-2"></i>
                                Aprobar PMI
                            </button>
                        </div>
                    </div>
                </div>
                <div className="card-body p-0">
                    <div
                        className="table-responsive"
                        style={{ maxHeight: '600px', overflowY: 'auto' }}
                    >
                        <table className="table table-bordered mb-0">
                            <thead
                                className="table-dark"
                                style={{ position: 'sticky', top: 0, zIndex: 10 }}
                            >
                                <tr>
                                    <th className="text-center">Gestión</th>
                                    <th className="text-center">Componente</th>
                                    <th className="text-center" style={{ minWidth: '20rem' }}>
                                        Factor Crítico
                                    </th>
                                    <th className="text-center" style={{ minWidth: '20rem' }}>
                                        Objectivo
                                    </th>
                                    <th className="text-center" style={{ minWidth: '10rem' }}>
                                        Meta
                                    </th>
                                    <th className="text-center">Indicador</th>
                                    <th className="text-center" style={{ minWidth: '10rem' }}>
                                        Actividad
                                    </th>
                                    <th className="text-center">Recurso ($)</th>
                                    <th className="text-center">Responsables</th>
                                </tr>
                            </thead>
                            <tbody>
                                {tableRows.map((row, index) => (
                                    <tr key={`${index}-${row.actividad?.id || 'na'}`}>
                                        {index === 0 ||
                                        tableRows[index - 1].gestion !== row.gestion ? (
                                            <td
                                                rowSpan={getRowSpan(index, 'gestion')}
                                                className="align-middle fw-bold"
                                                style={{ verticalAlign: 'middle' }}
                                            >
                                                {row.gestion}
                                            </td>
                                        ) : null}

                                        {index === 0 ||
                                        tableRows[index - 1].componente !== row.componente ? (
                                            <td
                                                rowSpan={getRowSpan(index, 'componente')}
                                                className="align-middle"
                                                style={{ verticalAlign: 'middle' }}
                                            >
                                                {row.componente}
                                            </td>
                                        ) : null}

                                        {index === 0 ||
                                        tableRows[index - 1].factorCritico !== row.factorCritico ? (
                                            <td
                                                rowSpan={getRowSpan(index, 'factorCritico')}
                                                className="align-middle"
                                                style={{ verticalAlign: 'middle' }}
                                            >
                                                <div className="d-flex justify-content-between align-items-center p-2">
                                                    <div>
                                                        <small className="text-muted px-1">
                                                            {
                                                                row.factorCritico.grupo_calificacion
                                                                    ?.indice
                                                            }
                                                        </small>
                                                        <div className="fw-semibold text-primary">
                                                            {row.factorCritico.descripcion || (
                                                                <span className="text-muted fst-italic">
                                                                    Sin descripción
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>
                                                    {Boolean(pmi?.estado == 'Proceso') && (
                                                        <i
                                                            className="fas fa-edit text-warning fs-4 cursor-pointer"
                                                            onClick={() =>
                                                                (window.location.href = `edit/factor-critico/${row.factorCritico.id}`)
                                                            }
                                                        ></i>
                                                    )}
                                                </div>
                                                <div className=" d-flex">
                                                    {Boolean(
                                                        pmi?.comentarios?.some(
                                                            ({ factor_id, estado }) =>
                                                                factor_id ===
                                                                    row?.factorCritico?.id &&
                                                                estado == 'activo'
                                                        )
                                                    ) ? (
                                                        <button
                                                            type="button"
                                                            className="btn btn-sm btn-warning me-2"
                                                            onClick={() => {
                                                                const comentario =
                                                                    pmi?.comentarios?.find(
                                                                        ({ factor_id, estado }) =>
                                                                            factor_id ===
                                                                                row?.factorCritico
                                                                                    ?.id &&
                                                                            estado === 'activo'
                                                                    ) ?? {
                                                                        comentario: '',
                                                                        factor_id:
                                                                            row?.factorCritico?.id,
                                                                        pmi_id: pmi.id,
                                                                    };
                                                                setSelectedFactorCritico(
                                                                    row.factorCritico
                                                                );
                                                                setSelectedComentario(comentario);
                                                                openCrearAvance();
                                                            }}
                                                        >
                                                            <i className="fas fa-plus me-1"></i>
                                                            Editar comentario
                                                        </button>
                                                    ) : (
                                                        <button
                                                            type="button"
                                                            className="btn btn-sm btn-primary me-2"
                                                            onClick={() => {
                                                                const comentario = {
                                                                    comentario: '',
                                                                    factor_id:
                                                                        row?.factorCritico?.id,
                                                                    pmi_id: pmi.id,
                                                                };
                                                                setSelectedFactorCritico(
                                                                    row.factorCritico
                                                                );
                                                                setSelectedComentario(comentario);
                                                                openCrearAvance();
                                                            }}
                                                        >
                                                            <i className="fas fa-plus me-1"></i>
                                                            Agregar comentario
                                                        </button>
                                                    )}
                                                </div>
                                            </td>
                                        ) : null}

                                        {index === 0 ||
                                        tableRows[index - 1].objetivo !== row.objetivo ? (
                                            <td
                                                rowSpan={getRowSpan(index, 'objetivo')}
                                                className="align-middle"
                                                style={{ verticalAlign: 'middle' }}
                                            >
                                                {row?.objetivo?.descripcion || 'Sin descripción'}
                                            </td>
                                        ) : null}

                                        {index === 0 || tableRows[index - 1].meta !== row.meta ? (
                                            <td
                                                rowSpan={getRowSpan(index, 'meta')}
                                                className="align-middle"
                                                style={{ verticalAlign: 'middle' }}
                                            >
                                                <div className="">
                                                    {row?.meta?.descripcion || 'Sin descripción'}
                                                </div>
                                                {row?.meta?.valor_requerido !== undefined &&
                                                    row?.meta?.unidad_medida !== undefined && (
                                                        <div className="d-flex flex-column">
                                                            <small className="text-muted">
                                                                <strong>Valor:</strong>{' '}
                                                                {row?.meta?.valor_requerido ||
                                                                    'N/A'}
                                                            </small>
                                                            <small className="text-muted">
                                                                <strong>Unidad de medida:</strong>{' '}
                                                                {row?.meta?.unidad_medida || ''}
                                                            </small>
                                                        </div>
                                                    )}
                                            </td>
                                        ) : null}
                                        {index === 0 || tableRows[index - 1].meta !== row.meta ? (
                                            <td
                                                rowSpan={getRowSpan(index, 'meta')}
                                                className="align-middle"
                                                style={{ verticalAlign: 'middle' }}
                                            >
                                                {row?.meta?.valor_requerido !== undefined &&
                                                row?.meta?.indicador !== undefined ? (
                                                    <div>
                                                        {/* Columna de fracción */}
                                                        <div className="text-center">
                                                            <div className="d-flex align-items-center gap-2">
                                                                <small>
                                                                    {
                                                                        row?.meta?.indicador_info
                                                                            ?.unidad_parcial
                                                                    }
                                                                </small>
                                                            </div>

                                                            <hr className="my-1" />

                                                            <div className="d-flex align-items-center gap-2">
                                                                <small>
                                                                    {
                                                                        row?.meta?.indicador_info
                                                                            ?.unidad_total
                                                                    }
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ) : (
                                                    <div>Sin indicador</div>
                                                )}
                                            </td>
                                        ) : null}

                                        <td>
                                            {row.actividad ? (
                                                <div className="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <div className="fw-semibold">
                                                            {row.actividad.descripcion ||
                                                                'Sin descripción'}
                                                        </div>
                                                        <div className="d-flex flex-column">
                                                            <small className="text-muted">
                                                                <strong>Estado:</strong>{' '}
                                                                {row.actividad.slug_estado || 'N/A'}
                                                            </small>
                                                            <small className="text-muted">
                                                                <strong>
                                                                    Porcentaje de avance:
                                                                </strong>{' '}
                                                                {row.actividad?.accumulated}%
                                                            </small>
                                                            <small className="text-muted">
                                                                <strong>Peso:</strong>{' '}
                                                                {row.actividad.peso || 'N/A'}%
                                                            </small>
                                                            <small className="text-muted">
                                                                <strong>Inicio:</strong>{' '}
                                                                {row.actividad.fecha_inicio &&
                                                                    new Date(
                                                                        row.actividad.fecha_inicio
                                                                    ).toLocaleDateString('es-CO')}
                                                            </small>
                                                            <small className="text-muted">
                                                                <strong>Fin:</strong>{' '}
                                                                {row.actividad.fecha_fin &&
                                                                    new Date(
                                                                        row.actividad.fecha_fin
                                                                    ).toLocaleDateString('es-CO')}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            ) : (
                                                <div>Sin actividades</div>
                                            )}
                                        </td>

                                        <td className="text-center">
                                            {row.actividad?.recursos ? (
                                                <span className=" ">{row.actividad.recursos}</span>
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
            {/* Render the showFormularioComentario when showFormularioComentario is true */}
            {Boolean(showFormularioComentario) && (
                <FormularioComentarioFactor
                    pmiId={pmi.id}
                    onClose={closeCrearAvance}
                    csrfToken={csrfToken}
                    factorCritico={selectedFactorCritico}
                    comentario={selectedComentario}
                />
            )}
        </div>
    );
};

export default FactoresCriticosTable;
