import { h } from 'preact';
import { useState } from 'preact/hooks';

// Modal de editar
const ModalAjustes = ({
  nombre_gestion,
  institucionId,
  csrfToken,
  formData,
  setFormData,
  documentos,
  onClose,
  onSave
}) => {

  const [fileUploads, setFileUploads] = useState({});

  const handleSubmit = (e) => {
    e.preventDefault();
    onSave(formData, fileUploads);
  };

 const handleFileChange = (documentData, e) => {
  console.log('documentData', documentData);

  if (e.target.files[0]) {
    setFileUploads({
      ...fileUploads,
      // Usamos tanto la clave original como la snake_case por compatibilidad
      [documentData.original_key]: e.target.files[0],
      [documentData.document_key]: e.target.files[0]
    });
  }
};


const handleNewFile = (fieldName, e) => {
  setFileUploads({
    ...fileUploads,
    [fieldName]: e.target.files[0]
  });
};

  const tipoCodificacionOptions = [
    { value: 1, label: 'Inicial' },
    { value: 2, label: 'Resignificacion' },
    { value: 3, label: 'Ajuste' },
    { value: 4, label: 'Corrección' },
  ];

  return (
    <div className="modal fade show d-block" style={{backgroundColor: 'rgba(0,0,0,0.5)'}}>
    <div className="modal-dialog modal-lg modal-dialog-centered">
      <div className="modal-content">
        <div className="modal-header">
          <h5 className="modal-title">EDITAR {nombre_gestion}</h5>
          <button
            type="button"
            className="btn-close"
            onClick={onClose}
            aria-label="Cerrar"
          ></button>
        </div>
        <div className="modal-body">
          <form onSubmit={handleSubmit}>
            <input type="hidden" name="_token" value={csrfToken} />

            {/* Sección superior: Tipo de ajuste y Fecha */}
            <div className="row mb-4">
              <div className="col-md-6">
                <div className="mb-3">
                  <label className="form-label">Tipo de ajuste  <span style={{color: 'red'}}>*</span></label>
                  <select
                    className="form-select"
                    value={formData.tipo_codificacion || ''}
                    onChange={(e) => setFormData({...formData, tipo_codificacion: e.target.value})}
                    required
                  >
                    {tipoCodificacionOptions.map((option) => (
                      <option key={option.value} value={option.value}>
                        {option.label}
                      </option>
                    ))}
                  </select>
                </div>
              </div>
              <div className="col-md-6">
                <div className="mb-3">
                  <label className="form-label text-capitalize">Fecha  <span style={{color: 'red'}}>*</span></label>
                  <input
                    type="date"
                    required
                    className="form-control"
                    value={formData.fecha || ''}
                    min={new Date().toISOString().split("T")[0]}
                    onChange={(e) => setFormData({...formData, fecha: e.target.value})}
                  />
                </div>
              </div>
            </div>

            {/* Sección central: Campos del formulario en 2 columnas */}
            <div className="row mb-4">
              {Object.entries(formData).map(([clave, valor]) => {

                if (['tipo_codificacion', 'fecha', 'observacion', 'relation_name'].includes(clave)) return null;

                return (
                  <div className="col-md-6 mb-3" key={`edit-${clave}`}>
                    <label className="form-label text-capitalize">{clave.replace(/_/g, ' ')}</label>
                    <textarea
                      type="text"
                      className="form-control"
                      value={valor || ''}
                      onChange={(e) => setFormData({...formData, [clave]: e.target.value})}
                    />
                  </div>
                );
              })}
            </div>

            {/* Sección de documentos */}
            {documentos && (
              <div className="mb-4 pt-3 border-top">
                <h6 className="fw-bold mb-3">Documentos</h6>
                <div className="row">
                  {Object.entries(documentos).map(([docKey, docData]) => {
                    // Si docData es null, creamos un objeto vacío con la estructura básica
                    const documentData = docData || {
                      id: null,
                      ruta: null,
                      nombre_completo: null,
                      document_key: docKey
                        .replace(/([A-Z])/g, '_$1')
                        .toLowerCase()
                        .replace(/^_/, ''),
                      original_key: docKey
                    };

                    const { id, ruta, nombre_completo } = documentData;
                    const nombreMostrar = docKey
                      .replace(/([A-Z])/g, ' $1')
                      .replace(/_/g, ' ')
                      .trim()
                      .toLowerCase()
                      .replace(/\b\w/g, l => l.toUpperCase());

                    // Verificamos si hay un archivo subido recientemente para este documento
                    const hasUploadedFile = fileUploads[documentData.document_key] ||
                                          fileUploads[documentData.original_key];

                    return (
                      <div className="col-md-6 mb-3" key={`edit-doc-${id || docKey}`}>
                        <div className="d-flex justify-content-between align-items-center">
                          <span className="text-capitalize">{nombreMostrar}</span>
                          <div>
                            <label className="btn btn-sm btn-outline-primary mb-0">
                              <i className="fas fa-upload me-1"></i> Subir
                              <input
                                type="file"
                                style={{display: 'none'}}
                                onChange={(e) => handleFileChange(documentData, e)}
                              />
                            </label>

                            {/* Mostrar nombre del archivo subido recientemente */}
                            {hasUploadedFile && (
                              <span className="ms-2">{hasUploadedFile.name}</span>
                            )}

                            {/* Mostrar botón Ver si hay ruta o archivo subido */}
                            {(ruta || hasUploadedFile) && (
                              <a
                                href={ruta ? `/storage/${ruta}` : URL.createObjectURL(hasUploadedFile)}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="btn btn-sm btn-outline-success ms-2"
                              >
                                <i className="fas fa-eye me-1"></i> Ver
                              </a>
                            )}
                          </div>
                        </div>
                        {nombre_completo && (
                          <small className="text-muted d-block">{nombre_completo}</small>
                        )}
                      </div>
                    );
                  })}
                </div>
              </div>
            )}

            {/* Sección inferior: Observación y campo de documento adicional */}
            <div className="row mt-3">
              <div className="col-md-12 mb-3">
                <label className="form-label text-capitalize">Observación</label>
                <textarea
                  className="form-control"
                  value={formData.observacion || ''}
                  onChange={(e) => setFormData({...formData, observacion: e.target.value})}
                  rows="3"
                />
              </div>

              {/* Campo adicional para subir documento */}
              <div className="col-md-12 mb-3">
                <label className="form-label text-capitalize">Acto administrativo  <span style={{color: 'red'}}>*</span></label>
                <div className="input-group">
                  <input
                    type="file"
                    required={nombre_gestion !== 'RESEÑA HISTORICA'} // No requerido solo para reseña histórica
                    className="form-control"
                    onChange={(e) => handleNewFile('documento_adicional', e)}
                  />
                  {/* {fileUploads['documento_adicional'] && (
                    <span className="input-group-text">
                      {fileUploads['documento_adicional'].name}
                    </span>
                  )} */}
                </div>
              </div>
            </div>

            <div className="modal-footer">
              <button
                type="button"
                className="btn btn-secondary"
                onClick={onClose}
              >
                Cancelar
              </button>
              <button type="submit" className="btn btn-primary">
                Guardar Cambios
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  );
};

// Modal de historial
const ModalHistoricos = ({
  traces,
  nombre_gestion,
  onClose
}) => {
  // Función para formatear la fecha
  const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('es-ES', options);
  };

  // Función para obtener el tipo de cambio
  const getTipoCambio = (tipo) => {
    const tipos = {
      1: 'Inicial',
      2: 'Resignificación',
      3: 'Ajuste',
      4: 'Error'
    };
    return tipos[tipo] || 'Desconocido';
  };

  // Función para parsear y comparar los datos
  const parseChanges = (trace) => {
    try {
      // Normalizamos los datos (convertimos strings JSON a objetos si es necesario)
      const normalizeData = (data) => {
        if (typeof data === 'string') {
          try {
            return JSON.parse(data);
          } catch (e) {
            console.error('Error parsing JSON data:', e);
            return {};
          }
        }
        return data || {};
      };

      const oldData = normalizeData(trace.changes.old_data);
      const newData = normalizeData(trace.changes.new_data);

      // Eliminamos campos técnicos que no son relevantes para la comparación
      const technicalFields = ['updated_at', 'created_at', 'id'];
      technicalFields.forEach(field => {
        delete oldData[field];
        delete newData[field];
      });

      // Objeto para almacenar los cambios detectados
      const detectedChanges = {};

      // 1. Detectamos campos modificados o nuevos
      Object.keys(newData).forEach(key => {
        if (!oldData.hasOwnProperty(key) || JSON.stringify(oldData[key]) !== JSON.stringify(newData[key])) {
          detectedChanges[key] = {
            old_value: oldData[key] !== undefined ? oldData[key] : 'No existía',
            new_value: newData[key] !== undefined ? newData[key] : 'Vacío',
            status: oldData.hasOwnProperty(key) ? 'modified' : 'added'
          };
        }
      });

      // 2. Detectamos campos eliminados (presentes en oldData pero no en newData)
      Object.keys(oldData).forEach(key => {
        if (!newData.hasOwnProperty(key)) {
          detectedChanges[key] = {
            old_value: oldData[key] !== undefined ? oldData[key] : 'Vacío',
            new_value: 'Eliminado',
            status: 'deleted'
          };
        }
      });

      // Devolvemos un objeto con toda la información relevante
      return {
        model_id: trace.model_id,
        model_type: trace.model_type,
        date: trace.date,
        tipo_codificacion: trace.tipo_codificacion,
        observation: trace.observation,
        changes: detectedChanges,
        raw_data: {
          old: oldData,
          new: newData
        }
      };
    } catch (error) {
      console.error('Error processing trace:', error);
      return {
        error: 'Error processing changes',
        trace_id: trace.model_id,
        raw_data: trace
      };
    }
  };

  return (
    <div className="modal fade show d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
      <div className="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">
              <i className="fas fa-history me-2"></i>
              HISTORIAL DE CAMBIOS - {nombre_gestion}
            </h5>
            <button type="button" className="btn-close" onClick={onClose} aria-label="Cerrar"></button>
          </div>

          <div className="modal-body bg-white">
            {traces && traces.length > 0 ? (
              traces.map((trace, index) => {
                const { changes: fieldChanges } = parseChanges(trace);

                return (
                  <div className="card shadow-sm border mb-4" key={`trace-${index}`}>
                    <div className="card-header bg-light d-flex justify-content-between align-items-center">
                      <span className="badge bg-primary text-dark">
                        {getTipoCambio(trace.tipo_codificacion)}
                      </span>
                      <small className="text-muted">
                        <i className="far fa-clock me-1"></i>
                        {formatDate(trace.date || trace.created_at)}
                      </small>
                    </div>

                    <div className="card-body">
                    {trace.observation && (
                      <div className="my-3 border rounded p-2">
                        <i className="fas fa-comment me-2 text-muted"></i>
                        {trace.observation}
                      </div>
                    )}
                    {trace.attachment_url && (
                      <div className="my-3 border rounded p-2">
                        <i className="fas fa-file-signature me-2 text-muted"></i>
                        <a
                          href={`/storage/${trace.attachment_url}`}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="text-decoration-none text-primary"
                        >
                          Ver documento administrativo
                        </a>
                      </div>
                    )}

                      {Object.keys(fieldChanges).length > 0 ? (
                        Object.entries(fieldChanges).map(([field, values]) => (
                          <div className="mb-4" key={field}>
                            <div className="d-flex justify-content-between align-items-center mb-2">
                              <strong className="text-capitalize">{field.replace(/_/g, ' ')}</strong>
                              {values.status !== 'modified' && (
                                <span className={`badge ${
                                  values.status === 'added' ? 'bg-success-subtle text-success' :
                                  'bg-danger-subtle text-danger'
                                } text-capitalize`}>
                                  {values.status}
                                </span>
                              )}
                            </div>

                            <div className="row">
                              <div className="col-md-6 mb-2">
                                <small className="text-muted d-block">Anterior</small>
                                <div className="border rounded p-2 bg-light text-danger">
                                  {values.old_value ?? <span className="fst-italic text-muted">Vacío</span>}
                                </div>
                              </div>
                              <div className="col-md-6 mb-2">
                                <small className="text-muted d-block">Nuevo</small>
                                <div className="border rounded p-2 bg-light text-success">
                                  {values.new_value ?? <span className="fst-italic text-muted">Vacío</span>}
                                </div>
                              </div>
                            </div>
                          </div>
                        ))
                      ) : (
                        <div className="text-muted text-center">
                          <i className="far fa-info-circle me-2"></i>
                          No se detectaron cambios en los datos principales
                        </div>
                      )}
                    </div>
                  </div>
                );
              })
            ) : (
              <div className="text-center py-5">
                <i className="fas fa-history fa-4x text-muted mb-3"></i>
                <h5 className="text-muted">No hay registros históricos</h5>
                <p className="text-muted">No se han realizado cambios en esta gestión</p>
              </div>
            )}
          </div>

          <div className="modal-footer">
            <button type="button" className="btn btn-secondary" onClick={onClose}>
              <i className="fas fa-times me-1"></i> Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>
  );

};

export default function ActualizarPei({
  editarUrl = '#',
  institucionId = [],
  institucionData = {},
  institucionNombre = 'Nombre de la institución',
  csrfToken = '',
}) {
  // Definir el orden deseado de las gestiones
  const ordenGestiones = [
    'resena_historica',
    'gestion_directiva',
    'gestion_academica',
    'gestion_administrativa',
    'gestion_comunidad'
  ];

  // Convertir el objeto a un array de niveles de gestión
  const gestionArray = Object.entries(institucionData).map(([key, value]) => ({
    id: key,
    indice: key,
    nombre: key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
    data: value,
    hijos: Object.values(value).flat().filter(item => typeof item === 'object' && item !== null)
  }));

  // Ordenar el array según el orden definido
  const gestionArrayOrdenado = gestionArray.sort((a, b) => {
    const indexA = ordenGestiones.indexOf(a.id);
    const indexB = ordenGestiones.indexOf(b.id);

    // Si un elemento no está en el array de orden, lo colocamos al final
    if (indexA === -1) return 1;
    if (indexB === -1) return -1;

    return indexA - indexB;
  });

  console.log('gestionArrayOrdenado', gestionArrayOrdenado);


  const [activeTab, setActiveTab] = useState(0);
  const [currentModal, setCurrentModal] = useState(null);
  const [historicosModal, setHistoricosModal] = useState(null);

  const getGestion = (valor) => {
    switch (valor) {
      case 'resena_historica': return 'RESEÑA HISTORICA';
      case 'gestion_academica': return 'GESTIÓN ACADÉMICA';
      case 'gestion_administrativa': return 'GESTIÓN ADMINISTRATIVA Y FINANCIERA';
      case 'gestion_comunidad': return 'GESTIÓN COMUNIDAD';
      case 'gestion_directiva': return 'GESTIÓN DIRECTIVA';
      default: return valor.replace(/_/g, ' ').toUpperCase();
    }
  };


    const handleSave = async (institucionId, hijoIndex, formData, files) => {
    try {
      // Crear FormData para enviar tanto campos como archivos
      const formDataToSend = new FormData();

      // Agregar campos del formulario
      Object.entries(formData).forEach(([key, value]) => {
        formDataToSend.append(key, value);
      });

      // Agregar archivos subidos
      Object.entries(files).forEach(([fieldName, file]) => {
        if (file) {
          formDataToSend.append(fieldName, file);
        }
      });

      formDataToSend.append('institucion_id', institucionId);
      formDataToSend.append('hijo_index', hijoIndex);

      const response = await fetch(`/institutional_profile/institution/${institucionId}/save-new-pei`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
        },
        body: formDataToSend
      });

      if (!response.ok) {
        throw new Error('Error en la respuesta del servidor');
      }

      const data = await response.json();

      location.reload();

      console.log('Datos guardados exitosamente:', data);
      setCurrentModal(null);

      alert('Los cambios se guardaron correctamente');

    } catch (error) {
      console.error('Error al guardar los cambios:', error);

      // Mostrar error al usuario
      alert('Ocurrió un error al guardar los cambios: ' + error.message);
    }
  };

  return (
    <div className="container mt-5 bg-white p-4">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2 className="mb-0">Ajustes al PEI - {institucionNombre}</h2>
      </div>

      <div className="mb-4">
        <ul className="nav nav-tabs border" id="gruposTabs" role="tablist">
          {gestionArray.map((grupo, index) => (
            <li className="nav-item" key={`tab-${grupo.id}`}>
              <button
               style={activeTab === index ? {backgroundColor: '#cfe2ff',color: '#084298'} : {backgroundColor: '#d6d6d6', color: '#000'}}
                className={`nav-link ${activeTab === index ? 'active' : ''}`}
                onClick={() => setActiveTab(index)}
                type="button"
                role="tab"
              >
                <span>{getGestion(grupo.id)}</span>
              </button>
            </li>
          ))}
        </ul>

        <div className="border border-top-0 rounded-bottom p-3">
          {gestionArray.map((grupo, index) => (
            <div key={`content-${grupo.id}`} style={{display: activeTab === index ? 'block' : 'none'}}>
              {grupo.hijos?.length > 0 && (
                <div>
                  {grupo.hijos.map((hijo, hijoIndex) => {
                    const { documentos, nombre_gestion, traces, ...otrosCampos } = hijo;


                    return (
                      <div className="mb-4 p-3 border rounded" key={nombre_gestion}>
                        {/* Encabezado con botones */}
                        <div className="d-flex justify-content-between  mb-3">
                          {nombre_gestion === 'RESEÑA HISTORICA' ? (
                            <h5 className="fw-bold mb-0"></h5>
                          ) : (
                            <h5 className="fw-bold mb-0">{nombre_gestion}</h5>
                          )}
                          <div>
                            <button
                              className="btn btn-sm btn-outline-primary me-2"
                              onClick={() => setCurrentModal({ gestionIndex: index, hijoIndex, formData: {...otrosCampos}, documentos, nombre_gestion })}
                            >
                              <i className="fas fa-edit me-1"></i> Actualizar
                            </button>
                            <button
                              className="btn btn-sm btn-outline-secondary"
                              onClick={() => setHistoricosModal({index, hijoIndex, nombre_gestion, traces})}
                            >
                              <i className="fas fa-history me-1"></i> Históricos
                          </button>
                          </div>
                        </div>

                        {/* Contenido normal (vista) */}
                        <div>
                          {Object.entries(otrosCampos)
                          .filter(([clave]) => clave !== 'relation_name')
                          .map(([clave, valor]) => (
                            <div className="mb-3" key={clave}>
                              <div className="col-md-6 fw-semibold text-capitalize">
                                {clave.replace(/_/g, ' ')}:
                              </div>
                              <div className="text-break">
                                {valor || <span className="text-muted fst-italic">No registrado</span>}
                              </div>
                            </div>
                          ))}
                        </div>

                        {/* Documentos */}
                        {documentos && Object.keys(documentos).length > 0 && (
                          <div className="mt-4">
                            <h6 className="fw-bold mb-3">Documentos</h6>
                            <div>
                              {Object.entries(documentos).map(([docNombre, docValor]) => (
                                (
                                  <div className="d-inline-block mx-3 mb-2" key={docNombre}>
                                    <div className="fw-semibold text-capitalize">
                                      {docNombre
                                        .replace(/([A-Z])/g, ' $1')
                                        .replace(/^./, str => str.toUpperCase())
                                        .replace(/_/g, ' ')
                                        .trim()}
                                    </div>
                                    {docValor?.ruta ? (
                                      <a
                                        href={`/storage/${docValor.ruta}`}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="badge bg-primary rounded-pill text-decoration-none"
                                      >
                                        Ver documento
                                      </a>
                                    ) : (
                                      <span className="text-muted fst-italic">Sin información</span>
                                    )}
                                  </div>
                                )
                              ))}
                            </div>
                          </div>
                        )}
                      </div>
                    );
                  })}
                </div>
              )}
            </div>
          ))}
        </div>

        {/* Boton de volver */}
        {/* <div class="d-flex justify-content-end mt-4">
        <button
          onClick={() => window.history.back()}
          class="btn btn-secondary"
        >
          <i class="fas fa-arrow-left me-2"></i> Volver
        </button>
      </div> */}

      </div>

      {/* Modal de Ajustes */}
      {currentModal && (
        <ModalAjustes
          nombre_gestion={currentModal.nombre_gestion}
          institucionId={institucionId}
          csrfToken={csrfToken}
          formData={currentModal.formData}
          setFormData={(newData) => setCurrentModal({...currentModal, formData: newData})}
          documentos={currentModal.documentos}
          onClose={() => setCurrentModal(null)}
          onSave={(formData, files) => handleSave(institucionId, currentModal.gestionIndex, formData, files)}
        />
      )}
       {/* Nuevo Modal de Históricos */}
       {historicosModal && (
        <ModalHistoricos
          nombre_gestion={historicosModal.nombre_gestion}
          traces={historicosModal.traces}
          onClose={() => setHistoricosModal(null)}
        />
      )}
    </div>
  );
}
