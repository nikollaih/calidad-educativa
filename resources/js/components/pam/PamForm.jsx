 import React, { useState, useEffect } from 'react';
import { route } from 'preact-router';
import Swal from 'sweetalert2';

const PamForm = ({ id, csrfToken = '' }) => {
  // El estado ahora maneja un array de componentes, permitiendo múltiples jerarquías
  const [formData, setFormData] = useState({
    componentes: [], // Ahora un array de componentes
  });
  const [isLoading, setIsLoading] = useState(true);
  const [isEditing, setIsEditing] = useState(false);
  const [originalData, setOriginalData] = useState(null); // No se usa directamente en el renderizado, pero se mantiene para referencia
  const [users, setUsers] = useState([]);
  const [isUsersLoading, setIsUsersLoading] = useState(false);

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
    return items.map(item => {
      // Si encontramos el elemento por su ID
      if (item.id === targetId) {
        return { ...item, [fieldName]: newValue };
      }

      // Si el elemento tiene una 'accion' anidada y su ID coincide
      if (item.accion && item.accion.id === targetId) {
        return { ...item, accion: { ...item.accion, [fieldName]: newValue } };
      }

      // Recursivamente busca en los arrays de hijos si existen
      if (item.procesos) {
        item.procesos = updateItemField(item.procesos, targetId, fieldName, newValue);
      }
      if (item.subprocesos) {
        item.subprocesos = updateItemField(item.subprocesos, targetId, fieldName, newValue);
      }
      if (item.metas_plan_desarrollo) {
        item.metas_plan_desarrollo = updateItemField(item.metas_plan_desarrollo, targetId, fieldName, newValue);
      }
      if (item.objetivos) {
        item.objetivos = updateItemField(item.objetivos, targetId, fieldName, newValue);
      }
      if (item.metas) {
        item.metas = updateItemField(item.metas, targetId, fieldName, newValue);
      }
      if (item.indicadores) {
        item.indicadores = updateItemField(item.indicadores, targetId, fieldName, newValue);
      }
      return item;
    });
  };

  /**
   * Función específica para actualizar el campo 'descripcion' de cualquier elemento anidado.
   *
   * @param {string} itemId El ID del elemento cuya descripción se va a actualizar.
   * @param {string} value El nuevo valor de la descripción.
   */
  const updateDescription = (itemId, value) => {

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
      return { componentes: newComponents };
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
                id: data.componente_id || `componente-${Date.now()}`,
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


  // --- Funciones para agregar elementos (ahora agregan a arrays específicos) ---

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
                        descripcion: '',
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
      componente: firstComponent.descripcion,
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
        id: isEditing ? id : null, // Solo envía ID si está editando
        componentes: formData.componentes.map(comp => ({
          // id: comp.id,
          descripcion: comp.descripcion,
          procesos: comp.procesos.map(proc => ({
            // id: proc.id,
            descripcion: proc.descripcion,
            subprocesos: proc.subprocesos.map(subproc => ({
              // id: subproc.id,
              descripcion: subproc.descripcion,
              metas_plan_desarrollo: subproc.metas_plan_desarrollo.map(metaPlan => ({
                // id: metaPlan.id,
                descripcion: metaPlan.descripcion,
                objetivos: metaPlan.objetivos.map(obj => ({
                  // id: obj.id,
                  descripcion: obj.descripcion,
                  metas: obj.metas.map(meta => ({
                    // id: meta.id,
                    descripcion: meta.descripcion,
                    indicadores: meta.indicadores.map(indicador => ({
                      // id: indicador.id,
                      descripcion: indicador.descripcion,
                      accion: indicador.accion ? { // Asegúrate de que accion exista
                        // id: indicador.accion.id,
                        descripcion: indicador.accion.descripcion,
                        user_id: indicador.accion.responsable?.id, // Envía solo el ID del responsable
                        responsable_nombre: indicador.accion.responsable?.descripcion, // Mantiene la descripción si es necesaria
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

      const url = isEditing ? `/pam/update-pam/${id}` : '/pam/pam-row-store';
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
            className="btn btn-danger btn-sm"
            onClick={() => updateAccionNestedField(indicadorId, 'fechas', null)} // Establece fechas a null para eliminar
          >
            Eliminar Fechas
          </button>
        </div>
        <div className="card-body">
          {/* Eliminadas las clases col-md-6 para asegurar 100% de ancho */}
          <div>
            <label className="form-label fw-bold">Fecha de Inicio:</label>
            <input
              type="date"
              className="form-control"
              style={{ width: '100%' }}
              value={accion.fechas.fecha_inicio}
              onChange={(e) => updateAccionNestedField(indicadorId, 'fechas', {
                ...accion.fechas,
                fecha_inicio: e.target.value
              })}
            />
          </div>
          <div className="mt-3"> {/* Añadido margen para espaciado */}
            <label className="form-label fw-bold">Fecha Final:</label>
            <input
              type="date"
              className="form-control"
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
            className="btn btn-danger btn-sm"
            onClick={() => updateAccionNestedField(indicadorId, 'recursos', null)} // Establece recursos a null para eliminar
          >
            Eliminar Recursos
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={accion.recursos.descripcion}
              onInput={(e) => updateAccionNestedField(indicadorId, 'recursos', { ...accion.recursos, descripcion: e.target.value })}
            />
          </div>
          {accion.recursos.descripcion && !accion.fechas && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => updateAccionNestedField(indicadorId, 'fechas', { fecha_inicio: '', fecha_final: '' })}
              >
                Agregar Fechas
              </button>
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
            className="btn btn-danger btn-sm"
            onClick={() => updateAccionNestedField(indicadorId, 'responsable', null)} // Establece responsable a null para eliminar
          >
            Eliminar Responsable
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Seleccionar Responsable:</label>
            {isUsersLoading ? (
              <p>Cargando usuarios...</p>
            ) : (
              <select
                className="form-control"
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
              <button
                className="btn btn-primary mt-2"
                onClick={() => updateAccionNestedField(indicadorId, 'recursos', { descripcion: '' })}
              >
                Agregar Recursos
              </button>
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
            className="btn btn-danger btn-sm"
            onClick={() => updateAccionNestedField(indicador.id, 'accion', null)} // Establece acción a null para eliminar
          >
            Eliminar Acción
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={indicador.accion.descripcion}
              onInput={(e) => updateDescription(indicador.accion.id, e.target.value)} // Usar updateDescription para la descripción de la acción
            />
          </div>
          {indicador.accion.descripcion && !indicador.accion.responsable && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => updateAccionNestedField(indicador.id, 'responsable', { id: '', descripcion: '' })}
              >
                Agregar Responsable
              </button>
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
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', 'subprocesos', 'metas_plan_desarrollo', 'objetivos', 'metas', metaId, 'indicadores'], indicador.id)}
          >
            Eliminar Indicador
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={indicador.descripcion}
              onInput={(e) => updateDescription(indicador.id, e.target.value)}
            />
          </div>
          {indicador.descripcion && !indicador.accion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addIndicadorAccion(indicador.id)} // Función para agregar la acción al indicador
              >
                Agregar Acción
              </button>
            </div>
          )}
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
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', 'subprocesos', 'metas_plan_desarrollo', 'objetivos', objetivoId, 'metas'], meta.id)}
          >
            Eliminar Meta
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
          <input
            type="number"
            className="form-control"
            value={meta.descripcion}
            onChange={(e) => updateDescription(meta.id, e.target.value)}
          />
          </div>
          {meta.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addIndicador(meta.id)}
              >
                Agregar Indicador
              </button>
            </div>
          )}
          {meta.indicadores.map(indicador => renderIndicador(indicador, meta.id))}
        </div>
      </div>
    );
  };

  const renderObjetivo = (objetivo, metaPlanId) => {
    return (
      <div key={objetivo.id} className="card mt-3 border-primary" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Objetivo Estratégico</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', 'subprocesos', 'metas_plan_desarrollo', metaPlanId, 'objetivos'], objetivo.id)}
          >
            Eliminar Objetivo
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={objetivo.descripcion}
              onInput={(e) => updateDescription(objetivo.id, e.target.value)}
            />
          </div>
          {objetivo.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addMeta(objetivo.id)}
              >
                Agregar Meta
              </button>
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
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', 'subprocesos', subprocesoId, 'metas_plan_desarrollo'], metaPlan.id)}
          >
            Eliminar Meta del Plan
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={metaPlan.descripcion}
              onInput={(e) => updateDescription(metaPlan.id, e.target.value)}
            />
          </div>
          {metaPlan.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addObjetivo(metaPlan.id)}
              >
                Agregar Objetivo Estratégico
              </button>
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
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(['componentes', 'procesos', procesoId, 'subprocesos'], subproceso.id)}
          >
            Eliminar Subproceso
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={subproceso.descripcion}
              onInput={(e) => updateDescription(subproceso.id, e.target.value)}
            />
          </div>
          {subproceso.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addMetaPlan(subproceso.id)}
              >
                Agregar Meta del Plan
              </button>
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
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(['componentes', componenteId, 'procesos'], proceso.id)}
          >
            Eliminar Proceso
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={proceso.descripcion}
              onInput={(e) => updateDescription(proceso.id, e.target.value)}
            />
          </div>
          {proceso.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addSubproceso(proceso.id)}
              >
                Agregar Subproceso
              </button>
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
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement(['componentes'], componente.id)}
          >
            Eliminar Componente
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={componente.descripcion}
              onInput={(e) => updateDescription(componente.id, e.target.value)}
            />
          </div>
          {componente.descripcion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={() => addProceso(componente.id)}
              >
                Agregar Proceso
              </button>
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
      <div className="card shadow">
        <div className="card-header bg-white">
          <h1 className="h3 mb-0">
            {isEditing ? `Editar PAM #${id}` : 'Nuevo Plan de apoyo al mejoramiento (PAM)'}
          </h1>
          <p className="mb-0 text-muted">
            {isEditing ? 'Modifique los campos necesarios' : 'Complete cada descripción para habilitar el siguiente nivel'}
          </p>
        </div>
        <div className="card-body">
          <button
            type="button"
            className="btn btn-success mb-4"
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
              className="btn btn-primary me-2"
              onClick={saveAll}
              disabled={formData.componentes.length === 0} // Deshabilita si no hay componentes
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
          </div>
        </div>
      </div>
    </div>
  );
};

export default PamForm;
