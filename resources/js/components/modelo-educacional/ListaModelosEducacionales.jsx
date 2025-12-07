import { h } from 'preact';
import { useState } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';

export default function ListaModelosEducacionales({ agregarUrl, modelosEducacionales, csrfToken = '', canEditParametros = false }) {
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('agregar'); // 'agregar' o 'editar'
    const [currentMunicipio, setCurrentMunicipio] = useState(null);
    const [name, setNombre] = useState('');

    const handleAgregarClick = () => {
        setModalMode('agregar');
        setNombre('');
        setCurrentMunicipio(null);
        setShowModal(true);
    };

    const handleEditarClick = (modeloEducacional) => {
        setModalMode('editar');
        setNombre(modeloEducacional.name);
        setCurrentMunicipio(modeloEducacional);
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        setNombre('');
        setCurrentMunicipio(null);
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
            nombreInput.name = 'name';
            nombreInput.value = name;

            form.appendChild(tokenInput);
            form.appendChild(nombreInput);
            document.body.appendChild(form);
            form.submit();
        } else {
            // Editar modeloEducacional existente
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/modelos-educacionales/${currentMunicipio.id}`;

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
            nombreInput.name = 'name';
            nombreInput.value = name;

            form.appendChild(tokenInput);
            form.appendChild(methodInput);
            form.appendChild(nombreInput);
            document.body.appendChild(form);
            form.submit();
        }
    };

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Modelos flexibles</h2>
            {canEditParametros && (
                <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                    Agregar modelo flexible
                </button>
            )}

            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        {canEditParametros && <th>Acciones</th>}
                    </tr>
                </thead>
                <tbody>
                    {modelosEducacionales.data.map((modeloEducacional) => (
                        <tr key={modeloEducacional.id}>
                            <td>{modeloEducacional.name}</td>
                            {canEditParametros && (
                                <td>
                                    <button
                                        onClick={() => handleEditarClick(modeloEducacional)}
                                        className="btn btn-warning btn-sm me-2"
                                    >
                                        Editar
                                    </button>
                                    <form
                                        action={`/modelos-educacionales/${modeloEducacional.id}`}
                                        method="POST"
                                        style={{ display: 'inline' }}
                                        onSubmit={(e) => {
                                            if (!confirm('¿Estás seguro de que quieres eliminar este modeloEducacional?')) {
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

            <CPagination pagination={modelosEducacionales} />
            {/* Modal */}
            {showModal && canEditParametros && (
                <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {modalMode === 'agregar' ? 'Agregar modeloEducacional' : 'Editar modeloEducacional'}
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
                                            Nombre del modelo educacional
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            value={name}
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
                                        disabled={!name.trim()}
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
