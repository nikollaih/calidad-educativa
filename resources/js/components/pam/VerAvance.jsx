import { useState, useEffect } from 'preact/hooks';
import { render } from 'preact'; // Needed for external mounting, if applicable

const VerAvance = ({ accionId, onClose }) => {
    const [isOpen, setIsOpen] = useState(true);
    const [avances, setAvances] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const closeModal = () => {
        setIsOpen(false);
        if (onClose) {
            onClose(); // Call the parent's onClose handler
        }
    };

    useEffect(() => {
        if (!accionId) {
            setError('No se proporcionó ID de acción para ver los avances.');
            setLoading(false);
            return;
        }

        const fetchAvances = async () => {
            setLoading(true);
            setError(null);
            try {
                const response = await fetch(`/pam/get-avances-by-accion/${accionId}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                setAvances(data);
            } catch (err) {
                console.error('Error al cargar avances:', err);
                setError('Error al cargar los avances: ' + err.message);
            } finally {
                setLoading(false);
            }
        };

        if (isOpen) { // Only fetch if modal is open
            fetchAvances();
        }
    }, [accionId, isOpen]); // Re-fetch if accionId changes or modal opens

    if (!isOpen) {
        return null; // Don't render if closed
    }

    return (
        <div
            className="modal fade show"
            style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}
            tabIndex="-1"
            aria-labelledby="viewAdvancesModalLabel"
            aria-modal="true"
            role="dialog"
        >
            <div className="modal-dialog modal-xl"> {/* modal-xl for wider content */}
                <div className="modal-content">
                    <div className="modal-header">
                        <h5 className="modal-title" id="viewAdvancesModalLabel">Avances de la Acción</h5>
                        <button type="button" className="btn-close" onClick={closeModal} aria-label="Cerrar"></button>
                    </div>
                    <div className="modal-body">
                        {loading && <p>Cargando avances...</p>}
                        {error && <div className="alert alert-danger">{error}</div>}
                        {!loading && !error && (
                            avances.length > 0 ? (
                                <div className="table-responsive">
                                    <table className="table table-striped table-hover table-bordered">
                                        <thead className="table-light">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Cantidad</th>
                                                <th>Observación</th>
                                                {/* <th>Acción Relacionada</th> */}
                                                <th>Archivos Adjuntos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {avances.map((avance) => (
                                                <tr key={avance.id}>
                                                    <td>{avance.fecha_avance}</td>
                                                    <td>{avance.cantidad_ejecutada}</td>
                                                    <td>{avance.observacion || 'N/A'}</td>
                                                    {/* <td>{avance.accion_descripcion}</td> */}
                                                    <td>
                                                        {avance.archivos_adjuntos && avance.archivos_adjuntos.length > 0 ? (
                                                            <div className="d-flex flex-wrap gap-2">
                                                                {avance.archivos_adjuntos.map(file => (
                                                                    <div key={file.id} className="mb-1">
                                                                        <a 
                                                                            href={file.url} 
                                                                            target="_blank" 
                                                                            rel="noopener noreferrer"
                                                                            className="btn btn-sm btn-outline-primary d-flex align-items-center"
                                                                            title={`Descargar ${file.nombre}`}
                                                                        >
                                                                            <i className="fas fa-file-download me-1"></i>
                                                                            <span className="text-truncate" style={{maxWidth: '150px'}}>
                                                                                {file.nombre}
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                ))}
                                                            </div>
                                                        ) : (
                                                            <span className="text-muted">
                                                                Sin archivos
                                                            </span>
                                                        )}
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            ) : (
                                <p>No hay avances registrados para esta acción.</p>
                            )
                        )}
                    </div>
                    <div className="modal-footer">
                        <button type="button" className="btn btn-secondary" onClick={closeModal}>Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default VerAvance;