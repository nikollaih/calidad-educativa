import React, { useState, useEffect } from 'react';
import { route } from 'preact-router';
import Swal from 'sweetalert2';
import TextMultipleTags from "@/components/shared/TextMultipleTags.jsx";
import CAutocompleteFromArray from "@/components/shared/CAutocompleteFromArray.jsx";
import { h } from "preact";

const uniqueId = (p = 'v-') => `${p}${Date.now()}-${Math.random().toString(36).slice(2, 8)}`;

const FactorCriticoEdit = ({
                               id,
                               csrfToken = '',
                               factorCritico = {},
                               pmiId = -1,
                               institucionId = -1,
                               objetivosGenerales,
                               agregarUrl = '',
                               indicadores = []
                           }) => {
    const [formData, setFormData] = useState({
        objetivos: [], // Array de objetivos
    });
    const [isEditing, setIsEditing] = useState(false);
    const [originalData, setOriginalData] = useState(null);

    // Mapa objetivoId -> metaId seleccionada en el select
    const [selectedMetaByObjetivo, setSelectedMetaByObjetivo] = useState({});

    useEffect(() => {
        if (factorCritico?.objetivos?.length > 0) {
            setFormData(prev => ({
                objetivos: factorCritico.objetivos
            }));
        }
    }, []);

    useEffect(() => {
        // console.log('formData', formData);
    }, [formData]);

    /**
     * Helper para encontrar y actualizar un campo específico de un elemento anidado
     */
    const updateItemField = (items, targetId, fieldName, newValue) => {
        return items.map(item => {
            if (item.id === targetId) {
                return { ...item, [fieldName]: newValue };
            }

            // Buscar en metas
            if (item.metas) {
                return {
                    ...item,
                    metas: updateItemField(item.metas, targetId, fieldName, newValue)
                };
            }

            // Buscar en actividades
            if (item.actividades) {
                return {
                    ...item,
                    actividades: updateItemField(item.actividades, targetId, fieldName, newValue)
                };
            }

            return item;
        });
    };

    /**
     * Función para actualizar campos específicos
     */
    const updateField = (itemId, fieldName, value) => {
        setFormData(prevFormData => ({
            ...prevFormData,
            objetivos: updateItemField(prevFormData.objetivos, itemId, fieldName, value)
        }));
    };

    /**
     * Al seleccionar un objetivo general: setea su descripción e ID,
     * limpia metas y resetea la meta seleccionada para ese objetivo.
     */
    const handleObjetivoChange = (objetivoId, objetivoGeneralSeleccionadoId) => {
        const objetivoGeneralSeleccionado = objetivosGenerales.find(
            obj => obj.id === parseInt(objetivoGeneralSeleccionadoId, 10)
        );

        if (!objetivoGeneralSeleccionado) return;

        setFormData(prevData => ({
            ...prevData,
            objetivos: prevData.objetivos.map(objetivo => {
                if (objetivo.id === objetivoId) {
                    return {
                        ...objetivo,
                        descripcion: objetivoGeneralSeleccionado.descripcion,
                        objetivo_general_id: objetivoGeneralSeleccionado.id,
                        metas: [] // Se agregan con el botón "Agregar meta"
                    };
                }
                return objetivo;
            })
        }));

        // Reset del select de metas para ese objetivo
        setSelectedMetaByObjetivo(prev => ({ ...prev, [objetivoId]: '' }));
    };

    // --- Funciones para agregar elementos ---

    const agregarObjetivo = () => {
        const newObjetivo = {
            id: `objetivo-virtual-${uniqueId()}`,
            descripcion: '',
            objetivo_general_id: null,
            metas: []
        };

        setFormData(prev => ({
            ...prev,
            objetivos: [...prev.objetivos, newObjetivo]
        }));
    };

    const addMetaFromSelect = (objetivo) => {
        const selectedMetaId = selectedMetaByObjetivo[objetivo.id];
        if (!selectedMetaId) return;

        const objetivoGeneral = objetivosGenerales.find(obj => obj.id === objetivo.objetivo_general_id);
        const metaSeleccionada = objetivoGeneral?.metas?.find(m => m.id === parseInt(selectedMetaId, 10));
        if (!metaSeleccionada) return;

        // Evitar agregar duplicados: comparamos por el ID real de la meta origen
        const yaExiste = (objetivo.metas || []).some(m => m.__source_meta_id === metaSeleccionada.id);
        if (yaExiste) {
            Swal.fire({
                icon: 'info',
                title: 'Meta ya agregada',
                text: 'Esta meta ya se encuentra en el listado.',
                timer: 1800,
                showConfirmButton: false
            });
            return;
        }

        const newMeta = {
            id: `meta-virtual-${uniqueId()}`,
            __source_meta_id: metaSeleccionada.id, // solo para control interno (no se envía)
            descripcion: metaSeleccionada.descripcion,
            indicador_id: metaSeleccionada.indicador_id ?? '',
            valor_requerido: metaSeleccionada.valor_requerido ?? 0,
            objetivo_id: objetivo.id,
            actividades: (metaSeleccionada.actividades || []).map(actividad => ({
                id: `actividad-virtual-${uniqueId()}`,
                descripcion: actividad.descripcion,
                peso: actividad.peso ?? 0,
                accumulated: actividad.accumulated ?? 0,
                responsables: '',
                fecha_inicio: '',
                fecha_fin: '',
                meta_id: metaSeleccionada.id
            }))
        };

        setFormData(prev => ({
            ...prev,
            objetivos: prev.objetivos.map(o =>
                o.id === objetivo.id
                    ? { ...o, metas: [...(o.metas || []), newMeta] }
                    : o
            )
        }));

        // Opcional: limpiar el select tras agregar
        setSelectedMetaByObjetivo(prev => ({ ...prev, [objetivo.id]: '' }));
    };

    /**
     * Función para eliminar elementos
     */
    const removeElement = (type, itemId) => {
        if (!confirm('¿Estás seguro de que deseas eliminar este elemento?')) {
            return;
        }

        setFormData(prev => {
            switch (type) {
                case 'objetivo':
                    return {
                        ...prev,
                        objetivos: prev.objetivos.filter(obj => obj.id !== itemId)
                    };

                case 'meta':
                    return {
                        ...prev,
                        objetivos: prev.objetivos.map(objetivo => ({
                            ...objetivo,
                            metas: (objetivo.metas || []).filter(meta => meta.id !== itemId)
                        }))
                    };

                case 'actividad':
                    return {
                        ...prev,
                        objetivos: prev.objetivos.map(objetivo => ({
                            ...objetivo,
                            metas: (objetivo.metas || []).map(meta => ({
                                ...meta,
                                actividades: (meta.actividades || []).filter(act => act.id !== itemId)
                            }))
                        }))
                    };

                default:
                    return prev;
            }
        });
    };

    // --- Funciones de Renderizado ---

    const renderActividad = (actividad, metaId) => {
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
                        <label className="form-label fw-bold">Descripción:</label>
                        <textarea
                            className="form-control"
                            rows="3"
                            value={actividad.descripcion}
                            onChange={(e) => updateField(actividad.id, 'descripcion', e.target.value)}
                            placeholder="Descripción de la actividad"
                            disabled={true}
                        />
                    </div>

                    <div className="row">
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Peso:</label>
                            <input
                                type="number"
                                className="form-control"
                                value={actividad.peso}
                                onChange={(e) => updateField(actividad.id, 'peso', parseFloat(e.target.value) || 0)}
                                placeholder="0"
                                min="0"
                                max="100"
                                step="0.01"
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Sumará a la meta:</label>
                            <input
                                type="number"
                                className="form-control"
                                value={actividad.accumulated}
                                onChange={(e) => updateField(actividad.id, 'accumulated', parseFloat(e.target.value) || 0)}
                                placeholder="0"
                                min="0"
                                step="0.01"
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Responsables:</label>
                            <TextMultipleTags
                                initialValue={actividad.responsables}
                                label={"Responsables"}
                                onTagsChange={(joinedTags) => {
                                    updateField(actividad.id, 'responsables', joinedTags)
                                }}
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Recursos:</label>
                            <input
                                type="text"
                                className="form-control"
                                value={
                                    actividad.recursos === null || actividad.recursos === undefined || actividad.recursos === ''
                                        ? ''
                                        : new Intl.NumberFormat('es-CO').format(actividad.recursos)
                                }
                                onChange={(e) => {
                                    const raw = e.target.value.replace(/\D+/g, '');
                                    const numberValue = raw === '' ? '' : parseInt(raw, 10);
                                    updateField(actividad.id, 'recursos', numberValue);
                                }}
                                placeholder="Ejm: 12.000"
                                inputMode="numeric"
                                pattern="[0-9]*"
                                required={true}
                            />
                        </div>
                    </div>

                    <div className="row mt-3">
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Fecha de Inicio:</label>
                            <input
                                type="date"
                                className="form-control"
                                value={actividad.fecha_inicio}
                                onChange={(e) => updateField(actividad.id, 'fecha_inicio', e.target.value)}
                                required={true}
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Fecha de Fin:</label>
                            <input
                                type="date"
                                className="form-control"
                                value={actividad.fecha_fin}
                                onChange={(e) => updateField(actividad.id, 'fecha_fin', e.target.value)}
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
                    <h5 className="mb-0">Meta</h5>
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
                        <label className="form-label fw-bold">Descripción:</label>
                        <textarea
                            className="form-control"
                            rows="3"
                            value={meta.descripcion}
                            onChange={(e) => updateField(meta.id, 'descripcion', e.target.value)}
                            placeholder="Descripción de la meta"
                            disabled={true}
                        />
                    </div>

                    <div className="row">
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Unidad de Medida:</label>
                            <CAutocompleteFromArray
                                data={indicadores}
                                isEditable={false}
                                initialValue={meta.indicador_id}
                                fieldName={"indicador_id"}
                                searchFields={['unidad_total', 'unidad_parcial']}
                                labelFields={['unidad_parcial', 'unidad_total']}
                                onSelect={(unidadMedida) => {
                                    updateField(meta.id, 'indicador_id', unidadMedida.id)
                                }}
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Valor Requerido:</label>
                            <input
                                type="number"
                                className="form-control"
                                value={meta.valor_requerido}
                                onChange={(e) => updateField(meta.id, 'valor_requerido', parseInt(e.target.value, 10) || 0)}
                                placeholder="0"
                                min="0"
                            />
                        </div>
                    </div>

                    {/* Renderizar actividades */}
                    {meta.actividades && meta.actividades.map(actividad =>
                        renderActividad(actividad, meta.id)
                    )}
                </div>
            </div>
        );
    };

    const renderObjetivo = (objetivo) => {
        // Metas disponibles según objetivo + filtradas para no repetir las ya agregadas
        const metasDisponibles = objetivosGenerales.find(obj => obj.id === objetivo.objetivo_general_id)?.metas || [];
        const metasYaAgregadasIds = new Set((objetivo.metas || []).map(m => m.__source_meta_id).filter(Boolean));
        const metasParaSelect = metasDisponibles.filter(m => !metasYaAgregadasIds.has(m.id));
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
                    <div className="mb-3">
                        <label className="form-label fw-bold">Seleccione un objetivo:</label>
                        <select
                            className="form-control"
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
                                        ? objetivoGeneral.descripcion.substring(0, 120) + "..."
                                        : objetivoGeneral.descripcion}
                                </option>
                            ))}
                        </select>
                    </div>
                    {/* Descripción completa del objetivo seleccionado */}
                    {objetivo.descripcion && (
                        <div className="mt-3">
                            <div className="alert alert-info">
                                <strong>Descripción del objetivo:</strong>
                                <p className="mb-2">{objetivo.descripcion}</p>
                            </div>
                        </div>
                    )}
                    {/* Select de metas + botón agregar */}
                    {objetivo.objetivo_general_id && (
                        <div className="mb-3">
                            <label className="form-label fw-bold">Metas del objetivo:</label>
                            <div className="d-flex gap-2">
                                <select
                                    className="form-control"
                                    value={selectedMetaId}
                                    onChange={(e) =>
                                        setSelectedMetaByObjetivo(prev => ({ ...prev, [objetivo.id]: e.target.value }))
                                    }
                                    style={{ maxWidth: '100%' }}
                                >
                                    <option value="">-- Seleccione una meta --</option>
                                    {metasParaSelect.map(meta => (
                                        <option key={meta.id} value={meta.id}>
                                            {meta.descripcion.length > 120
                                                ? meta.descripcion.substring(0, 120) + "..."
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
                                <small className="text-muted d-block mt-1">Este objetivo no tiene metas registradas.</small>
                            )}
                            {metasParaSelect.length === 0 && (objetivo.metas || []).length > 0 && (
                                <small className="text-muted d-block mt-1">Ya agregaste todas las metas disponibles.</small>
                            )}
                        </div>
                    )}



                    {/* Renderizar metas agregadas */}
                    {objetivo.metas && objetivo.metas.map(meta =>
                        renderMeta(meta, objetivo.id)
                    )}
                </div>
            </div>
        );
    };

    return (
        <div className="container py-4">
            <div className="card shadow">
                <div className="card-header bg-white">
                    <h1 className="h3 mb-0">
                        Edición del factor crítico
                    </h1>
                    <p className="mb-0 text-muted">
                        Factor crítico: {factorCritico.descripcion}
                    </p>
                </div>
                <div className="card-body">
                    <button
                        type="button"
                        className="btn btn-success mb-4"
                        onClick={agregarObjetivo}
                    >
                        <i className="fas fa-plus-circle"></i> Agregar Objetivo
                    </button>

                    <div id="objetivos-container">
                        {formData.objetivos.map(objetivo => renderObjetivo(objetivo))}
                    </div>

                    <form method="POST" action={agregarUrl}>
                        <input type="hidden" name="_token" value={csrfToken} />

                        {/* Recorrer objetivos */}
                        {formData.objetivos.map((objetivo, i) => (
                            <React.Fragment key={objetivo.id}>
                                <input type="hidden" name={`objetivos[${i}][id]`} value={objetivo.id} />
                                <input type="hidden" name={`objetivos[${i}][descripcion]`} value={objetivo.descripcion} />
                                <input type="hidden" name={`objetivos[${i}][objetivo_general_id]`} value={objetivo.objetivo_general_id || ''} />

                                {/* Recorrer metas */}
                                {objetivo.metas && objetivo.metas.map((meta, j) => (
                                    <React.Fragment key={meta.id}>
                                        <input type="hidden" name={`objetivos[${i}][metas][${j}][id]`} value={meta.id} />
                                        <input type="hidden" name={`objetivos[${i}][metas][${j}][descripcion]`} value={meta.descripcion} />
                                        <input type="hidden" name={`objetivos[${i}][metas][${j}][indicador_id]`} value={meta.indicador_id} />
                                        <input type="hidden" name={`objetivos[${i}][metas][${j}][valor_requerido]`} value={meta.valor_requerido} />
                                        <input type="hidden" name={`objetivos[${i}][metas][${j}][objetivo_id]`} value={meta.objetivo_id} />

                                        {/* Recorrer actividades */}
                                        {meta.actividades && meta.actividades.map((actividad, k) => (
                                            <React.Fragment key={actividad.id}>
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][id]`} value={actividad.id} />
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][descripcion]`} value={actividad.descripcion} />
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][peso]`} value={actividad.peso} />
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][accumulated]`} value={actividad.accumulated} />
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][responsables]`} value={actividad.responsables} />
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][recursos]`} value={actividad.recursos} />
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][fecha_inicio]`} value={actividad.fecha_inicio} />
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][fecha_fin]`} value={actividad.fecha_fin} />
                                                <input type="hidden" name={`objetivos[${i}][metas][${j}][actividades][${k}][meta_id]`} value={actividad.meta_id} />
                                            </React.Fragment>
                                        ))}
                                    </React.Fragment>
                                ))}
                            </React.Fragment>
                        ))}

                        <button
                            type="submit"
                            className="btn btn-primary me-2"
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
