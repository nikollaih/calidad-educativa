import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';

export default function ListaRedesAprendizaje({ agregarUrl, redesAprendizajes, csrfToken = '' }) {
    // Estado para controlar la visibilidad del modal y su modo (agregar/editar)
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('agregar');
    const [currentRedAprendizaje, setCurrentRedAprendizaje] = useState(null);

    // Nuevos estados para los campos del formulario
    const [nombre, setNombre] = useState('');
    const [descripcion, setDescripcion] = useState('');
    const [actoAdministrativo, setActoAdministrativo] = useState(null); // Para el nuevo archivo
    // MODIFICACION: Nuevo estado para almacenar la URL del documento existente
    const [actoAdministrativoUrl, setActoAdministrativoUrl] = useState(null); 
    const [representanteId, setRepresentanteId] = useState(''); // ID del representante seleccionado
    const [numeroContacto, setNumeroContacto] = useState('');

    // Estado para la lista de usuarios (representantes)
    const [usuarios, setUsuarios] = useState([]);
    const [isLoadingUsers, setIsLoadingUsers] = useState(false);
    const [usersError, setUsersError] = useState(null);

    // Estados para los modales de alerta y confirmación
    const [showAlertModal, setShowAlertModal] = useState(false);
    const [alertMessage, setAlertMessage] = useState('');
    const [showConfirmModal, setShowConfirmModal] = useState(false);
    const [confirmAction, setConfirmAction] = useState(null);
    const [loading, setLoading] = useState(false);

    // Estado para la lista de redes de aprendizaje
    const [redes, setRedes] = useState(redesAprendizajes);

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

    const handleAgregarClick = () => {
        setModalMode('agregar');
        // Limpiar todos los estados del formulario al agregar
        setNombre('');
        setDescripcion('');
        setActoAdministrativo(null);
        // MODIFICACION: Limpiar la URL del documento
        setActoAdministrativoUrl(null); 
        setRepresentanteId('');
        setNumeroContacto('');
        setCurrentRedAprendizaje(null);
        setShowModal(true);
    };

    const handleEditarClick = (redAprendizaje) => {
        
        setModalMode('editar');
        // Llenar el formulario con los datos de la red de aprendizaje actual
        setCurrentRedAprendizaje(redAprendizaje);
        setNombre(redAprendizaje.nombre || '');
        setDescripcion(redAprendizaje.descripcion || '');
        setRepresentanteId(redAprendizaje.representante_id || '');
        setNumeroContacto(redAprendizaje.numero_contacto || '');
        setActoAdministrativo(null); // No se precarga el archivo
        // MODIFICACION: Cargar la URL del documento existente
        setActoAdministrativoUrl(redAprendizaje.acto_administrativo?.ruta || null); 
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        // Limpiar todos los estados al cerrar el modal
        setNombre('');
        setDescripcion('');
        setActoAdministrativo(null);
        // MODIFICACION: Limpiar la URL del documento
        setActoAdministrativoUrl(null);
        setRepresentanteId('');
        setNumeroContacto('');
        setCurrentRedAprendizaje(null);
    };

    const handleSubmit = (e) => {
      // Esta función ahora solo realiza la validación.
      // Si la validación falla, se evita el envío del formulario.
      if (!nombre.trim() || !representanteId) {
          showAlert('Por favor, completa los campos obligatorios (Nombre y Representante).');
          e.preventDefault(); // Detiene el envío nativo del formulario
          return;
      }
      if (modalMode === 'agregar' && !actoAdministrativo) {
          showAlert('El "Acto Administrativo" es un campo obligatorio para la creación.');
          e.preventDefault(); // Detiene el envío nativo del formulario
          return;
      }
      // Si la validación es exitosa, no se llama a e.preventDefault()
      // y el formulario se envía de forma nativa.
    };
    
    // Maneja la acción de eliminar
    const handleDelete = async (id) => {
        showConfirm('¿Estás seguro de que quieres eliminar esta red de aprendizaje?', async () => {
            setLoading(true);
            try {
                const response = await fetch(`/redes-aprendizajes/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'DELETE' // Para simular el método DELETE en Laravel
                    },
                    body: JSON.stringify({ _method: 'DELETE', _token: csrfToken }),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error en el servidor');
                }

                // Filtrar la red de aprendizaje eliminada del estado
                setRedes(prevRedes => prevRedes.filter(red => red.id !== id));
                showAlert('Red de aprendizaje eliminada con éxito.');

            } catch (error) {
                showAlert(`Error al eliminar: ${error.message}`);
            } finally {
                setLoading(false);
            }
        });
    };


    return (
        <div class="container mt-4">
            <h2 class="mb-4">Redes de Aprendizajes</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar red de aprendizaje
            </button>
            {loading && <div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>}
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Representante</th>
                        <th>Acto Administrativo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {redes.map((redAprendizaje) => (
                        <tr key={redAprendizaje.id}>
                            <td>{redAprendizaje.nombre}</td>
                            <td>{redAprendizaje.descripcion ?? 'Sin información'}</td>
                            <td>{redAprendizaje.representante ? redAprendizaje.representante.name : 'N/A'}</td>
                            <td>
                                {redAprendizaje.acto_administrativo?.ruta ? (
                                    <a href={`/storage/${redAprendizaje.acto_administrativo.ruta}`} target="_blank">Ver documento</a>
                                ) : (
                                    'sin información'
                                )}
                            </td>
                            <td>
                                <button
                                    onClick={() => handleEditarClick(redAprendizaje)}
                                    className="btn btn-warning btn-sm me-2"
                                >
                                    Editar
                                </button>
                                <button
                                    className="btn btn-danger btn-sm"
                                    onClick={() => handleDelete(redAprendizaje.id)}
                                >
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>

            {/* Modal de formulario (agregar/editar) */}
            {showModal && (
                <div class="modal d-block" style={{backgroundColor: 'rgba(0,0,0,0.5)'}}>
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {modalMode === 'agregar' ? 'Agregar red de aprendizaje' : 'Editar red de aprendizaje'}
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    onClick={handleCloseModal}
                                ></button>
                            </div>
                            <form
                                action={modalMode === 'agregar' ? agregarUrl : `/redes-aprendizajes/${currentRedAprendizaje.id}`}
                                method="POST"
                                enctype="multipart/form-data"
                                onSubmit={handleSubmit}
                            >
                                <div class="modal-body">
                                    {modalMode === 'editar' && (
                                        <input type="hidden" name="_method" value="PUT" />
                                    )}
                                    <input type="hidden" name="_token" value={csrfToken} />
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="nombre"
                                            name="nombre"
                                            value={nombre}
                                            onInput={(e) => setNombre(e.target.value)}
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea
                                            class="form-control"
                                            id="descripcion"
                                            name="descripcion"
                                            value={descripcion}
                                            onInput={(e) => setDescripcion(e.target.value)}
                                            rows="3"
                                        ></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="actoAdministrativo" class="form-label">Acto Administrativo {modalMode === 'agregar' && <span class="text-danger">*</span>}</label>
                                        {/* MODIFICACION: Mostrar el documento actual y la opción de reemplazarlo */}
                                        {modalMode === 'editar' && actoAdministrativoUrl && (
                                            <div class="mb-2">
                                                <p>Documento actual: <a href={`/storage/${actoAdministrativoUrl}`} target="_blank">Ver documento</a></p>
                                                <small class="form-text text-muted">Selecciona un nuevo archivo para reemplazar el actual.</small>
                                            </div>
                                        )}
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="actoAdministrativo"
                                            name="acto_administrativo"
                                            onChange={(e) => setActoAdministrativo(e.target.files[0])}
                                            required={modalMode === 'agregar'}
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="representante" class="form-label">Representante <span class="text-danger">*</span></label>
                                        {isLoadingUsers ? (
                                            <div>Cargando usuarios...</div>
                                        ) : usersError ? (
                                            <div class="text-danger">Error: {usersError}</div>
                                        ) : (
                                            <select
                                                class="form-select"
                                                id="representante"
                                                name="representante_id"
                                                value={representanteId}
                                                onInput={(e) => setRepresentanteId(e.target.value)}
                                                required
                                            >
                                                <option value="">Selecciona un representante</option>
                                                {usuarios.map((user) => (
                                                    <option key={user.id} value={user.id}>
                                                        {user.name}
                                                    </option>
                                                ))}
                                            </select>
                                        )}
                                    </div>
                                    <div class="mb-3">
                                        <label for="numeroContacto" class="form-label">Número de Contacto</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="numeroContacto"
                                            name="numero_contacto"
                                            value={numeroContacto}
                                            onInput={(e) => setNumeroContacto(e.target.value)}
                                        />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        onClick={handleCloseModal}
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        disabled={loading || !nombre.trim() || !representanteId || (modalMode === 'agregar' && !actoAdministrativo)}
                                    >
                                        {loading ? 'Cargando...' : modalMode === 'agregar' ? 'Agregar' : 'Guardar Cambios'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}
            
            {/* Modal de alerta personalizado */}
            {showAlertModal && (
                <div class="modal d-block" style={{backgroundColor: 'rgba(0,0,0,0.5)'}}>
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
                <div class="modal d-block" style={{backgroundColor: 'rgba(0,0,0,0.5)'}}>
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
