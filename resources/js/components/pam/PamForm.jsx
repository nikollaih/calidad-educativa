import React, { useState, useEffect } from 'react';
// import { useState, useEffect } from 'preact/hooks';
import { route } from 'preact-router';
import Swal from 'sweetalert2';

const PamForm = ({ id, csrfToken = '' }) => {
  const [formData, setFormData] = useState({
    componente: null,
    proceso: null,
    subproceso: null,
    meta_plan_desarrollo: null,
    objetivo: null,
    meta: null,
    indicador: null,
    accion: null,
    responsable: null,
    recursos: null,
    fechas: null
  });
  const [isLoading, setIsLoading] = useState(true);
  const [isEditing, setIsEditing] = useState(false);
  const [originalData, setOriginalData] = useState(null);
  // NEW STATE: To store the list of users for the dropdown
  const [users, setUsers] = useState([]);
  const [isUsersLoading, setIsUsersLoading] = useState(false);


  // Cargar datos cuando el componente se monta o el ID cambia
  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);

        // If no ID or it's 'new', it's a new record
        if (!id || isNaN(id)) {
          setIsEditing(false);
          setIsLoading(false);
          return;
        }

        // It's an existing record, load the data
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

          // Map backend data to frontend format
          setFormData({
            componente: data.componente ? { id: 'componente-1', descripcion: data.componente } : null,
            proceso: data.proceso ? { id: 'proceso-1', descripcion: data.proceso } : null,
            subproceso: data.subproceso ? { id: 'subproceso-1', descripcion: data.subproceso } : null,
            meta_plan_desarrollo: data.meta_plan_desarrollo ? { id: 'meta-plan-1', descripcion: data.meta_plan_desarrollo } : null,
            objetivo: data.objetivo_estrategico ? { id: 'objetivo-1', descripcion: data.objetivo_estrategico } : null,
            meta: data.meta ? { id: 'meta-1', descripcion: data.meta } : null,
            indicador: data.indicador ? { id: 'indicador-1', descripcion: data.indicador } : null,
            accion: data.accion ? { id: 'accion-1', descripcion: data.accion } : null,
            // Adjust responsible to match the new selector's value format (e.g., the user's ID)
            // You might need to adjust 'id' based on what your /usuarios/get returns
            responsable: data.responsable ? { id: data.user_id || 'responsable-1', descripcion: data.responsable } : null, // Assuming user_id exists
            responsable_id: data.responsable ? { id: data.user_id || 'responsable-1', descripcion: data.responsable } : null, // Assuming user_id exists
            recursos: data.recursos ? { id: 'recursos-1', descripcion: data.recursos } : null,
            fechas: (data.fecha_inicio || data.fecha_final) ? {
              id: 'fechas-1',
              fecha_inicio: data.fecha_inicio ? data.fecha_inicio.split(' ')[0] : '',
              fecha_final: data.fecha_final ? data.fecha_final.split(' ')[0] : ''
            } : null
          });
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
          route('/pam'); // Redirect to the list if there's an error
        });
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, [id]);

  // NEW useEffect: Fetch users when the component mounts
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
  }, []); // Empty dependency array means this runs once on mount


  // Helper function for updating form data
  const updateField = (field, value) => {
    setFormData(prev => ({
      ...prev,
      [field]: value
    }));
  };

  // Functions to add elements (same as before)
  const addComponente = () => {
    if (formData.componente) return;
    const newComponent = { id: `componente-${Date.now()}`, descripcion: '' };
    updateField('componente', newComponent);
  };

  const addProceso = () => {
    if (!formData.componente || formData.proceso) return;
    const newProceso = { id: `proceso-${Date.now()}`, descripcion: '' };
    updateField('proceso', newProceso);
  };

  const addSubproceso = () => {
    if (!formData.proceso || formData.subproceso) return;
    const newSubproceso = { id: `subproceso-${Date.now()}`, descripcion: '' };
    updateField('subproceso', newSubproceso);
  };

  const addMetaPlan = () => {
    if (!formData.subproceso || formData.meta_plan_desarrollo) return;
    const newMetaPlan = { id: `meta-plan-${Date.now()}`, descripcion: '' };
    updateField('meta_plan_desarrollo', newMetaPlan);
  };

  const addObjetivo = () => {
    if (!formData.meta_plan_desarrollo || formData.objetivo) return;
    const newObjetivo = { id: `objetivo-${Date.now()}`, descripcion: '' };
    updateField('objetivo', newObjetivo);
  };

  const addMeta = () => {
    if (!formData.objetivo || formData.meta) return;
    const newMeta = { id: `meta-${Date.now()}`, descripcion: '' };
    updateField('meta', newMeta);
  };

  const addIndicador = () => {
    if (!formData.meta || formData.indicador) return;
    const newIndicador = { id: `indicador-${Date.now()}`, descripcion: '' };
    updateField('indicador', newIndicador);
  };

  const addAccion = () => {
    if (!formData.indicador || formData.accion) return;
    const newAccion = { id: `accion-${Date.now()}`, descripcion: '' };
    updateField('accion', newAccion);
  };

  const addResponsable = () => {
    // No need to set a default id/descripcion here, let the dropdown handle it
    if (!formData.accion || formData.responsable) return;
    updateField('responsable', { id: '', descripcion: '' }); // Initialize with empty values
  };

  const addRecursos = () => {
    if (!formData.responsable || formData.recursos) return;
    const newRecursos = { id: `recursos-${Date.now()}`, descripcion: '' };
    updateField('recursos', newRecursos);
  };

  const addFechas = () => {
    if (!formData.recursos || formData.fechas) return;
    const newFechas = { id: `fechas-${Date.now()}`, fecha_inicio: '', fecha_final: '' };
    updateField('fechas', newFechas);
  };

  // Function to remove elements and their dependencies
  const removeElement = (field) => {
    if (!confirm('¿Estás seguro de que deseas eliminar este elemento y todos sus elementos hijos?')) {
      return;
    }

    const fieldOrder = [
      'componente', 'proceso', 'subproceso', 'meta_plan_desarrollo',
      'objetivo', 'meta', 'indicador', 'accion', 'responsable', 'recursos', 'fechas'
    ];
    const fieldIndex = fieldOrder.indexOf(field);

    if (fieldIndex === -1) return;

    const fieldsToReset = fieldOrder.slice(fieldIndex);

    setFormData(prev => {
      const newData = { ...prev
      };
      fieldsToReset.forEach(f => {
        newData[f] = null;
      });
      return newData;
    });
  };

  // Function to save data (updated to handle editing)
  const saveAll = async () => {
    // Validation of required fields
    const requiredFields = {
      componente: 'Componente',
      proceso: 'Proceso',
      subproceso: 'Subproceso',
      meta_plan_desarrollo: 'Meta del Plan de Desarrollo',
      objetivo: 'Objetivo Estratégico',
      meta: 'Meta',
      indicador: 'Indicador',
      accion: 'Acción',
      responsable_id: 'Responsable',
      // user_id: 'Id del responsable',
      recursos: 'Recursos',
      fecha_inicio: 'Fecha de Inicio',
      fecha_final: 'Fecha Final'
    };

    const missingFields = [];
    Object.entries(requiredFields).forEach(([field, name]) => {
      if (field === 'fecha_inicio' || field === 'fecha_final') {
        if (!formData.fechas?.[field]) {
          missingFields.push(`• ${name}`);
        }
      } else if (field === 'responsable') {
        // For responsible, check if both id and description are present
        if (!formData.responsable?.id || !formData.responsable?.descripcion) {
            missingFields.push(`• ${name}`);
        }
      } else if (!formData[field]?.descripcion) {
        missingFields.push(`• ${name}`);
      }
    });

    if (missingFields.length > 0) {
      await Swal.fire({
        title: 'Campos obligatorios faltantes',
        html: missingFields.join('<br>'),
        icon: 'error',
        confirmButtonText: 'Entendido'
      });
      return;
    }

    // Date validation
    if (new Date(formData.fechas.fecha_final) < new Date(formData.fechas.fecha_inicio)) {
      await Swal.fire({
        title: 'Error en fechas',
        text: 'La fecha final no puede ser anterior a la fecha de inicio',
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
      // Prepare data to send
      const dataToSend = {
        id: isEditing ? id : null,
        componente: formData.componente.descripcion,
        proceso: formData.proceso.descripcion,
        subproceso: formData.subproceso.descripcion,
        meta_plan_desarrollo: formData.meta_plan_desarrollo.descripcion,
        objetivo_estrategico: formData.objetivo.descripcion,
        meta: formData.meta.descripcion,
        indicador: formData.indicador.descripcion,
        accion: formData.accion.descripcion,
        // Send the ID of the selected user for responsible
        user_id: formData.responsable?.id ?? formData.user_id,
        responsable: formData.responsable.descripcion, // Keep sending description if needed on backend
        recursos: formData.recursos.descripcion,
        fecha_inicio: formData.fechas.fecha_inicio,
        fecha_final: formData.fechas.fecha_final
      };
      console.log('dataToSend', dataToSend);
      

      // Determine URL and method based on whether it's editing or creating
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

      // Success - show message
      await Swal.fire({
        title: '¡Éxito!',
        text: isEditing ? 'Registro actualizado correctamente' : 'Registro creado correctamente',
        icon: 'success',
        confirmButtonText: 'Aceptar'
      });

      // Reset form data after successful save/update
      setFormData({
        componente: null,
        proceso: null,
        subproceso: null,
        meta_plan_desarrollo: null,
        objetivo: null,
        meta: null,
        indicador: null,
        accion: null,
        responsable: null,
        recursos: null,
        fechas: null
      });

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


  // Actualiza la función renderFechas para mostrar los campos de fecha
  const renderFechas = () => {
    if (!formData.fechas) return null;

    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Fechas</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('fechas')}
          >
            Eliminar Fechas
          </button>
        </div>
        <div className="card-body">

          {/* Campos de fecha */}
          <div className="row">
            <div className="col-md-6 ">
              <label className="form-label fw-bold">Fecha de Inicio:</label>
              <input
                type="date"
                className="form-control"
                value={formData.fechas.fecha_inicio}
                onChange={(e) => updateField('fechas', {
                  ...formData.fechas,
                  fecha_inicio: e.target.value
                })}
              />
            </div>
            <div className="col-md-6 ">
              <label className="form-label fw-bold">Fecha Final:</label>
              <input
                type="date"
                className="form-control"
                value={formData.fechas.fecha_final}
                onChange={(e) => updateField('fechas', {
                  ...formData.fechas,
                  fecha_final: e.target.value
                })}
                min={formData.fechas.fecha_inicio} // Fecha mínima = fecha inicio
              />
            </div>
          </div>
        </div>
        </div>
    );
  };

  // Component to render resources
  const renderRecursos = () => {
    if (!formData.recursos) return null;
    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Recursos</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('recursos')}
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
              value={formData.recursos.descripcion}
              onInput={(e) => updateField('recursos', { ...formData.recursos, descripcion: e.target.value })}
            />
          </div>
          {formData.recursos.descripcion && !formData.fechas && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addFechas}
              >
                Agregar Fechas
              </button>
            </div>
          )}
        </div>
          {renderFechas()}
      </div>
    );
  };

  // NEW renderResponsable function with a selector
  const renderResponsable = () => {
    if (!formData.responsable) return null;

    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Responsable</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('responsable')}
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
                value={formData.responsable.id || ''} // Use the ID for the select's value
                onChange={(e) => {
                  const selectedUserId = e.target.value;
                  const selectedUser = users.find(user => user.id === parseInt(selectedUserId));
                  updateField('responsable', {
                    id: selectedUserId,
                    descripcion: selectedUser ? selectedUser.name : '' // Assuming 'name' is the display field
                  });
                }}
                required
              >
                <option value="">Seleccione un responsable</option>
                {users.map((user) => (
                  <option key={user.id} value={user.id}>
                    {user.name} {/* Assuming user object has 'id' and 'name' properties */}
                  </option>
                ))}
              </select>
            )}
          </div>
          {/* Only enable adding resources if a responsible is selected */}
          {formData.responsable?.id && !formData.recursos && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addRecursos}
              >
                Agregar Recursos
              </button>
            </div>
          )}
        </div>
          {renderRecursos()}
      </div>
    );
  };

  // Component to render action
  const renderAccion = () => {
    if (!formData.accion) return null;
    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Acción</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('accion')}
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
              value={formData.accion.descripcion}
              onInput={(e) => updateField('accion', { ...formData.accion, descripcion: e.target.value })}
            />
          </div>
          {formData.accion.descripcion && !formData.responsable && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addResponsable}
              >
                Agregar Responsable
              </button>
            </div>
          )}
        </div>
          {renderResponsable()}
      </div>
    );
  };

  // Component to render indicator
  const renderIndicador = () => {
    if (!formData.indicador) return null;
    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Indicador</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('indicador')}
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
              value={formData.indicador.descripcion}
              onInput={(e) => updateField('indicador', { ...formData.indicador, descripcion: e.target.value })}
            />
          </div>
          {formData.indicador.descripcion && !formData.accion && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addAccion}
              >
                Agregar Acción
              </button>
            </div>
          )}
        </div>
          {renderAccion()}
      </div>
    );
  };

  // Component to render goal
  const renderMeta = () => {
    if (!formData.meta) return null;
    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Meta</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('meta')}
          >
            Eliminar Meta
          </button>
        </div>
        <div className="card-body">
          <div>
            <label className="form-label fw-bold">Descripción:</label>
            <textarea
              className="form-control"
              rows="3"
              value={formData.meta.descripcion}
              onInput={(e) => updateField('meta', { ...formData.meta, descripcion: e.target.value })}
            />
          </div>
          {formData.meta.descripcion && !formData.indicador && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addIndicador}
              >
                Agregar Indicador
              </button>
            </div>
          )}
        </div>
          {renderIndicador()}
      </div>
    );
  };

  // Component to render objective
  const renderObjetivo = () => {
    if (!formData.objetivo) return null;
    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Objetivo Estratégico</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('objetivo')}
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
              value={formData.objetivo.descripcion}
              onInput={(e) => updateField('objetivo', { ...formData.objetivo, descripcion: e.target.value })}
            />
          </div>
          {formData.objetivo.descripcion && !formData.meta && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addMeta}
              >
                Agregar Meta
              </button>
            </div>
          )}
        </div>
          {renderMeta()}
      </div>
    );
  };

  // Component to render development plan goal
  const renderMetaPlan = () => {
    if (!formData.meta_plan_desarrollo) return null;
    return (
      <div className="card  border-info" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Meta del Plan de Desarrollo</h5>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('meta_plan_desarrollo')}
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
              value={formData.meta_plan_desarrollo.descripcion}
              onInput={(e) => updateField('meta_plan_desarrollo', { ...formData.meta_plan_desarrollo, descripcion: e.target.value })}
            />
          </div>
          {formData.meta_plan_desarrollo.descripcion && !formData.objetivo && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addObjetivo}
              >
                Agregar Objetivo Estratégico
              </button>
            </div>
          )}
        </div>
            {renderObjetivo()}
      </div>
    );
  };

  // Component to render subprocess
  const renderSubproceso = () => {
    if (!formData.subproceso) return null;
    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Subproceso</h5>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('subproceso')}
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
              value={formData.subproceso.descripcion}
              onInput={(e) => updateField('subproceso', { ...formData.subproceso, descripcion: e.target.value })}
            />
          </div>
          {formData.subproceso.descripcion && !formData.meta_plan_desarrollo && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addMetaPlan}
              >
                Agregar Meta del Plan
              </button>
            </div>
          )}
        </div>
            {renderMetaPlan()}
      </div>
    );
  };

  // Component to render process
  const renderProceso = () => {
    if (!formData.proceso) return null;
    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
          <h4 className="mb-0">Proceso</h4>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('proceso')}
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
              value={formData.proceso.descripcion}
              onInput={(e) => updateField('proceso', { ...formData.proceso, descripcion: e.target.value })}
            />
          </div>
          {formData.proceso.descripcion && !formData.subproceso && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addSubproceso}
              >
                Agregar Subproceso
              </button>
            </div>
          )}
        </div>
            {renderSubproceso()}
      </div>
    );
  };

  // Component to render component
  const renderComponente = () => {
    if (!formData.componente) return null;
    return (
      <div className="card" style={{ width: '100%' }}>
        <div className="card-header bg-light d-flex justify-content-between align-items-center">
          <h3 className="mb-0">Componente</h3>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('componente')}
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
              value={formData.componente.descripcion}
              onInput={(e) => updateField('componente', { ...formData.componente, descripcion: e.target.value })}
            />
          </div>
          {formData.componente.descripcion && !formData.proceso && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addProceso}
              >
                Agregar Proceso
              </button>
            </div>
          )}
        </div>
            {renderProceso()}
      </div>
    );
  };

  if (isLoading || isUsersLoading) { // Check both loading states
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
          {!formData.componente && (
            <button
              type="button"
              className="btn btn-success mb-4"
              onClick={addComponente}
            >
              <i className="bi bi-plus-circle"></i> Agregar componente
            </button>
          )}

          <div id="componentes-container">
            {renderComponente()}
          </div>

          <div className="mt-4 pt-3 border-top">
            <button
              type="button"
              className="btn btn-primary me-2"
              onClick={saveAll}
              disabled={!formData.componente}
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