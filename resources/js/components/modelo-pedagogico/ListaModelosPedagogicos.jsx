import { h } from 'preact';
import { useState } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';
import CAddButton from "@/components/layout/components/buttons/CAddButton.jsx";
import CTableActionButton from "@/components/layout/components/buttons/CTableActionButton.jsx";

export default function ListaModelosPedagogicos({ agregarUrl, modelosPedagogicos, csrfToken = '', canEditParametros = false }) {
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
        <div className="col-md-12 bg-white rounded-xl !border border-custom-blue-light py-3">
            <div className={'p-3'}>
                <h2 class="mb-4 text-custom-blue-dark">Estrategias pedagógicas</h2>
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
                    {modelosPedagogicos.data.map((modeloPedagogico) => (
                        <tr key={modeloPedagogico.id}>
                            <td>{modeloPedagogico.nombre}</td>
                            {canEditParametros && (
                                <td>
                                    <CTableActionButton
                                        title={'Editar'}
                                        onClick={() => handleEditarClick(modeloPedagogico)}
                                        iconClass={'fas fa-pencil'}
                                        hoverIconColor={'text-custom-primary'}
                                    />
                                    <form id="delete-form-modelo-pedagogico"
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
                                        <CTableActionButton
                                            formRef={'#delete-form-modelo-pedagogico'}
                                            title={'Eliminar'}
                                            iconClass={'fa fa-trash'}
                                            confirmMessage={'¿Estás seguro de que quieres eliminar este modelo pedagógico?'}
                                            hoverIconColor={'text-custom-primary'}
                                        />
                                    </form>
                                </td>
                            )}
                        </tr>
                    ))}
                    </tbody>
                </table>
                <CPagination pagination={modelosPedagogicos}/>

                {/* Modal */}
                {showModal && canEditParametros && (
                    <div className="modal d-block" style={{backgroundColor: 'rgba(0,0,0,0.5)'}}>
                        <div className="modal-dialog">
                            <div className="modal-content">
                                <div className="modal-header">
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
                                    <div className="modal-body">
                                        <div className="mb-3">
                                            <label for="name" class="block text-sm mb-2 ml-4">
                                                Nombre de la estrategia pedagógica
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
                                    <div className="modal-footer">
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
            </div>
            );
            }
