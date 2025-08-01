import { useState, useEffect } from 'preact/hooks';

const PamVistaCompleta = ({ pamGeneralId, csrfToken }) => {
  const [rows, setRows] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  // Cargar datos iniciales
  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);

        // Swal.fire({
        //   icon: 'info',
        //   title: 'PAM en Desarrollo',
        //   text: 'La funcionalidad de creación de PAM, creación de avances y exportación de excel se encuentran actualmente en desarrollo.',
        //   confirmButtonText: 'Entendido'
        // });
        const response = await fetch(`get-pam`, {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        
        if (!response.ok) {
          throw new Error(`Error HTTP! Estado: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success && Array.isArray(result.data)) {
          // Mapear los datos de la API al formato esperado por el frontend
          const mappedData = result.data.map(item => ({
            id: item.id,
            componente: item.componente || '',
            proceso: item.proceso || '',
            subproceso: item.subproceso || '',
            metaPlanDesarrollo: item.meta_plan_desarrollo || '',
            objetivoEstrategico: item.objetivo_estrategico || '',
            meta: item.meta || '',
            indicador: item.indicador || '',
            accion: item.accion || '',
            responsable: item.responsable || '',
            recursos: item.recursos || '',
            fechaInicio: item.fecha_inicio ? item.fecha_inicio : '',
            fechaTerminacion: item.fecha_final ? item.fecha_final : ''
          }));
          
          setRows(mappedData);
        } else {
          throw new Error(result.message || 'Formato de datos inesperado');
        }
      } catch (err) {
        console.error('Error al cargar datos:', err);
        setError(err.message);
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  if (isLoading) {
    return (
      <div className="text-center my-5">
        <div className="spinner-border" role="status">
          <span className="visually-hidden">Cargando...</span>
        </div>
        <p>Cargando datos...</p>
      </div>
    );
  }

  if (error) {
    return (
      <div className="alert alert-danger" role="alert">
        Error al cargar los datos: {error}
        <button className="btn btn-sm btn-secondary ms-2" onClick={() => window.location.reload()}>
          Recargar
        </button>
      </div>
    );
  }

  return (
  <div className="container-fluid mt-4">
    <div className="card shadow-sm">
      <div className="card-body p-0">
        <div className="table-responsive">
          <table className="table table-hover table-bordered mb-0">
            <thead className="sticky-top" style={{ backgroundColor: '#f8f9fa' }}>
              <tr>
                {/* Aumentamos los anchos de las columnas para una mejor distribución */}
                <th width="4%" className="align-middle">COMPONENTE</th>
                <th width="8%" className="align-middle">PROCESO</th>
                <th width="8%" className="align-middle">SUBPROCESO</th>
                <th width="10%" className="align-middle">META DEL PLAN</th>
                <th width="12%" className="align-middle">OBJETIVO ESTRATÉGICO</th>
                <th width="8%" className="align-middle">META</th>
                <th width="12%" className="align-middle">INDICADOR</th>
                <th width="8%" className="align-middle">ACCIÓN</th>
                <th width="8%" className="align-middle">RESPONSABLE</th>
                <th width="8%" className="align-middle">RECURSOS</th>
                <th width="6%" className="align-middle">FECHA INICIO</th>
                <th width="6%" className="align-middle">FECHA FIN</th>
                <th width="10%" className="align-middle">PORCENTAJE DE AVANCE</th>
              </tr>
            </thead>
            <tbody>
              {rows.map((row, index) => (
                <tr key={row.id || index} className="align-middle">
                  <td className="py-3">{row.componente || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.proceso || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.subproceso || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.metaPlanDesarrollo || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.objetivoEstrategico || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.meta || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.indicador || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.accion || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.responsable?.name || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.recursos || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.fechaInicio || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.fechaTerminacion || <span className="text-muted">Sin información</span>}</td>
                  <td className="py-3">{row.porcentaje_avance || <span className="text-muted">Sin información</span>}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div className="mt-3 d-flex justify-content-between align-items-center">
      <div className="text-muted small">
        Mostrando {rows.length} registros
      </div>
    </div>
  </div>
);
};

export default PamVistaCompleta;