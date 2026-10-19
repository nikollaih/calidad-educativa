import { h } from 'preact';
import { useState } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';
import CAddButton from '@/components/layout/components/buttons/CAddButton.jsx';
import CTableActionButton from '@/components/layout/components/buttons/CTableActionButton.jsx';
import auth from '@/utilidades/auth.js';

export default function ListaTemasEnsenanzaObligatoria({
    temas,
    storeUrl,
    csrfToken = '',
    canEditParametros = false,
}) {
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('agregar');
    const [currentTema, setCurrentTema] = useState(null);
    const [nombre, setNombre] = useState('');
    const canEdit = canEditParametros && auth.can('s-parametro-editar');

    const handleAgregarClick = () => {
        setModalMode('agregar');
        setCurrentTema(null);
        setNombre('');
        setShowModal(true);
    };

    const handleEditarClick = (tema) => {
        setModalMode('editar');
        setCurrentTema(tema);
        setNombre(tema.nombre || '');
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        setCurrentTema(null);
        setNombre('');
    };

    const rows = temas?.data ?? [];
    const actionUrl = modalMode === 'agregar'
        ? storeUrl
        : `/temas-ensenanza-obligatoria/${currentTema?.id}`;

    return (
        <div className="col-md-12 bg-white rounded-xl !border border-custom-blue-light py-3">
            <div className="p-3">
                <h2 className="mb-4 text-custom-blue-dark">Temas de enseñanza obligatoria</h2>

                {canEdit && <CAddButton onClick={handleAgregarClick} />}

                <table className="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            {canEdit && <th>Acciones</th>}
                        </tr>
                    </thead>
                    <tbody>
                        {rows.length === 0 ? (
                            <tr>
                                <td colSpan={canEdit ? 3 : 2} className="text-center">
                                    No hay temas de enseñanza obligatoria registrados.
                                </td>
                            </tr>
                        ) : rows.map((tema) => (
                            <tr key={tema.id}>
                                <td>{tema.id}</td>
                                <td>{tema.nombre}</td>
                                {canEdit && (
                                    <td>
                                        <CTableActionButton
                                            route={`/temas-ensenanza-obligatoria/${tema.id}`}
                                            title="Ver detalle"
                                            iconClass="fa fa-eye"
                                            hoverIconColor="text-custom-primary"
                                        />
                                        <CTableActionButton
                                            title="Editar"
                                            onClick={() => handleEditarClick(tema)}
                                            iconClass="fas fa-pencil"
                                            hoverIconColor="text-custom-primary"
                                        />
                                        <form
                                            id={`delete-tema-ensenanza-obligatoria-${tema.id}`}
                                            action={`/temas-ensenanza-obligatoria/${tema.id}`}
                                            method="POST"
                                            className="inline"
                                            onSubmit={(event) => {
                                                if (!window.confirm(`¿Eliminar el tema «${tema.nombre}»?`)) {
                                                    event.preventDefault();
                                                }
                                            }}
                                        >
                                            <input type="hidden" name="_token" value={csrfToken} />
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <CTableActionButton
                                                formRef={`#delete-tema-ensenanza-obligatoria-${tema.id}`}
                                                title="Eliminar"
                                                iconClass="fa fa-trash"
                                                hoverIconColor="text-custom-primary"
                                            />
                                        </form>
                                    </td>
                                )}
                            </tr>
                        ))}
                    </tbody>
                </table>

                <CPagination pagination={temas} />
            </div>

            {showModal && canEdit && (
                <div className="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title">
                                    {modalMode === 'agregar' ? 'Agregar tema' : 'Editar tema'}
                                </h5>
                                <button type="button" className="btn-close" onClick={handleCloseModal}></button>
                            </div>
                            <form method="POST" action={actionUrl}>
                                <div className="modal-body">
                                    {modalMode === 'editar' && <input type="hidden" name="_method" value="PUT" />}
                                    <input type="hidden" name="_token" value={csrfToken} />
                                    <div className="mb-3">
                                        <label htmlFor="tema-ensenanza-obligatoria-nombre" className="block text-sm mb-2 ml-4">
                                            Nombre <span className="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                            id="tema-ensenanza-obligatoria-nombre"
                                            name="nombre"
                                            value={nombre}
                                            onInput={(event) => setNombre(event.target.value)}
                                            maxLength={255}
                                            required
                                            autoFocus
                                        />
                                    </div>
                                </div>
                                <div className="modal-footer">
                                    <button type="button" className="border bg-blue-500 text-white p-2 rounded-pill" onClick={handleCloseModal}>
                                        Cancelar
                                    </button>
                                    <button type="submit" className="border bg-blue-500 text-white p-2 rounded-pill" disabled={!nombre.trim()}>
                                        {modalMode === 'agregar' ? 'Agregar' : 'Guardar cambios'}
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
