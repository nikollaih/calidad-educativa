import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';
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

  // Cargar datos cuando el componente se monta o el ID cambia
  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        
        // Si no hay ID o es 'new', es un nuevo registro
        if (!id || isNaN(id)) {
          setIsEditing(false);
          setIsLoading(false);
          return;
        }

        // Es un registro existente, cargar los datos
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

          console.log(data);
          
          // Mapear los datos del backend al formato del frontend
          setFormData({
            componente: data.componente ? { id: 'componente-1', descripcion: data.componente } : null,
            proceso: data.proceso ? { id: 'proceso-1', descripcion: data.proceso } : null,
            subproceso: data.subproceso ? { id: 'subproceso-1', descripcion: data.subproceso } : null,
            meta_plan_desarrollo: data.meta_plan_desarrollo ? { id: 'meta-plan-1', descripcion: data.meta_plan_desarrollo } : null,
            objetivo: data.objetivo_estrategico ? { id: 'objetivo-1', descripcion: data.objetivo_estrategico } : null,
            meta: data.meta ? { id: 'meta-1', descripcion: data.meta } : null,
            indicador: data.indicador ? { id: 'indicador-1', descripcion: data.indicador } : null,
            accion: data.accion ? { id: 'accion-1', descripcion: data.accion } : null,
            responsable: data.responsable ? { id: 'responsable-1', descripcion: data.responsable } : 'asd',
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
          route('/pam'); // Redirigir al listado si hay error
        });
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, [id]);

  // Helper function for updating form data
  const updateField = (field, value) => {
    setFormData(prev => ({
      ...prev,
      [field]: value
    }));
  };

  // Funciones para agregar elementos (igual que antes)
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
    if (!formData.accion || formData.responsable) return;
    const newResponsable = { id: `responsable-${Date.now()}`, descripcion: '' };
    updateField('responsable', newResponsable);
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

  // Función para eliminar elementos y sus dependencias
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
      const newData = {...prev};
      fieldsToReset.forEach(f => {
        newData[f] = null;
      });
      return newData;
    });
  };

  // Función para guardar los datos (actualizada para manejar edición)
  const saveAll = async () => {
    // Validación de campos requeridos
    const requiredFields = {
      componente: 'Componente',
      proceso: 'Proceso',
      subproceso: 'Subproceso',
      meta_plan_desarrollo: 'Meta del Plan de Desarrollo',
      objetivo: 'Objetivo Estratégico',
      meta: 'Meta',
      indicador: 'Indicador',
      accion: 'Acción',
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

    // Validación de fechas
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
      // Preparar datos para enviar
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
        responsable: formData.responsable?.descripcion || '',
        recursos: formData.recursos.descripcion,
        fecha_inicio: formData.fechas.fecha_inicio,
        fecha_final: formData.fechas.fecha_final
      };

      // Determinar la URL y método según si es edición o creación
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

      // Manejar la respuesta
      if (response.redirected) {
        window.location.href = response.url;
        return;
      }

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

      // Éxito - mostrar mensaje
      await Swal.fire({
        title: '¡Éxito!',
        text: isEditing ? 'Registro actualizado correctamente' : 'Registro creado correctamente',
        icon: 'success',
        confirmButtonText: 'Aceptar'
      });

      // Si es nuevo registro, redirigir a la edición
      if (!isEditing && responseData.id) {
        route(`/pam/pam-form/${responseData.id}`);
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

  
  // Actualiza la función renderFechas para mostrar los campos de fecha
  const renderFechas = () => {
    if (!formData.fechas) return null;
    
    return (
      <div className="card mb-3 border-secondary" style={{ width: '100%' }}>
        <div className="card-header bg-secondary bg-opacity-10 d-flex justify-content-between align-items-center">
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
            <div className="col-md-6 mb-3">
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
            <div className="col-md-6 mb-3">
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
      <div className="card mb-3 border-info" style={{ width: '100%' }}>
        <div className="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Recursos</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('recursos')}
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
          {renderFechas()}
        </div>
      </div>
    );
  };

  // Component to render responsible
  const renderResponsable = () => {
    if (!formData.responsable) return null;
    return (
      <div className="card mb-3 border-dark" style={{ width: '100%' }}>
        <div className="card-header bg-dark bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Responsable</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('responsable')}
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
              value={formData.responsable.descripcion}
              onInput={(e) => updateField('responsable', { ...formData.responsable, descripcion: e.target.value })}
            />
          </div>
          {formData.responsable.descripcion && !formData.recursos && (
            <div className="mt-3">
              <button
                className="btn btn-primary mt-2"
                onClick={addRecursos}
              >
                Agregar Recursos
              </button>
            </div>
          )}
          {renderRecursos()}
        </div>
      </div>
    );
  };

  // Component to render action
  const renderAccion = () => {
    if (!formData.accion) return null;
    return (
      <div className="card mb-3 border-warning" style={{ width: '100%' }}>
        <div className="card-header bg-warning bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Acción</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('accion')}
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
          {renderResponsable()}
        </div>
      </div>
    );
  };

  // Component to render indicator
  const renderIndicador = () => {
    if (!formData.indicador) return null;
    return (
      <div className="card mb-3 border-success" style={{ width: '100%' }}>
        <div className="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Indicador</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('indicador')}
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
          {renderAccion()}
        </div>
      </div>
    );
  };

  // Component to render goal
  const renderMeta = () => {
    if (!formData.meta) return null;
    return (
      <div className="card mb-3 border-primary" style={{ width: '100%' }}>
        <div className="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Meta</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('meta')}
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
          {renderIndicador()}
        </div>
      </div>
    );
  };

  // Component to render objective
  const renderObjetivo = () => {
    if (!formData.objetivo) return null;
    return (
      <div className="card mb-3 border-danger" style={{ width: '100%' }}>
        <div className="card-header bg-danger bg-opacity-10 d-flex justify-content-between align-items-center">
          <h6 className="mb-0">Objetivo Estratégico</h6>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('objetivo')}
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
          {renderMeta()}
        </div>
      </div>
    );
  };

  // Component to render development plan goal
  const renderMetaPlan = () => {
    if (!formData.meta_plan_desarrollo) return null;
    return (
      <div className="card mb-3 border-info" style={{ width: '100%' }}>
        <div className="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Meta del Plan de Desarrollo</h5>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('meta_plan_desarrollo')}
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
          <div className="ms-4">
            {renderObjetivo()}
          </div>
        </div>
      </div>
    );
  };

  // Component to render subprocess
  const renderSubproceso = () => {
    if (!formData.subproceso) return null;
    return (
      <div className="card mb-3 border-success" style={{ width: '100%' }}>
        <div className="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Subproceso</h5>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('subproceso')}
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
          {renderMetaPlan()}
        </div>
      </div>
    );
  };

  // Component to render process
  const renderProceso = () => {
    if (!formData.proceso) return null;
    return (
      <div className="card mb-3 border-primary" style={{ width: '100%' }}>
        <div className="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
          <h4 className="mb-0">Proceso</h4>
          <button
            className="btn btn-danger btn-sm"
            onClick={() => removeElement('proceso')}
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
          <div className="ms-4">
            {renderSubproceso()}
          </div>
        </div>
      </div>
    );
  };

  // Component to render component
  const renderComponente = () => {
    if (!formData.componente) return null;
    return (
      <div className="card mb-3" style={{ width: '100%' }}>
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
          <div className="mb-3">
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
          <div>
            {renderProceso()}
          </div>
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
              onClick={() => route('/pam')}
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