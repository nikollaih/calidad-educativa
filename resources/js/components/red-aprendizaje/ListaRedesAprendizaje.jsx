import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';
import CAddButton from "@/components/layout/components/buttons/CAddButton.jsx";
import CTableActionButton from "@/components/layout/components/buttons/CTableActionButton.jsx";

export default function ListaRedesAprendizaje({ agregarUrl, redesAprendizajes, csrfToken = '', canEditParametros = false }) {
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
    // MODIFICACION: Nuevo estado para el correo electrónico
    const [correoElectronico, setCorreoElectronico] = useState('');

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

    // NUEVO: Estados para el modal de ver actividades e integrantes
    const [showViewModal, setShowViewModal] = useState(false);
    const [actividadesIntegrantes, setActividadesIntegrantes] = useState(null);
    const [isLoadingActividades, setIsLoadingActividades] = useState(false);
    const [actividadesError, setActividadesError] = useState(null);

    // Mapeo de roles por ID
    const integrantesRoles = [
        { id: 1, name: 'Líder' },
        { id: 2, name: 'Integrante' },
        { id: 3, name: 'Aliado' },
    ];

    // NUEVO: Función para obtener el nombre del rol por ID
    const getRoleName = (rolId) => {
        const rol = integrantesRoles.find(r => r.id === rolId);
        return rol ? rol.name : 'Sin rol';
    };

    // Estado para la lista de redes de aprendizaje
    const [redes, setRedes] = useState(redesAprendizajes.data);

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

    // NUEVO: Función para ver actividades e integrantes
    const handleVerClick = async (redAprendizaje) => {
        setCurrentRedAprendizaje(redAprendizaje);
        setShowViewModal(true);
        setIsLoadingActividades(true);
        setActividadesError(null);
        setActividadesIntegrantes(null);

        try {
            const response = await fetch(`/get-actividades-integrantes/${redAprendizaje.id}`);
            if (!response.ok) {
                throw new Error('Error al obtener las actividades e integrantes.');
            }
            const data = await response.json();
            setActividadesIntegrantes(data);
        } catch (error) {
            setActividadesError(error.message);
        } finally {
            setIsLoadingActividades(false);
        }
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
        // MODIFICACION: Limpiar el campo de correo electrónico
        setCorreoElectronico('');
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
        // MODIFICACION: Llenar el campo de correo electrónico
        setCorreoElectronico(redAprendizaje.correo || '');
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
        // MODIFICACION: Limpiar el campo de correo electrónico
        setCorreoElectronico('');
        setCurrentRedAprendizaje(null);
    };

    // NUEVO: Función para cerrar el modal de vista
    const handleCloseViewModal = () => {
        setShowViewModal(false);
        setActividadesIntegrantes(null);
        setActividadesError(null);
        setCurrentRedAprendizaje(null);
    };

    const handleSubmit = (e) => {
        // Esta función ahora solo realiza la validación.
        // Si la validación falla, se evita el envío del formulario.
        // MODIFICACION: Validar que el campo de correo no esté vacío
        if (!nombre.trim() || !representanteId || !correoElectronico.trim()) {
            showAlert('Por favor, completa los campos obligatorios (Nombre, Representante y Correo Electrónico).');
            e.preventDefault(); // Detiene el envío nativo del formulario
            return;
        }
        // MODIFICACION: Validar el formato del correo electrónico
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correoElectronico)) {
            showAlert('Por favor, introduce un correo electrónico válido.');
            e.preventDefault();
            return;
        }

        if (modalMode === 'agregar' && !actoAdministrativo) {
            showAlert('El "Acto Administrativo" es un campo obligatorio para la creación.');
            e.preventDefault(); // Detiene el envío nativo del formulario
            return;
        }
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
        <div class="col-md-12 bg-white rounded-xl !border border-custom-blue-light py-3">
            <div className={'p-3'}>
            <h2 class="mb-4 text-custom-blue-dark">Redes de Aprendizaje</h2>
            {canEditParametros && (
                <CAddButton
                    onClick={handleAgregarClick}
                />
            )}
            {loading && <div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>}

            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Representante</th>
                        <th>Correo Electrónico</th>
                        <th>Acto Administrativo</th>
                        {canEditParametros && <th>Acciones</th>}
                    </tr>
                </thead>
                <tbody>
                    {redes.map((redAprendizaje) => (
                        <tr key={redAprendizaje.id}>
                            <td>{redAprendizaje.nombre}</td>
                            <td>{redAprendizaje.descripcion ?? 'Sin información'}</td>
                            <td>{redAprendizaje.representante ? redAprendizaje.representante.name : 'N/A'}</td>
                            {/* MODIFICACION: Celda para mostrar el correo electrónico */}
                            <td>{redAprendizaje.correo ?? 'Sin información'}</td>
                            <td>
                                {redAprendizaje.acto_administrativo?.ruta ? (
                                    <a href={`/storage/${redAprendizaje.acto_administrativo.ruta}`} target="_blank">Ver documento</a>
                                ) : (
                                    'sin información'
                                )}
                            </td>
                            {canEditParametros && (
                                <td>
                                    <CTableActionButton
                                        title={'Ver'}
                                        onClick={() => handleVerClick(redAprendizaje)}
                                        iconClass={'fas fa-eye'}
                                        hoverIconColor={'text-custom-primary'}
                                    />
                                    <CTableActionButton
                                        title={'Editar'}
                                        onClick={() => handleEditarClick(redAprendizaje)}
                                        iconClass={'fas fa-pencil'}
                                        hoverIconColor={'text-custom-primary'}
                                    />
                                    <CTableActionButton
                                        title={'Eliminar'}
                                        onClick={() => handleDelete(redAprendizaje.id)}
                                        iconClass={'fas fa-trash'}
                                        hoverIconColor={'text-custom-primary'}
                                    />
                                </td>
                            )}
                        </tr>
                    ))}
                </tbody>
            </table>

            {/* Modal de formulario (agregar/editar) */}
            {showModal && canEditParametros && (
                <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
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
                                        <label for="nombre" class="block text-sm mb-2 ml-4">Nombre <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                            id="nombre"
                                            name="nombre"
                                            value={nombre}
                                            onInput={(e) => setNombre(e.target.value)}
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="block text-sm mb-2 ml-4">Descripción</label>
                                        <textarea
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                            id="descripcion"
                                            name="descripcion"
                                            value={descripcion}
                                            onInput={(e) => setDescripcion(e.target.value)}
                                            rows="3"
                                        ></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="actoAdministrativo" class="block text-sm mb-2 ml-4">Acto Administrativo {modalMode === 'agregar' && <span class="text-danger">*</span>}</label>
                                        {/* MODIFICACION: Mostrar el documento actual y la opción de reemplazarlo */}
                                        {modalMode === 'editar' && actoAdministrativoUrl && (
                                            <div class="mb-2">
                                                <p>Documento actual: <a href={`/storage/${actoAdministrativoUrl}`} target="_blank">Ver documento</a></p>
                                                <small class="form-text text-muted">Selecciona un nuevo archivo para reemplazar el actual.</small>
                                            </div>
                                        )}
                                        <input
                                            type="file"
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                            id="actoAdministrativo"
                                            name="acto_administrativo"
                                            onChange={(e) => setActoAdministrativo(e.target.files[0])}
                                            required={modalMode === 'agregar'}
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="representante" class="block text-sm mb-2 ml-4">Representante <span class="text-danger">*</span></label>
                                        {isLoadingUsers ? (
                                            <div>Cargando usuarios...</div>
                                        ) : usersError ? (
                                            <div class="text-danger">Error: {usersError}</div>
                                        ) : (
                                            <select
                                                class="w-full !border border-custom-blue-dark rounded-xl"
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
                                        <label for="numeroContacto" class="block text-sm mb-2 ml-4">Número de Contacto</label>
                                        <input
                                            type="text"
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                            id="numeroContacto"
                                            name="numero_contacto"
                                            value={numeroContacto}
                                            onInput={(e) => setNumeroContacto(e.target.value)}
                                        />
                                    </div>
                                    {/* MODIFICACION: Nuevo campo para el correo electrónico */}
                                    <div class="mb-3">
                                        <label for="correoElectronico" class="block text-sm mb-2 ml-4">Correo Electrónico <span class="text-danger">*</span></label>
                                        <input
                                            type="email"
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                            id="correoElectronico"
                                            name="correo"
                                            value={correoElectronico}
                                            onInput={(e) => setCorreoElectronico(e.target.value)}
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="border bg-blue-500  text-white p-2 rounded-pill"
                                        onClick={handleCloseModal}
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        class="border bg-blue-500  text-white p-2 rounded-pill"
                                        // MODIFICACION: Se agregó el campo de correo electrónico a la validación
                                        disabled={loading || !nombre.trim() || !representanteId || !correoElectronico.trim() || (modalMode === 'agregar' && !actoAdministrativo)}
                                    >
                                        {loading ? 'Cargando...' : modalMode === 'agregar' ? 'Agregar' : 'Guardar Cambios'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}

            {/* NUEVO: Modal para ver actividades e integrantes */}
            {showViewModal && (
                <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Actividades e Integrantes - {currentRedAprendizaje?.nombre}
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    onClick={handleCloseViewModal}
                                ></button>
                            </div>
                            <div class="modal-body">
                                {isLoadingActividades ? (
                                    <div class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                        <p class="mt-2">Cargando actividades e integrantes...</p>
                                    </div>
                                ) : actividadesError ? (
                                    <div class="alert alert-danger">
                                        <strong>Error:</strong> {actividadesError}
                                    </div>
                                ) : actividadesIntegrantes ? (
                                    <div class="row">
                                        {/* Sección de Actividades */}
                                        <div class="col-md-6 mb-4">
                                            <h6 class="mb-3">
                                                <i class="fas fa-tasks me-2"></i>Actividades
                                            </h6>
                                            {actividadesIntegrantes.actividades && actividadesIntegrantes.actividades.length > 0 ? (
                                                <div class="list-group">
                                                    {actividadesIntegrantes.actividades.map((actividad) => (
                                                        <div key={actividad.id} class="list-group-item">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <h6 class="mb-1">Actividad #{actividad.id}</h6>
                                                                <small>{actividad.fecha ? new Date(actividad.fecha).toLocaleDateString() : ''}</small>
                                                            </div>
                                                            {actividad.descripcion && (
                                                                <p class="mb-1 text-muted small" style={{ wordWrap: 'break-word', wordBreak: 'break-word', whiteSpace: 'normal' }}>{actividad.descripcion}</p>
                                                            )}
                                                        </div>
                                                    ))}
                                                </div>
                                            ) : (
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    No hay actividades registradas para esta red de aprendizaje.
                                                </div>
                                            )}
                                        </div>

                                        {/* Sección de Integrantes */}
                                        <div class="col-md-6 mb-4">
                                            <h6 class="mb-3">
                                                <i class="fas fa-users me-2"></i>Integrantes
                                            </h6>
                                            {actividadesIntegrantes.integrantes && actividadesIntegrantes.integrantes.length > 0 ? (
                                                <div class="list-group">
                                                    {actividadesIntegrantes.integrantes.map((integrante) => (
                                                        <div key={integrante.id} class="list-group-item">
                                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                                <h6 class="mb-1">{integrante.nombre}</h6>
                                                                <span class="badge bg-primary rounded-pill">
                                                                    {getRoleName(integrante.rol)}
                                                                </span>
                                                            </div>
                                                            <div class="mb-1">
                                                                {integrante.email && (
                                                                    <p class="mb-1 text-muted small">
                                                                        <i class="fas fa-envelope me-1"></i>{integrante.email}
                                                                    </p>
                                                                )}
                                                                {integrante.telefono && (
                                                                    <p class="mb-1 text-muted small">
                                                                        <i class="fas fa-phone me-1"></i>{integrante.telefono}
                                                                    </p>
                                                                )}
                                                                {integrante.fecha_vinculacion && (
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-calendar me-1"></i>
                                                                        Vinculado: {integrante.fecha_vinculacion}
                                                                    </small>
                                                                )}
                                                            </div>
                                                        </div>
                                                    ))}
                                                </div>
                                            ) : (
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    No hay integrantes registrados para esta red de aprendizaje.
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                ) : null}
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="border bg-blue-500  text-white p-2 rounded-pill"
                                    onClick={handleCloseViewModal}
                                >
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            <CPagination pagination={redesAprendizajes} />
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
                                <button type="button" class="border bg-blue-500  text-white p-2 rounded-pill" onClick={() => setShowAlertModal(false)}>Aceptar</button>
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
                                <button type="button" class="border bg-blue-500  text-white p-2 rounded-pill" onClick={() => setShowConfirmModal(false)}>Cancelar</button>
                                <button type="button" class="border bg-blue-500  text-white p-2 rounded-pill" onClick={() => {
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
        </div>
    );
}
