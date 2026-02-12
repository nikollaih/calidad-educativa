import { h } from 'preact';
import { useState } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';

export default function ListaMunicipios({ agregarUrl, municipios, csrfToken = '', canEditParametros = false }) {
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('agregar'); // 'agregar' o 'editar'
    const [currentMunicipio, setCurrentMunicipio] = useState(null);
    const [nombre, setNombre] = useState('');
    const handleAgregarClick = () => {
        setModalMode('agregar');
        setNombre('');
        setCurrentMunicipio(null);
        setShowModal(true);
    };

    const handleEditarClick = (municipio) => {
        setModalMode('editar');
        setNombre(municipio.nombre);
        setCurrentMunicipio(municipio);
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
            // Crear nuevo municipio
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
            // Editar municipio existente
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/municipios/${currentMunicipio.id}`;

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
            <h2 class="mb-4">Municipios</h2>
            {canEditParametros && (
                <button class="border bg-blue-500  text-white p-2 rounded-pill mb-3" onClick={handleAgregarClick}>
                    Agregar Municipio
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
                    {municipios.data.map((municipio) => (
                        <tr key={municipio.id}>
                            <td>{municipio.nombre}</td>
                            {canEditParametros && (
                                <td>
                                    <button
                                        onClick={() => handleEditarClick(municipio)}
                                        className="btn btn-warning btn-sm me-2"
                                    >
                                        Editar
                                    </button>
                                    <form
                                        action={`/municipios/${municipio.id}`}
                                        method="POST"
                                        style={{ display: 'inline' }}
                                        onSubmit={(e) => {
                                            if (!confirm('¿Estás seguro de que quieres eliminar este municipio?')) {
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
            <CPagination pagination={municipios} />
            {/* Modal */}
            {showModal && canEditParametros && (
                <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {modalMode === 'agregar' ? 'Agregar Municipio' : 'Editar Municipio'}
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
                                        <label for="nombre" class="block text-sm mb-2 ml-4">
                                            Nombre del Municipio
                                        </label>
                                        <input
                                            type="text"
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
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
                                        class="border bg-blue-500  text-white p-2 rounded-pill"
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
