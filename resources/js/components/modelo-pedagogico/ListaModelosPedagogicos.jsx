import { h } from 'preact';
import { useState } from 'preact/hooks';

export default function ListaModelosPedagogicos({ agregarUrl, modelosPedagogicos, csrfToken = '' }) {
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('agregar'); // 'agregar' o 'editar'
    const [modeloActual, setModeloActual] = useState(null);
    const [nombre, setNombre] = useState('');

    const handleAgregarClick = () => {
        setModalMode('agregar');
        setNombre('');
        setModeloActual(null);
        setShowModal(true);
    };

    const handleEditarClick = (modeloEducacional) => {
        setModalMode('editar');
        setNombre(modeloEducacional.nombre);
        setModeloActual(modeloEducacional);
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        setNombre('');
        setModeloActual(null);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        if (modalMode === 'agregar') {
            // Crear nuevo modeloEducacional
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = agregarUrl;

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken;

            const nombreInput = document.createElement('input');
            nombreInput.type = 'hidden';
            nombreInput.name = 'nombre';
            nombreInput.value = nombre;

            form.appendChild(tokenInput);
            form.appendChild(nombreInput);
            document.body.appendChild(form);
            form.submit();
        } else {
            // Editar modeloPedagogico existente
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/modelos-pedagogicos/${modeloActual.id}`;

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken;

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';

            const nombreInput = document.createElement('input');
            nombreInput.type = 'hidden';
            nombreInput.name = 'nombre';
            nombreInput.value = nombre;

            form.appendChild(tokenInput);
            form.appendChild(methodInput);
            form.appendChild(nombreInput);
            document.body.appendChild(form);
            form.submit();
        }
    };

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Modelos pedagógicos</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar estrategia pedagógica
            </button>

            <table class="table">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                {modelosPedagogicos.map((modeloPedagogico) => (
                    <tr key={modeloPedagogico.id}>
                        <td>{modeloPedagogico.nombre}</td>
                        <td>
                            <button
                                onClick={() => handleEditarClick(modeloPedagogico)}
                                className="btn btn-warning btn-sm me-2"
                            >
                                Editar
                            </button>
                            <form
                                action={`/modelos-pedagogicos/${modeloPedagogico.id}`}
                                method="POST"
                                style={{display: 'inline'}}
                                onSubmit={(e) => {
                                    if (!confirm('¿Estás seguro de que quieres eliminar esta estrategia pedagógica?')) {
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
                                    {modalMode === 'agregar' ? 'Agregar estrategia pedagógica' : 'Editar estrategia pedagógica'}
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
                                        <label for="name" class="form-label">
                                            Nombre de la estrategia pedagógica
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="nombre"
                                            value={nombre}
                                            onInput={(e) => setNombre(e.target.value)}
                                            required
                                            autoFocus
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
                                        disabled={!nombre.trim()}
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
