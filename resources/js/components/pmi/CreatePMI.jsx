import React, { useState } from 'react';

const IndexPMI = () => {
    const [areasGestion, setAreasGestion] = useState([
        {
            id: 'area-directiva',
            nombre: 'Directiva',
            descripcion: '',
            componentes: [],
        },
        {
            id: 'area-academica',
            nombre: 'Academica',
            descripcion: '',
            componentes: [],
        },
        {
            id: 'area-administrativa',
            nombre: 'Administrativa y financiera',
            descripcion: '',
            componentes: [],
        },
        {
            id: 'area-proyeccion',
            nombre: 'Proyeccion a la comunidad',
            descripcion: '',
            componentes: [],
        },
    ]);

    // Helper function for immutable nested updates
    const updateNested = (obj, path, value) => {
        if (path.length === 0) {
            return value;
        }

        const [key, ...restPath] = path;

        if (Array.isArray(obj)) {
            return obj.map((item, idx) =>
                idx === parseInt(key) ? updateNested(item, restPath, value) : item
            );
        } else if (typeof obj === 'object' && obj !== null) {
            return {
                ...obj,
                [key]: updateNested(obj[key], restPath, value),
            };
        }
        return obj;
    };

    // Function to update a field using the new updateNested helper
    const updateField = (path, field, value) => {
        setAreasGestion((prev) => {
            const fullPath = [...path, field];
            return updateNested(prev, fullPath, value);
        });
    };

    // Función para agregar componente a un área
    const addComponente = (areaIndex) => {
        const newComponente = {
            id: `componente-${Date.now()}`,
            descripcion: '',
            factoresCriticos: [],
        };
        setAreasGestion((prev) => {
            const newAreas = [...prev];
            newAreas[areaIndex] = {
                ...newAreas[areaIndex],
                componentes: [...newAreas[areaIndex].componentes, newComponente],
            };
            return newAreas;
        });
    };

    // Función para agregar factor crítico a un componente
    const addFactorCritico = (areaIndex, componenteIndex) => {
        const newFactorCritico = {
            id: `factor-${Date.now()}`,
            descripcion: '',
            objetivos: [],
        };
        setAreasGestion((prev) => {
            const newAreas = [...prev];
            const updatedComponentes = [...newAreas[areaIndex].componentes];
            updatedComponentes[componenteIndex] = {
                ...updatedComponentes[componenteIndex],
                factoresCriticos: [...updatedComponentes[componenteIndex].factoresCriticos, newFactorCritico],
            };
            newAreas[areaIndex] = {
                ...newAreas[areaIndex],
                componentes: updatedComponentes,
            };
            return newAreas;
        });
    };

    // Función para agregar objetivo a un factor crítico
    const addObjetivo = (areaIndex, componenteIndex, factorIndex) => {
        const newObjetivo = {
            id: `objetivo-${Date.now()}`,
            descripcion: '',
            metas: [],
        };
        setAreasGestion((prev) => {
            const newAreas = [...prev];
            const updatedComponentes = [...newAreas[areaIndex].componentes];
            const updatedFactores = [...updatedComponentes[componenteIndex].factoresCriticos];
            updatedFactores[factorIndex] = {
                ...updatedFactores[factorIndex],
                objetivos: [...updatedFactores[factorIndex].objetivos, newObjetivo],
            };
            updatedComponentes[componenteIndex] = {
                ...updatedComponentes[componenteIndex],
                factoresCriticos: updatedFactores,
            };
            newAreas[areaIndex] = {
                ...newAreas[areaIndex],
                componentes: updatedComponentes,
            };
            return newAreas;
        });
    };

    // Función para agregar meta a un objetivo
    const addMeta = (areaIndex, componenteIndex, factorIndex, objetivoIndex) => {
        const newMeta = {
            id: `meta-${Date.now()}`,
            descripcion: '',
            indicadores: [],
        };
        setAreasGestion((prev) => {
            const newAreas = [...prev];
            const updatedComponentes = [...newAreas[areaIndex].componentes];
            const updatedFactores = [...updatedComponentes[componenteIndex].factoresCriticos];
            const updatedObjetivos = [...updatedFactores[factorIndex].objetivos];
            updatedObjetivos[objetivoIndex] = {
                ...updatedObjetivos[objetivoIndex],
                metas: [...updatedObjetivos[objetivoIndex].metas, newMeta],
            };
            updatedFactores[factorIndex] = {
                ...updatedFactores[factorIndex],
                objetivos: updatedObjetivos,
            };
            updatedComponentes[componenteIndex] = {
                ...updatedComponentes[componenteIndex],
                factoresCriticos: updatedFactores,
            };
            newAreas[areaIndex] = {
                ...newAreas[areaIndex],
                componentes: updatedComponentes,
            };
            return newAreas;
        });
    };

    // Función para agregar indicador a una meta
    const addIndicador = (areaIndex, componenteIndex, factorIndex, objetivoIndex, metaIndex) => {
        const newIndicador = {
            id: `indicador-${Date.now()}`,
            descripcion: '',
        };
        setAreasGestion((prev) => {
            const newAreas = [...prev];
            const updatedComponentes = [...newAreas[areaIndex].componentes];
            const updatedFactores = [...updatedComponentes[componenteIndex].factoresCriticos];
            const updatedObjetivos = [...updatedFactores[factorIndex].objetivos];
            const updatedMetas = [...updatedObjetivos[objetivoIndex].metas];
            updatedMetas[metaIndex] = {
                ...updatedMetas[metaIndex],
                indicadores: [...updatedMetas[metaIndex].indicadores, newIndicador],
            };
            updatedObjetivos[objetivoIndex] = {
                ...updatedObjetivos[objetivoIndex],
                metas: updatedMetas,
            };
            updatedFactores[factorIndex] = {
                ...updatedFactores[factorIndex],
                objetivos: updatedObjetivos,
            };
            updatedComponentes[componenteIndex] = {
                ...updatedComponentes[componenteIndex],
                factoresCriticos: updatedFactores,
            };
            newAreas[areaIndex] = {
                ...newAreas[areaIndex],
                componentes: updatedComponentes,
            };
            return newAreas;
        });
    };

    // Función para eliminar un elemento
    const removeElement = (path) => {
        if (!window.confirm('¿Estás seguro de que deseas eliminar este elemento y todos sus elementos hijos?')) {
            return;
        }

        setAreasGestion((prev) => {
            const newAreas = JSON.parse(JSON.stringify(prev));
            let current = newAreas;
            let parent = null;
            let lastIndex = path[path.length - 1];

            for (let i = 0; i < path.length - 1; i++) {
                parent = current;
                current = current[path[i]];
            }

            if (Array.isArray(current)) {
                current.splice(lastIndex, 1);
            } else if (parent && lastIndex in parent) {
                if (typeof parent === 'object' && parent !== null) {
                    if (Array.isArray(parent)) {
                        parent.splice(lastIndex, 1);
                    } else {
                        delete parent[lastIndex];
                    }
                }
            }
            return newAreas;
        });
    };

    // Función para guardar todo
    const saveAll = () => {
        console.log('Datos del PMI:', areasGestion);
        alert('Datos guardados (ver consola)');
    };

    // Componente para renderizar indicador
    const renderIndicador = (indicador, path) => {
        return (
            <div className="card mb-2 border-secondary" style={{ width: '100%' }}>
                <div className="card-header bg-secondary bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h6 className="mb-0 text-sm">Indicador</h6>
                    <button
                        className="btn btn-danger btn-sm"
                        onClick={() => removeElement(path)}
                    >
                        Eliminar
                    </button>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <label className="form-label fw-bold">Descripción:</label>
                        <textarea
                            className="form-control"
                            rows="2"
                            value={indicador.descripcion}
                            onChange={(e) => updateField(path, 'descripcion', e.target.value)}
                        />
                    </div>
                </div>
            </div>
        );
    };

    // Componente para renderizar meta
    const renderMeta = (meta, path, areaIndex, componenteIndex, factorIndex, objetivoIndex, metaIndex) => {
        return (
            <div className="card mb-3 border-info" style={{ width: '100%' }}>
                <div className="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h6 className="mb-0">Meta</h6>
                    <button
                        className="btn btn-danger btn-sm"
                        onClick={() => removeElement(path)}
                    >
                        Eliminar Meta
                    </button>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <label className="form-label fw-bold">Descripción:</label>
                        <textarea
                            className="form-control"
                            rows="3"
                            value={meta.descripcion}
                            onChange={(e) => updateField(path, 'descripcion', e.target.value)}
                        />
                    </div>
                    {meta.descripcion && (
                        <div className="mt-3">
                            <button
                                className="btn btn-primary btn-sm mt-2"
                                onClick={() => addIndicador(areaIndex, componenteIndex, factorIndex, objetivoIndex, metaIndex)}
                            >
                                Agregar Indicador
                            </button>
                        </div>
                    )}
                    <div className="ms-3">
                        {meta.indicadores?.map((indicador, i) =>
                            renderIndicador(indicador, [...path, 'indicadores', i])
                        )}
                    </div>
                </div>
            </div>
        );
    };

    // Componente para renderizar objetivo
    const renderObjetivo = (objetivo, path, areaIndex, componenteIndex, factorIndex, objetivoIndex) => {
        return (
            <div className="card mb-3 border-warning" style={{ width: '100%' }}>
                <div className="card-header bg-warning bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h6 className="mb-0">Objetivo</h6>
                    <button
                        className="btn btn-danger btn-sm"
                        onClick={() => removeElement(path)}
                    >
                        Eliminar Objetivo
                    </button>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <label className="form-label fw-bold">Descripción:</label>
                        <textarea
                            className="form-control"
                            rows="3"
                            value={objetivo.descripcion}
                            onChange={(e) => updateField(path, 'descripcion', e.target.value)}
                        />
                    </div>
                    {objetivo.descripcion && (
                        <div className="mt-3">
                            <button
                                className="btn btn-primary btn-sm mt-2"
                                onClick={() => addMeta(areaIndex, componenteIndex, factorIndex, objetivoIndex)}
                            >
                                Agregar Meta
                            </button>
                        </div>
                    )}
                    <div className="ms-3">
                        {objetivo.metas?.map((meta, i) =>
                            renderMeta(meta, [...path, 'metas', i], areaIndex, componenteIndex, factorIndex, objetivoIndex, i)
                        )}
                    </div>
                </div>
            </div>
        );
    };

    // Componente para renderizar factor crítico
    const renderFactorCritico = (factor, path, areaIndex, componenteIndex, factorIndex) => {
        return (
            <div className="card mb-3 border-danger" style={{ width: '100%' }}>
                <div className="card-header bg-danger bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h5 className="mb-0">Factor Crítico</h5>
                    <button
                        className="btn btn-danger btn-sm"
                        onClick={() => removeElement(path)}
                    >
                        Eliminar Factor
                    </button>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <label className="form-label fw-bold">Descripción:</label>
                        <textarea
                            className="form-control"
                            rows="3"
                            value={factor.descripcion}
                            onChange={(e) => updateField(path, 'descripcion', e.target.value)}
                        />
                    </div>
                    {factor.descripcion && (
                        <div className="mt-3">
                            <button
                                className="btn btn-primary mt-2"
                                onClick={() => addObjetivo(areaIndex, componenteIndex, factorIndex)}
                            >
                                Agregar Objetivo
                            </button>
                        </div>
                    )}
                    <div className="ms-4">
                        {factor.objetivos?.map((objetivo, i) =>
                            renderObjetivo(objetivo, [...path, 'objetivos', i], areaIndex, componenteIndex, factorIndex, i)
                        )}
                    </div>
                </div>
            </div>
        );
    };

    // Componente para renderizar componente
    const renderComponente = (componente, path, areaIndex, componenteIndex) => {
        return (
            <div className="card mb-3 border-success" style={{ width: '100%' }}>
                <div className="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h5 className="mb-0">Componente</h5>
                    <button
                        className="btn btn-danger btn-sm"
                        onClick={() => removeElement(path)}
                    >
                        Eliminar Componente
                    </button>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <label className="form-label fw-bold">Descripción:</label>
                        <textarea
                            className="form-control"
                            rows="3"
                            value={componente.descripcion}
                            onChange={(e) => updateField(path, 'descripcion', e.target.value)}
                        />
                    </div>
                    {componente.descripcion && (
                        <div className="mt-3">
                            <button
                                className="btn btn-primary mt-2"
                                onClick={() => addFactorCritico(areaIndex, componenteIndex)}
                            >
                                Agregar Factor Crítico
                            </button>
                        </div>
                    )}
                    <div className="ms-4">
                        {componente.factoresCriticos?.map((factor, i) =>
                            renderFactorCritico(factor, [...path, 'factoresCriticos', i], areaIndex, componenteIndex, i)
                        )}
                    </div>
                </div>
            </div>
        );
    };

    // Componente para renderizar área de gestión
    const renderAreaGestion = (area, index) => {
        return (
            <div className="card mb-4 border-primary" style={{ width: '100%' }}>
                <div className="card-header bg-primary bg-opacity-10">
                    <h3 className="mb-0 text-white">{area.nombre}</h3>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <label className="form-label fw-bold">Descripción del Área:</label>
                        <textarea
                            className="form-control"
                            rows="3"
                            value={area.descripcion}
                            onChange={(e) => updateField([index], 'descripcion', e.target.value)}
                        />
                    </div>
                    {area.descripcion && (
                        <div className="mt-3">
                            <button
                                className="btn btn-primary mt-2"
                                onClick={() => addComponente(index)}
                            >
                                Agregar Componente
                            </button>
                        </div>
                    )}
                    <div className="ms-4">
                        {area.componentes?.map((componente, i) =>
                            renderComponente(componente, [index, 'componentes', i], index, i)
                        )}
                    </div>
                </div>
            </div>
        );
    };

    return (
        <div className="container py-4">
            <div className="card shadow-lg">
                <div className="card-header bg-white border-bottom">
                    <h1 className="h3 mb-0 text-center">Plan de Mejoramiento Institucional (PMI)</h1>
                    <p className="mb-0 text-muted text-center">Áreas de Gestión - Complete cada descripción para habilitar el siguiente nivel</p>
                </div>
                <div className="card-body">

                    <div id="areas-container">
                        {areasGestion.map((area, i) => renderAreaGestion(area, i))}
                    </div>

                    <div className="mt-4 pt-3 border-top text-center">
                        <button
                            type="button"
                            className="btn btn-success btn-lg"
                            onClick={saveAll}
                        >
                            💾 Guardar Plan Completo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default IndexPMI;
