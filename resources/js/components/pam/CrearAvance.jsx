// src/components/CrearAvance.jsx
import { useState, useEffect } from 'preact/hooks';
import { render } from 'preact'; // Asegúrate de tener esto para montar el modal

const CrearAvance = ({ onClose }) => {
  const [isOpen, setIsOpen] = useState(true);
  const [formData, setFormData] = useState({
    fecha_avance: '',
    meta_id: '', // New field for selected meta ID
    accion_id: '', // Changed to accion_id
    cantidad_ejecutada: '',
    observacion: '',
    archivos_adjuntos: [], // Estado para almacenar los objetos File de los adjuntos
  });
  const [metasOptions, setMetasOptions] = useState([]);
  const [filteredMetas, setFilteredMetas] = useState([]);
  const [searchTermMeta, setSearchTermMeta] = useState('');

  const [accionesOptions, setAccionesOptions] = useState([]);
  const [filteredAcciones, setFilteredAcciones] = useState([]);
  const [searchTermAccion, setSearchTermAccion] = useState('');

  const [loadingMetas, setLoadingMetas] = useState(true);
  const [loadingAcciones, setLoadingAcciones] = useState(false); // Initially false, loads after meta selection
  const [submitMessage, setSubmitMessage] = useState(null);

  // --- CSRF Token State ---
  const [csrfToken, setCsrfToken] = useState('');

  // --- Modal control functions ---
  const openModal = () => setIsOpen(true);
  const closeModal = () => {
    setIsOpen(false);
    // Reset the form when closed
    setFormData({
      fecha_avance: '',
      meta_id: '',
      accion_id: '',
      cantidad_ejecutada: '',
      observacion: '',
      archivos_adjuntos: [], // Restablece el array de archivos adjuntos
    });
    setSubmitMessage(null); // Clear message on close
    setSearchTermMeta(''); // Clear search terms
    setSearchTermAccion('');
    setFilteredMetas([]);
    setFilteredAcciones([]);
    setLoadingMetas(true); // Reset loading states to refetch on next open
    setLoadingAcciones(false);
    if (onClose) {
      onClose();
    }
  };

  // Expose openModal globally for Blade
  useEffect(() => {
    window.openCrearAvance = openModal;
    return () => {
      delete window.openCrearAvance;
    };
  }, []);

  // --- Get CSRF token on component mount ---
  useEffect(() => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) {
      setCsrfToken(token);
    } else {
      console.error('CSRF token not found! Ensure meta tag is present in your Blade layout.');
    }
  }, []); // Run once on mount

  // --- Load options for 'metas' selector ---
  useEffect(() => {
    const fetchMetas = async () => {
      try {
        const response = await fetch('/pam/get-metas');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        setMetasOptions(data);
        setFilteredMetas(data); // Initialize filtered metas with all options
      } catch (error) {
        console.error('Error al cargar las metas:', error);
      } finally {
        setLoadingMetas(false);
      }
    };
    if (isOpen && loadingMetas) {
      fetchMetas();
    } else if (!isOpen) {
      setLoadingMetas(true); // Reset loading state for next open
    }
  }, [isOpen, loadingMetas]);

  // --- Filter 'metas' based on search term ---
  useEffect(() => {
    if (searchTermMeta === '') {
      setFilteredMetas(metasOptions);
    } else {
      setFilteredMetas(
        metasOptions.filter((meta) =>
          meta.descripcion.toLowerCase().includes(searchTermMeta.toLowerCase()) // Assuming 'descripcion' is the display field
        )
      );
    }
  }, [searchTermMeta, metasOptions]);

  // --- Load options for 'acciones' selector based on selected meta_id ---
  useEffect(() => {
    const fetchAcciones = async (metaId) => {
      setLoadingAcciones(true);
      try {
        const response = await fetch(`/pam/get-acciones?meta_id=${metaId}`); // Adjusted URL with meta_id
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        setAccionesOptions(data);
        setFilteredAcciones(data); // Initialize filtered acciones with all options
      } catch (error) {
        console.error('Error al cargar las acciones:', error);
        setAccionesOptions([]); // Clear options on error
        setFilteredAcciones([]);
      } finally {
        setLoadingAcciones(false);
      }
    };

    if (formData.meta_id) {
      fetchAcciones(formData.meta_id);
    } else {
      setAccionesOptions([]);
      setFilteredAcciones([]);
      setFormData((prevData) => ({ ...prevData, accion_id: '' })); // Clear selected action if meta is unselected
    }
  }, [formData.meta_id]);

  // --- Filter 'acciones' based on search term ---
  useEffect(() => {
    if (searchTermAccion === '') {
      setFilteredAcciones(accionesOptions);
    } else {
      setFilteredAcciones(
        accionesOptions.filter((accion) =>
          accion.descripcion.toLowerCase().includes(searchTermAccion.toLowerCase()) // Assuming 'descripcion' is the display field
        )
      );
    }
  }, [searchTermAccion, accionesOptions]);

  // --- Handle form changes ---
  const handleChange = (e) => {
    const { name, value, files } = e.target;
    if (name === 'archivos_adjuntos') {
      // Cuando se seleccionan archivos, se añaden al array existente de archivos_adjuntos
      setFormData((prevData) => ({
        ...prevData,
        // Concatena los nuevos archivos con los que ya existían
        [name]: prevData.archivos_adjuntos.concat(Array.from(files)),
      }));
    } else if (name === 'meta_id') {
      setFormData((prevData) => ({
        ...prevData,
        [name]: value,
        accion_id: '', // Reset accion when meta changes
      }));
      setSearchTermAccion(''); // Clear accion search term
    } else {
      setFormData((prevData) => ({
        ...prevData,
        [name]: value,
      }));
    }
  };

  // --- Función para eliminar un archivo adjunto de la lista ---
  const handleDeleteFile = (fileNameToDelete) => {
    setFormData((prevData) => ({
      ...prevData,
      // Filtra el array de archivos adjuntos para remover el archivo con el nombre especificado
      archivos_adjuntos: prevData.archivos_adjuntos.filter(
        (file) => file.name !== fileNameToDelete
      ),
    }));
  };

  // --- Función para abrir un archivo adjunto en una nueva pestaña ---
  const handleOpenFile = (file) => {
    // Crea una URL de objeto temporal para el archivo
    const fileURL = URL.createObjectURL(file);
    // Abre la URL en una nueva ventana/pestaña
    window.open(fileURL, '_blank');
    // Libera la URL del objeto después de un corto tiempo para evitar fugas de memoria
    // (Generalmente, el navegador lo limpia cuando la página se cierra, pero es buena práctica)
    setTimeout(() => URL.revokeObjectURL(fileURL), 100);
  };

  // --- Handle search input changes ---
  const handleSearchMetaChange = (e) => {
    setSearchTermMeta(e.target.value);
    // When searching, clear selected meta if the current input doesn't match a selected one
    if (!metasOptions.some(meta => meta.id === formData.meta_id && meta.descripcion.toLowerCase().includes(e.target.value.toLowerCase()))) {
      setFormData((prevData) => ({ ...prevData, meta_id: '', accion_id: '' }));
    }
  };

  const handleSearchAccionChange = (e) => {
    setSearchTermAccion(e.target.value);
    // When searching, clear selected accion if the current input doesn't match a selected one
    if (!accionesOptions.some(accion => accion.id === formData.accion_id && accion.descripcion.toLowerCase().includes(e.target.value.toLowerCase()))) {
      setFormData((prevData) => ({ ...prevData, accion_id: '' }));
    }
  };

  // --- Handle form submission ---
  const handleSubmit = async (e) => {
    e.preventDefault();
    setSubmitMessage(null); // Clear previous messages

    // Basic client-side validation
    if (!formData.fecha_avance || !formData.meta_id || !formData.accion_id || !formData.cantidad_ejecutada) {
      setSubmitMessage({ type: 'error', text: 'Por favor, completa todos los campos obligatorios.' });
      return;
    }

    const dataToSend = new FormData();
    // *** IMPORTANT: Append the CSRF token here ***
    if (csrfToken) {
      dataToSend.append('_token', csrfToken);
    } else {
      setSubmitMessage({ type: 'error', text: 'Error: CSRF token no disponible. La página podría estar expirada.' });
      return; // Stop submission if token is missing
    }

    dataToSend.append('fecha_avance', formData.fecha_avance);
    dataToSend.append('meta_id', formData.meta_id);
    dataToSend.append('accion_id', formData.accion_id);
    dataToSend.append('cantidad_ejecutada', formData.cantidad_ejecutada);
    dataToSend.append('observacion', formData.observacion);

    // Adjunta cada archivo al FormData
    formData.archivos_adjuntos.forEach((file, index) => {
      dataToSend.append(`archivos_adjuntos[${index}]`, file);
    });

    try {
      const response = await fetch('/pam/store-advance', {
        method: 'POST',
        body: dataToSend,
      });

      if (!response.ok) {
        const errorData = await response.json();
        // If it's a validation error, errorData.errors will contain specific field errors
        if (response.status === 422 && errorData.errors) {
            const errorMessages = Object.values(errorData.errors).flat().join('\n');
            throw new Error(`Errores de validación:\n${errorMessages}`);
        }
        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
      }

      const result = await response.json();
      console.log('Server response:', result);
      setSubmitMessage({ type: 'success', text: result.message || 'Avance guardado exitosamente!' });
      setTimeout(closeModal, 2000);
    } catch (error) {
      console.error('Error al guardar el avance:', error);
      setSubmitMessage({ type: 'error', text: error.message || 'Error al guardar el avance. Inténtalo de nuevo.' });
    }
  };

  if (!isOpen) {
    return null; // Don't render anything if the modal is closed
  }

  return (
    // Modal backdrop
    <div
      className="modal fade show"
      style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}
      tabIndex="-1"
      aria-labelledby="advanceFormModalLabel"
      aria-modal="true"
      role="dialog"
    >
      <div className="modal-dialog modal-lg">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title" id="advanceFormModalLabel">Registrar Avance</h5>
            <button type="button" className="btn-close" onClick={closeModal} aria-label="Cerrar"></button>
          </div>
          <div className="modal-body">
            {submitMessage && (
              <div className={`alert alert-${submitMessage.type === 'success' ? 'success' : 'danger'}`} role="alert">
                {submitMessage.text}
              </div>
            )}
            <form onSubmit={handleSubmit}>
              <div className="mb-3">
                <label htmlFor="fecha_avance" className="form-label">Fecha de Avance:</label>
                <input
                  type="date"
                  className="form-control"
                  id="fecha_avance"
                  name="fecha_avance"
                  value={formData.fecha_avance}
                  onChange={handleChange}
                  required
                />
              </div>

              {/* Meta Selector with Search */}
              <div className="mb-3">
                <label htmlFor="meta_id" className="form-label">Meta:</label>
                {loadingMetas ? (
                  <p>Cargando metas...</p>
                ) : (
                  <>
                    <input
                      type="text"
                      className="form-control mb-2"
                      placeholder="Buscar meta..."
                      value={searchTermMeta}
                      onChange={handleSearchMetaChange}
                    />
                    <select
                      className="form-select"
                      id="meta_id"
                      name="meta_id"
                      value={formData.meta_id}
                      onChange={handleChange}
                      required
                    >
                      <option value="">Selecciona una meta</option>
                      {filteredMetas.map((meta) => (
                        <option key={meta.id} value={meta.id}>
                          {meta.descripcion} {/* Assuming 'descripcion' is the display field */}
                        </option>
                      ))}
                    </select>
                  </>
                )}
              </div>

              {/* Accion Selector with Search (conditionally rendered) */}
              {formData.meta_id && (
                <div className="mb-3">
                  <label htmlFor="accion_id" className="form-label">Acción:</label>
                  {loadingAcciones ? (
                    <p>Cargando acciones...</p>
                  ) : (
                    <>
                      <input
                        type="text"
                        className="form-control mb-2"
                        placeholder="Buscar acción..."
                        value={searchTermAccion}
                        onChange={handleSearchAccionChange}
                        disabled={!formData.meta_id} // Disable if no meta is selected
                      />
                      <select
                        className="form-select"
                        id="accion_id"
                        name="accion_id"
                        value={formData.accion_id}
                        onChange={handleChange}
                        required
                        disabled={!formData.meta_id} // Disable if no meta is selected
                      >
                        <option value="">Selecciona una acción</option>
                        {filteredAcciones.map((accion) => (
                          <option key={accion.id} value={accion.id}>
                            {accion.descripcion} {/* Assuming 'descripcion' is the display field */}
                          </option>
                        ))}
                      </select>
                    </>
                  )}
                </div>
              )}

              <div className="mb-3">
                <label htmlFor="cantidad_ejecutada" className="form-label">Cantidad Ejecutada:</label>
                <input
                  type="number"
                  className="form-control"
                  id="cantidad_ejecutada"
                  name="cantidad_ejecutada"
                  value={formData.cantidad_ejecutada}
                  onChange={handleChange}
                  min="0"
                  required
                />
              </div>

              <div className="mb-3">
                <label htmlFor="observacion" className="form-label">Observación:</label>
                <textarea
                  className="form-control"
                  id="observacion"
                  name="observacion"
                  rows="4"
                  value={formData.observacion}
                  onChange={handleChange}
                ></textarea>
              </div>

              {/* Sección para adjuntar archivos */}
              <div className="mb-3">
                <label htmlFor="archivos_adjuntos" className="form-label">Adjuntar archivo(s) de evidencia(s):</label>
                <input
                  type="file"
                  className="form-control"
                  id="archivos_adjuntos"
                  name="archivos_adjuntos"
                  accept=".jpg,.png,.pdf,.docx"
                  multiple // Permite seleccionar múltiples archivos
                  onChange={handleChange} // Usa la misma función handleChange, adaptada para archivos
                />

                {/* Muestra la lista de archivos seleccionados */}
                {formData.archivos_adjuntos.length > 0 && (
                  <div className="mt-2">
                    <small className="form-text text-muted">Archivos seleccionados:</small>
                    <ul className="list-group">
                      {formData.archivos_adjuntos.map((file, index) => (
                        <li
                          key={file.name + index} // Usa el nombre del archivo y el índice como key única
                          className="list-group-item d-flex justify-content-between align-items-center"
                        >
                          {/* Nombre del archivo clickeable para abrirlo */}
                          <span
                            onClick={() => handleOpenFile(file)}
                            style={{ cursor: 'pointer', color: 'blue', textDecoration: 'underline' }}
                          >
                            {file.name}
                          </span>
                          {/* Botón para eliminar el archivo */}
                          <button
                            type="button"
                            className="btn btn-danger btn-sm"
                            onClick={() => handleDeleteFile(file.name)}
                          >
                            Eliminar
                          </button>
                        </li>
                      ))}
                    </ul>
                  </div>
                )}
              </div>

              <div className="modal-footer">
                <button type="button" className="btn btn-secondary" onClick={closeModal}>Cerrar</button>
                <button type="submit" className="btn btn-primary">Guardar Avance</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CrearAvance;