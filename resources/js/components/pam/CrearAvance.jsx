// src/components/CrearAvance.jsx
import { useState, useEffect } from 'preact/hooks';
import { render } from 'preact'; // Asegúrate de tener esto para montar el modal

const CrearAvance = ({ onClose }) => {
  const [isOpen, setIsOpen] = useState(true);
  const [formData, setFormData] = useState({
    fecha_avance: '',
    accion: '',
    cantidad_ejecutada: '',
    observacion: '',
    archivos_adjuntos: [], // Para almacenar los objetos File
  });
  const [accionesOptions, setAccionesOptions] = useState([]);
  const [loadingAcciones, setLoadingAcciones] = useState(true);
  const [submitMessage, setSubmitMessage] = useState(null); // Para mensajes de éxito/error

  // --- Funciones de control del modal ---
  const openModal = () => setIsOpen(true);
  const closeModal = () => {
    setIsOpen(false);
    // Reiniciar el formulario cuando se cierra
    setFormData({
      fecha_avance: '',
      accion: '',
      cantidad_ejecutada: '',
      observacion: '',
      archivos_adjuntos: [],
    });
    setSubmitMessage(null); // Limpiar mensaje al cerrar
    if (onClose) {
      onClose();
    }
  };

  // Exponemos la función openModal globalmente para ser llamada desde Blade
  useEffect(() => {
    window.openCrearAvance = openModal;
    return () => {
      delete window.openCrearAvance;
    };
  }, []); // Se ejecuta una sola vez al montar el componente

  // --- Carga de opciones para el selector de 'accion' ---
  useEffect(() => {
    const fetchAcciones = async () => {
      try {
        const response = await fetch('/get-pam-rows'); // Ajusta la URL si es necesario
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        // Asume que 'data' es un array de objetos con 'id' y 'nombre' (o el nombre real de tu campo)
        setAccionesOptions(data);
      } catch (error) {
        console.error('Error al cargar las acciones:', error);
        // Podrías establecer un estado de error para mostrar al usuario
      } finally {
        setLoadingAcciones(false);
      }
    };
    if (isOpen && loadingAcciones) { // Cargar opciones solo cuando el modal se abre y si no se han cargado
      fetchAcciones();
    } else if (!isOpen) {
        // Reiniciar el estado de carga si el modal se cierra, para que se recarguen si se abre de nuevo
        setLoadingAcciones(true);
    }
  }, [isOpen]); // Depende de 'isOpen' para recargar cuando el modal se abre

  // --- Manejo de cambios en el formulario ---
  const handleChange = (e) => {
    const { name, value, files } = e.target;
    if (name === 'archivos_adjuntos') {
      setFormData((prevData) => ({
        ...prevData,
        [name]: files ? Array.from(files) : [],
      }));
    } else {
      setFormData((prevData) => ({
        ...prevData,
        [name]: value,
      }));
    }
  };

  // --- Manejo del envío del formulario ---
  const handleSubmit = async (e) => {
    e.preventDefault();
    setSubmitMessage(null); // Limpiar mensajes anteriores

    const dataToSend = new FormData();
    dataToSend.append('fecha_avance', formData.fecha_avance);
    dataToSend.append('accion', formData.accion);
    dataToSend.append('cantidad_ejecutada', formData.cantidad_ejecutada);
    dataToSend.append('observacion', formData.observacion);

    formData.archivos_adjuntos.forEach((file, index) => {
      dataToSend.append(`archivos_adjuntos[${index}]`, file);
    });

    try {
      const response = await fetch('/save-advance', { // Ajusta la URL de envío
        method: 'POST',
        body: dataToSend,
        // No establezcas 'Content-Type' para FormData, el navegador lo hace automáticamente
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
      }

      const result = await response.json();
      setSubmitMessage({ type: 'success', text: result.message || 'Avance guardado exitosamente!' });
      // Podrías cerrar el modal o limpiar el formulario después de un éxito
      setTimeout(closeModal, 2000); // Cierra el modal después de 2 segundos
    } catch (error) {
      console.error('Error al guardar el avance:', error);
      setSubmitMessage({ type: 'error', text: error.message || 'Error al guardar el avance. Inténtalo de nuevo.' });
    }
  };

  if (!isOpen) {
    return null; // No renderiza nada si el modal está cerrado
  }

  return (
    // Backdrop del modal
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

              <div className="mb-3">
                <label htmlFor="accion" className="form-label">Acción:</label>
                {loadingAcciones ? (
                  <p>Cargando acciones...</p>
                ) : (
                  <select
                    className="form-select"
                    id="accion"
                    name="accion"
                    value={formData.accion}
                    onChange={handleChange}
                    required
                  >
                    <option value="">Selecciona una acción</option>
                    {accionesOptions.map((accion) => (
                      <option key={accion.id} value={accion.id}>
                        {accion.nombre} {/* Asume que tus objetos tienen 'nombre' */}
                      </option>
                    ))}
                  </select>
                )}
              </div>

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

              <div className="mb-3">
                <label htmlFor="archivos_adjuntos" className="form-label">Adjuntar Archivos:</label>
                <input
                  type="file"
                  className="form-control"
                  id="archivos_adjuntos"
                  name="archivos_adjuntos"
                  multiple // Permite seleccionar múltiples archivos
                  onChange={handleChange}
                />
                {formData.archivos_adjuntos.length > 0 && (
                  <small className="form-text text-muted">
                    Archivos seleccionados: {formData.archivos_adjuntos.map(f => f.name).join(', ')}
                  </small>
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