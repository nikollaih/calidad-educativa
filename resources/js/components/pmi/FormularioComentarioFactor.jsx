// src/components/pmi/FormularioComentarioFactor.jsx
import { useState, useEffect } from 'preact/hooks';
const FormularioComentarioFactor = ({
    pmiId = undefined,
    onClose,
    csrfToken = '',
    comentario = undefined,
    factorCritico = undefined,
}) => {
    const [isOpen, setIsOpen] = useState(true);
    const [formData, setFormData] = useState({
        comentario: '',
    });
    const [submitMessage, setSubmitMessage] = useState(null);

    useEffect(() => {
        setFormData(comentario);
    }, [comentario]);
    // --- Modal control functions ---
    const openModal = () => setIsOpen(true);
    const closeModal = () => {
        setIsOpen(false);
        setFormData({
            comentario: '',
        });
        setSubmitMessage(null);
        if (onClose) {
            onClose();
        }
    };

    useEffect(() => {
        window.openCrearAvance = openModal;
        return () => {
            delete window.openCrearAvance;
        };
    }, []);

    // --- Maneja los cambios del formulario ---
    const handleChange = (e) => {
        const { name, value, files } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
    };
    const handleBorrarComentario = () => {
        if (!formData?.id) return;

        const confirmar = window.confirm('¿Estás seguro de que deseas eliminar este comentario?');
        if (!confirmar) return;

        // Crear formulario dinámico
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pmi/validacion/${pmiId}/eliminar-comentario/${formData.id}`;

        // Token CSRF
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);

        // Agregar el formulario al DOM temporalmente
        document.body.appendChild(form);

        // Enviar formulario (HTML request)
        form.submit();
    };

    // --- Valida antes de enviar ---
    const handleSubmit = (e) => {
        // evita que se mande automáticamente
        e.preventDefault();
        if (!formData.comentario.trim()) {
            setSubmitMessage({
                type: 'error',
                text: 'El campo de comentario no puede estar vacio.',
            });
            return;
        }

        // si pasa todas las validaciones, envía el formulario real
        e.target.submit();
    };
    if (!isOpen) {
        return null;
    }
    return (
        <div
            className="modal fade show"
            style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}
            tabIndex="-1"
            aria-labelledby="advanceFormModalLabel"
            aria-modal="true"
            role="dialog"
        >
            <div className="modal-dialog modal-lg">
                <div className="modal-content">
                    <div className="modal-header">
                        <h5 className="modal-title" id="advanceFormModalLabel">
                            Formulario de comentario
                            {Boolean(formData?.id) && (
                                <i
                                    class="fa-solid fa-trash text-danger ms-2"
                                    role="button"
                                    onClick={handleBorrarComentario}
                                ></i>
                            )}
                        </h5>
                        <button
                            type="button"
                            className="btn-close"
                            onClick={closeModal}
                            aria-label="Cerrar"
                        ></button>
                    </div>
                    <div className="modal-body">
                        <form>
                            <div className="mb-3">
                                <label htmlFor="descripcion" className="block text-sm mb-2 ml-4">
                                    Factor crítico:
                                </label>
                                <p className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-plaintext border rounded p-2 bg-light">
                                    {factorCritico.descripcion}
                                </p>
                            </div>
                            <div className="mb-3">
                                <label htmlFor="descripcion" className="block text-sm mb-2 ml-4">
                                    Observación
                                </label>
                                <textarea
                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                    id="comentario"
                                    name="comentario"
                                    rows="6"
                                    value={formData.comentario}
                                    onChange={handleChange}
                                ></textarea>
                            </div>
                            <div className="modal-footer">
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    onClick={closeModal}
                                >
                                    Cerrar
                                </button>
                                {comentario && (
                                    <form
                                        method="POST"
                                        action={`/pmi/validacion/${pmiId}/almacenar-comentario`}
                                        onSubmit={handleSubmit}
                                    >
                                        <input type="hidden" name="_token" value={csrfToken} />
                                        <input type="hidden" name="pmi_id" value={pmiId} />
                                        <input
                                            type="hidden"
                                            name="factor_id"
                                            value={factorCritico.id}
                                        />
                                        <input type="hidden" name="id" value={formData.id} />

                                        <input
                                            type="hidden"
                                            name="comentario"
                                            value={formData.comentario}
                                        />
                                        <button type="submit" className="border bg-blue-500  text-white p-2 rounded-pill">
                                            {Boolean(comentario?.id) ? 'Editar' : 'Guardar'}{' '}
                                            comentario
                                        </button>
                                    </form>
                                )}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default FormularioComentarioFactor;
