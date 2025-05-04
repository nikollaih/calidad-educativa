import { h } from 'preact';
import { useState } from 'preact/hooks';

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

  const handleFileChange = (fieldName, e) => {
    setFileUploads({
      ...fileUploads,
      [fieldName]: e.target.files[0]
    });
  };

  const tipoCodificacionOptions = [
    { value: 1, label: 'Inicial' },
    { value: 2, label: 'Resignificacion' },
    { value: 3, label: 'Ajuste' },
    { value: 4, label: 'Error' },
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
            
            {/* Sección superior: Tipo de codificación y Fecha */}
            <div className="row mb-4">
              <div className="col-md-6">
                <div className="mb-3">
                  <label className="form-label text-capitalize">Tipo de codificación</label>
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
                  <label className="form-label text-capitalize">Fecha</label>
                  <input
                    type="date"
                    className="form-control"
                    value={formData.fecha || ''}
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
                    <input
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
                  {Object.entries(documentos).map(([docNombre, docValor]) => (
                    <div className="col-md-6 mb-3" key={`edit-doc-${docNombre}`}>
                      <div className="d-flex justify-content-between align-items-center">
                        <span className="text-capitalize">{docNombre.replace(/_/g, ' ')}</span>
                        <div>
                          <span className="badge bg-primary rounded-pill me-2">{docValor}</span>
                          <label className="btn btn-sm btn-outline-primary mb-0">
                            <i className="fas fa-upload me-1"></i> Subir
                            <input 
                              type="file" 
                              style={{display: 'none'}} 
                              onChange={(e) => handleFileChange(docNombre, e)}
                            />
                          </label>
                          {fileUploads[docNombre] && (
                            <span className="ms-2">{fileUploads[docNombre].name}</span>
                          )}
                        </div>
                      </div>
                    </div>
                  ))}
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
                <label className="form-label text-capitalize">Documento anexo</label>
                <div className="input-group">
                  <input 
                    type="file" 
                    className="form-control"
                    onChange={(e) => handleFileChange('documento_adicional', e)}
                  />
                  {fileUploads['documento_adicional'] && (
                    <span className="input-group-text">
                      {fileUploads['documento_adicional'].name}
                    </span>
                  )}
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

export default function ActualizarPei({ 
  editarUrl = '#',
  institucionId = [],
  institucionData = {},
  csrfToken = '',
}) {
  // Convertir el objeto a un array de niveles de gestión
  const gestionArray = Object.entries(institucionData).map(([key, value]) => ({
    id: key,
    indice: key,
    nombre: key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
    data: value,
    hijos: Object.values(value).flat().filter(item => typeof item === 'object' && item !== null)
  }));

  
  const [activeTab, setActiveTab] = useState(0);
  const [currentModal, setCurrentModal] = useState(null);

  const getGestion = (valor) => {
    switch (valor) {
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
      
      // Agregar el índice de gestión e hijo si es necesario
      formDataToSend.append('institucion_id', institucionId);
      // Agregar el índice de gestión e hijo si es necesario
      formDataToSend.append('hijo_index', hijoIndex);
      
      // Enviar datos al backend Laravel
      const response = await fetch(`/institutional_profile/institution/${institucionId}/save-new-pei`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken, // CSRF token para protección
          'Accept': 'application/json', // Indicamos que queremos JSON de vuelta
        },
        body: formDataToSend
      });
      
      if (!response.ok) {
        throw new Error('Error en la respuesta del servidor');
      }
      
      const data = await response.json();
      
      // Manejar la respuesta exitosa
      location.reload();

      console.log('Datos guardados exitosamente:', data);
      setCurrentModal(null);
      
      // Aquí podrías agregar una notificación de éxito o actualizar el estado
      // Ejemplo: mostrar un toast de éxito
      alert('Los cambios se guardaron correctamente');
      
      // Opcional: recargar datos o actualizar el estado
      // loadData(); // Si tienes una función para recargar los datos
      
    } catch (error) {
      console.error('Error al guardar los cambios:', error);
      
      // Mostrar error al usuario
      alert('Ocurrió un error al guardar los cambios: ' + error.message);
    }
  };

  return (
    <div className="container mt-5">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2 className="mb-0">Ajustes al PEI</h2>
      </div>

      <div className="mb-4">
        <ul className="nav nav-tabs border" id="gruposTabs" role="tablist">
          {gestionArray.map((grupo, index) => (
            <li className="nav-item" key={`tab-${grupo.id}`}>
              <button
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
                    const { documentos, nombre_gestion, ...otrosCampos } = hijo;
                    
                    return (
                      <div className="mb-4 p-3 border rounded" key={nombre_gestion}>
                        {/* Encabezado con botones */}
                        <div className="d-flex justify-content-between align-items-center mb-3">
                          <h5 className="fw-bold mb-0">{nombre_gestion}</h5>
                          <div>
                            <button 
                              className="btn btn-sm btn-outline-primary me-2"
                              onClick={() => setCurrentModal({ gestionIndex: index, hijoIndex, formData: {...otrosCampos}, documentos, nombre_gestion })}
                            >
                              <i className="fas fa-edit me-1"></i> Ajustes
                            </button>
                            <button className="btn btn-sm btn-outline-secondary">
                              <i className="fas fa-history me-1"></i> Históricos
                            </button>
                          </div>
                        </div>
                        
                        {/* Contenido normal (vista) */}
                        <div className="mx-auto" style={{maxWidth: '800px'}}>
                          {Object.entries(otrosCampos)
                          .filter(([clave]) => clave !== 'relation_name')
                          .map(([clave, valor]) => (
                            <div className="row mb-3" key={clave}>
                              <div className="col-md-6 fw-semibold text-capitalize text-md-end">
                                {clave.replace(/_/g, ' ')}:
                              </div>
                              <div className="col-md-6">
                                {valor || <span className="text-muted fst-italic">No registrado</span>}
                              </div>
                            </div>
                          ))}
                        </div>
                        
                        {/* Documentos */}
                        {documentos && (
                          <div className="mt-4">
                            <h6 className="fw-bold mb-3 text-center">Documentos</h6>
                            <div className="text-center">
                              {Object.entries(documentos).map(([docNombre, docValor]) => (
                                <div className="d-inline-block mx-3 mb-2" key={docNombre}>
                                  <div className="fw-semibold text-capitalize">
                                    {docNombre.replace(/_/g, ' ')}:
                                  </div>
                                  <span className="badge bg-primary rounded-pill">{docValor}</span>
                                </div>
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
    </div>
  );
}