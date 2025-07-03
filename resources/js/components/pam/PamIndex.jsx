import { useState, useEffect } from 'preact/hooks';
import { h } from 'preact';
import Swal from 'sweetalert2';

// Función para formatear fechas ISO a formato legible
const formatDate = (isoString) => {
  if (!isoString) return '';
  const date = new Date(isoString);
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const PamIndex = () => {
  const [rows, setRows] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  // Función para obtener el token CSRF
  const getCsrfToken = () => {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
  };

  // Cargar datos iniciales
  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const response = await fetch('get-pam', {
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
            fechaInicio: item.fecha_inicio ? formatDate(item.fecha_inicio) : '',
            fechaTerminacion: item.fecha_final ? formatDate(item.fecha_final) : ''
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

  const deleteRow = async (id, index) => {
    try {
      const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      });

      if (result.isConfirmed) {
        setIsLoading(true);
        
        // Hacer petición DELETE al servidor
        const response = await fetch(`/pam/${id}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json'
          }
        });

        if (!response.ok) {
          throw new Error('Error al eliminar el registro');
        }

        // Actualizar el estado local si la petición fue exitosa
        setRows(prevRows => {
          const newRows = [...prevRows];
          newRows.splice(index, 1);
          return newRows;
        });

        // Mostrar notificación de éxito
        await Swal.fire(
          '¡Eliminado!',
          'El registro ha sido eliminado.',
          'success'
        );
        window.location.reload()
      }
    } catch (error) {
      console.error('Error al eliminar:', error);
      Swal.fire(
        'Error',
        'No se pudo eliminar el registro: ' + error.message,
        'error'
      );
    } finally {
      setIsLoading(false);
    }
  };

  // const handleCellChange = (index, field, value) => {
  //   const newRows = [...rows];
  //   newRows[index][field] = value;
  //   setRows(newRows);
  // };
  const handleCellChange = (index, field, value) => {
    // Sanitizar el valor (eliminar etiquetas HTML potencialmente peligrosas)
    const sanitizedValue = value.replace(/<[^>]*>?/gm, '');
    
    // Actualizar el estado
    setRows(prevRows => {
      const newRows = [...prevRows];
      newRows[index] = {
        ...newRows[index],
        [field]: sanitizedValue === '&nbsp;' ? '' : sanitizedValue
      };
      return newRows;
    });
  };

  const saveChanges = async () => {
    setIsLoading(true);
    try {
      // Preparar datos para enviar al backend
      const dataToSend = rows.map(row => ({
        id: row.id,
        componente: row.componente,
        proceso: row.proceso,
        subproceso: row.subproceso,
        meta_plan_desarrollo: row.metaPlanDesarrollo,
        objetivo_estrategico: row.objetivoEstrategico,
        meta: row.meta,
        indicador: row.indicador,
        accion: row.accion,
        recursos: row.recursos,
        fecha_inicio: row.fechaInicio,
        fecha_final: row.fechaTerminacion
      }));

      const response = await fetch('/save-pam', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken(),
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        body: JSON.stringify(dataToSend)
      });
      
      if (!response.ok) {
        throw new Error('Error al guardar los cambios');
      }
      
      const result = await response.json();
      
      if (result.success) {
        alert('Cambios guardados exitosamente');
        // Si el backend devuelve los datos actualizados, actualizamos el estado
        if (result.data) {
          const updatedData = result.data.map(item => ({
            id: item.id,
            componente: item.componente || '',
            proceso: item.proceso || '',
            subproceso: item.subproceso || '',
            metaPlanDesarrollo: item.meta_plan_desarrollo || '',
            objetivoEstrategico: item.objetivo_estrategico || '',
            meta: item.meta || '',
            indicador: item.indicador || '',
            accion: item.accion || '',
            responsable: '',
            recursos: item.recursos || '',
            fechaInicio: item.fecha_inicio ? formatDate(item.fecha_inicio) : '',
            fechaTerminacion: item.fecha_final ? formatDate(item.fecha_final) : ''
          }));
          setRows(updatedData);
        }
      } else {
        throw new Error(result.message || 'Error al guardar');
      }
    } catch (err) {
      console.error('Error al guardar:', err);
      setError(err.message);
      alert('Error al guardar: ' + err.message);
    } finally {
      setIsLoading(false);
    }
  };

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
          <div className="table-responsive" style={{ maxHeight: '600px', overflowY: 'auto' }}>
            <table className="table table-hover table-bordered mb-0">
              <thead className="sticky-top" style={{ backgroundColor: '#f8f9fa' }}>
                <tr>
                  <th width="10%" className="align-middle">COMPONENTE</th>
                  <th width="10%" className="align-middle">PROCESO</th>
                  <th width="10%" className="align-middle">SUBPROCESO</th>
                  <th width="10%" className="align-middle">META DEL PLAN</th>
                  <th width="12%" className="align-middle">OBJETIVO ESTRATÉGICO</th>
                  <th width="8%" className="align-middle">META</th>
                  <th width="8%" className="align-middle">INDICADOR</th>
                  <th width="8%" className="align-middle">ACCIÓN</th>
                  <th width="8%" className="align-middle">RESPONSABLE</th>
                  <th width="6%" className="align-middle">RECURSOS</th>
                  <th width="5%" className="align-middle">FECHA INICIO</th>
                  <th width="5%" className="align-middle">FECHA FIN</th>
                  <th width="5%" className="align-middle text-center">ACCIONES</th>
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
                    <td className="py-3">{row.responsable || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.recursos || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.fechaInicio || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.fechaTerminacion || <span className="text-muted">Sin información</span>}</td>
                    <td className="text-center">
                      <div className="d-flex justify-content-center gap-2">
                        <a 
                          href={`/pam/pam-form/${row.id}`}
                          className="btn btn-sm btn-primary"
                          title="Editar registro"
                        >
                          <i className="fas fa-edit"></i>
                        </a>
                        <button 
                          className="btn btn-sm btn-danger"
                          onClick={() => deleteRow(row.id)}
                          disabled={isLoading}
                          title="Eliminar registro"
                        >
                          <i className="fas fa-trash-alt"></i>
                        </button>
                      </div>
                    </td>
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
        <button 
          className="btn btn-success"
          onClick={saveChanges}
          disabled={isLoading}
        >
          {isLoading ? (
            <>
              <span className="spinner-border spinner-border-sm me-2"></span>
              Guardando...
            </>
          ) : (
            <>
              <i className="bi bi-save me-2"></i>
              Guardar Cambios
            </>
          )}
        </button>
      </div>
    </div>
  );
};

export default PamIndex;