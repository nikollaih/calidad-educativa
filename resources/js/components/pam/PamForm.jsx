import { h } from 'preact';
import { useState } from 'preact/hooks';

const ComponentManagement = () => {
  const [components, setComponents] = useState([]);

  // Helper function for immutable nested updates
  const updateNested = (obj, path, value) => {
    if (path.length === 0) {
      return value;
    }

    const [key, ...restPath] = path;

    if (Array.isArray(obj)) {
      // If the current step is an array index
      return obj.map((item, idx) =>
        idx === parseInt(key) ? updateNested(item, restPath, value) : item
      );
    } else if (typeof obj === 'object' && obj !== null) {
      // If the current step is an object key
      return {
        ...obj,
        [key]: updateNested(obj[key], restPath, value),
      };
    }
    return obj; // Return original if not an object or array (e.g., a primitive value)
  };

  // Function to update a field using the new updateNested helper
  const updateField = (path, field, value) => {
    setComponents((prev) => {
      // Create a path that includes the field to update
      const fullPath = [...path, field];
      return updateNested(prev, fullPath, value);
    });
  };

  // Función para agregar un nuevo componente
  const addComponente = () => {
    const newComponent = {
      id: `componente-${Date.now()}`,
      descripcion: '',
      procesos: [],
    };
    setComponents((prev) => [...prev, newComponent]);
  };

  // Función para agregar un proceso a un componente
  const addProceso = (componenteIndex) => {
    const newProceso = {
      id: `proceso-${Date.now()}`,
      descripcion: '',
      subprocesos: [],
    };
    setComponents((prev) => {
      const newComponents = [...prev];
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: [...newComponents[componenteIndex].procesos, newProceso],
      };
      return newComponents;
    });
  };

  // Función para agregar un subproceso a un proceso
  const addSubproceso = (componenteIndex, procesoIndex) => {
    const newSubproceso = {
      id: `subproceso-${Date.now()}`,
      descripcion: '',
    };
    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: [...updatedProcesos[procesoIndex].subprocesos, newSubproceso],
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para agregar meta del plan de desarrollo a un subproceso
  const addMetaPlan = (componenteIndex, procesoIndex, subprocesoIndex) => {
    const newMetaPlan = {
      id: `meta-plan-${Date.now()}`,
      descripcion: '',
      objetivos: [],
    };
    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      const updatedSubprocesos = [...updatedProcesos[procesoIndex].subprocesos];
      updatedSubprocesos[subprocesoIndex] = {
        ...updatedSubprocesos[subprocesoIndex],
        meta_plan_desarrollo: newMetaPlan,
      };
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: updatedSubprocesos,
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para agregar objetivo a una meta del plan
  const addObjetivo = (componenteIndex, procesoIndex, subprocesoIndex) => {
    const newObjetivo = {
      id: `objetivo-${Date.now()}`,
      descripcion: '',
      meta: null,
    };

    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      const updatedSubprocesos = [...updatedProcesos[procesoIndex].subprocesos];
      const updatedMetaPlan = {
        ...updatedSubprocesos[subprocesoIndex].meta_plan_desarrollo,
        objetivos: [
          ...updatedSubprocesos[subprocesoIndex].meta_plan_desarrollo.objetivos,
          newObjetivo,
        ],
      };
      updatedSubprocesos[subprocesoIndex] = {
        ...updatedSubprocesos[subprocesoIndex],
        meta_plan_desarrollo: updatedMetaPlan,
      };
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: updatedSubprocesos,
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para agregar meta a un objetivo
  const addMeta = (componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    const newMeta = {
      id: `meta-${Date.now()}`,
      descripcion: '',
      indicador: null,
    };
    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      const updatedSubprocesos = [...updatedProcesos[procesoIndex].subprocesos];
      const updatedMetaPlan = {
        ...updatedSubprocesos[subprocesoIndex].meta_plan_desarrollo,
      };
      const updatedObjetivos = [...updatedMetaPlan.objetivos];
      updatedObjetivos[objetivoIndex] = {
        ...updatedObjetivos[objetivoIndex],
        meta: newMeta,
      };
      updatedMetaPlan.objetivos = updatedObjetivos;
      updatedSubprocesos[subprocesoIndex] = {
        ...updatedSubprocesos[subprocesoIndex],
        meta_plan_desarrollo: updatedMetaPlan,
      };
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: updatedSubprocesos,
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para agregar indicador a una meta
  const addIndicador = (componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    const newIndicador = {
      id: `indicador-${Date.now()}`,
      descripcion: '',
      accion: null,
    };

    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      const updatedSubprocesos = [...updatedProcesos[procesoIndex].subprocesos];
      const updatedMetaPlan = {
        ...updatedSubprocesos[subprocesoIndex].meta_plan_desarrollo,
      };
      const updatedObjetivos = [...updatedMetaPlan.objetivos];
      const updatedMeta = {
        ...updatedObjetivos[objetivoIndex].meta,
        indicador: newIndicador,
      };
      updatedObjetivos[objetivoIndex] = {
        ...updatedObjetivos[objetivoIndex],
        meta: updatedMeta,
      };
      updatedMetaPlan.objetivos = updatedObjetivos;
      updatedSubprocesos[subprocesoIndex] = {
        ...updatedSubprocesos[subprocesoIndex],
        meta_plan_desarrollo: updatedMetaPlan,
      };
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: updatedSubprocesos,
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para agregar acción a un indicador
  const addAccion = (componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    const newAccion = {
      id: `accion-${Date.now()}`,
      descripcion: '',
      responsable: null,
    };

    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      const updatedSubprocesos = [...updatedProcesos[procesoIndex].subprocesos];
      const updatedMetaPlan = {
        ...updatedSubprocesos[subprocesoIndex].meta_plan_desarrollo,
      };
      const updatedObjetivos = [...updatedMetaPlan.objetivos];
      const updatedMeta = {
        ...updatedObjetivos[objetivoIndex].meta,
      };
      const updatedIndicador = {
        ...updatedMeta.indicador,
        accion: newAccion,
      };
      updatedMeta.indicador = updatedIndicador;
      updatedObjetivos[objetivoIndex] = {
        ...updatedObjetivos[objetivoIndex],
        meta: updatedMeta,
      };
      updatedMetaPlan.objetivos = updatedObjetivos;
      updatedSubprocesos[subprocesoIndex] = {
        ...updatedSubprocesos[subprocesoIndex],
        meta_plan_desarrollo: updatedMetaPlan,
      };
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: updatedSubprocesos,
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para agregar responsable a una acción
  const addResponsable = (componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    const newResponsable = {
      id: `responsable-${Date.now()}`,
      descripcion: '',
      recursos: null,
    };
    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      const updatedSubprocesos = [...updatedProcesos[procesoIndex].subprocesos];
      const updatedMetaPlan = {
        ...updatedSubprocesos[subprocesoIndex].meta_plan_desarrollo,
      };
      const updatedObjetivos = [...updatedMetaPlan.objetivos];
      const updatedMeta = {
        ...updatedObjetivos[objetivoIndex].meta,
      };
      const updatedIndicador = {
        ...updatedMeta.indicador,
      };
      const updatedAccion = {
        ...updatedIndicador.accion,
        responsable: newResponsable,
      };
      updatedIndicador.accion = updatedAccion;
      updatedMeta.indicador = updatedIndicador;
      updatedObjetivos[objetivoIndex] = {
        ...updatedObjetivos[objetivoIndex],
        meta: updatedMeta,
      };
      updatedMetaPlan.objetivos = updatedObjetivos;
      updatedSubprocesos[subprocesoIndex] = {
        ...updatedSubprocesos[subprocesoIndex],
        meta_plan_desarrollo: updatedMetaPlan,
      };
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: updatedSubprocesos,
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para agregar recursos a un responsable
  const addRecursos = (componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    const newRecursos = {
      id: `recursos-${Date.now()}`,
      descripcion: '',
      fechas: null,
    };
    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      const updatedSubprocesos = [...updatedProcesos[procesoIndex].subprocesos];
      const updatedMetaPlan = {
        ...updatedSubprocesos[subprocesoIndex].meta_plan_desarrollo,
      };
      const updatedObjetivos = [...updatedMetaPlan.objetivos];
      const updatedMeta = {
        ...updatedObjetivos[objetivoIndex].meta,
      };
      const updatedIndicador = {
        ...updatedMeta.indicador,
      };
      const updatedAccion = {
        ...updatedIndicador.accion,
      };
      const updatedResponsable = {
        ...updatedAccion.responsable,
        recursos: newRecursos,
      };
      updatedAccion.responsable = updatedResponsable;
      updatedIndicador.accion = updatedIndicador;
      updatedMeta.indicador = updatedIndicador;
      updatedObjetivos[objetivoIndex] = {
        ...updatedObjetivos[objetivoIndex],
        meta: updatedMeta,
      };
      updatedMetaPlan.objetivos = updatedObjetivos;
      updatedSubprocesos[subprocesoIndex] = {
        ...updatedSubprocesos[subprocesoIndex],
        meta_plan_desarrollo: updatedMetaPlan,
      };
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: updatedSubprocesos,
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para agregar fechas a recursos
  const addFechas = (componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    const newFechas = {
      id: `fechas-${Date.now()}`,
      descripcion: '',
    };
    setComponents((prev) => {
      const newComponents = [...prev];
      const updatedProcesos = [...newComponents[componenteIndex].procesos];
      const updatedSubprocesos = [...updatedProcesos[procesoIndex].subprocesos];
      const updatedMetaPlan = {
        ...updatedSubprocesos[subprocesoIndex].meta_plan_desarrollo,
      };
      const updatedObjetivos = [...updatedMetaPlan.objetivos];
      const updatedMeta = {
        ...updatedObjetivos[objetivoIndex].meta,
      };
      const updatedIndicador = {
        ...updatedMeta.indicador,
      };
      const updatedAccion = {
        ...updatedIndicador.accion,
      };
      const updatedResponsable = {
        ...updatedAccion.responsable,
      };
      const updatedRecursos = {
        ...updatedResponsable.recursos,
        fechas: newFechas,
      };
      updatedResponsable.recursos = updatedRecursos;
      updatedAccion.responsable = updatedAccion;
      updatedIndicador.accion = updatedIndicador;
      updatedMeta.indicador = updatedMeta;
      updatedObjetivos[objetivoIndex] = {
        ...updatedObjetivos[objetivoIndex],
        meta: updatedMeta,
      };
      updatedMetaPlan.objetivos = updatedObjetivos;
      updatedSubprocesos[subprocesoIndex] = {
        ...updatedSubprocesos[subprocesoIndex],
        meta_plan_desarrollo: updatedMetaPlan,
      };
      updatedProcesos[procesoIndex] = {
        ...updatedProcesos[procesoIndex],
        subprocesos: updatedSubprocesos,
      };
      newComponents[componenteIndex] = {
        ...newComponents[componenteIndex],
        procesos: updatedProcesos,
      };
      return newComponents;
    });
  };

  // Función para eliminar un elemento
  const removeElement = (path) => {
    if (!confirm('¿Estás seguro de que deseas eliminar este elemento y todos sus elementos hijos?')) {
      return;
    }

    setComponents((prev) => {
      const newComponents = JSON.parse(JSON.stringify(prev)); // Deep copy to ensure immutability
      let current = newComponents;
      let parent = null;
      let lastIndex = path[path.length - 1];

      for (let i = 0; i < path.length - 1; i++) {
        parent = current;
        current = current[path[i]];
      }

      if (Array.isArray(current)) {
        current.splice(lastIndex, 1);
      } else if (parent && lastIndex in parent) {
        // If it's a direct property, set it to null or delete
        if (typeof parent === 'object' && parent !== null) {
          if (Array.isArray(parent)) {
            parent.splice(lastIndex, 1);
          } else {
            delete parent[lastIndex]; // or parent[lastIndex] = null; depending on desired structure
          }
        }
      }
      return newComponents;
    });
  };

  // --- Data Formatting Function ---
  const formatDataForSave = (data) => {
    const formattedData = [];

    data.forEach(componente => {
      // Componente
      formattedData.push({
        type: 'componente',
        id: componente.id,
        descripcion: componente.descripcion,
      });

      componente.procesos.forEach(proceso => {
        // Proceso
        formattedData.push({
          type: 'proceso',
          id: proceso.id,
          descripcion: proceso.descripcion,
          parentId: componente.id, // Reference to parent componente
        });

        proceso.subprocesos.forEach(subproceso => {
          // Subproceso
          formattedData.push({
            type: 'subproceso',
            id: subproceso.id,
            descripcion: subproceso.descripcion,
            parentId: proceso.id, // Reference to parent proceso
          });

          if (subproceso.meta_plan_desarrollo) {
            const metaPlan = subproceso.meta_plan_desarrollo;
            // Meta del Plan de Desarrollo
            formattedData.push({
              type: 'metaPlan',
              id: metaPlan.id,
              descripcion: metaPlan.descripcion,
              parentId: subproceso.id, // Reference to parent subproceso
            });

            metaPlan.objetivos.forEach(objetivo => {
              // Objetivo Estratégico
              formattedData.push({
                type: 'objetivo',
                id: objetivo.id,
                descripcion: objetivo.descripcion,
                parentId: metaPlan.id, // Reference to parent metaPlan
              });

              if (objetivo.meta) {
                const meta = objetivo.meta;
                // Meta (specific to Objetivo)
                formattedData.push({
                  type: 'meta',
                  id: meta.id,
                  descripcion: meta.descripcion,
                  parentId: objetivo.id, // Reference to parent objetivo
                });

                if (meta.indicador) {
                  const indicador = meta.indicador;
                  // Indicador
                  formattedData.push({
                    type: 'indicador',
                    id: indicador.id,
                    descripcion: indicador.descripcion,
                    parentId: meta.id, // Reference to parent meta
                  });

                  if (indicador.accion) {
                    const accion = indicador.accion;
                    // Acción
                    formattedData.push({
                      type: 'accion',
                      id: accion.id,
                      descripcion: accion.descripcion,
                      parentId: indicador.id, // Reference to parent indicador
                    });

                    if (accion.responsable) {
                      const responsable = accion.responsable;
                      // Responsable
                      formattedData.push({
                        type: 'responsable',
                        id: responsable.id,
                        descripcion: responsable.descripcion,
                        parentId: accion.id, // Reference to parent accion
                      });

                      if (responsable.recursos) {
                        const recursos = responsable.recursos;
                        // Recursos
                        formattedData.push({
                          type: 'recursos',
                          id: recursos.id,
                          descripcion: recursos.descripcion,
                          parentId: responsable.id, // Reference to parent responsable
                        });

                        if (recursos.fechas) {
                          const fechas = recursos.fechas;
                          // Fechas
                          formattedData.push({
                            type: 'fechas',
                            id: fechas.id,
                            descripcion: fechas.descripcion,
                            parentId: recursos.id, // Reference to parent recursos
                          });
                        }
                      }
                    }
                  }
                }
              }
            });
          }
        });
      });
    });

    return formattedData;
  };


  // Función para guardar todo
  const saveAll = () => {
    const dataToSave = formatDataForSave(components);
    console.log('Data to save:', dataToSave);
    alert('Datos guardados (ver consola)');
  };

  // Componente para renderizar fechas
  const renderFechas = (fechas, path) => {
    if (!fechas) return null;
    return (
      <div className="card mb-3 border-secondary" style={{ width: '100%' }}>
        <div className="card-header bg-secondary bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Fechas</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement([...path, 'fechas'])}
          >
            Eliminar Fechas
          </button>
        </div>
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={fechas.descripcion}
              onInput={(e) => updateField([...path], 'fechas', { ...fechas, descripcion: e.target.value })}
            />
          </div>
        </div>
      </div>
    );
  };

  // Componente para renderizar recursos
  const renderRecursos = (recursos, path, componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    if (!recursos) return null;
    return (
      <div className="card mb-3 border-info" style={{ width: '100%' }}>
        <div className="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Recursos</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement([...path, 'recursos'])}
          >
            Eliminar Recursos
          </button>
        </div>
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={recursos.descripcion}
              onInput={(e) => updateField([...path], 'recursos', { ...recursos, descripcion: e.target.value })}
            />
          </div>
          {recursos.descripcion && !recursos.fechas && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addFechas(componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
              >
                Agregar Fechas
              </button>
            </div>
          )}
          {renderFechas(recursos.fechas, [...path, 'recursos'])}
        </div>
      </div>
    );
  };

  // Componente para renderizar responsable
  const renderResponsable = (responsable, path, componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    if (!responsable) return null;
    return (
      <div className="card mb-3 border-dark" style={{ width: '100%' }}>
        <div className="card-header bg-dark bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Responsable</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement([...path, 'responsable'])}
          >
            Eliminar Responsable
          </button>
        </div>
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={responsable.descripcion}
              onInput={(e) => updateField([...path], 'responsable', { ...responsable, descripcion: e.target.value })}
            />
          </div>
          {responsable.descripcion && !responsable.recursos && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addRecursos(componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
              >
                Agregar Recursos
              </button>
            </div>
          )}
          {renderRecursos(responsable.recursos, [...path, 'responsable'], componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
        </div>
      </div>
    );
  };

  // Componente para renderizar acción
  const renderAccion = (accion, path, componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    if (!accion) return null;
    return (
      <div className="card mb-3 border-warning" style={{ width: '100%' }}>
        <div className="card-header bg-warning bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Acción</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement([...path, 'accion'])}
          >
            Eliminar Acción
          </button>
        </div>
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={accion.descripcion}
              onInput={(e) => updateField([...path], 'accion', { ...accion, descripcion: e.target.value })}
            />
          </div>
          {accion.descripcion && !accion.responsable && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addResponsable(componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
              >
                Agregar Responsable
              </button>
            </div>
          )}
          {renderResponsable(accion.responsable, [...path, 'accion'], componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
        </div>
      </div>
    );
  };

  // Componente para renderizar indicador
  const renderIndicador = (indicador, path, componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    if (!indicador) return null;
    return (
      <div className="card mb-3 border-success" style={{ width: '100%' }}>
        <div className="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Indicador</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement([...path, 'indicador'])}
          >
            Eliminar Indicador
          </button>
        </div>
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={indicador.descripcion}
              onInput={(e) => updateField([...path], 'indicador', { ...indicador, descripcion: e.target.value })}
            />
          </div>
          {indicador.descripcion && !indicador.accion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addAccion(componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
              >
                Agregar Acción
              </button>
            </div>
          )}
          {renderAccion(indicador.accion, [...path, 'indicador'], componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
        </div>
      </div>
    );
  };

  // Componente para renderizar meta
  const renderMeta = (meta, path, componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    if (!meta) return null;
    return (
      <div className="card mb-3 border-primary" style={{ width: '100%' }}>
        <div className="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Meta</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement([...path, 'meta'])}
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
              onInput={(e) => updateField([...path], 'meta', { ...meta, descripcion: e.target.value })}
            />
          </div>
          {meta.descripcion && !meta.indicador && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addIndicador(componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
              >
                Agregar Indicador
              </button>
            </div>
          )}
          {renderIndicador(meta.indicador, [...path, 'meta'], componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
        </div>
      </div>
    );
  };

  // Componente para renderizar objetivo
  const renderObjetivo = (objetivo, path, componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex) => {
    return (
      <div className="card mb-3 border-danger" style={{ width: '100%' }}>
        <div className="card-header bg-danger bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Objetivo Estratégico</h6>
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
              onInput={(e) => updateField(path, 'descripcion', e.target.value)}
            />
          </div>
          {objetivo.descripcion && !objetivo.meta && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addMeta(componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
              >
                Agregar Meta
              </button>
            </div>
          )}
          {renderMeta(objetivo.meta, path, componenteIndex, procesoIndex, subprocesoIndex, objetivoIndex)}
        </div>
      </div>
    );
  };

  // Componente para renderizar meta del plan
  const renderMetaPlan = (metaPlan, path, componenteIndex, procesoIndex, subprocesoIndex) => {
    if (!metaPlan) return null;
    return (
      <div className="card mb-3 border-info" style={{ width: '100%' }}>
        <div className="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Meta del Plan de Desarrollo</h5>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement([...path, 'meta_plan_desarrollo'])}
          >
            Eliminar Meta del Plan
          </button>
        </div>
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={metaPlan.descripcion}
              onInput={(e) => updateField([...path], 'meta_plan_desarrollo', { ...metaPlan, descripcion: e.target.value })}
            />
          </div>
          {metaPlan.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addObjetivo(componenteIndex, procesoIndex, subprocesoIndex)}
              >
                Agregar Objetivo Estratégico
              </button>
            </div>
          )}
          <div className="ms-4">
            {metaPlan.objetivos?.map((objetivo, i) =>
              renderObjetivo(
                objetivo,
                [...path, 'meta_plan_desarrollo', 'objetivos', i],
                componenteIndex,
                procesoIndex,
                subprocesoIndex,
                i
              )
            )}
          </div>
        </div>
      </div>
    );
  };

  // Componente para renderizar subproceso
  const renderSubproceso = (subproceso, path, componenteIndex, procesoIndex) => {
    return (
      <div className="card mb-3 border-success" style={{ width: '100%' }}>
        <div className="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Subproceso</h5>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(path)}
          >
            Eliminar Subproceso
          </button>
        </div>
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={subproceso.descripcion}
              onInput={(e) => updateField(path, 'descripcion', e.target.value)}
            />
          </div>
          {subproceso.descripcion && !subproceso.meta_plan_desarrollo && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addMetaPlan(componenteIndex, procesoIndex, path[path.length - 1])}
              >
                Agregar Meta del Plan
              </button>
            </div>
          )}
          {renderMetaPlan(subproceso.meta_plan_desarrollo, path, componenteIndex, procesoIndex, path[path.length - 1])}
        </div>
      </div>
    );
  };

  // Componente para renderizar proceso
  const renderProceso = (proceso, path, componenteIndex) => {
    return (
      <div className="card mb-3 border-primary" style={{ width: '100%' }}>
        <div className="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
          <h4 className="mb-0">Proceso</h4>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(path)}
          >
            Eliminar Proceso
          </button>
        </div>
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={proceso.descripcion}
              onInput={(e) => updateField(path, 'descripcion', e.target.value)}
            />
          </div>
          {proceso.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addSubproceso(componenteIndex, path[path.length - 1])}
              >
                Agregar Subproceso
              </button>
            </div>
          )}
          <div className="ms-4">
            {proceso.subprocesos?.map((subproceso, i) =>
              renderSubproceso(subproceso, [...path, 'subprocesos', i], componenteIndex, path[path.length - 1])
            )}
          </div>
        </div>
      </div>
    );
  };

  // Componente para renderizar componente
  const renderComponente = (componente, index) => {
    return (
      <div className="card mb-3" style={{ width: '100%' }}>
        <div className="card-header bg-light d-flex justify-content-between align-items-center">
          <h3 className="mb-0">Componente</h3>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement([index])}
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
              onInput={(e) => updateField([index], 'descripcion', e.target.value)}
            />
          </div>
          {componente.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addProceso(index)}
              >
                Agregar Proceso
              </button>
            </div>
          )}
          <div className="ms-4">
            {componente.procesos?.map((proceso, i) =>
              renderProceso(proceso, [index, 'procesos', i], index)
            )}
          </div>
        </div>
      </div>
    );
  };

  return (
    <div className="container py-4">
      <div className="card shadow">
        <div className="card-header bg-white">
          <h1 className="h3 mb-0">Plan de apoyo al mejoramiento (PAM)</h1>
          <p className="mb-0 text-muted">Complete cada descripción para habilitar el siguiente nivel</p>
        </div>
        <div className="card-body">
          <button
            type="button"
            className="btn btn-success mb-4"
            onClick={addComponente}
          >
            <i className="bi bi-plus-circle"></i> Agregar componente
          </button>

          <div id="componentes-container">
            {components.map((componente, i) => renderComponente(componente, i))}
          </div>

          <div className="mt-4 pt-3 border-top">
            <button
              type="button"
              className="btn btn-primary"
              onClick={saveAll}
            >
              <i className="bi bi-save"></i> Guardar Plan Completo
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ComponentManagement;