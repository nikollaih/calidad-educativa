import { useState } from 'preact/hooks';
import CNavigationButton from '@/components/shared/CNavigationButton.jsx';
import FormularioComentarioFactor from '@/components/pmi/FormularioComentarioFactor.jsx';

const FactoresCriticosTable = ({
    csrfToken = '',
    pmiData = {},
    canManage = false,
    institucionId = -1,
    exportarUrl = '',
}) => {
    const [pmi] = useState(pmiData);
    const [showFormularioComentario, setShowFormularioComentario] = useState(false);
    const [selectedComentario, setSelectedComentario] = useState({});
    const [selectedFactorCritico, setSelectedFactorCritico] = useState({});

    const openCrearAvance = () => setShowFormularioComentario(true);
    const closeCrearAvance = () => setShowFormularioComentario(false);

    // Agrupar datos por gestión y componente
    const groupedData = {};
    pmi?.factores_criticos?.forEach((fc) => {
        const gestion = fc.calificacion.grupo?.padre?.nombre || 'Sin gestión';
        const componente = fc.calificacion?.nombre || 'Sin componente';

        if (!groupedData[gestion]) groupedData[gestion] = {};
        if (!groupedData[gestion][componente]) groupedData[gestion][componente] = [];
        groupedData[gestion][componente].push(fc);
    });

    // Construir filas planas incluyendo la nueva estructura: Meta → Indicadores → Actividades
    const buildRows = () => {
        const rows = [];

        Object.entries(groupedData).forEach(([gestion, componentes]) => {
            Object.entries(componentes).forEach(([componente, factores]) => {
                factores.forEach((fc) => {
                    const objetivos = fc.objetivos?.length ? fc.objetivos : [null];

                    objetivos.forEach((obj) => {
                        const metas = obj?.metas?.length ? obj.metas : [null];

                        metas.forEach((meta) => {
                            // Ahora una meta tiene múltiples indicadores
                            const indicadores = meta?.indicadores?.length
                                ? meta.indicadores
                                : [null];

                            indicadores.forEach((indicador) => {
                                // Cada indicador tiene múltiples actividades
                                const actividades = indicador?.actividades?.length
                                    ? indicador.actividades
                                    : [null];

                                actividades.forEach((actividad) => {
                                    rows.push({
                                        gestion,
                                        componente,
                                        factorCritico: fc,
                                        objetivo: obj,
                                        meta,
                                        indicador,
                                        actividad,
                                    });
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

    // Calcular rowSpans para cada nivel jerárquico
    const getRowSpan = (index, key) => {
        const current = tableRows[index][key];
        let span = 0;
        for (let i = index; i < tableRows.length; i++) {
            if (tableRows[i][key] === current) span++;
            else break;
        }
        return span;
    };

    // Calcular % completitud total por indicador (basado en sus actividades)
    const calcularCompletitudIndicador = (indicador) => {
        if (!indicador?.actividades?.length) return 0;

        return indicador.actividades
            .reduce((total, act) => {
                const peso = act.peso || 0;
                const avance = act.accumulated || 0;
                return total + (peso * avance) / 100;
            }, 0)
            .toFixed(2);
    };

    // Calcular % completitud total por meta (promedio de sus indicadores)
    const calcularCompletitudMeta = (meta) => {
        if (!meta?.indicadores?.length) return 0;

        const totalAvance = meta.indicadores.reduce((sum, ind) => {
            return sum + parseFloat(calcularCompletitudIndicador(ind));
        }, 0);

        return (totalAvance / meta.indicadores.length).toFixed(2);
    };

    // Funciones para manejar comentarios
    const handleComentarioClick = (factorCritico) => {
        const comentarioExistente = pmi?.comentarios?.find(
            ({ factor_id, estado }) => factor_id === factorCritico?.id && estado === 'activo'
        );

        const comentario = comentarioExistente || {
            comentario: '',
            factor_id: factorCritico?.id,
            pmi_id: pmi.id,
        };

        setSelectedFactorCritico(factorCritico);
        setSelectedComentario(comentario);
        openCrearAvance();
    };

    // Funciones para aprobar/devolver PMI
    const cambiarEstadoPmi = (nuevoEstado) => {
        if (!pmi?.id) return;

        const confirmar = window.confirm(
            `¿Estás seguro de que deseas ${nuevoEstado === 'Aprobado' ? 'aprobar' : 'devolver'} este pmi?`
        );
        if (!confirmar) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pmi/validacion/${pmi.id}/cambiar-estado`;

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;

        const estadoInput = document.createElement('input');
        estadoInput.type = 'hidden';
        estadoInput.name = 'estado';
        estadoInput.value = nuevoEstado;

        form.appendChild(tokenInput);
        form.appendChild(estadoInput);
        document.body.appendChild(form);
        form.submit();
    };

    const devolverPmi = () => cambiarEstadoPmi('Proceso');
    const aprobarPmi = () => cambiarEstadoPmi('Aprobado');

    // Componentes reutilizables para celdas
    const CeldaGestion = ({ row, index }) =>
        (index === 0 || tableRows[index - 1].gestion !== row.gestion) && (
            <td
                rowSpan={getRowSpan(index, 'gestion')}
                className="align-middle fw-bold"
                style={{ verticalAlign: 'middle' }}
            >
                {row.gestion}
            </td>
        );

    const CeldaComponente = ({ row, index }) =>
        (index === 0 || tableRows[index - 1].componente !== row.componente) && (
            <td
                rowSpan={getRowSpan(index, 'componente')}
                className="align-middle"
                style={{ verticalAlign: 'middle' }}
            >
                {row.componente}
            </td>
        );

    const CeldaFactorCritico = ({ row, index }) =>
        (index === 0 || tableRows[index - 1].factorCritico !== row.factorCritico) && (
            <td
                rowSpan={getRowSpan(index, 'factorCritico')}
                className="align-middle"
                style={{ verticalAlign: 'middle' }}
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
                    {pmi?.estado === 'Proceso' && (
                        <i
                            className="fas fa-edit text-warning fs-4 cursor-pointer"
                            onClick={() =>
                                (window.location.href = `/edit/factor-critico/${row.factorCritico.id}`)
                            }
                        ></i>
                    )}
                </div>
                <div className="d-flex">
                    <button
                        type="button"
                        className={`btn btn-sm ${
                            pmi?.comentarios?.some(
                                ({ factor_id, estado }) =>
                                    factor_id === row?.factorCritico?.id && estado === 'activo'
                            )
                                ? 'btn-warning'
                                : 'btn-primary'
                        } me-2`}
                        onClick={() => handleComentarioClick(row.factorCritico)}
                    >
                        <i className="fas fa-plus me-1"></i>
                        {pmi?.comentarios?.some(
                            ({ factor_id, estado }) =>
                                factor_id === row?.factorCritico?.id && estado === 'activo'
                        ) && canManage
                            ? 'Editar comentario'
                            : 'Agregar comentario'}
                    </button>
                </div>
            </td>
        );

    const CeldaObjetivo = ({ row, index }) =>
        (index === 0 || tableRows[index - 1].objetivo !== row.objetivo) && (
            <td
                rowSpan={getRowSpan(index, 'objetivo')}
                className="align-middle"
                style={{ verticalAlign: 'middle' }}
            >
                {row?.objetivo?.descripcion || 'Sin descripción'}
            </td>
        );

    const CeldaMeta = ({ row, index }) =>
        (index === 0 || tableRows[index - 1].meta !== row.meta) && (
            <td
                rowSpan={getRowSpan(index, 'meta')}
                className="align-middle"
                style={{ verticalAlign: 'middle' }}
            >
                <div className="mb-2">{row?.meta?.descripcion || 'Sin descripción'}</div>
                <div className="card mt-3 shadow-sm border-0" style={{ maxWidth: '16rem' }}>
                    <div className="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                        <small className="text-muted p-1">Avance Total</small>
                        <span className="fw-bold text-success">
                            {calcularCompletitudMeta(row?.meta)}%
                        </span>
                    </div>
                </div>
            </td>
        );

    const CeldaIndicador = ({ row, index }) =>
        (index === 0 || tableRows[index - 1].indicador !== row.indicador) && (
            <td
                rowSpan={getRowSpan(index, 'indicador')}
                className="align-middle"
                style={{ verticalAlign: 'middle' }}
            >
                {row?.indicador ? (
                    <div>
                        <div className="text-center mb-3">
                            <div className="d-flex align-items-center justify-content-center gap-2">
                                <small className="fw-semibold">
                                    {row.indicador.unidad_parcial || 'N/A'}
                                </small>
                            </div>
                            <hr className="my-1" />
                            <div className="d-flex align-items-center justify-content-center gap-2">
                                <small className="fw-semibold">
                                    {row.indicador.unidad_total || 'N/A'}
                                </small>
                            </div>
                        </div>
                        <div className="d-flex flex-column gap-1">
                            <small className="text-muted">
                                <strong>Valor Requerido:</strong>{' '}
                                {row.indicador.valor_requerido ?? 'N/A'}
                            </small>
                            <small className="text-muted">
                                <strong>Valor Obtenido:</strong>{' '}
                                {row.indicador.valor_obtenido ?? 'N/A'}
                            </small>
                        </div>
                        <div className="card mt-3 shadow-sm border-0" style={{ maxWidth: '14rem' }}>
                            <div className="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                <small className="text-muted">Avance Indicador</small>
                                <span className="fw-bold text-info">
                                    {calcularCompletitudIndicador(row.indicador)}%
                                </span>
                            </div>
                        </div>
                    </div>
                ) : (
                    <div className="text-muted fst-italic">Sin indicador</div>
                )}
            </td>
        );

    const CeldaActividad = ({ row }) => (
        <td>
            {row.actividad ? (
                <div className="d-flex justify-content-between align-items-center">
                    <div>
                        <div className="fw-semibold">
                            {row.actividad.descripcion || 'Sin descripción'}
                        </div>
                        <div className="d-flex flex-column mt-2">
                            <small className="text-muted">
                                <strong>Estado:</strong> {row.actividad.slug_estado || 'N/A'}
                            </small>
                            <small className="text-muted">
                                <strong>Porcentaje de avance:</strong>{' '}
                                {row.actividad?.accumulated || 0}%
                            </small>
                            <small className="text-muted">
                                <strong>Peso:</strong> {row.actividad.peso || 'N/A'}%
                            </small>
                            <small className="text-muted">
                                <strong>Inicio:</strong>{' '}
                                {row.actividad.fecha_inicio &&
                                    new Date(row.actividad.fecha_inicio).toLocaleDateString(
                                        'es-CO'
                                    )}
                            </small>
                            <small className="text-muted">
                                <strong>Fin:</strong>{' '}
                                {row.actividad.fecha_fin &&
                                    new Date(row.actividad.fecha_fin).toLocaleDateString('es-CO')}
                            </small>
                        </div>
                    </div>
                </div>
            ) : (
                <div className="text-muted fst-italic">Sin actividades</div>
            )}
        </td>
    );

    const CeldaRecursos = ({ row }) => (
        <td className="text-center">
            {row.actividad?.recursos ? (
                <span>{row.actividad.recursos}</span>
            ) : (
                <div className="text-muted fst-italic">Sin recursos</div>
            )}
        </td>
    );

    const CeldaResponsables = ({ row }) => (
        <td>
            {row.actividad?.responsables ? (
                <span>{row.actividad.responsables}</span>
            ) : (
                <div className="text-muted fst-italic">Sin asignar</div>
            )}
        </td>
    );
    const CeldaInstrumentosRecoleccion = ({ row }) => (
        <td>
            {row.actividad?.instrumentos_recoleccion ? (
                <span>{row.actividad.instrumentos_recoleccion}</span>
            ) : (
                <div className="text-muted fst-italic">Sin asignar</div>
            )}
        </td>
    );

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
                        <div className="d-flex gap-3">
                            {canManage && (
                                <>
                                    <button className="btn btn-warning" onClick={devolverPmi}>
                                        <i className="fa-solid fa-rotate-left me-2"></i>
                                        Devolver PMI
                                    </button>
                                    <button className="btn btn-success" onClick={aprobarPmi}>
                                        <i className="fa-solid fa-check me-2"></i>
                                        Aprobar PMI
                                    </button>
                                </>
                            )}
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
                                        Objetivo
                                    </th>
                                    <th className="text-center" style={{ minWidth: '10rem' }}>
                                        Meta
                                    </th>
                                    <th className="text-center" style={{ minWidth: '12rem' }}>
                                        Indicador
                                    </th>
                                    <th className="text-center" style={{ minWidth: '10rem' }}>
                                        Actividad
                                    </th>
                                    <th className="text-center">Recurso ($)</th>
                                    <th className="text-center">Responsables</th>
                                    <th className="text-center">Instrumentos de recolección</th>
                                </tr>
                            </thead>
                            <tbody>
                                {tableRows.map((row, index) => (
                                    <tr key={`${index}-${row.actividad?.id || 'na'}`}>
                                        <CeldaGestion row={row} index={index} />
                                        <CeldaComponente row={row} index={index} />
                                        <CeldaFactorCritico row={row} index={index} />
                                        <CeldaObjetivo row={row} index={index} />
                                        <CeldaMeta row={row} index={index} />
                                        <CeldaIndicador row={row} index={index} />
                                        <CeldaActividad row={row} />
                                        <CeldaRecursos row={row} />
                                        <CeldaResponsables row={row} />
                                        <CeldaInstrumentosRecoleccion row={row} />
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

            {showFormularioComentario && (
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
