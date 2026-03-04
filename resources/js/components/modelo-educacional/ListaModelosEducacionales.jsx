import { h } from 'preact';
import { useState } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';
import CAddButton from "@/components/layout/components/buttons/CAddButton.jsx";
import CTableActionButton from "@/components/layout/components/buttons/CTableActionButton.jsx";

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
        <div class="col-md-12 bg-white rounded-xl !border border-custom-blue-light py-3">
            <div class={'p-3'}>
            <h2 class="mb-4 text-custom-blue-dark">Modelos flexibles</h2>
            {canEditParametros && (
                <CAddButton
                    onClick={handleAgregarClick}
                />
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
                                    <CTableActionButton
                                        title={'Editar'}
                                        onClick={() => handleEditarClick(modeloEducacional)}
                                        iconClass={'fas fa-pencil'}
                                        hoverIconColor={'text-custom-primary'}
                                    />
                                    <form id="delete-form-modelo"
                                        action={`/modelos-educacionales/${modeloEducacional.id}`}
                                        method="POST"
                                        style={{ display: 'inline' }}
                                        onSubmit={(e) => {
                                            if (!confirm('¿Estás seguro de que quieres eliminar este modelo educacional?')) {
                                                e.preventDefault();
                                            }
                                        }}
                                    >
                                        <input type="hidden" name="_token" value={csrfToken} />
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <CTableActionButton
                                            formRef={'#delete-form-municipio'}
                                            title={'Eliminar'}
                                            iconClass={'fa fa-trash'}
                                            confirmMessage={'¿Estás seguro de que quieres eliminar este modelo educacional?'}
                                            hoverIconColor={'text-custom-primary'}
                                        />
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
                                        <label for="name" class="block text-sm mb-2 ml-4">
                                            Nombre del modelo educacional
                                        </label>
                                        <input
                                            type="text"
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
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
                                        class="border bg-blue-500  text-white p-2 rounded-pill"
                                        onClick={handleCloseModal}
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        class="border bg-blue-500  text-white p-2 rounded-pill"
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
        </div>
    );
}
