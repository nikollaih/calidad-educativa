import { h } from 'preact';
import { useState } from 'preact/hooks';

export default function ListaMunicipios({ agregarUrl, indicadores, csrfToken = '' }) {
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('agregar');
    // 'agregar' o 'editar'
    const [indicadorActual, setIndicadorActual] = useState(null);

    const [unidadTotal, setUnidadTotal] = useState('');
    const [unidadParcial, setUnidadParcial] = useState('');



    const handleAgregarClick = () => {
        setModalMode('agregar');
        setUnidadTotal('');
        setUnidadParcial('');
        setIndicadorActual(null);
        setShowModal(true);
    };

    const handleEditarClick = (indicador) => {
        setModalMode('editar');
        setUnidadTotal(indicador.unidad_total);
        setUnidadParcial(indicador.unidad_parcial);

        setIndicadorActual(indicador);
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        setUnidadTotal('');
        setUnidadParcial('');
        setIndicadorActual(null);
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

            const unidadTotalInput = document.createElement('input');
            unidadTotalInput.type = 'hidden';
            unidadTotalInput.name = 'unidad_total';
            unidadTotalInput.value = unidadTotal;
            const unidadParcialInput = document.createElement('input');
            unidadParcialInput.type = 'hidden';
            unidadParcialInput.name = 'unidad_parcial';
            unidadParcialInput.value = unidadParcial;

            form.appendChild(tokenInput);
            form.appendChild(unidadTotalInput);
            form.appendChild(unidadParcialInput);
            document.body.appendChild(form);
            form.submit();
        } else {
            // Editar municipio existente
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/indicadores-pmi/${indicadorActual.id}`;

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken;

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';

            const unidadTotalInput = document.createElement('input');
            unidadTotalInput.type = 'hidden';
            unidadTotalInput.name = 'unidad_total';
            unidadTotalInput.value = unidadTotal;
            const unidadParcialInput = document.createElement('input');
            unidadParcialInput.type = 'hidden';
            unidadParcialInput.name = 'unidad_parcial';
            unidadParcialInput.value = unidadParcial;

            form.appendChild(tokenInput);
            form.appendChild(methodInput);
            form.appendChild(unidadTotalInput);
            form.appendChild(unidadParcialInput);
            document.body.appendChild(form);
            form.submit();
        }
    };

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Indicadores</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar indicador
            </button>

            <table class="table">
                <thead>
                <tr>
                    <th>Unidad parcial</th>
                    <th>Unidad total</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                {indicadores.map((indicador) => (
                    <tr key={indicador.id}>
                        <td>{indicador.unidad_parcial}</td>
                        <td>{indicador.unidad_total}</td>
                        <td>
                            <button
                                onClick={() => handleEditarClick(indicador)}
                                className="btn btn-warning btn-sm me-2"
                            >
                                Editar
                            </button>
                            <form
                                action={`/indicadores-pmi/${indicador.id}`}
                                method="POST"
                                style={{display: 'inline'}}
                                onSubmit={(e) => {
                                    if (!confirm('¿Estás seguro de que quieres eliminar este indicador?')) {
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
                                    {modalMode === 'agregar' ? 'Agregar indicador' : 'Editar indicador'}
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
                                        <label htmlFor="nombre" className="form-label">
                                            Nombre de la unidad parcial
                                        </label>
                                        <input
                                            type="text"
                                            className="form-control"
                                            id="unidad_parcial"
                                            value={unidadParcial}
                                            onInput={(e) => setUnidadParcial(e.target.value)}
                                            required
                                            autoFocus
                                        />
                                    </div>
                                    <div className="mb-3">
                                        <label htmlFor="unidad_total" className="form-label">
                                            Nombre de la unidad total
                                        </label>
                                        <input
                                            type="text"
                                            className="form-control"
                                            id="unidad_total"
                                            value={unidadTotal}
                                            onInput={(e) => setUnidadTotal(e.target.value)}
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
                                        disabled={!unidadTotal.trim() && !unidadTotal.trim()}
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
