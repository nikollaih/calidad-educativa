import React, { useState, useEffect } from 'react';
import { route } from 'preact-router';
import Swal from 'sweetalert2';
import TextMultipleTags from "@/components/shared/TextMultipleTags.jsx";

const FactorCriticoEdit = ({ id, csrfToken = '', factorCritico = {}, pmiId = -1, institucionId = -1, objetivosGenerales, agregarUrl = '' }) => {
    const [formData, setFormData] = useState({
        objetivos: [], // Array de objetivos
    });
    const [isLoading, setIsLoading] = useState(true);
    const [isEditing, setIsEditing] = useState(false);
    const [originalData, setOriginalData] = useState(null);

    useEffect(() => {
        if(factorCritico.objetivos.length > 0){
             console.log('primera carga',factorCritico);
            setFormData(prev => ({
                objetivos: factorCritico.objetivos
            }));
        }

    },[]);
    useEffect(() => {
        console.log(formData);
    },[formData]);
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
     * Función para manejar la selección de un objetivo del dropdown
     */
    const handleObjetivoChange = (objetivoId, objetivoGeneralSeleccionadoId) => {
        const objetivoGeneralSeleccionado = objetivosGenerales.find(
            obj => obj.id === parseInt(objetivoGeneralSeleccionadoId)
        );

        if (!objetivoGeneralSeleccionado) return;

        const generateUniqueId = () =>'virtual-unique-id' + Date.now() + Math.random();

        setFormData(prevData => ({
            ...prevData,
            objetivos: prevData.objetivos.map(objetivo => {
                if (objetivo.id === objetivoId) {
                    return {
                        ...objetivo,
                        descripcion: objetivoGeneralSeleccionado.descripcion,
                        objetivo_general_id: objetivoGeneralSeleccionado.id,
                        metas: objetivoGeneralSeleccionado.metas ?
                            objetivoGeneralSeleccionado.metas.map(meta => ({
                                id: generateUniqueId(),
                                descripcion: meta.descripcion,
                                unidad_medida: meta.unidad_medida,
                                valor_requerido: meta.valor_requerido,
                                objetivo_id: objetivoId,
                                actividades: meta.actividades ? meta.actividades.map(actividad => ({
                                    id: generateUniqueId(),
                                    descripcion: actividad.descripcion,
                                    peso: actividad.peso,
                                    accumulated: actividad.accumulated,
                                    responsables: '',
                                    fecha_inicio: '',
                                    fecha_fin: '',
                                    meta_id: meta.id
                                })) : []
                            })) : objetivo.metas || []
                    };
                }
                return objetivo;
            })
        }));
    };

    // Cargar datos cuando el componente se monta
    useEffect(() => {
        const fetchData = async () => {
            try {
                setIsLoading(true);

                if (!id || isNaN(id)) {
                    setIsEditing(false);
                    setIsLoading(false);
                    return;
                }

                const response = await fetch(`/pam/get-pam/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`Error HTTP! Estado: ${response.status}`);
                }

                const result = await response.json();

                if (result.success && result.data) {
                    const data = result.data;
                    setIsEditing(true);
                    setOriginalData(data);

                    // Mapear los datos del backend a la nueva estructura
                    const mappedData = {
                        objetivos: data.objetivos || []
                    };
                    setFormData(mappedData);

                } else {
                    throw new Error(result.message || 'Formato de datos inesperado');
                }
            } catch (err) {
                console.error('Error al cargar datos:', err);
                Swal.fire({
                    title: 'Error',
                    text: `No se pudo cargar el registro: ${err.message}`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    route('/pam');
                });
            } finally {
                setIsLoading(false);
            }
        };

        fetchData();
    }, [id]);

    // --- Funciones para agregar elementos ---

    const agregarObjetivo = () => {
        const newObjetivo = {
            id: `objetivo-virtual-${Date.now()}`,
            descripcion: '',
            objetivo_general_id: null,
            metas: []
        };

        setFormData(prev => ({
            ...prev,
            objetivos: [...prev.objetivos, newObjetivo]
        }));
    };

    const addMeta = (objetivoId) => {
        const newMeta = {
            id: `meta-virtual-${Date.now()}`,
            descripcion: '',
            unidad_medida: '',
            valor_requerido: 0,
            objetivo_id: objetivoId,
            actividades: []
        };

        setFormData(prev => ({
            ...prev,
            objetivos: prev.objetivos.map(objetivo =>
                objetivo.id === objetivoId
                    ? { ...objetivo, metas: [...objetivo.metas, newMeta] }
                    : objetivo
            )
        }));
    };

    const addActividad = (metaId) => {
        const newActividad = {
            id: `actividad-virtual-${Date.now()}`,
            descripcion: '',
            peso: 0,
            accumulated: 0,
            responsables: '',
            recursos: '',
            fecha_inicio: '',
            fecha_fin: '',
            meta_id: metaId
        };

        setFormData(prev => ({
            ...prev,
            objetivos: prev.objetivos.map(objetivo => ({
                ...objetivo,
                metas: objetivo.metas.map(meta =>
                    meta.id === metaId
                        ? { ...meta, actividades: [...meta.actividades, newActividad] }
                        : meta
                )
            }))
        }));
    };

    /**
     * Función para eliminar elementos
     */
    const removeElement = (type, itemId, parentId = null) => {
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
                            metas: objetivo.metas.filter(meta => meta.id !== itemId)
                        }))
                    };

                case 'actividad':
                    return {
                        ...prev,
                        objetivos: prev.objetivos.map(objetivo => ({
                            ...objetivo,
                            metas: objetivo.metas.map(meta => ({
                                ...meta,
                                actividades: meta.actividades.filter(act => act.id !== itemId)
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
                                disabled={true}
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
                                disabled={true}
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
                                    // Solo números
                                    const raw = e.target.value.replace(/\D+/g, '');
                                    // Convertir a entero o vacío
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
                            <input
                                type="text"
                                className="form-control"
                                value={meta.unidad_medida}
                                onChange={(e) => updateField(meta.id, 'unidad_medida', e.target.value)}
                                placeholder="Ej: Cantidad, Porcentaje, etc."
                                disabled={true}
                            />
                        </div>
                        <div className="col-md-6">
                            <label className="form-label fw-bold">Valor Requerido:</label>
                            <input
                                type="number"
                                className="form-control"
                                value={meta.valor_requerido}
                                onChange={(e) => updateField(meta.id, 'valor_requerido', parseInt(e.target.value) || 0)}
                                placeholder="0"
                                min="0"
                                disabled={true}
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
        return (
            <div key={objetivo.id} className="card mt-3 border-primary" style={{ width: '100%' }}>
                <div className="card-header bg-light d-flex justify-content-between align-items-center">
                    <h3 className="mb-0">Objetivo</h3>
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

                    {/* Mostrar la descripción completa del objetivo seleccionado */}
                    {objetivo.descripcion && (
                        <div className="mt-3">
                            <div className="alert alert-info">
                                <strong>Descripción del objetivo:</strong>
                                <p className="mb-2">{objetivo.descripcion}</p>
                            </div>
                        </div>
                    )}

                    {/* Renderizar las metas existentes */}
                    {objetivo.metas && objetivo.metas.map(meta =>
                        renderMeta(meta, objetivo.id)
                    )}
                </div>
            </div>
        );
    };

    if (isLoading) {
        return (
            <div className="container py-4 text-center">
                <div className="spinner-border text-primary" role="status">
                    <span className="visually-hidden">Cargando...</span>
                </div>
                <p className="mt-2">Cargando datos del registro...</p>
            </div>
        );
    }

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
                        <i className="bi bi-plus-circle"></i> Agregar Objetivo
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
                                        <input type="hidden" name={`objetivos[${i}][metas][${j}][unidad_medida]`} value={meta.unidad_medida} />
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
                            <i className="bi bi-save"></i> {isEditing ? 'Actualizar' : 'Guardar'}
                        </button>

                        <button
                            type="button"
                            className="btn btn-secondary"
                            onClick={() => window.location.href = "/pam/index"}
                        >
                            <i className="bi bi-arrow-left"></i> Volver al listado
                        </button>
                    </form>

                </div>
            </div>
        </div>
    );
};

export default FactorCriticoEdit;
