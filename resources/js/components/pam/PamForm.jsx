import React, { useState, useEffect } from 'react';
import { route } from 'preact-router';
import CNavigationButton from "@/components/shared/CNavigationButton.jsx";
import Swal from 'sweetalert2';

const PamForm = ({ id, csrfToken = '', pamGeneralId }) => {
  // El estado ahora maneja un array de componentes, permitiendo múltiples jerarquías
  const [formData, setFormData] = useState({
    componentes: [], // Ahora un array de componentes
  });
  const [isLoading, setIsLoading] = useState(true);
  const [isEditing, setIsEditing] = useState(false);
  const [originalData, setOriginalData] = useState(null); // No se usa directamente en el renderizado, pero se mantiene para referencia
  const [pamGeneralIdEdit, setPamGeneralIdEdit] = useState(null);
  const [users, setUsers] = useState([]);
  const [isUsersLoading, setIsUsersLoading] = useState(false);
  const [unidadesMeta, setUnidadesMeta] = useState([]); // NUEVO: Estado para almacenar las unidades de meta
  const [isUnidadesMetaLoading, setIsUnidadesMetaLoading] = useState(false);
  const [componentes, setComponentes] = useState([]); // NUEVO: Estado para almacenar los componentes
  const [isComponentesLoading, setIsComponentesLoading] = useState(false);

  /**
   * Helper para encontrar y actualizar un campo específico de un elemento anidado de forma inmutable.
   * Recorre la estructura de datos para encontrar el elemento por su ID y actualiza el campo especificado.
   *
   * @param {Array} items El array actual en el nivel de anidación.
   * @param {string} targetId El ID del elemento a actualizar.
   * @param {string} fieldName El nombre del campo a actualizar (ej: 'descripcion', 'id', 'fecha_inicio').
   * @param {any} newValue El nuevo valor para el campo.
   * @returns {Array} Un nuevo array con el elemento actualizado.
   */
  const updateItemField = (items, targetId, fieldName, newValue) => {
    console.log(items, targetId, fieldName, newValue);

    return items.map(item => {
      // Caso 1: Encontramos el elemento por su ID en el nivel actual.
      // Lo actualizamos y retornamos de inmediato.
      if (item.id === targetId) {
        // Modifica: Se actualiza el campo del objeto encontrado
        return { ...item, [fieldName]: newValue };
      }

      // Caso 2: El elemento tiene un objeto 'accion' anidado cuyo ID coincide.
      // Actualizamos la acción y retornamos.
      if (item.accion && item.accion.id === targetId) {
        // Modifica: Se actualiza el campo de la acción anidada
        return { ...item, accion: { ...item.accion, [fieldName]: newValue } };
      }

      // Objeto para almacenar los resultados de las llamadas recursivas
      const updatedSubItems = {};
      let hasChanges = false;

      // Caso 3: Búsqueda recursiva en los arrays anidados.
      // Se recorren las propiedades que son arrays y se llama recursivamente.
      // Se usa un array de nombres para hacerlo más dinámico y fácil de leer.
      const nestedArrays = [
        'procesos',
        'subprocesos',
        'metas_plan_desarrollo',
        'objetivos',
        'metas',
        'indicadores'
      ];

      for (const key of nestedArrays) {
        if (item[key] && Array.isArray(item[key])) {
          const result = updateItemField(item[key], targetId, fieldName, newValue);
          // Si el resultado de la recursión es diferente, significa que hubo un cambio
          if (result !== item[key]) {
            updatedSubItems[key] = result;
            hasChanges = true;
            // Optimización: Si se encuentra el elemento en este nivel recursivo,
            // no es necesario seguir buscando en otros arrays de este mismo item.
            break;
          }
        }
      }

      // Retorna el nuevo objeto combinado con los cambios si los hay,
      // o el objeto original si no se encontró nada.
      return hasChanges ? { ...item, ...updatedSubItems } : item;
    });
  };

  /**
   * Función específica para actualizar el campo 'descripcion' de cualquier elemento anidado.
   *
   * @param {string} itemId El ID del elemento cuya descripción se va a actualizar.
   * @param {string} value El nuevo valor de la descripción.
   */
  const updateDescription = (itemId, value) => {
    console.log(itemId, value);

    setFormData(prevFormData => ({
      ...prevFormData,
      componentes: updateItemField(prevFormData.componentes, itemId, 'descripcion', value),
    }));
  };

  /**
   * Función específica para actualizar campos anidados dentro del objeto 'accion' de un indicador.
   * Esta función se encarga de 'responsable', 'recursos' y 'fechas'.
   *
   * @param {string} indicadorId El ID del indicador que contiene la acción.
   * @param {string} fieldName El nombre del campo dentro de 'accion' a actualizar (ej: 'responsable', 'recursos', 'fechas').
   * @param {any} value El nuevo valor para el campo.
   */
  const updateAccionNestedField = (indicadorId, fieldName, value) => {
  setFormData(prevFormData => {
    const newComponents = prevFormData.componentes.map(comp => ({
      ...comp,
      procesos: comp.procesos.map(proc => ({
        ...proc,
        subprocesos: proc.subprocesos.map(subproc => ({
          ...subproc,
          metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan => ({
            ...metaPlan,
            objetivos: metaPlan.objetivos.map(obj => ({
              ...obj,
              metas: obj.metas.map(meta => ({
                ...meta,
                indicadores: meta.indicadores.map(indicador => {
                  if (indicador.id === indicadorId) {
                    return {
                      ...indicador,
                      accion: {
                        ...indicador.accion,
                        [fieldName]: value
                      }
                    };
                  }
                  return indicador;
                })
              }))
            }))
          }))
        }))
      }))
    }));

    // CORRECCIÓN: Mantener todas las propiedades del formData anterior
    return {
      ...prevFormData,  // Esta línea es crucial
      componentes: newComponents
    };
  });
};

  // Función específica para actualizar el campo 'valor_meta' de una meta.
  const updateValorMeta = (metaId, value) => {
    setFormData(prevFormData => {
      const newComponents = prevFormData.componentes.map(comp => ({
        ...comp,
        procesos: comp.procesos.map(proc => ({
          ...proc,
          subprocesos: proc.subprocesos.map(subproc => ({
            ...subproc,
            metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan => ({
              ...metaPlan,
              objetivos: metaPlan.objetivos.map(obj => ({
                ...obj,
                metas: obj.metas.map(meta =>
                  meta.id === metaId ? { ...meta, valor_meta: value } : meta
                )
              }))
            }))
          }))
        }))
      }));
      return { componentes: newComponents };
    });
  };

  // Función específica para actualizar el campo 'unidad_meta_id' de una meta.
  const updateUnidadMetaId = (metaId, newUnidadId) => {
    setFormData(prevFormData => {
      const newComponents = prevFormData.componentes.map(comp => ({
        ...comp,
        procesos: comp.procesos.map(proc => ({
          ...proc,
          subprocesos: proc.subprocesos.map(subproc => ({
            ...subproc,
            metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan => ({
              ...metaPlan,
              objetivos: metaPlan.objetivos.map(obj => ({
                ...obj,
                metas: obj.metas.map(meta =>
                  meta.id === metaId ? { ...meta, unidad_meta_id: newUnidadId } : meta
                )
              }))
            }))
          }))
        }))
      }));
      return { componentes: newComponents };
    });
  };

  // Función específica para actualizar el campo 'componente_id' de una meta.
  const updateComponenteId = (componenteId, newComponenteId) => {
    setFormData(prevFormData => {
      // Mapea sobre la lista de componentes para encontrar y actualizar el que coincida
      const newComponents = prevFormData.componentes.map(comp => {
        // Comprobamos si el 'id' del componente actual coincide con el que queremos actualizar
        if (comp.id === componenteId) {
          // Si coincide, devolvemos un nuevo objeto con el 'id' actualizado
          // Mantenemos el resto de las propiedades del componente original
          return {
            ...comp,
            id: newComponenteId
          };
        }
        // Si no coincide, devolvemos el componente sin cambios
        return comp;
      });

      // Devolvemos el estado completo, incluyendo la lista de componentes actualizada
      // Esto es importante para no perder otras propiedades de formData si las hubiera
      return {
        ...prevFormData,
        componentes: newComponents
      };
    });
  };

  // Cargar datos cuando el componente se monta o el ID cambia
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
          pamGeneralId = new URLSearchParams(window.location.search).get('pam');
          setPamGeneralIdEdit(pamGeneralId);

          const data = result.data;
          setIsEditing(true);
          setOriginalData(data); // Guarda los datos originales para referencia

          // Mapeo de datos del backend a la nueva estructura de arrays anidados.
          // Esta lógica asume que el backend devuelve una única jerarquía completa.
          // Si el backend puede devolver múltiples componentes/procesos, etc.,
          // esta parte necesitará una lógica de mapeo más compleja.
          const mappedData = {
            componentes: [
              {
                id: data.componente || `componente-${Date.now()}`,
                descripcion: data.componente_descripcion || '',
                procesos: [
                  {
                    id: data.proceso_id || `proceso-${Date.now() + 1}`,
                    descripcion: data.proceso_descripcion || '',
                    subprocesos: [
                      {
                        id: data.subproceso_id || `subproceso-${Date.now() + 2}`,
                        descripcion: data.subproceso_descripcion || '',
                        metas_plan_desarrollo: [
                          {
                            id: data.meta_plan_desarrollo_id || `meta-plan-${Date.now() + 3}`,
                            descripcion: data.meta_plan_desarrollo_descripcion || '',
                            objetivos: [
                              {
                                id: data.objetivo_estrategico_id || `objetivo-${Date.now() + 4}`,
                                descripcion: data.objetivo_estrategico_descripcion || '',
                                metas: [
                                  {
                                    id: data.meta_id || `meta-${Date.now() + 5}`,
                                    descripcion: data.meta_descripcion || '',
                                    valor_meta: data.valor_meta || '',
                                    unidad_meta_id: data.unidad_meta_id || '',
                                    indicadores: [
                                      {
                                        id: data.indicador_id || `indicador-${Date.now() + 6}`,
                                        descripcion: data.indicador_descripcion || '',
                                        accion: { // Acción sigue siendo un objeto único por indicador
                                          id: data.accion_id || `accion-${Date.now() + 7}`,
                                          descripcion: data.accion_descripcion || '',
                                          responsable: {
                                            id: data.user_id || '',
                                            descripcion: data.responsable_nombre || ''
                                          },
                                          recursos: {
                                            id: `recursos-${Date.now() + 8}`,
                                            descripcion: data.recursos_descripcion || ''
                                          },
                                          fechas: {
                                            id: `fechas-${Date.now() + 9}`,
                                            fecha_inicio: data.fecha_inicio ? data.fecha_inicio.split(' ')[0] : '',
                                            fecha_final: data.fecha_final ? data.fecha_final.split(' ')[0] : ''
                                          }
                                        }
                                      }
                                    ]
                                  }
                                ]
                              }
                            ]
                          }
                        ]
                      }
                    ]
                  }
                ]
              }
            ]
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
          route('/pam'); // Redirige a la lista si hay un error
        });
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, [id]);

  // Carga la lista de usuarios para el selector de responsable
  useEffect(() => {
    const fetchUsers = async () => {
      setIsUsersLoading(true);
      try {
        const response = await fetch('/get-usuarios', {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        if (!response.ok) {
          throw new Error(`Error fetching users: ${response.statusText}`);
        }
        const data = await response.json();
        if (data.success && Array.isArray(data.data)) {
          setUsers(data.data);
        } else {
          console.error("Unexpected response format for users:", data);
          setUsers([]);
        }
      } catch (error) {
        console.error("Failed to fetch users:", error);
        Swal.fire({
          title: 'Error',
          text: 'No se pudieron cargar los usuarios para el responsable.',
          icon: 'error',
          confirmButtonText: 'Entendido'
        });
      } finally {
        setIsUsersLoading(false);
      }
    };

    fetchUsers();
  }, []); // Se ejecuta una sola vez al montar el componente

  // Obtiene las unidades de meta
  useEffect(() => {
    const fetchUnidadesMeta = async () => {
      setIsUnidadesMetaLoading(true);
      try {
        const response = await fetch('/get-unidades-meta');
        if (!response.ok) {
          throw new Error(`Error fetching unidades de meta: ${response.statusText}`);
        }
        const data = await response.json();
        if (Array.isArray(data)) {
          setUnidadesMeta(data);
        } else {
          console.error("Unexpected response format for unidades de meta:", data);
          setUnidadesMeta([]);
        }
      } catch (error) {
        console.error("Failed to fetch unidades de meta:", error);
        Swal.fire({
          title: 'Error',
          text: 'No se pudieron cargar las unidades de meta.',
          icon: 'error',
          confirmButtonText: 'Entendido'
        });
      } finally {
        setIsUnidadesMetaLoading(false);
      }
    };

    fetchUnidadesMeta();
  }, []);

  // Obtiene los componentes
  useEffect(() => {
    const fetchComponentes = async () => {
      setIsComponentesLoading(true);
      try {
        const response = await fetch('/get-componentes');
        if (!response.ok) {
          throw new Error(`Error fetching componentes: ${response.statusText}`);
        }
        const data = await response.json();
        if (Array.isArray(data)) {
          setComponentes(data);
        } else {
          console.error("Unexpected response format for componentes:", data);
          setComponentes([]);
        }
      } catch (error) {
        console.error("Failed to fetch componentes:", error);
        Swal.fire({
          title: 'Error',
          text: 'No se pudieron cargar las componentes.',
          icon: 'error',
          confirmButtonText: 'Entendido'
        });
      } finally {
        setIsComponentesLoading(false);
      }
    };

    fetchComponentes();
  }, []);

  // useEffect para monitorear el estado y agregar el indicador automáticamente
  useEffect(() => {
    // Se crea una copia profunda para evitar mutaciones directas del estado
    const newComponents = JSON.parse(JSON.stringify(formData.componentes));

    newComponents.forEach(comp => {
      comp.procesos.forEach(proc => {
        proc.subprocesos.forEach(subproc => {
          subproc.metas_plan_desarrollo.forEach(metaPlan => {
            metaPlan.objetivos.forEach(obj => {
              obj.metas.forEach(meta => {
                // Se busca la unidad de meta seleccionada
                const unidadSeleccionada = unidadesMeta.find(unidad => unidad.id == meta.unidad_meta_id);
                const unidadDescripcion = unidadSeleccionada ? unidadSeleccionada.unidad_parcial : '';
                const unidadDescripcion2 = unidadSeleccionada ? unidadSeleccionada.unidad_total : '';

                // Se crea la nueva descripción del indicador
                const newDescription = `${unidadDescripcion} / ${unidadDescripcion2}`;

                // Comentamos lo que modificamos: Se agrega la lógica para manejar ambos escenarios.
                // Escenario 1: No hay indicadores, se agregan automáticamente
                if (
                  meta.descripcion &&
                  meta.valor_meta &&
                  meta.unidad_meta_id &&
                  (!meta.indicadores || meta.indicadores.length === 0)
                ) {
                  // Si cumple la condición y no hay indicadores, se agrega uno
                  addIndicador(meta.id);
                }
                // Escenario 2: Ya existen indicadores, se actualiza la descripción
                else if (
                  meta.indicadores &&
                  meta.indicadores.length > 0 &&
                  meta.indicadores[0].descripcion !== newDescription
                ) {
                  // Si la descripción del indicador es diferente a la nueva, se actualiza
                  updateIndicatorDescription(meta.id, newDescription);
                }
              });
            });
          });
        });
      });
    });

  }, [formData, unidadesMeta]);

  const addComponente = () => {
    setFormData(prev => ({
      ...prev,
      componentes: [...prev.componentes, { id: `componente-${Date.now()}`, descripcion: '', procesos: [] }]
    }));
  };

  const addProceso = (componenteId) => {
    setFormData(prev => ({
      ...prev,
      componentes: prev.componentes.map(comp =>
        comp.id === componenteId
          ? { ...comp, procesos: [...comp.procesos, { id: `proceso-${Date.now()}`, descripcion: '', subprocesos: [] }] }
          : comp
      )
    }));
  };

  const addSubproceso = (procesoId) => {
    setFormData(prev => ({
      ...prev,
      componentes: prev.componentes.map(comp => ({
        ...comp,
        procesos: comp.procesos.map(proc =>
          proc.id === procesoId
            ? { ...proc, subprocesos: [...proc.subprocesos, { id: `subproceso-${Date.now()}`, descripcion: '', metas_plan_desarrollo: [] }] }
            : proc
        )
      }))
    }));
  };

  const addMetaPlan = (subprocesoId) => {
    setFormData(prev => ({
      ...prev,
      componentes: prev.componentes.map(comp => ({
        ...comp,
        procesos: comp.procesos.map(proc => ({
          ...proc,
          subprocesos: proc.subprocesos.map(subproc =>
            subproc.id === subprocesoId
              ? { ...subproc, metas_plan_desarrollo: [...subproc.metas_plan_desarrollo, { id: `meta-plan-${Date.now()}`, descripcion: '', objetivos: [] }] }
              : subproc
          )
        }))
      }))
    }));
  };

  const addObjetivo = (metaPlanId) => {
    setFormData(prev => ({
      ...prev,
      componentes: prev.componentes.map(comp => ({
        ...comp,
        procesos: comp.procesos.map(proc => ({
          ...proc,
          subprocesos: proc.subprocesos.map(subproc => ({
            ...subproc,
            metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan =>
              metaPlan.id === metaPlanId
                ? { ...metaPlan, objetivos: [...metaPlan.objetivos, { id: `objetivo-${Date.now()}`, descripcion: '', metas: [] }] }
                : metaPlan
            )
          }))
        }))
      }))
    }));
  };

  const addMeta = (objetivoId) => {
    setFormData(prev => ({
      ...prev,
      componentes: prev.componentes.map(comp => ({
        ...comp,
        procesos: comp.procesos.map(proc => ({
          ...proc,
          subprocesos: proc.subprocesos.map(subproc => ({
            ...subproc,
            metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan => ({
              ...metaPlan,
              objetivos: metaPlan.objetivos.map(obj =>
                obj.id === objetivoId
                  ? { ...obj, metas: [...obj.metas, { id: `meta-${Date.now()}`, descripcion: '', indicadores: [] }] }
                  : obj
              )
            }))
          }))
        }))
      }))
    }));
  };

  const addIndicador = (metaId) => {
    const metaAfectada = formData.componentes.flatMap(comp => comp.procesos.flatMap(proc => proc.subprocesos.flatMap(subproc => subproc.metas_plan_desarrollo.flatMap(metaPlan => metaPlan.objetivos.flatMap(obj => obj.metas)))))
    .find(meta => meta.id === metaId);

    // Se busca la unidad de meta en el array de unidadesMeta usando el id
    const unidadSeleccionada = unidadesMeta.find(unidad => unidad.id == metaAfectada.unidad_meta_id);
    const unidadDescripcion = unidadSeleccionada ? unidadSeleccionada.descripcion : '';

    setFormData(prev => ({
      ...prev,
      componentes: prev.componentes.map(comp => ({
        ...comp,
        procesos: comp.procesos.map(proc => ({
          ...proc,
          subprocesos: proc.subprocesos.map(subproc => ({
            ...subproc,
            metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan => ({
              ...metaPlan,
              objetivos: metaPlan.objetivos.map(obj => ({
                ...obj,
                metas: obj.metas.map(meta =>
                  meta.id === metaId
                    ? {
                      ...meta,
                      indicadores: [...meta.indicadores, {
                        id: `indicador-${Date.now()}`,
                        descripcion: `${meta.valor_meta} ${unidadDescripcion}`,
                        accion: { // Inicializa la acción aquí
                          id: `accion-${Date.now()}`,
                          descripcion: '',
                          responsable: { id: '', descripcion: '' },
                          recursos: { id: '', descripcion: '' },
                          fechas: { fecha_inicio: '', fecha_final: '' }
                        }
                      }]
                    }
                    : meta
                )
              }))
            }))
          }))
        }))
      }))
    }));
  };

  // La función `addIndicador` se mantiene, pero se usa una nueva función para actualizar.
  const updateIndicatorDescription = (metaId, newDescription) => {
    setFormData(prev => ({
      ...prev,
      componentes: prev.componentes.map(comp => ({
        ...comp,
        procesos: comp.procesos.map(proc => ({
          ...proc,
          subprocesos: proc.subprocesos.map(subproc => ({
            ...subproc,
            metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan => ({
              ...metaPlan,
              objetivos: metaPlan.objetivos.map(obj => ({
                ...obj,
                metas: obj.metas.map(meta =>
                  meta.id === metaId
                    ? {
                        ...meta,
                        indicadores: meta.indicadores.map(indicador => ({
                          // Comentamos lo que modificamos: Se actualiza la descripción del primer indicador si existe.
                          ...indicador,
                          descripcion: newDescription,
                        })),
                      }
                    : meta
                )
              }))
            }))
          }))
        }))
      }))
    }));
  };

  /**
   * Función para eliminar un elemento de un array anidado.
   *
   * @param {Array<string|number>} parentArrayPath La ruta al array padre que contiene el elemento a eliminar.
   * (ej: ['componentes', componenteId, 'procesos']).
   * @param {string} itemId El ID del elemento a eliminar.
   * @param {string} [confirmMessage] Mensaje opcional de confirmación.
   */
  const removeElement = (parentArrayPath, itemId, confirmMessage) => {
    if (!confirm(confirmMessage || '¿Estás seguro de que deseas eliminar este elemento y todos sus elementos hijos?')) {
      return;
    }

    setFormData(prevFormData => {
      const newFormData = JSON.parse(JSON.stringify(prevFormData)); // Copia profunda

      let currentLevel = newFormData;
      // Navega hasta el array que contiene el elemento a eliminar
      for (let i = 0; i < parentArrayPath.length - 1; i++) {
        const key = parentArrayPath[i];
        const nextId = parentArrayPath[i + 1];
        if (Array.isArray(currentLevel[key])) {
          currentLevel = currentLevel[key].find(item => item.id === nextId);
          i++; // Salta el ID en la siguiente iteración
        } else {
          currentLevel = currentLevel[key];
        }
      }
      // Filtra el elemento del array final
      const targetArrayKey = parentArrayPath[parentArrayPath.length - 1];
      currentLevel[targetArrayKey] = currentLevel[targetArrayKey].filter(item => item.id !== itemId);

      return newFormData;
    });
  };

  // Función para guardar datos (adaptada para manejar la edición y la nueva estructura)
  const saveAll = async () => {
    // Validar que al menos un componente exista antes de intentar guardar
    if (formData.componentes.length === 0) {
      await Swal.fire({
        title: 'Campos incompletos',
        text: 'Debe agregar al menos un Componente para guardar.',
        icon: 'error',
        confirmButtonText: 'Entendido'
      });
      return;
    }

    const firstComponent = formData.componentes[0];
    if (firstComponent.procesos.length === 0 ||
        firstComponent.procesos[0].subprocesos.length === 0 ||
        firstComponent.procesos[0].subprocesos[0].metas_plan_desarrollo.length === 0 ||
        firstComponent.procesos[0].subprocesos[0].metas_plan_desarrollo[0].objetivos.length === 0 ||
        firstComponent.procesos[0].subprocesos[0].metas_plan_desarrollo[0].objetivos[0].metas.length === 0 ||
        firstComponent.procesos[0].subprocesos[0].metas_plan_desarrollo[0].objetivos[0].metas[0].indicadores.length === 0 ||
        !firstComponent.procesos[0].subprocesos[0].metas_plan_desarrollo[0].objetivos[0].metas[0].indicadores[0].accion
    ) {
      await Swal.fire({
        title: 'Campos incompletos',
        text: 'Debe completar al menos una jerarquía completa de Componente a Acción para guardar.',
        icon: 'error',
        confirmButtonText: 'Entendido'
      });
      return;
    }

    const firstProceso = firstComponent.procesos[0];
    const firstSubproceso = firstProceso.subprocesos[0];
    const firstMetaPlan = firstSubproceso.metas_plan_desarrollo[0];
    const firstObjetivo = firstMetaPlan.objetivos[0];
    const firstMeta = firstObjetivo.metas[0];
    const firstIndicador = firstMeta.indicadores[0];
    const firstAccion = firstIndicador.accion;

    // Validación de campos obligatorios para la primera jerarquía completa
    const requiredFields = {
      componente: firstComponent.id,
      proceso: firstProceso.descripcion,
      subproceso: firstSubproceso.descripcion,
      meta_plan_desarrollo: firstMetaPlan.descripcion,
      objetivo_estrategico: firstObjetivo.descripcion,
      meta: firstMeta.descripcion,
      indicador: firstIndicador.descripcion,
      accion: firstAccion.descripcion,
      responsable_id: firstAccion.responsable?.id,
      recursos: firstAccion.recursos?.descripcion,
      fecha_inicio: firstAccion.fechas?.fecha_inicio,
      fecha_final: firstAccion.fechas?.fecha_final
    };

    const missingFields = [];
    for (const key in requiredFields) {
      if (!requiredFields[key]) {
        missingFields.push(`• ${key.replace(/_/g, ' ')}`); // Formato básico
      }
    }

    if (missingFields.length > 0) {
      await Swal.fire({
        title: 'Campos obligatorios faltantes',
        html: missingFields.join('<br>'),
        icon: 'error',
        confirmButtonText: 'Entendido'
      });
      return;
    }

    const confirmResult = await Swal.fire({
      title: isEditing ? '¿Actualizar registro?' : '¿Crear nuevo registro?',
      text: isEditing ? '¿Estás seguro de actualizar este registro PAM?' : '¿Estás seguro de crear este nuevo registro PAM?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: isEditing ? 'Sí, actualizar' : 'Sí, crear',
      cancelButtonText: 'Cancelar'
    });

    if (!confirmResult.isConfirmed) return;

    const loadingSwal = Swal.fire({
      title: isEditing ? 'Actualizando...' : 'Creando...',
      html: 'Por favor espera mientras procesamos tu solicitud',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
    });

    try {
      // Prepara los datos para enviar: ¡Ahora enviamos la estructura completa anidada!
      const dataToSend = {
        id: isEditing ? id : null,
        componentes: formData.componentes.map(comp => ({
          componente_id: comp.id,
          procesos: comp.procesos.map(proc => ({
            descripcion: proc.descripcion,
            subprocesos: proc.subprocesos.map(subproc => ({
              descripcion: subproc.descripcion,
              metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan => ({
                descripcion: metaPlan.descripcion,
                objetivos: metaPlan.objetivos.map(obj => ({
                  descripcion: obj.descripcion,
                  metas: obj.metas.map(meta => ({
                    descripcion: meta.descripcion,
                    valor_meta: meta.valor_meta, // Se envía el valor numérico
                    unidad_meta_id: meta.unidad_meta_id, // Se envía el ID de la unidad
                    indicadores: meta.indicadores.map(indicador => ({
                      descripcion: indicador.descripcion,
                      accion: indicador.accion ? {
                        descripcion: indicador.accion.descripcion,
                        user_id: indicador.accion.responsable?.id,
                        responsable_nombre: indicador.accion.responsable?.descripcion,
                        recursos_descripcion: indicador.accion.recursos?.descripcion,
                        fecha_inicio: indicador.accion.fechas?.fecha_inicio,
                        fecha_final: indicador.accion.fechas?.fecha_final
                      } : null
                    }))
                  }))
                }))
              }))
            }))
          }))
        }))
      };

      const url = isEditing ? `/pam/update-pam/${id}` : `/pam/${pamGeneralId}/pam-row-store`;
      const method = isEditing ? 'PUT' : 'POST';

      const response = await fetch(url, {
        method: method,
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataToSend)
      });

      await loadingSwal.close();

      const responseData = await response.json();

      if (!response.ok) {
        let errorMessage = 'Error al guardar los datos';
        if (responseData.errors) {
          errorMessage = Object.values(responseData.errors).flat().join('<br>• ');
        } else if (responseData.message) {
          errorMessage = responseData.message;
        }

        throw new Error(errorMessage);
      }

      await Swal.fire({
        title: '¡Éxito!',
        text: isEditing ? 'Registro actualizado correctamente' : 'Registro creado correctamente',
        icon: 'success',
        confirmButtonText: 'Aceptar'
      });

      if (!isEditing) {
        setFormData({ componentes: [] });
        setIsEditing(false);
        route('/pam');
      }

     } catch (error) {
      console.error('Error al guardar:', error);
      Swal.fire({
        title: 'Error',
        html: error.message,
        icon: 'error',
        confirmButtonText: 'Entendido'
      });
    }
  };

  // --- Funciones de Renderizado (ahora aceptan el elemento y callbacks para agregar/eliminar hijos) ---
  const renderFechas = (accion, indicadorId) => {
    if (!accion.fechas) return null;

    return (
      <div className="card mt-3" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Fechas</h6>
          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => updateAccionNestedField(indicadorId, 'fechas', null)} // Establece fechas a null para eliminar
          >
            Eliminar Fechas
          </button>
        </div>
        <div className="card-body">
          {/* Eliminadas las clases col-md-6 para asegurar 100% de ancho */}
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Fecha de Inicio:</label>
            <input
              type="date"
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
              style={{ width: '100%' }}
              value={accion.fechas.fecha_inicio}
              onChange={(e) => updateAccionNestedField(indicadorId, 'fechas', {
                ...accion.fechas,
                fecha_inicio: e.target.value
              })}
            />
          </div>
          <div className="mt-3"> {/* Añadido margen para espaciado */}
            <label className="block text-sm mb-2 ml-4 fw-bold">Fecha Final:</label>
            <input
              type="date"
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
              style={{ width: '100%' }}
              value={accion.fechas.fecha_final}
              onChange={(e) => updateAccionNestedField(indicadorId, 'fechas', {
                ...accion.fechas,
                fecha_final: e.target.value
              })}
              min={accion.fechas.fecha_inicio}
            />
          </div>
        </div>
      </div>
    );
  };

  const renderRecursos = (accion, indicadorId) => {
    if (!accion.recursos) return null;
    return (
      <div className="card mt-3" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Recursos</h6>
          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => updateAccionNestedField(indicadorId, 'recursos', null)} // Establece recursos a null para eliminar
          >
            Eliminar Recursos
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <textarea
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
              rows="3"
              value={accion.recursos.descripcion}
              onChange={(e) => updateAccionNestedField(indicadorId, 'recursos', { ...accion.recursos, descripcion: e.target.value })}
            />
          </div>
          {accion.recursos.descripcion && !accion.fechas && (
            <div className="mt-3">
              {!isEditing && (
              <button
                className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
                onClick={() => updateAccionNestedField(indicadorId, 'fechas', { fecha_inicio: '', fecha_final: '' })}
              >
                Agregar Fechas
              </button>
              )}
            </div>
          )}
        </div>
        {renderFechas(accion, indicadorId)}
      </div>
    );
  };

  const renderResponsable = (accion, indicadorId) => {
    if (!accion.responsable) return null;

    return (
      <div className="card mt-3" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Responsable</h6>
          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => updateAccionNestedField(indicadorId, 'responsable', null)} // Establece responsable a null para eliminar
          >
            Eliminar Responsable
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Seleccionar Responsable:</label>
            {isUsersLoading ? (
              <p>Cargando usuarios...</p>
            ) : (
              <select
                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                style={{ width: '100%' }} // Asegura 100% de ancho
                value={accion.responsable.id || ''}
                onChange={(e) => {
                  const selectedUserId = e.target.value;
                  const selectedUser = users.find(user => user.id === parseInt(selectedUserId));
                  updateAccionNestedField(indicadorId, 'responsable', {
                    id: selectedUserId,
                    descripcion: selectedUser ? selectedUser.name : ''
                  });
                }}
                required
              >
                <option value="">Seleccione un responsable</option>
                {users.map((user) => (
                  <option key={user.id} value={user.id}>
                    {user.name}
                  </option>
                ))}
              </select>
            )}
          </div>
          {accion.responsable?.id && !accion.recursos && (
            <div className="mt-3">
              {!isEditing && (
              <button
                className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
                onClick={() => updateAccionNestedField(indicadorId, 'recursos', { descripcion: '' })}
              >
                Agregar Recursos
              </button>
              )}
            </div>
          )}
        </div>
        {renderRecursos(accion, indicadorId)}
      </div>
    );
  };

  const renderAccion = (indicador) => {
    if (!indicador.accion) return null;
    return (
      <div className="card mt-3" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Acción</h6>
          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => updateAccionNestedField(indicador.id, 'accion', null)} // Establece acción a null para eliminar
          >
            Eliminar Acción
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <textarea
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
              rows="3"
              value={indicador.accion.descripcion}
              onChange={(e) => updateDescription(indicador.accion.id, e.target.value)} // Usar updateDescription para la descripción de la acción
            />
          </div>
          {indicador.accion.descripcion && !indicador.accion.responsable && (
            <div className="mt-3">
              {!isEditing && (
              <button
                className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
                onClick={() => updateAccionNestedField(indicador.id, 'responsable', { id: '', descripcion: '' })}
              >
                Agregar Responsable
              </button>
              )}
            </div>
          )}
        </div>
        {renderResponsable(indicador.accion, indicador.id)}
      </div>
    );
  };

  const renderIndicador = (indicador, metaId) => {
    return (
      <div key={indicador.id} className="card mt-3 border-secondary" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Indicador</h6>
          {!isEditing && (

          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', 'subprocesos', 'metas_plan_desarrollo', 'objetivos', 'metas', metaId, 'indicadores'], indicador.id)}
          >
            Eliminar Indicador
          </button>
          )}
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <textarea
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
              rows="3"
              disabled
              value={indicador.descripcion}
              onChange={(e) => updateDescription(indicador.id, e.target.value)}
            />
          </div>
        </div>
        {renderAccion(indicador)}
      </div>
    );
  };

  // Helper para añadir la acción a un indicador específico
  const addIndicadorAccion = (indicadorId) => {
    setFormData(prevFormData => ({
      ...prevFormData,
      componentes: updateItemField(prevFormData.componentes, indicadorId, 'accion', {
        id: `accion-${Date.now()}`,
        descripcion: '',
        responsable: { id: '', descripcion: '' },
        recursos: { id: '', descripcion: '' },
        fechas: { fecha_inicio: '', fecha_final: '' }
      })
    }));
  };

  const renderMeta = (meta, objetivoId) => {
    return (
      <div key={meta.id} className="card mt-3 border-info" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Meta</h6>
          {!isEditing && (

          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', 'subprocesos', 'metas_plan_desarrollo', 'objetivos', objetivoId, 'metas'], meta.id)}
          >
            Eliminar Meta
          </button>
          )}
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <textarea
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
              rows="3"
              value={meta.descripcion}
              onChange={(e) => updateDescription(meta.id, e.target.value)}
            />
          </div>
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Valor de meta:</label>
            <input
              type="number"
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
              value={meta.valor_meta}
              onChange={(e) => updateValorMeta(meta.id, e.target.value)}
            />
          </div>

          {/* Selector de Unidad de Meta */}
          <div className="mt-3">
            <label className="block text-sm mb-2 ml-4 fw-bold">Unidad de Meta:</label>
            <select
              className="w-full !border border-custom-blue-dark rounded-xl"
              value={meta.unidad_meta_id || ''}
              onChange={(e) => updateUnidadMetaId(meta.id, e.target.value)}
              required
              disabled={isUnidadesMetaLoading}
            >
              <option value="">
                {isUnidadesMetaLoading ? 'Cargando unidades...' : 'Seleccione una unidad'}
              </option>
              {unidadesMeta.map((unidad) => (
                <option key={unidad.id} value={unidad.id}>
                  {`${unidad.unidad_parcial}`}
                </option>
              ))}
            </select>
          </div>

          {/* {meta.descripcion && meta.valor_meta && meta.unidad_meta_id && (
            <div className="mt-3">
            {!isEditing && (
          )}
            className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
            onClick={() => addIndicador(meta.id)}
          >
            Agregar Indicador
          </button>
        </div>
              <button
          )} */}
          {meta.indicadores && meta.indicadores.map(indicador => renderIndicador(indicador, meta.id))}
        </div>
      </div>
    );
  };

  const renderObjetivo = (objetivo, metaPlanId) => {
    return (
      <div key={objetivo.id} className="card mt-3 border-primary" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Objetivo Estratégico</h6>
          {!isEditing && (

          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', 'subprocesos', 'metas_plan_desarrollo', metaPlanId, 'objetivos'], objetivo.id)}
          >
            Eliminar Objetivo
          </button>
          )}
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <textarea
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
              rows="3"
              value={objetivo.descripcion}
              onChange={(e) => updateDescription(objetivo.id, e.target.value)}
            />
          </div>
          {objetivo.descripcion && (
            <div className="mt-3">
              {!isEditing && (
              <button
                className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
                onClick={() => addMeta(objetivo.id)}
              >
                Agregar Meta
              </button>
              )}
            </div>
          )}
          {objetivo.metas.map(meta => renderMeta(meta, objetivo.id))}
        </div>
      </div>
    );
  };

  const renderMetaPlan = (metaPlan, subprocesoId) => {
    return (
      <div key={metaPlan.id} className="card mt-3 border-success" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Meta del Plan de Desarrollo</h5>
          {!isEditing && (

          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', 'subprocesos', subprocesoId, 'metas_plan_desarrollo'], metaPlan.id)}
          >
            Eliminar Meta del Plan
          </button>
          )}
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <textarea
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
              rows="3"
              value={metaPlan.descripcion}
              onChange={(e) => updateDescription(metaPlan.id, e.target.value)}
            />
          </div>
          {metaPlan.descripcion && (
            <div className="mt-3">
              {!isEditing && (
              <button
                className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
                onClick={() => addObjetivo(metaPlan.id)}
              >
                Agregar Objetivo Estratégico
              </button>
              )}
            </div>
          )}
          {metaPlan.objetivos.map(objetivo => renderObjetivo(objetivo, metaPlan.id))}
        </div>
      </div>
    );
  };

  const renderSubproceso = (subproceso, procesoId) => {
    return (
      <div key={subproceso.id} className="card mt-3 border-warning" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Subproceso</h5>
          {!isEditing && (

          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', procesoId, 'subprocesos'], subproceso.id)}
          >
            Eliminar Subproceso
          </button>
          )}
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <textarea
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
              rows="3"
              value={subproceso.descripcion}
              onChange={(e) => updateDescription(subproceso.id, e.target.value)}
            />
          </div>
          {subproceso.descripcion && (
            <div className="mt-3">
              {!isEditing && (
              <button
                className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
                onClick={() => addMetaPlan(subproceso.id)}
              >
                Agregar Meta del Plan
              </button>
              )}
            </div>
          )}
          {subproceso.metas_plan_desarrollo.map(metaPlan => renderMetaPlan(metaPlan, subproceso.id))}
        </div>
      </div>
    );
  };

  const renderProceso = (proceso, componenteId) => {
    return (
      <div key={proceso.id} className="card mt-3 border-danger" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h4 className="mb-0">Proceso</h4>
          {!isEditing && (

          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => removeElement(['componentes', componenteId, 'procesos'], proceso.id)}
          >
            Eliminar Proceso
          </button>
          )}
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <textarea
              className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
              rows="3"
              value={proceso.descripcion}
              onChange={(e) => updateDescription(proceso.id, e.target.value)}
            />
          </div>
          {proceso.descripcion && (
            <div className="mt-3">
              {!isEditing && (
              <button
                className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
                onClick={() => addSubproceso(proceso.id)}
              >
                Agregar Subproceso
              </button>
              )}
            </div>
          )}
          {proceso.subprocesos.map(subproceso => renderSubproceso(subproceso, proceso.id))}
        </div>
      </div>
    );
  };

  const renderComponente = (componente) => {
    return (
      <div key={componente.id} className="card mt-3 border-primary" style={{ width: '100%' }}>
        <div className="card-header bg-light d-flex justify-content-between align-items-center">
          <h3 className="mb-0">Componente</h3>
          {!isEditing && (

          <button
            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
            onClick={() => removeElement(['componentes'], componente.id)}
          >
            Eliminar Componente
          </button>
          )}
        </div>
        <div className="card-body">
          <div>
            <label className="block text-sm mb-2 ml-4 fw-bold">Descripción:</label>
            <select
              className="w-full !border border-custom-blue-dark rounded-xl"
              value={componente.id || ''}
              onChange={(e) => updateComponenteId(componente.id, e.target.value)}
              required
              disabled={isComponentesLoading}
            >
              <option value="">
                {isComponentesLoading ? 'Cargando componentes...' : 'Seleccione un componente'}
              </option>
              {componentes.map((componente) => (
                <option key={componente.id} value={componente.id}>
                  {`${componente.descripcion}`}
                </option>
              ))}
            </select>
          </div>
          {componente.id && (
            <div className="mt-3">
              {!isEditing && (
              <button
                className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
                onClick={() => addProceso(componente.id)}
              >
                Agregar Proceso
              </button>
              )}
            </div>
          )}
          {componente.procesos.map(proceso => renderProceso(proceso, componente.id))}
        </div>
      </div>
    );
  };

  if (isLoading || isUsersLoading) {
    return (
      <div className="container py-4 text-center">
        <div className="spinner-border text-primary" role="status">
          <span className="visually-hidden">Cargando...</span>
        </div>
        <p className="mt-2">Cargando datos del registro y usuarios...</p>
      </div>
    );
  }

  return (
    <div className="container py-4">
      <div className='mb-2'>
          <CNavigationButton to={ isEditing ? '/pam/' + pamGeneralIdEdit + '/index' : '/pam/' + pamGeneralId + '/index'} />
      </div>
      <div className="card shadow">
        <div className="card-header bg-white">
          <h1 className="h3 mb-0">
            {isEditing ? `Editar PAM` : 'Nuevo Plan de apoyo al mejoramiento (PAM)'}
          </h1>
          <p className="mb-0 text-muted">
            {isEditing ? 'Modifique los campos necesarios' : 'Complete cada descripción para habilitar el siguiente nivel'}
          </p>
        </div>
        <div className="card-body">
          <button
            type="button"
            className="border bg-blue-500  text-white p-2 rounded-pill mt-2"
            onClick={addComponente}
          >
            <i className="bi bi-plus-circle"></i> Agregar Componente
          </button>

          <div id="componentes-container">
            {formData.componentes.map(componente => renderComponente(componente))}
          </div>

          <div className="mt-4 pt-3 border-top">
            <button
              type="button"
              className="border bg-blue-500  text-white p-2 rounded-pill me-2"
              onClick={saveAll}
              disabled={formData.componentes.length === 0} // Deshabilita si no hay componentes
            >
              <i className="bi bi-save"></i> {isEditing ? 'Actualizar' : 'Guardar'}
            </button>

            <button
              type="button"
              className="border bg-blue-500  text-white p-2 rounded-pill"
              onClick={() => {
                // Valida si isEditing es verdadero
                const url = isEditing
                  ? '/pam/' + pamGeneralIdEdit + '/index'
                  : '/pam/' + pamGeneralId + '/index';

                // Navega a la URL construida
                window.location.href = url;
              }}
            >
              <i className="bi bi-arrow-left"></i> Volver al listado
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default PamForm;
