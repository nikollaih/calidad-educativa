import { useState, useEffect } from 'preact/hooks';
import { h } from 'preact';
import Swal from 'sweetalert2';
import CNavigationButton from '../shared/CNavigationButton';
import CrearAvance from './CrearAvance';
import VerAvance from './VerAvance';

const PamIndex = ({ pamGeneralId, isInProceso, canGestionarPam = false }) => {
  const [rows, setRows] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showCrearAvance, setShowCrearAvance] = useState(false);
  const [showAvancesModal, setShowAvancesModal] = useState(false);
  const [selectedAccionId, setSelectedAccionId] = useState(null);
  const [selectedMeta, setSelectedMeta] = useState(null);
  const [selectedValorMeta, setSelectedValorMeta] = useState(null);


  // Función para obtener el token CSRF
  const getCsrfToken = () => {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
  };

  const openAvancesModal = (accionId, meta, valorMeta) => {
    console.log(accionId, meta, valorMeta);

    setSelectedAccionId(accionId);
    setSelectedMeta(meta);
    setSelectedValorMeta(valorMeta);
    setShowAvancesModal(true);
  };

  const closeAvancesModal = () => {
    setShowAvancesModal(false);
    setSelectedMeta(null);
    setSelectedValorMeta(null);
    setSelectedAccionId(null);
  };

  // Function to open the modal
  const openCrearAvance = (pamId) => {
    // setSelectedPamId(pamId);
    setShowCrearAvance(true);
  };

  // Function to close the modal
  const closeCrearAvance = () => {
    setShowCrearAvance(false);
    // setSelectedPamId(null);
  };

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
            dias_restantes: item.dias_restantes || '',
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

  // useEffect para recargar la página automáticamente cuando hay un error
  useEffect(() => {
    if (error) {
      const timer = setTimeout(() => {
        window.location.reload();
      }, 500);

      return () => clearTimeout(timer);
    }
  }, [error]);

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

  // Function for "Exportar tabla"
  const handleExportTable = async () => {
    try {
      // Mostrar loading
      Swal.fire({
        title: 'Exportando...',
        text: 'Por favor espere mientras se genera el archivo',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Realizar la petición para exportar
      const response = await fetch(`/pam/${pamGeneralId}/export`, {
        method: 'GET',
        headers: {
          'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
          'X-Requested-With': 'XMLHttpRequest',
          // Agregar token CSRF si es necesario
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
      });

      if (!response.ok) {
        throw new Error(`Error ${response.status}: ${response.statusText}`);
      }

      // Obtener el blob del archivo
      const blob = await response.blob();

      // Crear nombre del archivo con timestamp
      const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
      const filename = `pam_export_${timestamp}.xlsx`;

      // Crear enlace de descarga
      const url = window.URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = filename;

      // Ejecutar descarga
      document.body.appendChild(link);
      link.click();

      // Limpiar
      document.body.removeChild(link);
      window.URL.revokeObjectURL(url);

      // Mostrar mensaje de éxito
      Swal.fire({
        icon: 'success',
        title: 'Exportación Exitosa',
        text: `El archivo ${filename} se ha descargado correctamente.`,
        confirmButtonText: 'Ok'
      });

    } catch (error) {
      console.error('Error al exportar:', error);

      // Mostrar mensaje de error
      Swal.fire({
        icon: 'error',
        title: 'Error en la Exportación',
        text: 'Hubo un problema al generar el archivo. Por favor intente nuevamente.',
        confirmButtonText: 'Ok'
      });
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
      <div className="d-flex justify-content-start gap-2 mb-4">
        {/* <CBackButton /> */}
        {canGestionarPam && isInProceso && (
          <CNavigationButton label="Crear registro" to="pam-form" icon="fas fa-plus" />
        )}
        {canGestionarPam && !isInProceso && (
          <CNavigationButton
            label="Crear avance"
            to="#"
            icon="fas fa-history"
            onClick={openCrearAvance}
          />
        )}
        {canGestionarPam && (
          <CNavigationButton label="Exportar tabla" to="#" icon="fas fa-file-excel" onClick={handleExportTable} />
        )}
        <CNavigationButton
          label="Vista completa"
          to="tabla-completa-pam"
          icon="fas fa-table"
          target="_blank"
        />
      </div><div className="card shadow-sm">
        <div className="card-body p-0">
          <div className="table-responsive" style={{ maxHeight: '600px', overflowY: 'auto' }}>
            <table className="table table-hover table-bordered mb-0">
              <thead className="sticky-top" style={{ backgroundColor: '#f8f9fa' }}>
                <tr>
                  <th className="align-middle">OBJETIVO ESTRATÉGICO</th>
                  <th className="align-middle" style={{ minWidth: "150px" }}>META</th>
                  <th className="align-middle">VALOR DE META</th>
                  <th className="align-middle" style={{ minWidth: "150px" }}>INDICADOR</th>
                  <th className="align-middle" style={{ minWidth: "250px" }}>ACCIONES</th>
                  <th className="align-middle">RESPONSABLE</th>
                  <th className="align-middle">RECURSOS</th>
                  <th className="align-middle">FECHA INICIO</th>
                  <th className="align-middle">FECHA FIN</th>
                  <th className="align-middle">DIAS RESTANTES</th>
                  <th className="align-middle">PORCENTAJE DE AVANCE</th>
                  {canGestionarPam && <th className="align-middle text-center">ACCIONES</th>}
                </tr>
              </thead>
              <tbody>
                {rows.map((row, index) => (
                  <tr key={row.id || index} className="align-middle">
                    <td className="py-3">{row.objetivoEstrategico || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3" style={{ minWidth: "150px" }}>{row.meta.descripcion || <span className="text-muted">Sin información</span>}</td>
                    <td className="text-center py-3">{row.meta.valor_meta || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.indicador || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3" style={{ minWidth: "120px" }}>{row.accion || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.responsable?.name || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.recursos || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.fechaInicio || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.fechaTerminacion || <span className="text-muted">Sin información</span>}</td>
                    <td className="py-3">{row.dias_restantes || <span className="text-muted">Sin información</span>}</td>
                    <td className="text-center py-3">{row.meta.porcentaje_meta || <span className="text-muted">Sin información</span>}</td>
                    {canGestionarPam && (
                      <td className="text-center">
                        <div className="d-flex justify-content-center gap-2">
                          <button
                            className="btn btn-sm btn-info text-white"
                            onClick={() => openAvancesModal(row.id, row.meta.descripcion, row.meta.valor_meta)}
                            title="Ver Avances"
                          >
                            <i className="fas fa-eye"></i>
                          </button>
                          {isInProceso && (
                            <a
                              href={`/pam/pam-form/${row.id}?pam=${pamGeneralId}`}
                              className="btn btn-sm btn-primary"
                              title="Editar registro"
                            >
                              <i className="fas fa-edit"></i>
                            </a>
                          )}
                          {isInProceso && (
                            <button
                              className="btn btn-sm btn-danger"
                              onClick={() => deleteRow(row.id)}
                              disabled={isLoading}
                              title="Eliminar registro"
                            >
                              <i className="fas fa-trash-alt"></i>
                            </button>
                          )}
                        </div>
                      </td>
                    )}
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
        {/* Render the CrearAvance when showCrearAvance is true */}
        {showCrearAvance && (
          <CrearAvance onClose={closeCrearAvance} pamGeneralId={pamGeneralId} />
        )}
        {showAvancesModal && (
          <VerAvance
            accionId={selectedAccionId}
            onClose={closeAvancesModal}
            meta={selectedMeta}
            valorMeta={selectedValorMeta}
          />
        )}
      </div>
    </div>
  );
};

export default PamIndex;
