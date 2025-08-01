import { h } from 'preact';
import { useState } from 'preact/hooks';

export default function ListaUnidadMeta({ agregarUrl, unidadesMeta, csrfToken = '' }) {
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('agregar'); // 'agregar' o 'editar'
    const [currentUnidadMeta, setCurrentUnidadMeta] = useState(null);
    const [codigo, setCodigo] = useState('');       // Se renombró 'name' a 'codigo' y su setter
    const [descripcion, setDescripcion] = useState(''); // Ya existente

    const handleAgregarClick = () => {
        setModalMode('agregar');
        setCodigo('');       // Limpiar codigo
        setDescripcion('');  // Limpiar descripción
        setCurrentUnidadMeta(null);
        setShowModal(true);
    };

    const handleEditarClick = (unidadMeta) => {
        setModalMode('editar');
        // Asegúrate de que los datos de la API lleguen como 'codigo' y 'descripcion'
        setCodigo(unidadMeta.codigo || '');       // Usar 'codigo' de la unidadMeta
        setDescripcion(unidadMeta.descripcion || ''); // Usar 'descripcion' de la unidadMeta
        setCurrentUnidadMeta(unidadMeta);
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        setCodigo('');       // Limpiar al cerrar
        setDescripcion('');  // Limpiar al cerrar
        setCurrentUnidadMeta(null);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        // Validar que ambos campos no estén vacíos
        if (!codigo.trim() || !descripcion.trim()) {
            alert('Por favor, completa ambos campos: Código y Descripción.');
            return; // Detiene el envío del formulario
        }

        const form = document.createElement('form');
        form.method = 'POST';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);

        // Input para el código
        const codigoInput = document.createElement('input');
        codigoInput.type = 'hidden';
        codigoInput.name = 'codigo'; // Se cambió 'name' a 'codigo' aquí
        codigoInput.value = codigo;
        form.appendChild(codigoInput);

        // Input para la descripción
        const descripcionInput = document.createElement('input');
        descripcionInput.type = 'hidden';
        descripcionInput.name = 'descripcion';
        descripcionInput.value = descripcion;
        form.appendChild(descripcionInput);

        if (modalMode === 'agregar') {
            form.action = agregarUrl; // Usar la URL de agregar
        } else {
            // Editar unidadMeta existente
            form.action = `/unidades-meta/${currentUnidadMeta.id}`; // Usar la URL de edición
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
            <h2 class="mb-4">Unidades de meta</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar unidad de meta
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {unidadesMeta.map((unidadMeta) => (
                        <tr key={unidadMeta.id}>
                            <td>{unidadMeta.codigo}</td>      {/* Asegúrate de que el objeto unidadMeta de la API tenga 'codigo' */}
                            <td>{unidadMeta.descripcion}</td> {/* Asegúrate de que el objeto unidadMeta de la API tenga 'descripcion' */}
                            <td>
                                <button
                                    onClick={() => handleEditarClick(unidadMeta)}
                                    className="btn btn-warning btn-sm me-2"
                                >
                                    Editar
                                </button>
                                <form
                                    action={`/unidades-meta/${unidadMeta.id}`}
                                    method="POST"
                                    style={{display: 'inline'}}
                                    onSubmit={(e) => {
                                        if (!confirm('¿Estás seguro de que quieres eliminar esta unidad de meta?')) {
                                            e.preventDefault();
                                        }
                                    }}
                                >
                                    <input type="hidden" name="_token" value={csrfToken}/>
                                    <input type="hidden" name="_method" value="DELETE"/>
                                    <button type="submit" className="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>

            {/* Modal */}
            {showModal && (
                <div class="modal d-block" style={{backgroundColor: 'rgba(0,0,0,0.5)'}}>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {modalMode === 'agregar' ? 'Agregar unidad de meta' : 'Editar unidad de meta'}
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
                                        <label for="codigo" class="form-label">
                                            Código de la unidad de meta
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="codigo" // Se cambió id a 'codigo'
                                            value={codigo} // Usar el estado 'codigo'
                                            onInput={(e) => setCodigo(e.target.value)} // Usar el setter 'setCodigo'
                                            required
                                            autoFocus
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">
                                            Descripción de la unidad de meta
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="descripcion"
                                            value={descripcion}
                                            onInput={(e) => setDescripcion(e.target.value)}
                                            required
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
                                        disabled={!codigo.trim() || !descripcion.trim()} // Validar 'codigo' y 'descripcion'
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