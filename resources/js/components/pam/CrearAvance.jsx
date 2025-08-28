// src/components/CrearAvance.jsx
import { useState, useEffect } from "preact/hooks";
import Select from "react-select";

const CrearAvance = ({ onClose, pamGeneralId }) => {
    const [isOpen, setIsOpen] = useState(true);
    const [formData, setFormData] = useState({
        fecha_avance: "",
        meta_id: "",
        cantidad_ejecutada: "",
        observacion: "",
        archivos_adjuntos: [],
    });
    const [metasOptions, setMetasOptions] = useState([]);
    const [loadingMetas, setLoadingMetas] = useState(true);
    const [submitMessage, setSubmitMessage] = useState(null);

    // --- CSRF Token State ---
    const [csrfToken, setCsrfToken] = useState("");

    // --- Modal control functions ---
    const openModal = () => setIsOpen(true);
    const closeModal = () => {
        setIsOpen(false);
        setFormData({
            fecha_avance: "",
            meta_id: "",
            cantidad_ejecutada: "",
            observacion: "",
            archivos_adjuntos: [],
        });
        setSubmitMessage(null);
        setMetasOptions([]);
        setLoadingMetas(true);
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

    useEffect(() => {
        const token = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");
        if (token) {
            setCsrfToken(token);
        } else {
            console.error(
                "CSRF token not found! Ensure meta tag is present in your Blade layout."
            );
        }
    }, []);

    // --- Carga las opciones para el selector de 'metas' ---
    useEffect(() => {
        const fetchMetas = async () => {
            try {
                const response = await fetch("/pam/get-metas?pam_general_id=" + pamGeneralId);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                // Código modificado:
                // react-select espera un formato { label, value } por defecto,
                // pero aquí usamos getOptionLabel y getOptionValue para
                // usar las propiedades 'descripcion' e 'id' directamente.
                setMetasOptions(data);
            } catch (error) {
                console.error("Error al cargar las metas:", error);
            } finally {
                setLoadingMetas(false);
            }
        };
        if (isOpen && loadingMetas) {
            fetchMetas();
        } else if (!isOpen) {
            setLoadingMetas(true);
        }
    }, [isOpen, loadingMetas]);

    // --- Maneja los cambios del formulario ---
    const handleChange = (e) => {
        const { name, value, files } = e.target;
        if (name === "archivos_adjuntos") {
            setFormData((prevData) => ({
                ...prevData,
                [name]: prevData.archivos_adjuntos.concat(Array.from(files)),
            }));
        } else {
            setFormData((prevData) => ({
                ...prevData,
                [name]: value,
            }));
        }
    };

    // --- Código modificado: Maneja la selección del componente `Select` para las metas ---
    const handleMetaChange = (selectedOption) => {
        setFormData((prevData) => ({
            ...prevData,
            // Se usa el valor de la propiedad 'id' del objeto seleccionado
            meta_id: selectedOption ? selectedOption.id : "",
        }));
    };

    const handleDeleteFile = (fileNameToDelete) => {
        setFormData((prevData) => ({
            ...prevData,
            archivos_adjuntos: prevData.archivos_adjuntos.filter(
                (file) => file.name !== fileNameToDelete
            ),
        }));
    };

    const handleOpenFile = (file) => {
        const fileURL = URL.createObjectURL(file);
        window.open(fileURL, "_blank");
        setTimeout(() => URL.revokeObjectURL(fileURL), 100);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSubmitMessage(null);

        if (
            !formData.fecha_avance ||
            !formData.meta_id ||
            !formData.cantidad_ejecutada
        ) {
            setSubmitMessage({
                type: "error",
                text: "Por favor, completa todos los campos obligatorios.",
            });
            return;
        }

        const dataToSend = new FormData();
        if (csrfToken) {
            dataToSend.append("_token", csrfToken);
        } else {
            setSubmitMessage({
                type: "error",
                text: "Error: CSRF token no disponible. La página podría estar expirada.",
            });
            return;
        }

        dataToSend.append("fecha_avance", formData.fecha_avance);
        dataToSend.append("meta_id", formData.meta_id);
        dataToSend.append("cantidad_ejecutada", formData.cantidad_ejecutada);
        dataToSend.append("observacion", formData.observacion);

        formData.archivos_adjuntos.forEach((file, index) => {
            dataToSend.append(`archivos_adjuntos[${index}]`, file);
        });

        try {
            const response = await fetch("/pam/store-advance", {
                method: "POST",
                body: dataToSend,
            });

            if (!response.ok) {
                const errorData = await response.json();
                if (response.status === 422 && errorData.errors) {
                    const errorMessages = Object.values(errorData.errors)
                        .flat()
                        .join("\n");
                    throw new Error(`Errores de validación:\n${errorMessages}`);
                }
                throw new Error(
                    errorData.message ||
                        `HTTP error! status: ${response.status}`
                );
            }

            const result = await response.json();
            console.log("Server response:", result);
            setSubmitMessage({
                type: "success",
                text: result.message || "Avance guardado exitosamente!",
            });
            window.location.reload();
        } catch (error) {
            console.error("Error al guardar el avance:", error);
            setSubmitMessage({
                type: "error",
                text:
                    error.message ||
                    "Error al guardar el avance. Inténtalo de nuevo.",
            });
        }
    };

    if (!isOpen) {
        return null;
    }
    // Función para encontrar la opción seleccionada y pasarla a 'value'
    const getSelectedMeta = () =>
        metasOptions.find((option) => option.id === formData.meta_id);

    return (
        <div
            className="modal fade show"
            style={{ display: "block", backgroundColor: "rgba(0,0,0,0.5)" }}
            tabIndex="-1"
            aria-labelledby="advanceFormModalLabel"
            aria-modal="true"
            role="dialog"
        >
            <div className="modal-dialog modal-lg">
                <div className="modal-content">
                    <div className="modal-header">
                        <h5 className="modal-title" id="advanceFormModalLabel">
                            Registrar Avance
                        </h5>
                        <button
                            type="button"
                            className="btn-close"
                            onClick={closeModal}
                            aria-label="Cerrar"
                        ></button>
                    </div>
                    <div className="modal-body">
                        {submitMessage && (
                            <div
                                className={`alert alert-${
                                    submitMessage.type === "success"
                                        ? "success"
                                        : "danger"
                                }`}
                                role="alert"
                            >
                                {submitMessage.text}
                            </div>
                        )}
                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label
                                    htmlFor="fecha_avance"
                                    className="form-label"
                                >
                                    Fecha de Avance:
                                </label>
                                <input
                                    type="date"
                                    className="form-control"
                                    id="fecha_avance"
                                    name="fecha_avance"
                                    value={formData.fecha_avance}
                                    onChange={handleChange}
                                    required
                                />
                            </div>

                            {/* Selector de Meta con React-Select */}
                            <div className="mb-3">
                                <label className="form-label">Meta:</label>
                                {loadingMetas ? (
                                    <p>Cargando metas...</p>
                                ) : (
                                    <Select
                                        options={metasOptions}
                                        onChange={handleMetaChange}
                                        placeholder="Selecciona una meta"
                                        name="meta_id"
                                        // Código modificado:
                                        // Se usa getOptionLabel para que el selector muestre la 'descripcion'
                                        getOptionLabel={(option) =>
                                            option.descripcion
                                        }
                                        // Se usa getOptionValue para que el valor de la opción sea el 'id'
                                        getOptionValue={(option) => option.id}
                                        // Se usa la función auxiliar para que el selector sepa cuál opción está seleccionada
                                        value={getSelectedMeta()}
                                        noOptionsMessage={() =>
                                            "No se encontraron metas"
                                        }
                                    />
                                )}
                            </div>

                            <div className="mb-3">
                                <label
                                    htmlFor="cantidad_ejecutada"
                                    className="form-label"
                                >
                                    Cantidad Ejecutada:
                                </label>
                                <input
                                    type="number"
                                    className="form-control"
                                    id="cantidad_ejecutada"
                                    name="cantidad_ejecutada"
                                    value={formData.cantidad_ejecutada}
                                    onChange={handleChange}
                                    min="0"
                                    required
                                />
                            </div>

                            <div className="mb-3">
                                <label
                                    htmlFor="observacion"
                                    className="form-label"
                                >
                                    Observación:
                                </label>
                                <textarea
                                    className="form-control"
                                    id="observacion"
                                    name="observacion"
                                    rows="4"
                                    value={formData.observacion}
                                    onChange={handleChange}
                                ></textarea>
                            </div>

                            <div className="mb-3">
                                <label
                                    htmlFor="archivos_adjuntos"
                                    className="form-label"
                                >
                                    Adjuntar archivo(s) de evidencia(s):
                                </label>
                                <input
                                    type="file"
                                    className="form-control"
                                    id="archivos_adjuntos"
                                    name="archivos_adjuntos"
                                    accept=".jpg,.png,.pdf,.docx"
                                    multiple
                                    onChange={handleChange}
                                />
                                {formData.archivos_adjuntos.length > 0 && (
                                    <div className="mt-2">
                                        <small className="form-text text-muted">
                                            Archivos seleccionados:
                                        </small>
                                        <ul className="list-group">
                                            {formData.archivos_adjuntos.map(
                                                (file, index) => (
                                                    <li
                                                        key={file.name + index}
                                                        className="list-group-item d-flex justify-content-between align-items-center"
                                                    >
                                                        <span
                                                            onClick={() =>
                                                                handleOpenFile(
                                                                    file
                                                                )
                                                            }
                                                            style={{
                                                                cursor: "pointer",
                                                                color: "blue",
                                                                textDecoration:
                                                                    "underline",
                                                            }}
                                                        >
                                                            {file.name}
                                                        </span>
                                                        <button
                                                            type="button"
                                                            className="btn btn-danger btn-sm"
                                                            onClick={() =>
                                                                handleDeleteFile(
                                                                    file.name
                                                                )
                                                            }
                                                        >
                                                            Eliminar
                                                        </button>
                                                    </li>
                                                )
                                            )}
                                        </ul>
                                    </div>
                                )}
                            </div>

                            <div className="modal-footer">
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    onClick={closeModal}
                                >
                                    Cerrar
                                </button>
                                <button
                                    type="submit"
                                    className="btn btn-primary"
                                >
                                    Guardar Avance
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default CrearAvance;
