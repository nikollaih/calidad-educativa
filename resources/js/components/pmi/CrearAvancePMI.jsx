// src/components/CrearAvance.jsx
import { useState, useEffect } from 'preact/hooks';
import Select from 'react-select';
import { h } from 'preact';
import CMultiFileUploader from '@/components/shared/CMultiFileUploader.jsx';

const CrearAvancePMI = ({
    pmiId = undefined,
    onClose,
    csrfToken = '',
    actividad = undefined,
    institucionId = undefined,
}) => {
    const [isOpen, setIsOpen] = useState(true);
    const [selectedActivity, setSelectedActivity] = useState(null);
    const [formData, setFormData] = useState({
        fecha_avance: '',
        actividad_id: '',
        porcentaje_ejecutado: '',
        suma_al_indicador: 0,
        descripcion: '',
        archivos_adjuntos: [],
    });
    const [actividades, setActividades] = useState([]);
    const [loadingActividades, setLoadingActividades] = useState(true);
    const [submitMessage, setSubmitMessage] = useState(null);

    // --- Modal control functions ---
    const openModal = () => setIsOpen(true);
    const closeModal = () => {
        setIsOpen(false);
        setFormData({
            fecha_avance: '',
            actividad_id: '',
            porcentaje_ejecutado: '',
            suma_al_indicador: 0,
            descripcion: '',
            archivos_adjuntos: [],
        });
        setSubmitMessage(null);
        setActividades([]);
        setLoadingActividades(true);
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
        console.log(formData?.archivos_adjuntos);
    }, [formData]);

    // --- Carga las opciones para el selector de 'Actividades' ---
    useEffect(() => {
        const fetchActividades = async () => {
            try {
                const response = await fetch('/pmi/get-actividades/' + pmiId);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                // Código modificado:
                // react-select espera un formato { label, value } por defecto,
                // pero aquí usamos getOptionLabel y getOptionValue para
                setActividades(data);
            } catch (error) {
                console.error('Error al cargar las Actividades:', error);
            } finally {
                setLoadingActividades(false);
            }
        };
        if (isOpen && loadingActividades) {
            fetchActividades();
        } else if (!isOpen) {
            setLoadingActividades(true);
        }
    }, [isOpen, loadingActividades]);

    // --- Autoseleccionar la actividad recibida por props ---
    useEffect(() => {
        if (!loadingActividades && actividad && actividades.length > 0) {
            const encontrada = actividades.find((a) => a.id === actividad.id);
            if (encontrada) {
                setSelectedActivity(encontrada);
                setFormData((prev) => ({
                    ...prev,
                    actividad_id: encontrada.id, // asegura que se guarde al enviar
                }));
            }
        }
    }, [actividad, actividades, loadingActividades]);

    // --- Maneja los cambios del formulario ---
    const handleChange = (e) => {
        const { name, value, files } = e.target;

        if (name === 'archivos_adjuntos') {
            setFormData((prevData) => ({
                ...prevData,
                [name]: prevData.archivos_adjuntos.concat(Array.from(files)),
            }));
        } else if (name === 'suma_al_indicador' && selectedActivity) {
            // límite dinámico
            const min = 0;
            const max = selectedActivity.max_suma_indicador - selectedActivity.indicador_acumulado;
            let val = Number(value);

            // forzar dentro de rango
            if (val < min) val = min;
            if (val > max) val = max;

            setFormData((prevData) => ({
                ...prevData,
                [name]: val,
            }));
        } else {
            setFormData((prevData) => ({
                ...prevData,
                [name]: value,
            }));
        }
    };

    // --- Valida antes de enviar ---
    const handleSubmit = (e) => {
        // evita que se mande automáticamente
        e.preventDefault();

        if (!formData.fecha_avance) {
            setSubmitMessage({ type: 'error', text: 'Debes seleccionar la fecha de avance.' });
            return;
        }

        if (
            selectedActivity?.afecta_indicador &&
            (!formData.suma_al_indicador || formData.suma_al_indicador <= 0)
        ) {
            setSubmitMessage({
                type: 'error',
                text: "Debes ingresar un valor válido en 'cantidad'.",
            });
            return;
        }

        if (!formData.descripcion.trim()) {
            setSubmitMessage({
                type: 'error',
                text: 'Debes ingresar una observación o descripción.',
            });
            return;
        }

        // si pasa todas las validaciones, envía el formulario real
        e.target.submit();
    };

    // --- Código modificado: Maneja la selección del componente `Select` para las Actividades ---
    const handleMetaChange = (selectedOption) => {
        setSelectedActivity(selectedOption);
    };

    if (!isOpen) {
        return null;
    }
    // Función para encontrar la opción seleccionada y pasarla a 'value'
    const getSelectedMeta = () => actividades.find((option) => option.id === formData.actividad_id);
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
                                    submitMessage.type === 'success' ? 'success' : 'danger'
                                }`}
                                role="alert"
                            >
                                {submitMessage.text}
                            </div>
                        )}
                        <form>
                            <div className="mb-3">
                                <label htmlFor="fecha_avance" className="block text-sm mb-2 ml-4">
                                    Fecha de Avance:
                                </label>
                                <input
                                    type="date"
                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                    id="fecha_avance"
                                    name="fecha_avance"
                                    value={formData.fecha_avance}
                                    onChange={handleChange}
                                    max={new Date().toISOString().split('T')[0]} // 👈 límite: hoy
                                    required
                                />
                            </div>

                            {/* Selector de actividad con React-Select */}
                            <div className="mb-3">
                                <label className="block text-sm mb-2 ml-4">Actividad:</label>
                                {loadingActividades ? (
                                    <p>Cargando Actividades...</p>
                                ) : (
                                    <Select
                                        options={actividades}
                                        onChange={handleMetaChange}
                                        placeholder="Selecciona una actividad"
                                        name="actividad_id"
                                        // Código modificado:
                                        // Se usa getOptionLabel para que el selector muestre la 'descripcion'
                                        getOptionLabel={(option) => option.descripcion}
                                        // Se usa getOptionValue para que el valor de la opción sea el 'id'
                                        getOptionValue={(option) => option.id}
                                        // Se usa la función auxiliar para que el selector sepa cuál opción está seleccionada
                                        value={getSelectedMeta()}
                                        noOptionsMessage={() => 'No se encontraron Actividades'}
                                        isDisabled={Boolean(actividad)}
                                    />
                                )}
                            </div>
                            {selectedActivity && (
                                <>
                                    <div className="d-flex  gap-2">
                                        {Boolean(selectedActivity?.afecta_indicador) && (
                                            <div className="mb-3 w-100 ml-1">
                                                <label htmlFor="unidades" className="block text-sm mb-2 ml-4">
                                                    Cantidad :
                                                </label>
                                                <input
                                                    type="number"
                                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                                    id="suma_al_indicador"
                                                    name="suma_al_indicador"
                                                    value={formData.suma_al_indicador}
                                                    onChange={handleChange}
                                                    min="0"
                                                    max={
                                                        selectedActivity?.max_suma_indicador -
                                                        selectedActivity?.indicador_acumulado
                                                    }
                                                    required
                                                />
                                                <small>
                                                    (
                                                    {String(
                                                        selectedActivity.indicador.unidad_parcial
                                                    )}
                                                    )
                                                </small>
                                            </div>
                                        )}
                                    </div>

                                    <div className="mb-3">
                                        <label htmlFor="descripcion" className="block text-sm mb-2 ml-4">
                                            Observación:
                                        </label>
                                        <textarea
                                            className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                            id="descripcion"
                                            name="descripcion"
                                            rows="4"
                                            value={formData.descripcion}
                                            onChange={handleChange}
                                        ></textarea>
                                    </div>
                                    <div className="mb-3">
                                        <label className="block text-sm mb-2 ml-4">
                                            Archivos adjuntos del avance
                                        </label>
                                        <CMultiFileUploader
                                            onFilesAdded={(newFiles) => {
                                                setFormData((prevData) => ({
                                                    ...prevData,
                                                    archivos_adjuntos: [
                                                        ...prevData.archivos_adjuntos,
                                                        ...newFiles,
                                                    ],
                                                }));
                                            }}
                                            onFilesDelete={(newFiles) => {
                                                setFormData((prevData) => ({
                                                    ...prevData,
                                                    archivos_adjuntos: newFiles,
                                                }));
                                            }}
                                        />
                                    </div>
                                </>
                            )}

                            <div className="modal-footer">
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    onClick={closeModal}
                                >
                                    Cerrar
                                </button>
                                {selectedActivity && (
                                    <form
                                        method="POST"
                                        action="/pmi/guardar-avance-actividad"
                                        encType="multipart/form-data"
                                        onSubmit={handleSubmit}
                                    >
                                        <input type="hidden" name="_token" value={csrfToken} />
                                        <input type="hidden" name="pmi_id" value={pmiId} />
                                        <input
                                            type="hidden"
                                            name="actividad_id"
                                            value={formData.actividad_id}
                                        />
                                        <input
                                            type="hidden"
                                            name="fecha_avance"
                                            value={formData.fecha_avance}
                                        />
                                        <input
                                            type="hidden"
                                            name="porcentaje_ejecutado"
                                            value={formData.porcentaje_ejecutado}
                                        />
                                        <input
                                            type="hidden"
                                            name="suma_al_indicador"
                                            value={formData.suma_al_indicador}
                                        />
                                        <input
                                            type="hidden"
                                            name="descripcion"
                                            value={formData.descripcion}
                                        />

                                        {/* Inputs de archivos */}
                                        {formData?.archivos_adjuntos.map((file, index) => (
                                            <input
                                                key={index}
                                                type="file"
                                                name="adjuntos[]"
                                                style={{ display: 'none' }}
                                                ref={(el) => {
                                                    if (el) {
                                                        const dataTransfer = new DataTransfer();
                                                        dataTransfer.items.add(file); // asigna el File real
                                                        el.files = dataTransfer.files;
                                                    }
                                                }}
                                            />
                                        ))}

                                        <button type="submit" className="border bg-blue-500  text-white p-2 rounded-pill">
                                            Guardar Avance
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

export default CrearAvancePMI;
