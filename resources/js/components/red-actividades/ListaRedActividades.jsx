import React, { useState, useEffect, useRef } from 'react';
// Se eliminó la importación de Lucide-React y se usaron las clases de Font Awesome directamente.
// Los íconos de Font Awesome deben estar disponibles a través de una hoja de estilos CSS en el proyecto HTML.

export default function ListaRedActividades({
  agregarUrl,
  isRelatedToRed = false,
  redesActividades = [],
  integrantes = [],
  redesAprendizajes = [],
  csrfToken = ''
}) {
  // Estado para controlar qué pestaña está activa
  const [activeTab, setActiveTab] = useState('actividades');

  // Estados del modal de actividades
  const [showActividadModal, setShowActividadModal] = useState(false);
  const [modalActividadMode, setModalActividadMode] = useState('agregar');
  const [currentActividad, setCurrentActividad] = useState(null);

  // Estados para los campos del formulario de actividades
  const [actividadFecha, setActividadFecha] = useState('');
  const [actividadDescripcion, setActividadDescripcion] = useState('');
  const [actividadAdjuntos, setActividadAdjuntos] = useState([]);
  const fileInputRef = useRef(null);
  const integrantesRoles = [
    { id: 1, name: 'Líder' },
    { id: 2, name: 'Integrante' },
    { id: 3, name: 'Aliado' }
  ];
  // Estado para la lista de redes de aprendizaje
  const [redes, setRedes] = useState(redesAprendizajes);

  
  // Estados de Integrantes (para el segundo tab)
  const [showIntegranteModal, setShowIntegranteModal] = useState(false);
  const [modalIntegranteMode, setModalIntegranteMode] = useState('agregar');
  const [currentIntegrante, setCurrentIntegrante] = useState(null);
  const [integranteNombre, setIntegranteNombre] = useState('');
  const [integranteCorreo, setIntegranteCorreo] = useState(''); // NUEVO: Estado para el correo
  const [integranteContacto, setIntegranteContacto] = useState('');
  const [integranteActividad, setIntegranteActividad] = useState('');
  const [integranteRol, setIntegranteRol] = useState(''); // NUEVO: Estado para el rol del integrante


  // Lógica de carga, errores y modales genéricos (se mantienen)
  const [showAlertModal, setShowAlertModal] = useState(false);
  const [alertMessage, setAlertMessage] = useState('');
  const [showConfirmModal, setShowConfirmModal] = useState(false);
  const [confirmAction, setConfirmAction] = useState(null);
  const [loading, setLoading] = useState(false);

  // Estados para modales de documentos y compartir
  const [showDocumentosModal, setShowDocumentosModal] = useState(false); // NUEVO: Modal de documentos
  const [currentDocumentos, setCurrentDocumentos] = useState([]); // NUEVO: Documentos a mostrar
  const [showShareModal, setShowShareModal] = useState(false); // NUEVO: Modal de compartir
  const [currentShareItem, setCurrentShareItem] = useState(null); // NUEVO: Item a compartir
  const [rolesList, setRolesList] = useState([]); // NUEVO: Lista de roles para compartir
  const [selectedRole, setSelectedRole] = useState(''); // NUEVO: Rol seleccionado para compartir
  // CAMBIO: Estado para la descripción del correo en el modal de compartir
  const [shareDescription, setShareDescription] = useState('');


  // Estado para la lista de usuarios (representantes)
  const [usuarios, setUsuarios] = useState([]);
  const [isLoadingUsers, setIsLoadingUsers] = useState(false);
  const [usersError, setUsersError] = useState(null);

  // Efecto para obtener la lista de usuarios al cargar el componente
  useEffect(() => {
    const fetchUsers = async () => {
      setIsLoadingUsers(true);
      try {
        const response = await fetch('/get-usuarios');
        if (!response.ok) {
          throw new Error('Error al obtener los usuarios.');
        }
        const data = await response.json();
        setUsuarios(data.data);
        setUsersError(null);
      } catch (error) {
        setUsersError(error.message);
      } finally {
        setIsLoadingUsers(false);
      }
    };
    fetchUsers();
  }, []);

  // NUEVO: Efecto para obtener la lista de roles al abrir el modal de compartir
  useEffect(() => {
    if (showShareModal) {
      const fetchRoles = async () => {
        try {
          const response = await fetch('/get-roles'); // O la URL de tu endpoint para roles
          if (!response.ok) {
            throw new Error('Error al obtener los roles.');
          }
          const data = await response.json();
          setRolesList(data);
        } catch (error) {
          showAlert(`Error al cargar roles: ${error.message}`);
        }
      };
      fetchRoles();
    }
  }, [showShareModal]);


  // Función para mostrar el modal de alerta
  const showAlert = (message) => {
    setAlertMessage(message);
    setShowAlertModal(true);
  };

  // Función para mostrar el modal de confirmación
  const showConfirm = (message, action) => {
    setAlertMessage(message);
    setConfirmAction(() => action);
    setShowConfirmModal(true);
  };

  // Lógica para la pestaña de Actividades
  const handleAgregarActividadClick = () => {
    setModalActividadMode('agregar');
    setActividadFecha('');
    setActividadDescripcion('');
    setActividadAdjuntos([]);
    setCurrentActividad(null);
    setShowActividadModal(true);
  };

  const handleEditarActividadClick = (actividad) => {
    setModalActividadMode('editar');
    setCurrentActividad(actividad);
    setActividadFecha(actividad.fecha || '');
    setActividadDescripcion(actividad.descripcion || '');
    // Se asegura de que adjuntos sea un array, incluso si es null
    setActividadAdjuntos(actividad.adjuntos || []);
    setShowActividadModal(true);
  };

  const handleCloseActividadModal = () => {
    setShowActividadModal(false);
    setActividadFecha('');
    setActividadDescripcion('');
    setActividadAdjuntos([]);
    setCurrentActividad(null);
  };
  
  // CAMBIO: Ahora se concatena la nueva lista de archivos con la existente
  const handleFileChange = (e) => {
    const newFiles = Array.from(e.target.files);
    setActividadAdjuntos([...actividadAdjuntos, ...newFiles]);
    // Reinicia el input para permitir seleccionar los mismos archivos de nuevo
    e.target.value = null;
  };

  // NUEVA FUNCIÓN: Maneja la eliminación de un adjunto de la lista temporal
  const handleRemoveAdjunto = (indexToRemove) => {
    setActividadAdjuntos(actividadAdjuntos.filter((_, index) => index !== indexToRemove));
  };


  // Lógica para la pestaña de Integrantes
  const handleAgregarIntegranteClick = () => {
    setModalIntegranteMode('agregar');
    setIntegranteNombre('');
    setIntegranteCorreo(''); // NUEVO
    setIntegranteContacto('');
    setIntegranteActividad('');
    setIntegranteRol(''); // NUEVO
    setCurrentIntegrante(null);
    setShowIntegranteModal(true);
  };

  const handleEditarIntegranteClick = (integrante) => {
    setModalIntegranteMode('editar');
    setCurrentIntegrante(integrante);
    setIntegranteNombre(integrante.nombre || '');
    setIntegranteCorreo(integrante.correo || ''); // NUEVO
    setIntegranteContacto(integrante.telefono || ''); // CAMBIO: Se corrigió la propiedad de contacto
    setIntegranteActividad(integrante.actividad_id || '');
    setIntegranteRol(integrante.rol || ''); // NUEVO
    setShowIntegranteModal(true);
  };

  const handleCloseIntegranteModal = () => {
    setShowIntegranteModal(false);
    setIntegranteNombre('');
    setIntegranteCorreo(''); // NUEVO
    setIntegranteContacto('');
    setIntegranteActividad('');
    setIntegranteRol(''); // NUEVO
    setCurrentIntegrante(null);
  };
  
  // CAMBIO: Función para manejar la eliminación con confirmación
  const handleDeleteConfirm = (id, type) => {
    showConfirm('¿Estás seguro de que quieres eliminar este registro? Esta acción es irreversible.', () => handleDelete(id, type));
  };
  
  // Maneja la acción de eliminar (se mantiene)
  const handleDelete = async (id, type) => {
    setLoading(true);
    try {
        const url = type === 'actividad' ? `red-actividades/${id}` : `/red-integrantes/${id}`;
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'DELETE' 
            },
            body: JSON.stringify({ _method: 'DELETE', _token: csrfToken }),
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Error en el servidor');
        }
        // Lógica para actualizar el estado
        if (type === 'actividad') {
            handleCloseActividadModal();
        } else {
            handleCloseIntegranteModal();
            // CAMBIO: Guarda el tab activo en localStorage antes de recargar
            localStorage.setItem('activeTab', 'integrantes');
        }
        
        window.location.reload();

    } catch (error) {
        showAlert(`Error al eliminar: ${error.message}`);
    } finally {
        setLoading(false);
    }
  };

  // CAMBIO: Se modifica la función para realizar envíos de forma nativa
  const handleFormSubmit = async (e, type) => {
      e.preventDefault();

      setLoading(true);

      let url = '';
      let formData = new FormData();

      if (type === 'actividad') {
          if (!actividadFecha.trim() || !actividadDescripcion.trim()) {
              showAlert('Por favor, completa los campos obligatorios (Fecha y Descripción).');
              setLoading(false);
              return;
          }

          url = modalActividadMode === 'editar' ? `/red-actividades/${currentActividad.id}` : agregarUrl;

          formData.append('_token', csrfToken);
          formData.append('fecha', actividadFecha);
          formData.append('descripcion', actividadDescripcion);

          if (modalActividadMode === 'editar') {
              formData.append('_method', 'PUT');
          }

          actividadAdjuntos.forEach((file) => {
              if (file instanceof File) {
                  formData.append('adjuntos[]', file);
              }
          });

      } else if (type === 'integrante') {
          // Validación de campos obligatorios para integrantes
          if (!integranteNombre.trim() || !integranteCorreo.trim() || !integranteContacto.trim() || !integranteRol) {
            showAlert('Por favor, asegúrese de que todos los campos obligatorios estén completos.');
            setLoading(false);
            return;
        }

          url = modalIntegranteMode === 'editar' ? `/red-integrantes/${currentIntegrante.id}` : '/red-integrantes';

          formData.append('_token', csrfToken);
          formData.append('nombre', integranteNombre);
          formData.append('correo', integranteCorreo);
          formData.append('telefono', integranteContacto);
          formData.append('rol', integranteRol);

          if (modalIntegranteMode === 'editar') {
              formData.append('_method', 'PUT');
          }
      }

      try {
          const response = await fetch(url, {
              method: 'POST',
              body: formData,
          });

          if (!response.ok) {
              const errorData = await response.json();
              throw new Error(errorData.message || 'Error en el servidor');
          }

          if (type === 'actividad') {
              handleCloseActividadModal();
          } else {
              handleCloseIntegranteModal();
              // CAMBIO: Guarda el tab activo en localStorage antes de recargar
              localStorage.setItem('activeTab', 'integrantes');
          }
          
          window.location.reload();
      } catch (error) {
          showAlert(`Error al guardar: ${error.message}`);
      } finally {
          setLoading(false);
      }
  };


useEffect(() => {
  // Se lee el tab guardado en localStorage al cargar el componente
  const savedTab = localStorage.getItem('activeTab');
  if (savedTab) {
    setActiveTab(savedTab);
    // Se elimina el valor de localStorage para que la próxima carga sea normal
    localStorage.removeItem('activeTab');
  }
}, []);
  // CAMBIO: Se llama a la nueva función de envío
  const handleActividadSubmit = (e) => handleFormSubmit(e, 'actividad');
  const handleIntegranteSubmit = (e) => handleFormSubmit(e, 'integrante');

  // NUEVO: Lógica para abrir el modal de documentos
  const handleVerDocumentosClick = (adjuntos) => {
    setCurrentDocumentos(adjuntos);
    setShowDocumentosModal(true);
  };

  // NUEVO: Lógica para el modal de compartir
  const handleCompartirClick = (item, type) => {
    setCurrentShareItem({ ...item, type });
    setShowShareModal(true);
  };

  const handleShareSubmit = async (e) => {
    e.preventDefault();
    if (!selectedRole) {
      showAlert('Por favor, selecciona un rol para compartir.');
      return;
    }

    setLoading(true);
    try {
      const { id, type } = currentShareItem;
      const url = type === 'actividad' ? `/actividades/${id}/share` : `/integrantes/${id}/share`;
      
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        // CAMBIO: Se incluye la descripción en el cuerpo de la petición
        body: JSON.stringify({ role: selectedRole, description: shareDescription, _token: csrfToken }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Error al compartir');
      }

      showAlert('Elemento compartido con éxito.');
      setShowShareModal(false);
      setSelectedRole('');
      setShareDescription(''); // CAMBIO: Se limpia el estado de la descripción al cerrar el modal
    } catch (error) {
      showAlert(`Error al compartir: ${error.message}`);
    } finally {
      setLoading(false);
    }
  };


  // Función para renderizar la tabla de actividades
  const renderActividadesTable = () => (
    <div className="mt-4">
      <div className="d-flex justify-content-between align-items-center mb-3">
        <h4>Lista de Actividades</h4>
        <button className="btn btn-primary" onClick={handleAgregarActividadClick}>
          {/* Se reemplazó el componente LuPlus por la clase de Font Awesome */}
          <i className="fa fa-plus me-2"></i>Agregar Actividad
        </button>
      </div>
      <table className="table table-striped table-hover">
        <thead className="bg-primary text-white">
          <tr>
            <th>Fecha</th>
            <th>Descripción</th>
            {/* CAMBIO: Se quitó la columna de evidencias */}
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {redesActividades.length > 0 ? (
            redesActividades.map((actividad) => (
              <tr key={actividad.id}>
                <td>{actividad.fecha}</td>
                {/* NUEVO: Se agregó un estilo para limitar el ancho y permitir que el texto se envuelva */}
                <td style={{ maxWidth: '250px', wordBreak: 'break-word' }}>
                  {actividad.descripcion ?? 'Sin información'}
                </td>
                <td>
                  {/* NUEVO: Botón para ver documentos */}
                  {actividad.adjuntos && actividad.adjuntos.length > 0 && (
                    <button
                      onClick={() => handleVerDocumentosClick(actividad.adjuntos)}
                      className="btn btn-info btn-sm me-2"
                    >
                      <i className="fa fa-eye text-white"></i>
                    </button>
                  )}
                  {/* NUEVO: Botón de compartir */}
                  <button
                    onClick={() => handleCompartirClick(actividad, 'actividad')}
                    className="btn btn-secondary btn-sm me-2"
                  >
                    <i className="fa fa-share-alt text-white"></i>
                  </button>
                  {/* Se reemplazó el componente LuFileEdit por la clase de Font Awesome */}
                  <button
                    onClick={() => handleEditarActividadClick(actividad)}
                    className="btn btn-warning btn-sm me-2"
                  >
                    <i className="fa fa-pen-to-square text-white"></i>
                  </button>
                  {/* Se reemplazó el componente LuTrash2 por la clase de Font Awesome */}
                  <button
                    className="btn btn-danger btn-sm"
                    onClick={() => handleDeleteConfirm(actividad.id, 'actividad')}
                  >
                    <i className="fa fa-trash-alt text-white"></i>
                  </button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="3" className="text-center">No hay actividades para mostrar.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
);

  // Función para renderizar la tabla de integrantes
  const renderIntegrantesTable = () => (
    <div className="mt-4">
      <div className="d-flex justify-content-between align-items-center mb-3">
        <h4>Lista de Integrantes</h4>
        <button className="btn btn-primary" onClick={handleAgregarIntegranteClick}>
          {/* Se reemplazó el componente LuPlus por la clase de Font Awesome */}
          <i className="fa fa-plus me-2"></i>Agregar Integrante
        </button>
      </div>

      <table className="table table-striped table-hover">
        <thead className="bg-primary text-white">
          <tr>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {integrantes.length > 0 ? (
            integrantes.map((integrante) => (
              <tr key={integrante.id}>
                <td>{integrante.nombre ?? 'N/A'}</td>
                <td>{integrante.telefono ?? 'N/A'}</td>
                <td>{integrante.correo ?? 'N/A'}</td>
                <td>
                  {integrantesRoles.find(r => r.id === integrante.rol)?.name ?? 'N/A'}
                </td>
                <td>
                  {/* Se reemplazó el componente LuFileEdit por la clase de Font Awesome */}
                  <button
                    onClick={() => handleEditarIntegranteClick(integrante)}
                    className="btn btn-warning btn-sm me-2"
                  >
                    <i className="fa fa-pen-to-square text-white"></i>
                  </button>
                  {/* Se reemplazó el componente LuTrash2 por la clase de Font Awesome */}
                  <button
                    className="btn btn-danger btn-sm"
                    onClick={() => handleDeleteConfirm(integrante.id, 'integrante')}
                  >
                    <i className="fa fa-trash-alt text-white"></i>
                  </button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="4" className="text-center">No hay integrantes para mostrar.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
  
  return (
    <div className="container mt-4">
      <h2 className="mb-4 text-center">Gestión de Redes de Aprendizaje y Actividades</h2>
      {!isRelatedToRed ? (
        <div className="alert alert-info text-center" role="alert">
          El usuario actual no tiene redes asociadas.
        </div>
      ) : (
        <>
          <ul className="nav nav-tabs nav-justified">
            <li className="nav-item">
              <a
                className={`nav-link ${activeTab === 'actividades' ? 'active' : ''}`}
                onClick={() => setActiveTab('actividades')}
              >
                Actividades
              </a>
            </li>
            <li className="nav-item">
              <a
                className={`nav-link ${activeTab === 'integrantes' ? 'active' : ''}`}
                onClick={() => setActiveTab('integrantes')}
              >
                Integrantes
              </a>
            </li>
          </ul>

          <div className="tab-content mt-3 p-3 border border-top-0 rounded-bottom">
            {loading && <div className="text-center my-5"><div className="spinner-border text-primary" role="status"><span className="visually-hidden">Cargando...</span></div></div>}
            {activeTab === 'actividades' && renderActividadesTable()}
            {activeTab === 'integrantes' && renderIntegrantesTable()}
          </div>

          {/* Modal de formulario de actividades */}
          {showActividadModal && (
            <div className="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
              <div className="modal-dialog modal-lg">
                <div className="modal-content">
                  <div className="modal-header d-flex justify-content-between align-items-center">
                    {/* COMENTARIO: Se agregó una clase al div principal para separar el título del botón. */}
                    <div className="d-flex align-items-center me-3">
                      <h5 className="modal-title me-4">
                        {modalActividadMode === 'agregar' ? 'Agregar Actividad' : 'Editar Actividad'}
                      </h5>
                    </div>
                    <button
                      type="button"
                      className="btn-close"
                      onClick={handleCloseActividadModal}
                    ></button>
                  </div>
                  <form onSubmit={handleActividadSubmit}>
                    <div className="modal-body">
                      <div className="mb-3">
                        <label htmlFor="actividadFecha" className="form-label">Fecha<span className="text-danger">*</span></label>
                        <input
                          type="date"
                          className="form-control"
                          id="actividadFecha"
                          value={actividadFecha}
                          onInput={(e) => setActividadFecha(e.target.value)}
                          required
                        />
                      </div>
                      <div className="mb-3">
                        <label htmlFor="actividadDescripcion" className="form-label">Descripción<span className="text-danger">*</span></label>
                        <textarea
                          className="form-control"
                          id="actividadDescripcion"
                          value={actividadDescripcion}
                          onInput={(e) => setActividadDescripcion(e.target.value)}
                          rows="3"
                          required
                        ></textarea>
                      </div>
                      <div className="mb-3">
                        <label htmlFor="actividadAdjuntos" className="form-label">Evidencias</label>
                        <input
                          type="file"
                          className="form-control"
                          id="actividadAdjuntos"
                          multiple
                          onChange={handleFileChange}
                          ref={fileInputRef}
                        />
                        {/* CAMBIO: Se añadió una sección para ver y gestionar los archivos ya adjuntos */}
                        {actividadAdjuntos.length > 0 && (
                          <div className="mt-2">
                            <h6>Archivos seleccionados:</h6>
                            <ul className="list-group">
                              {actividadAdjuntos.map((file, index) => (
                                <li key={index} className="list-group-item d-flex justify-content-between align-items-center">
                                  <span>{file.name || `Documento ${index + 1}`}</span>
                                  <div>
                                    {/* NUEVO: Botón para ver el adjunto */}
                                    {file.url && (
                                      <a href={file.url} target="_blank" className="btn btn-info btn-sm me-2">
                                        <i className="fa fa-eye text-white"></i> Ver
                                      </a>
                                    )}
                                    {/* NUEVO: Botón para eliminar el adjunto del array */}
                                    <button
                                      type="button"
                                      className="btn btn-danger btn-sm flex gap-2"
                                      onClick={() => handleRemoveAdjunto(index)}
                                    >
                                      <i className="fa fa-trash-alt text-white"></i> Eliminar
                                    </button>
                                  </div>
                                </li>
                              ))}
                            </ul>
                          </div>
                        )}
                      </div>
                    </div>
                    <div className="modal-footer">
                      <button
                        type="button"
                        className="btn btn-secondary"
                        onClick={handleCloseActividadModal}
                      >
                        Cancelar
                      </button>
                      <button
                        type="submit"
                        className="btn btn-primary"
                      >
                        Guardar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          )}

          {/* Modal de formulario de integrantes */}
          {showIntegranteModal && (
            <div className="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
              <div className="modal-dialog modal-lg">
                <div className="modal-content">
                  <div className="modal-header d-flex justify-content-between align-items-center">
                    {/* COMENTARIO: Se agregó una clase al div principal para separar el título del botón. */}
                    <div className="d-flex align-items-center me-3">
                      <h5 className="modal-title me-4">
                        {modalIntegranteMode === 'agregar' ? 'Agregar Integrante' : 'Editar Integrante'}
                      </h5>
                    </div>
                    <button
                      type="button"
                      className="btn-close"
                      onClick={handleCloseIntegranteModal}
                    ></button>
                  </div>
                  <form onSubmit={handleIntegranteSubmit}>
                    <div className="modal-body">
                      <div className="mb-3">
                        <label htmlFor="integranteNombre" className="form-label">Nombre <span className="text-danger">*</span></label>
                        <input
                          type="text"
                          className="form-control"
                          id="integranteNombre"
                          value={integranteNombre}
                          onInput={(e) => setIntegranteNombre(e.target.value)}
                        />
                      </div>
                      <div className="mb-3">
                        <label htmlFor="integranteCorreo" className="form-label">Correo Electrónico <span className="text-danger">*</span></label>
                        <input
                          type="email"
                          className="form-control"
                          id="integranteCorreo"
                          value={integranteCorreo}
                          onInput={(e) => setIntegranteCorreo(e.target.value)}
                        />
                      </div>
                      <div className="mb-3">
                        <label htmlFor="integranteContacto" className="form-label">Número de contacto <span className="text-danger">*</span></label>
                        <input
                          type="text"
                          className="form-control"
                          id="integranteContacto"
                          value={integranteContacto}
                          onInput={(e) => setIntegranteContacto(e.target.value)}
                        />
                      </div>
                      <div className="mb-3">
                        <label htmlFor="integranteRol" className="form-label">Rol <span className="text-danger">*</span></label>
                        <select
                            className="form-control"
                            id="integranteRol"
                            value={integranteRol}
                            onChange={(e) => setIntegranteRol(e.target.value)}
                        >
                            <option value="">Selecciona un rol</option>
                            {/* MODIFICACIÓN: Se usa map() para generar las opciones */}
                            {integrantesRoles.map(rol => (
                                <option key={rol.id} value={rol.id}>{rol.name}</option>
                            ))}
                        </select>
                      </div>
                    </div>
                    <div className="modal-footer">
                      <button
                        type="button"
                        className="btn btn-secondary"
                        onClick={handleCloseIntegranteModal}
                      >
                        Cancelar
                      </button>
                      <button
                        type="submit"
                        className="btn btn-primary"
                      >
                        Guardar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          )}

          {/* NUEVO: Modal para ver documentos de la actividad */}
          {showDocumentosModal && (
            <div className="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
              <div className="modal-dialog">
                <div className="modal-content">
                  <div className="modal-header">
                    <h5 className="modal-title">Evidencias de la Actividad</h5>
                    <button type="button" className="btn-close" onClick={() => setShowDocumentosModal(false)}></button>
                  </div>
                  <div className="modal-body">
                    {currentDocumentos.length > 0 ? (
                      <ul className="list-group">
                        {currentDocumentos.map((adjunto, index) => (
                          <li key={index} className="list-group-item d-flex justify-content-between align-items-center">
                            <span>{adjunto.adjunto.nombre}</span>
                            <a href={`/storage/${adjunto.adjunto.ruta}`} target="_blank" className="btn btn-info btn-sm">
                              <i className="fa fa-eye text-white"></i> Ver
                            </a>
                          </li>
                        ))}
                      </ul>
                    ) : (
                      <p>No hay documentos para esta actividad.</p>
                    )}
                  </div>
                  <div className="modal-footer">
                    <button type="button" className="btn btn-secondary" onClick={() => setShowDocumentosModal(false)}>Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
          )}

          {/* NUEVO: Modal para compartir */}
          {showShareModal && (
            <div className="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
              <div className="modal-dialog">
                <div className="modal-content">
                  <div className="modal-header">
                    <h5 className="modal-title">Compartir con Rol</h5>
                    <button type="button" className="btn-close" onClick={() => setShowShareModal(false)}></button>
                  </div>
                  <form onSubmit={handleShareSubmit}>
                    <div className="modal-body">
                      <div className="mb-3">
                        <label htmlFor="selectRole" className="form-label">Selecciona un rol:</label>
                        <select
                          id="selectRole"
                          className="form-control"
                          value={selectedRole}
                          onChange={(e) => setSelectedRole(e.target.value)}
                        >
                          <option value="">-- Selecciona --</option>
                          {rolesList.map(rol => (
                            <option key={rol.id} value={rol.id}>{rol.name}</option>
                          ))}
                        </select>
                      </div>
                      {/* CAMBIO: Se agregó el textarea para la descripción del correo */}
                      <div className="mb-3">
                        <label htmlFor="shareDescription" className="form-label">Descripción para el correo</label>
                        <textarea
                          id="shareDescription"
                          className="form-control"
                          rows="3"
                          value={shareDescription}
                          onChange={(e) => setShareDescription(e.target.value)}
                        ></textarea>
                        <small className="form-text text-muted">Esta descripción se incluirá en el cuerpo del correo.</small>
                      </div>
                    </div>
                    <div className="modal-footer">
                      <button type="button" className="btn btn-secondary" onClick={() => setShowShareModal(false)}>Cancelar</button>
                      <button type="submit" className="btn btn-primary">Compartir</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          )}

          {/* Modal de alerta personalizado */}
          {showAlertModal && (
            <div className="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
              <div className="modal-dialog">
                <div className="modal-content">
                  <div className="modal-header">
                    <h5 className="modal-title">Alerta</h5>
                    <button type="button" className="btn-close" onClick={() => setShowAlertModal(false)}></button>
                  </div>
                  <div className="modal-body">
                    <p>{alertMessage}</p>
                  </div>
                  <div className="modal-footer">
                    <button type="button" className="btn btn-primary" onClick={() => setShowAlertModal(false)}>Aceptar</button>
                  </div>
                </div>
              </div>
            </div>
          )}

          {/* Modal de confirmación personalizado */}
          {showConfirmModal && (
            <div className="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
              <div className="modal-dialog">
                <div className="modal-content">
                  <div className="modal-header">
                    <h5 className="modal-title">Confirmación</h5>
                    <button type="button" className="btn-close" onClick={() => setShowConfirmModal(false)}></button>
                  </div>
                  <div className="modal-body">
                    <p>{alertMessage}</p>
                  </div>
                  <div className="modal-footer">
                    <button type="button" className="btn btn-secondary" onClick={() => setShowConfirmModal(false)}>Cancelar</button>
                    <button type="button" className="btn btn-danger" onClick={() => {
                      if (confirmAction) {
                        confirmAction();
                      }
                      setShowConfirmModal(false);
                    }}>Confirmar</button>
                  </div>
                </div>
              </div>
            </div>
          )}
        </>
      )}
    </div>
  );
}