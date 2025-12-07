import { h } from 'preact';
import { useState } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';

export default function ListaComponente({ agregarUrl, componentes, csrfToken = '', canEditParametros = false }) {
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('agregar'); // 'agregar' o 'editar'
    const [currentComponente, setCurrentComponente] = useState(null);
    const [descripcion, setDescripcion] = useState(''); // Ya existente

    const handleAgregarClick = () => {
        setModalMode('agregar');
        setDescripcion('');  // Limpiar descripción
        setCurrentComponente(null);
        setShowModal(true);
    };

    const handleEditarClick = (componente) => {
        setModalMode('editar');
        setDescripcion(componente.descripcion || '');
        setCurrentComponente(componente);
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        setCodigo('');       // Limpiar al cerrar
        setDescripcion('');  // Limpiar al cerrar
        setCurrentComponente(null);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        // Validar que ambos campos no estén vacíos
        if (!descripcion.trim()) {
            alert('Por favor, completa el campo descripción.');
            return; // Detiene el envío del formulario
        }

        const form = document.createElement('form');
        form.method = 'POST';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);

        // Input para la descripción
        const descripcionInput = document.createElement('input');
        descripcionInput.type = 'hidden';
        descripcionInput.name = 'descripcion';
        descripcionInput.value = descripcion;
        form.appendChild(descripcionInput);

        if (modalMode === 'agregar') {
            form.action = agregarUrl; // Usar la URL de agregar
        } else {
            // Editar componentes existente
            form.action = `/componentes/${currentComponente.id}`; // Usar la URL de edición
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT'; // Laravel reconocerá esto como un PUT
            form.appendChild(methodInput);
        }


        document.body.appendChild(form);
        form.submit();
    };

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Componentes</h2>
            {canEditParametros && (
                <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                    Agregar componente
                </button>
            )}

            <table class="table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        {canEditParametros && <th>Acciones</th>}
                    </tr>
                </thead>
                <tbody>
                    {componentes.data.map((componente) => (
                        <tr key={componente.id}>
                            <td>{componente.descripcion}</td>
                            {canEditParametros && (
                                <td>
                                    <button
                                        onClick={() => handleEditarClick(componente)}
                                        className="btn btn-warning btn-sm me-2"
                                    >
                                        Editar
                                    </button>
                                    <form
                                        action={`/componentes/${componente.id}`}
                                        method="POST"
                                        style={{ display: 'inline' }}
                                        onSubmit={(e) => {
                                            if (!confirm('¿Estás seguro de que quieres eliminar esta componente?')) {
                                                e.preventDefault();
                                            }
                                        }}
                                    >
                                        <input type="hidden" name="_token" value={csrfToken} />
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" className="btn btn-danger btn-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            )}
                        </tr>
                    ))}
                </tbody>
            </table>
            <CPagination pagination={componentes} />
            {/* Modal */}
            {showModal && canEditParametros && (
                <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {modalMode === 'agregar' ? 'Agregar componente' : 'Editar componente'}
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    onClick={handleCloseModal}
                                ></button>
                            </div>
                            <form onSubmit={handleSubmit}>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">
                                            Descripción del componente <span className="text-danger">*</span>
                                        </label>
                                        <textarea
                                            class="form-control"
                                            id="descripcion"
                                            value={descripcion}
                                            onInput={(e) => setDescripcion(e.target.value)}
                                            required
                                            rows="3"
                                        ></textarea>
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
                                        disabled={!descripcion.trim()}
                                    >
                                        {modalMode === 'agregar' ? 'Agregar' : 'Guardar Cambios'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
