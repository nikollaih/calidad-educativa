// src/components/VerAvancesPMI.jsx
import { useState, useEffect } from "preact/hooks";
import { h } from "preact";

const VerAvancesPMI = ({ actividad, onClose }) => {
    const [avances, setAvances] = useState([]);

    // --- Modal control functions ---
    const closeModal = () => {
        if (onClose) {
            onClose();
        }
    };

    // --- Carga avances por actividad ---
    useEffect(() => {
        fetchAvances();
    }, [actividad]);

    const fetchAvances = async () => {
        try {
            const response = await fetch("/pmi/get-avances-actividad/" + actividad?.id);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            // Ordenar por id descendente
            const sortedData = data.sort((a, b) => b.id - a.id);

            setAvances(sortedData);
        } catch (error) {
            console.error("Error al cargar los avances:", error);
        }
    };


    return (
        <div
            className="modal fade show"
            style={{ display: "block", backgroundColor: "rgba(0,0,0,0.5)" }}
            tabIndex="-1"
            aria-labelledby="advanceFormModalLabel"
            aria-modal="true"
            role="dialog"
        >
            <div className="modal-dialog modal-xl">
                <div className="modal-content">
                    <div className="modal-header">
                        <h5 className="modal-title" id="advanceFormModalLabel">
                            Ver Avances
                        </h5>
                        <button
                            type="button"
                            className="btn-close"
                            onClick={closeModal}
                            aria-label="Cerrar"
                        ></button>
                    </div>
                    <div className="modal-body">
                        {avances.length === 0 ? (
                            <p className="text-muted">No hay avances registrados.</p>
                        ) : (
                            <div className="table-responsive">
                                <table className="table table-striped table-bordered align-middle">
                                    <thead className="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>% Ejecutado</th>
                                        <th>Suma al Indicador</th>
                                        <th>Adjuntos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {avances.map((avance, idx) => (
                                        <tr key={avance.id}>
                                            <td>{avance.fecha_avance}</td>
                                            <td>{avance.descripcion}</td>
                                            <td>{avance.porcentaje_ejecutado}%</td>
                                            <td>{avance.suma_al_indicador}</td>
                                            <td>
                                                {avance.adjuntos && avance.adjuntos.length > 0 ? (
                                                    <ul className="list-unstyled mb-0 d-flex flex-wrap gap-3">
                                                        {avance.adjuntos.map((file) => (
                                                            <li key={file.id} className="text-center">
                                                                <a
                                                                    href={`/storage/${file.ruta}`}
                                                                    target="_blank"
                                                                    rel="noopener noreferrer"
                                                                >
                                                                    {file.tipo_mime.startsWith("image/") ? (
                                                                        <div>
                                                                            <img
                                                                                src={`/storage/${file.ruta}`}
                                                                                alt={file.nombre}
                                                                                style={{ maxWidth: "100px", maxHeight: "80px" }}
                                                                                className="img-thumbnail mb-1"
                                                                            />
                                                                            <div className="small text-truncate" style={{ maxWidth: "100px" }}>
                                                                                {file.nombre_completo}
                                                                            </div>
                                                                        </div>
                                                                    ) : (
                                                                        <div className="small">
                                                                            📄 {file.nombre_completo}
                                                                        </div>
                                                                    )}
                                                                </a>
                                                            </li>
                                                        ))}
                                                    </ul>
                                                ) : (
                                                    <span className="text-muted">Sin adjuntos</span>
                                                )}
                                            </td>

                                        </tr>
                                    ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default VerAvancesPMI;
