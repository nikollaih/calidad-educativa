import React, { useState, useEffect } from 'react';
import Select from 'react-select';
import Swal from 'sweetalert2';
import TextMultipleTags from '@/components/shared/TextMultipleTags.jsx';

const uniqueId = (p = 'v-') => `${p}${Date.now()}-${Math.random().toString(36).slice(2, 8)}`;

const FactorCriticoEdit = ({
    id,
    csrfToken = '',
    factorCritico = {},
    pmiId = -1,
    institucionId = -1,
    objetivosGenerales,
    agregarUrl = '',
    indicadores = [],
    frecuenciasRecoleccion = [],
}) => {
    const [formData, setFormData] = useState({
        objetivos: [], // Array de objetivos
    });
    const [isEditing, setIsEditing] = useState(false);

    // Mapa objetivoId -> metaId seleccionada en el select
    const [selectedMetaByObjetivo, setSelectedMetaByObjetivo] = useState({});

    useEffect(() => {
        if (factorCritico?.objetivos?.length > 0) {
            setFormData((prev) => ({
                objetivos: factorCritico.objetivos,
            }));
        }
    }, []);

    /**
     * Actualiza un campo específico de un elemento anidado según su tipo
     * Estructura: Objetivo -> Metas -> Indicadores -> Actividades
     */
    const updateItemField = (items, targetId, fieldName, newValue, type) => {
        return items.map((item) => {
            // Si el tipo es 'objetivo' y el ID coincide
            if (type === 'objetivo' && item.id === targetId) {
                return { ...item, [fieldName]: newValue };
            }

            // Si hay metas dentro del objetivo
            if (item.metas) {
                return {
                    ...item,
                    metas: updateItemField(item.metas, targetId, fieldName, newValue, type),
                };
            }

            // Si el tipo es 'meta' y el ID coincide
            if (type === 'meta' && item.id === targetId) {
                return { ...item, [fieldName]: newValue };
            }

            // Si hay indicadores dentro de la meta
            if (item.indicadores) {
                return {
                    ...item,
                    indicadores: updateItemField(
                        item.indicadores,
                        targetId,
                        fieldName,
                        newValue,
                        type
                    ),
                };
            }

            // Si el tipo es 'indicador' y el ID coincide
            if (type === 'indicador' && item.id === targetId) {
                return { ...item, [fieldName]: newValue };
            }

            // Si hay actividades dentro del indicador
            if (item.actividades) {
                return {
                    ...item,
                    actividades: updateItemField(
                        item.actividades,
                        targetId,
                        fieldName,
                        newValue,
                        type
                    ),
                };
            }

            // Si el tipo es 'actividad' y el ID coincide
            if (type === 'actividad' && item.id === targetId) {
                return { ...item, [fieldName]: newValue };
            }

            return item;
        });
    };

    /**
     * Función para actualizar campos específicos
     */
    const updateField = (itemId, fieldName, value, type) => {
        setFormData((prevFormData) => ({
            ...prevFormData,
            objetivos: updateItemField(prevFormData.objetivos, itemId, fieldName, value, type),
        }));
    };

    /**
     * Al seleccionar un objetivo general: setea su descripción e ID,
     * limpia metas y resetea la meta seleccionada para ese objetivo.
     */
    const handleObjetivoChange = (objetivoId, objetivoGeneralSeleccionadoId) => {
        const objetivoGeneralSeleccionado = objetivosGenerales.find(
            (obj) => obj.id === parseInt(objetivoGeneralSeleccionadoId, 10)
        );

        if (!objetivoGeneralSeleccionado) return;

        setFormData((prevData) => ({
            ...prevData,
            objetivos: prevData.objetivos.map((objetivo) => {
                if (objetivo.id === objetivoId) {
                    return {
                        ...objetivo,
                        descripcion: objetivoGeneralSeleccionado.descripcion,
                        objetivo_general_id: objetivoGeneralSeleccionado.id,
                        metas: [], // Se agregan con el botón "Agregar meta"
                    };
                }
                return objetivo;
            }),
        }));

        // Reset del select de metas para ese objetivo
        setSelectedMetaByObjetivo((prev) => ({ ...prev, [objetivoId]: '' }));
    };

    // --- Funciones para agregar elementos ---

    const agregarObjetivo = () => {
        var objetivoId = `objetivo-virtual-${uniqueId()}`;
        const newObjetivo = {
            id: objetivoId,
            descripcion: 'Nuevo objetivo',
            objetivo_general_id: null,
            metas: [
                {
                    id: `meta-virtual-${uniqueId()}`,
                    __source_meta_id: -1, // solo para control interno (no se envía)
                    descripcion: 'Nueva meta',
                    indicador_id: '',
                    valor_requerido: 0,
                    objetivo_id: objetivoId,
                    indicadores: [],
                },
            ],
        };

        setFormData((prev) => ({
            ...prev,
            objetivos: [newObjetivo, ...prev.objetivos],
        }));
    };

    const addMetaFromSelect = (objetivo) => {
        const selectedMetaId = selectedMetaByObjetivo[objetivo.id];
        if (!selectedMetaId) return;

        const objetivoGeneral = objetivosGenerales.find(
            (obj) => obj.id === objetivo.objetivo_general_id
        );
        const metaSeleccionada = objetivoGeneral?.metas?.find(
            (m) => m.id === parseInt(selectedMetaId, 10)
        );
        if (!metaSeleccionada) return;

        // Evitar agregar duplicados: comparamos por el ID real de la meta origen
        const yaExiste = (objetivo.metas || []).some(
            (m) => m.__source_meta_id === metaSeleccionada.id
        );
        if (yaExiste) {
            Swal.fire({
                icon: 'info',
                title: 'Meta ya agregada',
                text: 'Esta meta ya se encuentra en el listado.',
                timer: 1800,
                showConfirmButton: false,
            });
            return;
        }

        const newMeta = {
            id: `meta-virtual-${uniqueId()}`,
            __source_meta_id: metaSeleccionada.id, // solo para control interno (no se envía)
            descripcion: metaSeleccionada.descripcion,
            objetivo_id: objetivo.id,
            actividades: (metaSeleccionada.actividades || []).map((actividad) => ({
                id: `actividad-virtual-${uniqueId()}`,
                descripcion: actividad.descripcion,
                peso: actividad.peso ?? 0,
                max_suma_indicador: actividad.max_suma_indicador ?? 0,
                afecta_indicador: actividad.afecta_indicador ?? 0,
                responsables: '',
                instrumentos_recoleccion: '',
                recursos: '',
                fecha_inicio: '',
                fecha_fin: '',
                meta_id: metaSeleccionada.id,
            })),
        };

        setFormData((prev) => ({
            ...prev,
            objetivos: prev.objetivos.map((o) =>
                o.id === objetivo.id ? { ...o, metas: [...(o.metas || []), newMeta] } : o
            ),
        }));

        // Opcional: limpiar el select tras agregar
        setSelectedMetaByObjetivo((prev) => ({ ...prev, [objetivo.id]: '' }));
    };
    // Agregar actividad a un indicador por ID
    const addActividad = (indicadorId) => {
        setFormData((prev) => ({
            ...prev,
            objetivos: prev.objetivos.map((objetivo) => ({
                ...objetivo,
                metas: (objetivo.metas || []).map((meta) => ({
                    ...meta,
                    indicadores: (meta.indicadores || []).map((indicador) =>
                        indicador.id === indicadorId
                            ? {
                                  ...indicador,
                                  actividades: [
                                      ...(indicador.actividades || []),
                                      {
                                          id: `actividad-virtual-${uniqueId()}`,
                                          descripcion: '',
                                          peso: 0,
                                          max_suma_indicador: 0,
                                          afecta_indicador: 0,
                                          responsables: '',
                                          instrumentos_recoleccion: '',
                                          recursos: '',
                                          fecha_inicio: '',
                                          fecha_fin: '',
                                          indicador_id: indicadorId,
                                          frecuencia_recoleccion: '',
                                      },
                                  ],
                              }
                            : indicador
                    ),
                })),
            })),
        }));
    };
    // Agregar actividad a una meta por ID
    const addIndicador = (metaId) => {
        setFormData((prev) => ({
            ...prev,
            objetivos: prev.objetivos.map((objetivo) => ({
                ...objetivo,
                metas: (objetivo.metas || []).map((meta) =>
                    meta.id === metaId
                        ? {
                              ...meta,
                              indicadores: [
                                  ...(meta.indicadores || []),
                                  {
                                      id: `indicador-${uniqueId()}`,
                                      unidad_total: '',
                                      unidad_parcial: '',
                                      valor_requerido: 0,
                                      meta_id: metaId,
                                      actividades: [],
                                  },
                              ],
                          }
                        : meta
                ),
            })),
        }));
    };

    /**
     * Función para eliminar elementos
     */
    /**
     * Función para eliminar elementos
     */
    const removeElement = (type, itemId) => {
        if (!confirm('¿Estás seguro de que deseas eliminar este elemento?')) {
            return;
        }

        setFormData((prev) => {
            switch (type) {
                case 'objetivo':
                    return {
                        ...prev,
                        objetivos: prev.objetivos.filter((obj) => obj.id !== itemId),
                    };

                case 'meta':
                    return {
                        ...prev,
                        objetivos: prev.objetivos.map((objetivo) => ({
                            ...objetivo,
                            metas: (objetivo.metas || []).filter((meta) => meta.id !== itemId),
                        })),
                    };

                case 'indicador':
                    return {
                        ...prev,
                        objetivos: prev.objetivos.map((objetivo) => ({
                            ...objetivo,
                            metas: (objetivo.metas || []).map((meta) => ({
                                ...meta,
                                indicadores: (meta.indicadores || []).filter(
                                    (ind) => ind.id !== itemId
                                ),
                            })),
                        })),
                    };

                case 'actividad':
                    return {
                        ...prev,
                        objetivos: prev.objetivos.map((objetivo) => ({
                            ...objetivo,
                            metas: (objetivo.metas || []).map((meta) => ({
                                ...meta,
                                indicadores: (meta.indicadores || []).map((indicador) => ({
                                    ...indicador,
                                    actividades: (indicador.actividades || []).filter(
                                        (act) => act.id !== itemId
                                    ),
                                })),
                            })),
                        })),
                    };

                default:
                    return prev;
            }
        });
    };

    // --- Funciones de Renderizado ---

    const renderActividad = (actividad, indicadorId, restante, sumaPesos, indicador) => {
        const valorRequeridoAcumulado = calcularSumaIndicadores(indicador);
        const restanteValorRequerido = indicador.valor_requerido - valorRequeridoAcumulado;

        return (
            <div key={actividad.id} className="card mt-3 border-info" style={{ width: '100%' }}>
                <div className="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 className="mb-0">Actividad</h6>
                    <button
                        type="button"
                        className="btn btn-sm btn-outline-danger"
                        onClick={() => removeElement('actividad', actividad.id)}
                    >
                        <i className="fas fa-trash"></i>
                    </button>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
                        <textarea
                            className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                            rows="3"
                            value={actividad.descripcion}
                            onChange={(e) =>
                                updateField(
                                    actividad.id,
                                    'descripcion',
                                    e.target.value,
                                    'actividad'
                                )
                            }
                            placeholder="Descripción de la actividad"
                            disabled={false}
                        />
                    </div>

                    <div className="row">
                        <div className="col-md-6">
                            <label className="block text-sm mb-2 ml-4 fw-bold">
                                Peso (%) :
                                {restante < 0 ? (
                                    <span className="text-danger fw-bold">
                                        Excedido por {Math.abs(restante)}%
                                    </span>
                                ) : (
                                    <span className="text-primary fw-bold">
                                        (Se ha asignado un {sumaPesos}%)
                                    </span>
                                )}
                            </label>
                            <div className="flex">
                                <input
                                    type="number"
                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                    value={actividad.peso}
                                    onChange={(e) =>
                                        updateField(
                                            actividad.id,
                                            'peso',
                                            parseFloat(e.target.value) || 0,
                                            'actividad'
                                        )
                                    }
                                    placeholder="0"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                />
                            </div>
                        </div>
                        <div className="col-md-6">
                            <div className="d-flex justify-content-center align-items-center h-100">
                                <label className="block text-sm mb-2 ml-4 fw-bold  m-0 px-2">
                                    Sumará al indicador:
                                </label>
                                <input
                                    type="checkbox"
                                    className="form-check-input"
                                    checked={actividad.afecta_indicador}
                                    onChange={(e) =>
                                        updateField(
                                            actividad.id,
                                            'afecta_indicador',
                                            e.target.checked ? 1 : 0,
                                            'actividad'
                                        )
                                    }
                                />
                            </div>
                        </div>
                        {Boolean(actividad.afecta_indicador) && (
                            <div className="col-md-6">
                                <label className="block text-sm mb-2 ml-4 fw-bold">
                                    Valor que aporta al indicador:
                                    {restanteValorRequerido < 0 ? (
                                        <span className="text-danger fw-bold">
                                            Excedido por {restanteValorRequerido}
                                        </span>
                                    ) : (
                                        <span className="text-primary fw-bold">
                                            (Unidades asignables {restanteValorRequerido})
                                        </span>
                                    )}
                                </label>

                                <input
                                    type="number"
                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                    value={actividad.max_suma_indicador}
                                    onChange={(e) =>
                                        updateField(
                                            actividad.id,
                                            'max_suma_indicador',
                                            e.target.value,
                                            'actividad'
                                        )
                                    }
                                />
                            </div>
                        )}

                        <div className="col-md-6">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Responsables:</label>
                            <TextMultipleTags
                                initialValue={actividad.responsables}
                                label={''}
                                onTagsChange={(joinedTags) => {
                                    updateField(
                                        actividad.id,
                                        'responsables',
                                        joinedTags,
                                        'actividad'
                                    );
                                }}
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="block text-sm mb-2 ml-4 fw-bold">
                                Instrumentos de recolección:
                            </label>
                            <TextMultipleTags
                                initialValue={actividad.instrumentos_recoleccion}
                                label={''}
                                onTagsChange={(joinedTags) => {
                                    updateField(
                                        actividad.id,
                                        'instrumentos_recoleccion',
                                        joinedTags,
                                        'actividad'
                                    );
                                }}
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Frecuencia de recolección:</label>
                            <Select
                                value={
                                    actividad.frecuencia_recoleccion
                                        ? {
                                              value: actividad.frecuencia_recoleccion,
                                              label: actividad.frecuencia_recoleccion,
                                          }
                                        : null
                                }
                                options={frecuenciasRecoleccion.map((frecuencia) => ({
                                    value: frecuencia,
                                    label: frecuencia,
                                }))}
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                classNamePrefix="select"
                                placeholder="Selecciona la frecuencia de recolección..."
                                onChange={(frecuencia) => {
                                    updateField(
                                        actividad.id,
                                        'frecuencia_recoleccion',
                                        frecuencia.value,
                                        'actividad'
                                    );
                                }}
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Recursos:</label>
                            <TextMultipleTags
                                initialValue={actividad.recursos}
                                label={''}
                                onTagsChange={(joinedTags) => {
                                    updateField(actividad.id, 'recursos', joinedTags, 'actividad');
                                }}
                            />
                        </div>
                    </div>

                    <div className="row mt-3">
                        <div className="col-md-6">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Fecha de Inicio:</label>
                            <input
                                type="date"
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                value={actividad.fecha_inicio}
                                onChange={(e) =>
                                    updateField(
                                        actividad.id,
                                        'fecha_inicio',
                                        e.target.value,
                                        'actividad'
                                    )
                                }
                                min={`${new Date().getFullYear()}-01-01`}
                                required={true}
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Fecha de Fin:</label>
                            <input
                                type="date"
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                value={actividad.fecha_fin}
                                onChange={(e) =>
                                    updateField(
                                        actividad.id,
                                        'fecha_fin',
                                        e.target.value,
                                        'actividad'
                                    )
                                }
                                min={actividad.fecha_inicio}
                                required={true}
                            />
                        </div>
                    </div>
                </div>
            </div>
        );
    };

    const renderMeta = (meta, objetivoId) => {
        return (
            <div key={meta.id} className="card mt-3 border-warning" style={{ width: '100%' }}>
                <div className="card-header bg-light d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <h5 className="mb-0 pr-2">Meta</h5>
                    </div>

                    <button
                        type="button"
                        className="btn btn-sm btn-outline-danger"
                        onClick={() => removeElement('meta', meta.id)}
                    >
                        <i className="fas fa-trash"></i>
                    </button>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
                        <textarea
                            className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                            rows="3"
                            value={meta.descripcion}
                            onChange={(e) =>
                                updateField(meta.id, 'descripcion', e.target.value, 'meta')
                            }
                            placeholder="Descripción de la meta"
                            disabled={false}
                        />
                    </div>
                    {meta?.indicadores?.length == 0 && (
                        <button
                            type="button"
                            className="border bg-blue-500  text-white p-2 rounded-pill mt-4"
                            onClick={() => addIndicador(meta.id)}
                        >
                            Agregar indicador
                        </button>
                    )}
                    {/* Renderizar indicadores */}
                    {meta.indicadores &&
                        meta.indicadores.map((indicador) => renderIndicador(indicador, meta.id))}

                    {meta?.indicadores?.length > 0 && (
                        <button
                            type="button"
                            className="border bg-blue-500  text-white p-2 rounded-pill mt-4"
                            onClick={() => addIndicador(meta.id)}
                        >
                            Agregar indicador
                        </button>
                    )}
                </div>
            </div>
        );
    };
    const renderIndicador = (indicador, metaId) => {
        const sumaPesos = calcularSumaPesosIndicador(indicador);
        const restante = calcularRestanteIndicador(indicador);
        return (
            <div key={indicador.id} className="card mt-3 border-success" style={{ width: '100%' }}>
                <div className="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 className="mb-0">Indicador</h6>
                    <div className="mb-2 px-5">
                        <strong>Peso asignado: </strong>
                        {sumaPesos}% &nbsp; | &nbsp;
                        {restante > 0 && (
                            <span className="text-success">Restante: {restante}%</span>
                        )}
                        {restante === 0 && (
                            <span className="text-primary fw-bold">Completado ✅</span>
                        )}
                        {restante < 0 && (
                            <span className="text-danger fw-bold">
                                Excedido por {Math.abs(restante)}%
                            </span>
                        )}
                    </div>
                    <button
                        type="button"
                        className="btn btn-sm btn-outline-danger"
                        onClick={() => removeElement('indicador', indicador.id)}
                    >
                        <i className="fas fa-trash"></i>
                    </button>
                </div>
                <div className="card-body">
                    <div className="row">
                        <div className="col-md-4">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Unidad Total:</label>
                            <input
                                type="text"
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                value={indicador.unidad_total}
                                onChange={(e) =>
                                    updateField(
                                        indicador.id,
                                        'unidad_total',
                                        e.target.value,
                                        'indicador'
                                    )
                                }
                                placeholder="Ej: Total de estudiantes beneficiados"
                            />
                        </div>
                        <div className="col-md-4">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Unidad Parcial:</label>
                            <input
                                type="text"
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                value={indicador.unidad_parcial}
                                onChange={(e) =>
                                    updateField(
                                        indicador.id,
                                        'unidad_parcial',
                                        e.target.value,
                                        'indicador'
                                    )
                                }
                                placeholder="Ej: Número de estudiantes beneficiados"
                            />
                        </div>
                        <div className="col-md-4">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Valor Requerido:</label>
                            <input
                                type="number"
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                value={indicador.valor_requerido}
                                onChange={(e) =>
                                    updateField(
                                        indicador.id,
                                        'valor_requerido',
                                        parseFloat(e.target.value) || 0,
                                        'indicador'
                                    )
                                }
                                placeholder="0"
                                min="0"
                                step="0.01"
                            />
                        </div>
                        {indicador?.actividades?.length == 0 && (
                            <button
                                type="button"
                                className="border bg-blue-500  text-white p-2 rounded-pill mt-4"
                                onClick={() => addActividad(indicador.id)}
                            >
                                Agregar Actividad
                            </button>
                        )}
                        {/* Renderizar indicadores */}
                        {indicador.actividades &&
                            indicador.actividades.map((actividad) =>
                                renderActividad(
                                    actividad,
                                    indicador.id,
                                    restante,
                                    sumaPesos,
                                    indicador
                                )
                            )}
                    </div>
                    {indicador?.actividades?.length > 0 && (
                        <button
                            type="button"
                            className="border bg-blue-500  text-white p-2 rounded-pill mt-4"
                            onClick={() => addActividad(indicador.id)}
                        >
                            Agregar Actividad
                        </button>
                    )}
                </div>
            </div>
        );
    };
    const renderObjetivo = (objetivo) => {
        // Metas disponibles según objetivo + filtradas para no repetir las ya agregadas
        const metasDisponibles =
            objetivosGenerales.find((obj) => obj.id === objetivo.objetivo_general_id)?.metas || [];
        const metasYaAgregadasIds = new Set(
            (objetivo.metas || []).map((m) => m.__source_meta_id).filter(Boolean)
        );
        const metasParaSelect = metasDisponibles.filter((m) => !metasYaAgregadasIds.has(m.id));
        const selectedMetaId = selectedMetaByObjetivo[objetivo.id] || '';

        return (
            <div key={objetivo.id} className="card mt-3 border-primary" style={{ width: '100%' }}>
                <div className="card-header bg-light d-flex justify-content-between align-items-center">
                    <h3 className="mb-0">Objetivo</h3>
                    <button
                        type="button"
                        className="btn btn-sm btn-outline-danger"
                        onClick={() => removeElement('objetivo', objetivo.id)}
                    >
                        <i className="fas fa-trash"></i>
                    </button>
                </div>
                <div className="card-body">
                    {/* Descripción completa del objetivo seleccionado */}
                    {/* Descripción completa del objetivo seleccionado */}
                    {
                        <div className="mt-3">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción del objetivo:</label>
                            <textarea
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                rows="3"
                                value={objetivo.descripcion}
                                onChange={(e) =>
                                    updateField(
                                        objetivo.id,
                                        'descripcion',
                                        e.target.value,
                                        'objetivo'
                                    )
                                }
                                placeholder="Escribe o edita la descripción del objetivo"
                            />
                        </div>
                    }
                    <div className="mb-3">
                        <label className="block text-sm mb-2 ml-4 fw-bold">Seleccione un objetivo:</label>
                        <select
                            className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                            value={objetivo.objetivo_general_id || ''}
                            onChange={(e) => handleObjetivoChange(objetivo.id, e.target.value)}
                        >
                            <option value="">-- Seleccione un objetivo --</option>
                            {objetivosGenerales.map((objetivoGeneral) => (
                                <option
                                    key={objetivoGeneral.id}
                                    value={objetivoGeneral.id}
                                    title={objetivoGeneral.descripcion}
                                >
                                    {objetivoGeneral.descripcion.length > 120
                                        ? objetivoGeneral.descripcion.substring(0, 120) + '...'
                                        : objetivoGeneral.descripcion}
                                </option>
                            ))}
                        </select>
                    </div>

                    {/* Select de metas + botón agregar */}
                    {objetivo.objetivo_general_id && (
                        <div className="mb-3">
                            <label className="block text-sm mb-2 ml-4 fw-bold">Metas del objetivo:</label>
                            <div className="d-flex gap-2">
                                <select
                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                    value={selectedMetaId}
                                    onChange={(e) =>
                                        setSelectedMetaByObjetivo((prev) => ({
                                            ...prev,
                                            [objetivo.id]: e.target.value,
                                        }))
                                    }
                                    style={{ maxWidth: '100%' }}
                                >
                                    <option value="">-- Seleccione una meta --</option>
                                    {metasParaSelect.map((meta) => (
                                        <option key={meta.id} value={meta.id}>
                                            {meta.descripcion.length > 120
                                                ? meta.descripcion.substring(0, 120) + '...'
                                                : meta.descripcion}
                                        </option>
                                    ))}
                                </select>
                                <button
                                    type="button"
                                    className="btn btn-outline-primary"
                                    onClick={() => addMetaFromSelect(objetivo)}
                                    disabled={!selectedMetaId}
                                    title={!selectedMetaId ? 'Seleccione una meta' : 'Agregar meta'}
                                >
                                    <i className="fas fa-plus-circle"></i> Agregar meta
                                </button>
                            </div>
                            {metasDisponibles.length === 0 && (
                                <small className="text-muted d-block mt-1">
                                    Este objetivo no tiene metas registradas.
                                </small>
                            )}
                            {metasParaSelect.length === 0 && (objetivo.metas || []).length > 0 && (
                                <small className="text-muted d-block mt-1">
                                    Ya agregaste todas las metas disponibles.
                                </small>
                            )}
                        </div>
                    )}

                    {/* Renderizar metas agregadas */}
                    {objetivo.metas && objetivo.metas.map((meta) => renderMeta(meta, objetivo.id))}
                    <button
                        type="button"
                        className="border bg-blue-500  text-white p-2 rounded-pill"
                        onClick={() => {
                            const newMeta = {
                                id: `meta-virtual-${uniqueId()}`,
                                descripcion: 'Nueva meta',
                                objetivo_id: objetivo.id,
                                indicadores: [],
                            };
                            setFormData((prev) => ({
                                ...prev,
                                objetivos: prev.objetivos.map((o) =>
                                    o.id === objetivo.id
                                        ? { ...o, metas: [...(o.metas || []), newMeta] }
                                        : o
                                ),
                            }));
                        }}
                    >
                        <i className="fas fa-plus"></i> Nueva meta
                    </button>
                </div>
            </div>
        );
    };
    const handleSubmit = (e) => {
        // evita que se mande automáticamente
        e.preventDefault();

        for (const objetivo of formData.objetivos) {
            for (const meta of objetivo.metas || []) {
                // Validar que la meta tenga al menos un indicador
                if (!meta.indicadores || meta.indicadores.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Indicador requerido',
                        text: `La meta "${meta.descripcion}" debe tener al menos un indicador.`,
                    });
                    return;
                }

                // Validar cada indicador de la meta
                for (const indicador of meta.indicadores || []) {
                    // Validar que el indicador tenga campos completos
                    if (!indicador.unidad_total || indicador.unidad_total.trim() === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unidad Total requerida',
                            text: `Todos los indicadores de la meta "${meta.descripcion}" deben tener una Unidad Total.`,
                        });
                        return;
                    }

                    if (!indicador.unidad_parcial || indicador.unidad_parcial.trim() === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unidad Parcial requerida',
                            text: `Todos los indicadores de la meta "${meta.descripcion}" deben tener una Unidad Parcial.`,
                        });
                        return;
                    }

                    if (!indicador.valor_requerido || indicador.valor_requerido <= 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Valor Requerido inválido',
                            text: `Todos los indicadores de la meta "${meta.descripcion}" deben tener un Valor Requerido mayor a 0.`,
                        });
                        return;
                    }

                    // Validar pesos del indicador
                    const restante = calcularRestanteIndicador(indicador);
                    if (restante !== 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en pesos',
                            text: `El indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" de la meta "${meta.descripcion}" no tiene pesos correctos. Debe sumar 100%, actualmente está en ${100 - restante}%.`,
                        });
                        return;
                    }

                    // Validar valor requerido vs max_suma_indicador
                    const sumaIndicadores = calcularSumaIndicadores(indicador);
                    if (sumaIndicadores > 0 && indicador.valor_requerido !== sumaIndicadores) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en valor requerido',
                            text: `El indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" de la meta "${meta.descripcion}" tiene un valor requerido de ${indicador.valor_requerido}, pero debe ser igual a la suma de los valores de las actividades (${sumaIndicadores}).`,
                        });
                        return;
                    }

                    // Validar que el indicador tenga al menos una actividad
                    if (!indicador.actividades || indicador.actividades.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Actividades requeridas',
                            text: `El indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" de la meta "${meta.descripcion}" debe tener al menos una actividad.`,
                        });
                        return;
                    }

                    // Validar fechas de actividades del indicador
                    for (const actividad of indicador.actividades || []) {
                        // Validación de descripción
                        if (!actividad.descripcion || actividad.descripcion.trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Descripción requerida',
                                text: `Todas las actividades deben tener una descripción. Revisa las actividades del indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" de la meta "${meta.descripcion}".`,
                            });
                            return;
                        }

                        // Validación de fechas
                        if (!actividad.fecha_inicio || !actividad.fecha_fin) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Fechas incompletas',
                                text: `La actividad "${actividad.descripcion}" del indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" debe tener fecha de inicio y de fin.`,
                            });
                            return;
                        }
                        // Validación de instrumentos de recolección
                        if (!actividad.instrumentos_recoleccion) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Instrumentos de recolección',
                                text: `La actividad "${actividad.descripcion}" del indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" debe tener almenos un instrumento de recolección.`,
                            });
                            return;
                        }
                        // Validación de frecuencia de recolección
                        if (!actividad.frecuencia_recoleccion) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Frecuencia de recolección',
                                text: `La actividad "${actividad.descripcion}" del indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" debe tener una frecuencia de recolección.`,
                            });
                            return;
                        }
                        // Validación de responsables
                        if (!actividad.responsables) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Responsables',
                                text: `La actividad "${actividad.descripcion}" del indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" debe tener almenos un responsable.`,
                            });
                            return;
                        }
                        if (new Date(actividad.fecha_inicio) > new Date(actividad.fecha_fin)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error en fechas',
                                text: `La actividad "${actividad.descripcion}" del indicador "${indicador.unidad_parcial}/${indicador.unidad_total}" tiene la fecha de inicio posterior a la de fin.`,
                            });
                            return;
                        }
                    }
                }
            }
        }

        // si pasa todas las validaciones, envía el formulario real
        e.target.submit();
    };
    // Calcula la suma de pesos de todas las actividades de una meta
    const calcularSumaPesosIndicador = (indicador) => {
        return (indicador.actividades || []).reduce(
            (acc, act) => acc + (parseFloat(act.peso) || 0),
            0
        );
    };

    // Cuánto falta para llegar a 100
    const calcularRestanteIndicador = (indicador) => {
        return 100 - calcularSumaPesosIndicador(indicador);
    };
    // Suma los max_suma_indicador de actividades que afectan el indicador
    const calcularSumaIndicadores = (indicador) => {
        return (indicador.actividades || [])
            .filter((act) => act.afecta_indicador)
            .reduce((acc, act) => acc + (parseFloat(act.max_suma_indicador) || 0), 0);
    };

    return (
        <div className="container py-4">
            <div className="card shadow">
                <div className="card-header bg-white">
                    <h1 className="h3 mb-0">Edición del factor crítico</h1>
                    <p className="mb-0 text-muted">Factor crítico: {factorCritico.descripcion}</p>
                </div>
                <div className="card-body">
                    <button
                        type="button"
                        className="border bg-blue-500  text-white p-2 rounded-pill"
                        onClick={agregarObjetivo}
                    >
                        <i className="fas fa-plus-circle"></i> Agregar Objetivo
                    </button>

                    <div id="objetivos-container">
                        {formData.objetivos.map((objetivo) => renderObjetivo(objetivo))}
                    </div>

                    <form method="POST" action={agregarUrl} onSubmit={handleSubmit}>
                        <input type="hidden" name="_token" value={csrfToken} />
                        <input type="hidden" name="institucionId" value={institucionId} />

                        {/* Recorrer objetivos */}
                        {formData.objetivos.map((objetivo, i) => (
                            <React.Fragment key={objetivo.id}>
                                <input
                                    type="hidden"
                                    name={`objetivos[${i}][id]`}
                                    value={objetivo.id}
                                />
                                <input
                                    type="hidden"
                                    name={`objetivos[${i}][descripcion]`}
                                    value={objetivo.descripcion}
                                />
                                <input
                                    type="hidden"
                                    name={`objetivos[${i}][objetivo_general_id]`}
                                    value={objetivo.objetivo_general_id || ''}
                                />

                                {/* Recorrer metas */}
                                {objetivo.metas &&
                                    objetivo.metas.map((meta, j) => (
                                        <React.Fragment key={meta.id}>
                                            <input
                                                type="hidden"
                                                name={`objetivos[${i}][metas][${j}][id]`}
                                                value={meta.id}
                                            />
                                            <input
                                                type="hidden"
                                                name={`objetivos[${i}][metas][${j}][descripcion]`}
                                                value={meta.descripcion}
                                            />
                                            <input
                                                type="hidden"
                                                name={`objetivos[${i}][metas][${j}][objetivo_id]`}
                                                value={meta.objetivo_id}
                                            />

                                            {/* Recorrer indicadores */}
                                            {meta.indicadores &&
                                                meta.indicadores.map((indicador, k) => (
                                                    <React.Fragment key={indicador.id}>
                                                        <input
                                                            type="hidden"
                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][id]`}
                                                            value={indicador.id}
                                                        />
                                                        <input
                                                            type="hidden"
                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][unidad_total]`}
                                                            value={indicador.unidad_total}
                                                        />
                                                        <input
                                                            type="hidden"
                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][unidad_parcial]`}
                                                            value={indicador.unidad_parcial}
                                                        />
                                                        <input
                                                            type="hidden"
                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][valor_requerido]`}
                                                            value={indicador.valor_requerido}
                                                        />
                                                        <input
                                                            type="hidden"
                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][meta_id]`}
                                                            value={indicador.meta_id}
                                                        />

                                                        {/* Recorrer actividades */}
                                                        {indicador.actividades &&
                                                            indicador.actividades.map(
                                                                (actividad, l) => (
                                                                    <React.Fragment
                                                                        key={actividad.id}
                                                                    >
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][id]`}
                                                                            value={actividad.id}
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][descripcion]`}
                                                                            value={
                                                                                actividad.descripcion
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][peso]`}
                                                                            value={actividad.peso}
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][max_suma_indicador]`}
                                                                            value={
                                                                                actividad.max_suma_indicador
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][afecta_indicador]`}
                                                                            value={
                                                                                actividad.afecta_indicador
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][responsables]`}
                                                                            value={
                                                                                actividad.responsables
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][instrumentos_recoleccion]`}
                                                                            value={
                                                                                actividad.instrumentos_recoleccion
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][frecuencia_recoleccion]`}
                                                                            value={
                                                                                actividad.frecuencia_recoleccion
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][recursos]`}
                                                                            value={
                                                                                actividad.recursos
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][fecha_inicio]`}
                                                                            value={
                                                                                actividad.fecha_inicio
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][fecha_fin]`}
                                                                            value={
                                                                                actividad.fecha_fin
                                                                            }
                                                                        />
                                                                        <input
                                                                            type="hidden"
                                                                            name={`objetivos[${i}][metas][${j}][indicadores][${k}][actividades][${l}][indicador_id]`}
                                                                            value={
                                                                                actividad.indicador_id
                                                                            }
                                                                        />
                                                                    </React.Fragment>
                                                                )
                                                            )}
                                                    </React.Fragment>
                                                ))}
                                        </React.Fragment>
                                    ))}
                            </React.Fragment>
                        ))}

                        <button
                            type="submit"
                            className="border bg-blue-500  text-white p-2 rounded-pill me-2"
                            disabled={formData.objetivos.length === 0}
                        >
                            <i className="fas fa-save"></i> {isEditing ? 'Actualizar' : 'Guardar'}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default FactorCriticoEdit;
