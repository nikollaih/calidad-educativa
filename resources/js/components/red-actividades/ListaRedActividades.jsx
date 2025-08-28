import React, { useState, useEffect, useRef } from 'react';
// Se eliminó la importación de Lucide-React y se usaron las clases de Font Awesome directamente.
// Los íconos de Font Awesome deben estar disponibles a través de una hoja de estilos CSS en el proyecto HTML.

export default function ListaRedActividades({
  agregarUrl,
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
    setIntegranteContacto(integrante.numero_contacto || ''); // CAMBIO: Se corrigió la propiedad de contacto
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
  
  // Maneja la acción de eliminar (se mantiene)
  const handleDelete = async (id, type) => {
    showConfirm('¿Estás seguro de que quieres eliminar este registro?', async () => {
        setLoading(true);
        try {
            const url = type === 'actividad' ? `red-actividades/${id}` : `/integrantes/${id}`;
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
                window.location.reload(); 
            } else {
                window.location.reload();
            }
        } catch (error) {
            showAlert(`Error al eliminar: ${error.message}`);
        } finally {
            setLoading(false);
        }
    });
  };

  // CAMBIO: Se modifica la función para realizar envíos de forma nativa
  const handleFormSubmit = async (e, type) => {
    e.preventDefault();

    setLoading(true);

    let url = '';
    let formData = new FormData(); // Usamos FormData para manejar los archivos y datos

      if (type === 'actividad') {
        // Validación de campos obligatorios
        if (!actividadFecha.trim() || !actividadDescripcion.trim()) {
          showAlert('Por favor, completa los campos obligatorios (Fecha y Descripción).');
          setLoading(false);
          return;
        }
        
        // CAMBIO: La URL de la petición.
        url = modalActividadMode === 'editar' ? `/red-actividades/${currentActividad.id}` : agregarUrl;

        // CAMBIO: Se añaden todos los datos al objeto FormData
        formData.append('_token', csrfToken);
        formData.append('fecha', actividadFecha);
        formData.append('descripcion', actividadDescripcion);

        // CAMBIO: Si es edición, se añade el método de sobreescritura
        if (modalActividadMode === 'editar') {
          formData.append('_method', 'PUT');
        }
        
        // CAMBIO: Se añaden los archivos al FormData. ¡Esto es lo que soluciona el problema!
        // Se itera sobre la lista de archivos adjuntos.
        actividadAdjuntos.forEach((file) => {
          // Se verifica que sea una instancia de File (un archivo nuevo subido).
          // Los archivos existentes ya se manejan en el backend.
          if (file instanceof File) {
            // Se añade el archivo al FormData con el mismo nombre que espera el backend ('adjuntos[]').
            formData.append('adjuntos[]', file);
          }
        });
        
      } else if (type === 'integrante') {
        // Validación de campos obligatorios
        if (!integranteNombre.trim()) {
          showAlert('Por favor, completa el campo obligatorio (Nombre).');
          setLoading(false);
          return;
        }

        url = modalIntegranteMode === 'editar' ? `/red-integrantes/${currentIntegrante.id}` : '/red-integrantes';

        // CAMBIO: Se añaden los datos del integrante al FormData
        formData.append('_token', csrfToken);
        formData.append('nombre', integranteNombre);
        formData.append('correo', integranteCorreo);
        formData.append('numero_contacto', integranteContacto);
        formData.append('actividad_id', integranteActividad);
        formData.append('rol', integranteRol);

        // Si es edición, se añade el método PUT
        if (modalIntegranteMode === 'editar') {
          formData.append('_method', 'PUT');
        }
      }

      // CAMBIO: Se realiza la petición con Fetch API en lugar de un submit nativo
      const response = await fetch(url, {
        method: 'POST',
        body: formData, // Se envía el objeto FormData directamente
        // NOTA: No es necesario especificar el 'Content-Type' para FormData,
        // el navegador lo hace automáticamente y lo configura como 'multipart/form-data'.
      });

      console.log('response', response);
      

      console.log('type', type);
      
      setLoading(false);
      // Después de un envío exitoso, se cierran los modales y se actualiza la UI.
      if (type === 'actividad') {
        handleCloseActividadModal();
        window.location.reload();
      } else {
        handleCloseIntegranteModal();
        setActiveTab('integrantes')
      }


  };

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
        body: JSON.stringify({ role: selectedRole, _token: csrfToken }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Error al compartir');
      }

      showAlert('Elemento compartido con éxito.');
      setShowShareModal(false);
      setSelectedRole('');
    } catch (error) {
      showAlert(`Error al compartir: ${error.message}`);
    } finally {
      setLoading(false);
    }
  };


  // Función para renderizar la tabla de actividades
  const renderActividadesTable = () => (
    <div class="mt-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Lista de Actividades</h4>
        <button class="btn btn-primary" onClick={handleAgregarActividadClick}>
          {/* Se reemplazó el componente LuPlus por la clase de Font Awesome */}
          <i class="fa fa-plus me-2"></i>Agregar Actividad
        </button>
      </div>
      <table class="table table-striped table-hover">
        <thead class="bg-primary text-white">
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
                <td>{actividad.descripcion ?? 'Sin información'}</td>
                <td>
                  {/* NUEVO: Botón para ver documentos */}
                  {actividad.adjuntos && actividad.adjuntos.length > 0 && (
                    <button
                      onClick={() => handleVerDocumentosClick(actividad.adjuntos)}
                      className="btn btn-info btn-sm me-2"
                    >
                      <i class="fa fa-eye text-white"></i>
                    </button>
                  )}
                  {/* NUEVO: Botón de compartir */}
                  <button
                    onClick={() => handleCompartirClick(actividad, 'actividad')}
                    className="btn btn-secondary btn-sm me-2"
                  >
                    <i class="fa fa-share-alt text-white"></i>
                  </button>
                  {/* Se reemplazó el componente LuFileEdit por la clase de Font Awesome */}
                  <button
                    onClick={() => handleEditarActividadClick(actividad)}
                    className="btn btn-warning btn-sm me-2"
                  >
                    <i class="fa fa-pen-to-square text-white"></i>
                  </button>
                  {/* Se reemplazó el componente LuTrash2 por la clase de Font Awesome */}
                  <button
                    className="btn btn-danger btn-sm"
                    onClick={() => handleDelete(actividad.id, 'actividad')}
                  >
                    <i class="fa fa-trash-alt text-white"></i>
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
    <div class="mt-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Lista de Integrantes</h4>
        <button class="btn btn-primary" onClick={handleAgregarIntegranteClick}>
          {/* Se reemplazó el componente LuPlus por la clase de Font Awesome */}
          <i class="fa fa-plus me-2"></i>Agregar Integrante
        </button>
      </div>

      <table class="table table-striped table-hover">
        <thead class="bg-primary text-white">
          <tr>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {/* CAMBIO: Ahora se usa la variable integrantes en lugar de redesAprendizajes */}
          {integrantes.length > 0 ? (
            integrantes.map((integrante) => (
              <tr key={integrante.id}>
                <td>{integrante.nombre ?? 'N/A'}</td>
                <td>{integrante.telefono ?? 'N/A'}</td>
                <td>{integrante.correo ?? 'N/A'}</td>
                <td>{integrante.rol ?? 'N/A'}
                  {/* MODIFICACIÓN: Se busca el nombre del rol en la lista de roles */}
                  {/* {integrantesRoles.find(r => r.id === integrante.rol)?.nombre ?? 'N/A'} */}
                </td>
                <td>
                  {/* NUEVO: Botón de compartir */}
                  <button
                    onClick={() => handleCompartirClick(integrante, 'integrante')}
                    className="btn btn-secondary btn-sm me-2"
                  >
                    <i class="fa fa-share-alt text-white"></i> Compartir
                  </button>
                  {/* Se reemplazó el componente LuFileEdit por la clase de Font Awesome */}
                  <button
                    onClick={() => handleEditarIntegranteClick(integrante)}
                    className="btn btn-warning btn-sm me-2"
                  >
                    <i class="fa fa-pen-to-square text-white"></i>
                  </button>
                  {/* Se reemplazó el componente LuTrash2 por la clase de Font Awesome */}
                  <button
                    className="btn btn-danger btn-sm"
                    onClick={() => handleDelete(integrante.id, 'integrante')}
                  >
                    <i class="fa fa-trash-alt text-white"></i>
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
    <div class="container mt-4">
      <h2 class="mb-4 text-center">Gestión de Redes de Aprendizaje y Actividades</h2>
      <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
          <a
            class={`nav-link ${activeTab === 'actividades' ? 'active' : ''}`}
            onClick={() => setActiveTab('actividades')}
          >
            Actividades
          </a>
        </li>
        <li class="nav-item">
          <a
            class={`nav-link ${activeTab === 'integrantes' ? 'active' : ''}`}
            onClick={() => setActiveTab('integrantes')}
          >
            Integrantes
          </a>
        </li>
      </ul>

      <div class="tab-content mt-3 p-3 border border-top-0 rounded-bottom">
        {loading && <div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>}
        {activeTab === 'actividades' && renderActividadesTable()}
        {activeTab === 'integrantes' && renderIntegrantesTable()}
      </div>

      {/* Modal de formulario de actividades */}
      {showActividadModal && (
        <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  {modalActividadMode === 'agregar' ? 'Agregar Actividad' : 'Editar Actividad'}
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  onClick={handleCloseActividadModal}
                ></button>
              </div>
              <form onSubmit={handleActividadSubmit}>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="actividadFecha" class="form-label">Fecha<span class="text-danger">*</span></label>
                    <input
                      type="date"
                      class="form-control"
                      id="actividadFecha"
                      value={actividadFecha}
                      onInput={(e) => setActividadFecha(e.target.value)}
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label for="actividadDescripcion" class="form-label">Descripción<span class="text-danger">*</span></label>
                    <textarea
                      class="form-control"
                      id="actividadDescripcion"
                      value={actividadDescripcion}
                      onInput={(e) => setActividadDescripcion(e.target.value)}
                      rows="3"
                      required
                    ></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="actividadAdjuntos" class="form-label">Evidencias</label>
                    <input
                      type="file"
                      class="form-control"
                      id="actividadAdjuntos"
                      multiple
                      onChange={handleFileChange}
                      ref={fileInputRef}
                    />
                    {/* CAMBIO: Se añadió una sección para ver y gestionar los archivos ya adjuntos */}
                    {actividadAdjuntos.length > 0 && (
                      <div class="mt-2">
                        <h6>Archivos seleccionados:</h6>
                        <ul class="list-group">
                          {actividadAdjuntos.map((file, index) => (
                            <li key={index} class="list-group-item d-flex justify-content-between align-items-center">
                              <span>{file.name || `Documento ${index + 1}`}</span>
                              <div>
                                {/* NUEVO: Botón para ver el adjunto */}
                                {file.url && (
                                  <a href={file.url} target="_blank" className="btn btn-info btn-sm me-2">
                                    <i class="fa fa-eye text-white"></i> Ver
                                  </a>
                                )}
                                {/* NUEVO: Botón para eliminar el adjunto del array */}
                                <button
                                  type="button"
                                  className="btn btn-danger btn-sm flex gap-2"
                                  onClick={() => handleRemoveAdjunto(index)}
                                >
                                  <i class="fa fa-trash-alt text-white"></i> Eliminar
                                </button>
                              </div>
                            </li>
                          ))}
                        </ul>
                      </div>
                    )}
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    onClick={handleCloseActividadModal}
                  >
                    Cancelar
                  </button>
                  <button
                    type="submit"
                    class="btn btn-primary"
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
        <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  {modalIntegranteMode === 'agregar' ? 'Agregar Integrante' : 'Editar Integrante'}
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  onClick={handleCloseIntegranteModal}
                ></button>
              </div>
              <form onSubmit={handleIntegranteSubmit}>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="integranteNombre" class="form-label">Nombre<span class="text-danger">*</span></label>
                    <input
                      type="text"
                      class="form-control"
                      id="integranteNombre"
                      value={integranteNombre}
                      onInput={(e) => setIntegranteNombre(e.target.value)}
                    />
                  </div>
                  <div class="mb-3">
                    <label for="integranteCorreo" class="form-label">Correo Electrónico</label>
                    <input
                      type="email"
                      class="form-control"
                      id="integranteCorreo"
                      value={integranteCorreo}
                      onInput={(e) => setIntegranteCorreo(e.target.value)}
                    />
                  </div>
                  <div class="mb-3">
                    <label for="integranteContacto" class="form-label">Número de contacto</label>
                    <input
                      type="text"
                      class="form-control"
                      id="integranteContacto"
                      value={integranteContacto}
                      onInput={(e) => setIntegranteContacto(e.target.value)}
                    />
                  </div>
                  <div class="mb-3">
                    <label for="integranteRol" class="form-label">Rol</label>
                    <select
                      class="form-control"
                      id="integranteRol"
                      value={integranteRol}
                      onChange={(e) => setIntegranteRol(e.target.value)}
                    >
                      <option value="">Selecciona un rol</option>
                      <option value="1">Líder</option>
                      <option value="2">Integrante</option>
                      <option value="3">Aliado</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    onClick={handleCloseIntegranteModal}
                  >
                    Cancelar
                  </button>
                  <button
                    type="submit"
                    class="btn btn-primary"
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
        <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Evidencias de la Actividad</h5>
                <button type="button" class="btn-close" onClick={() => setShowDocumentosModal(false)}></button>
              </div>
              <div class="modal-body">
                {currentDocumentos.length > 0 ? (
                  <ul class="list-group">
                    {currentDocumentos.map((adjunto, index) => (
                      <li key={index} class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{adjunto.adjunto.nombre}</span>
                        <a href={`/storage/${adjunto.adjunto.ruta}`} target="_blank" className="btn btn-info btn-sm">
                          <i class="fa fa-eye text-white"></i> Ver
                        </a>
                      </li>
                    ))}
                  </ul>
                ) : (
                  <p>No hay documentos para esta actividad.</p>
                )}
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onClick={() => setShowDocumentosModal(false)}>Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* NUEVO: Modal para compartir */}
      {showShareModal && (
        <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Compartir con Rol</h5>
                <button type="button" class="btn-close" onClick={() => setShowShareModal(false)}></button>
              </div>
              <form onSubmit={handleShareSubmit}>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="selectRole" class="form-label">Selecciona un rol:</label>
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
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" onClick={() => setShowShareModal(false)}>Cancelar</button>
                  <button type="submit" class="btn btn-primary">Compartir</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}


      {/* Modal de alerta personalizado */}
      {showAlertModal && (
        <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Alerta</h5>
                <button type="button" class="btn-close" onClick={() => setShowAlertModal(false)}></button>
                </div>
              <div class="modal-body">
                <p>{alertMessage}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick={() => setShowAlertModal(false)}>Aceptar</button>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Modal de confirmación personalizado */}
      {showConfirmModal && (
        <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="btn-close" onClick={() => setShowConfirmModal(false)}></button>
              </div>
              <div class="modal-body">
                <p>{alertMessage}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onClick={() => setShowConfirmModal(false)}>Cancelar</button>
                <button type="button" class="btn btn-danger" onClick={() => {
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
    </div>
  );
}