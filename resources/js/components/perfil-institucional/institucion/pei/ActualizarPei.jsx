import { h } from 'preact';
import {useEffect, useState} from 'preact/hooks';

export default function ActualizarPei({ 
    editarUrl = '#',
    institucionId = [],
    institucionData = {},
    csrfToken = '',
}) {

    // Convertir el objeto a un array de niveles de gestión
    const gestionArray = Object.entries(institucionData).map(([key, value], index) => ({
        id: key, // Usamos la clave como ID
        indice: key, // Usamos la clave como índice para getGestion
        nombre: key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()), // Formatear el nombre
        data: value, // Los datos completos de este nivel de gestión
        hijos: Object.values(value).flat().filter(item => typeof item === 'object' && item !== null) // Ejemplo de 'hijos' (necesitarás adaptarlo)
    }));

    console.log(
        gestionArray
    );
    
    const [activeTab, setActiveTab] = useState(0);

    const getColorClass = (valor) => {
        switch (valor) {
            case 1: return 'bg-danger';
            case 2: return 'bg-warning';
            case 3: return 'bg-primary';
            case 4: return 'bg-success';
            default: return 'bg-secondary';
        }
    };

    const getGestion = (valor) => {
        switch (valor) {
            case 'gestion_academica': return 'GESTION ACADEMICA';
            case 'gestion_administrativa': return 'GESTION ADMINISTRATIVA Y FINANCIERA';
            case 'gestion_comunidad': return 'GESTION COMUNIDAD';
            case 'gestion_directiva': return 'GESTION DIRECTIVA';
            default: return null;
        }
    };


    return (
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Ajustes al PEI</h2>
            </div>

                <div class="mb-4">
                    <ul class="nav nav-tabs border" id="gruposTabs" role="tablist">
                        {gestionArray.map((grupo, index) => (
                            <li class="nav-item" key={`tab-${grupo.id}`}>
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

                    <div class="border border-top-0 rounded-bottom p-3">
                        {gestionArray.map((grupo, index) => (
                            <div key={`content-${grupo.id}`} style={{display: activeTab === index ? 'block' : 'none'}}>
                            {grupo.hijos?.length > 0 && (
                                <div>
                                {grupo.hijos.map((hijo) => {
                                    const { documentos, nombre_gestion, ...otrosCampos } = hijo;
                                    const [showModal, setShowModal] = useState(false);
                                    const [formData, setFormData] = useState({...otrosCampos});
                                    
                                    return (
                                    <div class="mb-4 p-3 border rounded" key={nombre_gestion}>
                                        {/* Encabezado con botones */}
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0">{nombre_gestion}</h5>
                                        <div>
                                            <button 
                                            class="btn btn-sm btn-outline-primary me-2"
                                            onClick={() => setShowModal(true)}
                                            >
                                            <i class="fas fa-edit me-1"></i> Ajustes
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-history me-1"></i> Históricos
                                            </button>
                                        </div>
                                        </div>
                                        
                                        {/* Contenido normal (vista) */}
                                        <div class="mx-auto" style={{maxWidth: '800px'}}>
                                        {Object.entries(otrosCampos).map(([clave, valor]) => (
                                            <div class="row mb-3" key={clave}>
                                            <div class="col-md-6 fw-semibold text-capitalize text-md-end">
                                                {clave.replace(/_/g, ' ')}:
                                            </div>
                                            <div class="col-md-6">
                                                {valor || <span class="text-muted fst-italic">No registrado</span>}
                                            </div>
                                            </div>
                                        ))}
                                        </div>
                                        
                                        {/* Documentos (se mantiene igual) */}
                                        {documentos && (
                                        <div class="mt-4">
                                            <h6 class="fw-bold mb-3 text-center">Documentos</h6>
                                            <div class="text-center">
                                            {Object.entries(documentos).map(([docNombre, docValor]) => (
                                                <div class="d-inline-block mx-3 mb-2" key={docNombre}>
                                                <div class="fw-semibold text-capitalize">
                                                    {docNombre.replace(/_/g, ' ')}:
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{docValor}</span>
                                                </div>
                                            ))}
                                            </div>
                                        </div>
                                        )}
                                        
                                        {/* Modal de Ajustes */}
                                        <div class={`modal fade ${showModal ? 'show d-block' : ''}`} tabindex="-1" style={{backgroundColor: 'rgba(0,0,0,0.5)'}}>
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar {nombre_gestion}</h5>
                                                <button type="button" class="btn-close" onClick={() => setShowModal(false)}></button>
                                            </div>
                                            <div class="modal-body">
                                                
                                                <form method="POST" action={`institution/${institucionId}/save-new-pei`}>
                                                    <input type="hidden" name="_token" value={csrfToken} />
                                                {Object.entries(otrosCampos).map(([clave, valor]) => (
                                                    <div class="mb-3" key={`edit-${clave}`}>
                                                    <label class="form-label text-capitalize">{clave.replace(/_/g, ' ')}</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        value={formData[clave] || ''}
                                                        onChange={(e) => setFormData({...formData, [clave]: e.target.value})}
                                                    />
                                                    </div>
                                                ))}
                                                
                                                {/* Sección de documentos en el modal */}
                                                {documentos && (
                                                    <div class="mt-4 pt-3 border-top">
                                                    <h6 class="fw-bold mb-3">Documentos</h6>
                                                    {Object.entries(documentos).map(([docNombre, docValor]) => (
                                                        <div class="mb-3" key={`edit-doc-${docNombre}`}>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-capitalize">{docNombre.replace(/_/g, ' ')}</span>
                                                            <div>
                                                            <span class="badge bg-primary rounded-pill me-2">{docValor}</span>
                                                            <button class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-upload me-1"></i> Subir
                                                            </button>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    ))}
                                                    </div>
                                                )}
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" onClick={() => setShowModal(false)}>
                                                Cancelar
                                                </button>
                                                <button type="button" class="btn btn-primary">
                                                Guardar Cambios
                                                </button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    );
                                })}
                                </div>
                            )}
                            </div>
                        ))}
                    </div>
                </div>

        </div>
    );
}
