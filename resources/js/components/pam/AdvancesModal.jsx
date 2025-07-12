import { useState, useEffect } from 'preact/hooks';
import { h } from 'preact';
import Swal from 'sweetalert2'; // Assuming you still want SweetAlert for potential error messages

const AdvancesModal = ({ pamId, onClose }) => {
  const [advances, setAdvances] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchAdvances = async () => {
      if (!pamId) {
        setError('PAM ID is missing.');
        setIsLoading(false);
        return;
      }

      try {
        setIsLoading(true);
        const response = await fetch(`/get-advances?pam_id=${pamId}`, {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();

        if (result.success && Array.isArray(result.data)) {
          setAdvances(result.data);
        } else {
          throw new Error(result.message || 'Unexpected data format from get-advances');
        }
      } catch (err) {
        console.error('Error fetching advances:', err);
        setError(err.message);
        Swal.fire('Error', 'Could not load advances: ' + err.message, 'error');
      } finally {
        setIsLoading(false);
      }
    };

    fetchAdvances();
  }, [pamId]); // Re-fetch when pamId changes

  return (
    <div className="modal show d-block" tabIndex="-1" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
      <div className="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">Avances del PAM</h5>
            <button type="button" className="btn-close" onClick={onClose} aria-label="Close"></button>
          </div>
          <div className="modal-body">
            {isLoading && (
              <div className="text-center my-3">
                <div className="spinner-border" role="status">
                  <span className="visually-hidden">Cargando avances...</span>
                </div>
                <p>Cargando avances...</p>
              </div>
            )}

            {error && (
              <div className="alert alert-danger" role="alert">
                Error: {error}
              </div>
            )}

            {!isLoading && !error && advances.length === 0 && (
              <div className="alert alert-info" role="alert">
                No se encontraron avances para este registro.
              </div>
            )}

            {!isLoading && !error && advances.length > 0 && (
              <div className="table-responsive">
                <table className="table table-striped table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>Fecha de Avance</th>
                      <th>Descripción</th>
                      <th>Porcentaje</th>
                    </tr>
                  </thead>
                  <tbody>
                    {advances.map((advance, index) => (
                      <tr key={advance.id || index}>
                        <td>{new Date(advance.fecha_avance).toLocaleDateString('es-ES')}</td>
                        <td>{advance.descripcion}</td>
                        <td>{advance.porcentaje_avance}%</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            )}
          </div>
          <div className="modal-footer">
            <button type="button" className="btn btn-secondary" onClick={onClose}>Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AdvancesModal;