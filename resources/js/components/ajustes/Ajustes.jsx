import { h } from 'preact';
import { useState } from 'preact/hooks';

export default function Ajustes({ faviconUrl, logoUrl, csrfToken = '' }) {
    const [faviconFile, setFaviconFile] = useState(null);
    const [logoFile, setLogoFile] = useState(null);

    const [faviconPrevieUrl, setFaviconPreviewUrl] = useState(faviconUrl);
    const [logoPrevieUrl, setLogoPreviewUrl] = useState(logoUrl);


    const handleFaviconUpload = (event) => {
        const file = event.target.files[0];
        if (file) {
            setFaviconFile(file);
            const previewUrl = URL.createObjectURL(file);
            setFaviconPreviewUrl(previewUrl);
        }
    };

    const handleLogoUpload = (event) => {
        const file = event.target.files[0];
        if (file) {
            setLogoFile(file);
            const previewUrl = URL.createObjectURL(file);
            setLogoPreviewUrl(previewUrl);
        }
    };

    const handleSaveChanges = () => {
        console.log('Guardando cambios...', { faviconFile, logoFile });
    };

    return (
        <div>
            <div className="container-fluid px-4 py-4">
                <div className="row justify-content-center">
                    <div className="col-12 col-lg-10 col-xl-8">
                        {/* Header */}
                        <div className="mb-4">
                            <h2 className="fw-bold text-dark mb-1">Configuración del Sistema</h2>
                        </div>

                        {/* Card Principal */}
                        <div className="card shadow-sm border-0">
                            <div
                                className="card-header bg-gradient text-black"
                            >
                                <h4 className="card-title mb-0 d-flex align-items-center ">
                                    <i className="fas fa-palette me-2"></i>
                                    Aspecto del Sistema
                                </h4>
                            </div>

                            <div className="card-body p-4">
                                <div className="row g-4">
                                    {/* Sección Favicon */}
                                    <div className="col-md-6">
                                        <div
                                            className="border rounded-3 p-4 h-100"
                                            style={{ background: 'linear-gradient(145deg, #f8f9ff 0%, #e6e9f4 100%)' }}
                                        >
                                            <div className="text-center mb-3">
                                                <div
                                                    className="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-3"
                                                    style={{ width: '80px', height: '80px' }}
                                                >
                                                    <img
                                                        src={faviconPrevieUrl}
                                                        alt="Favicon actual"
                                                        style={{ width: '38px', height: '38px' }}
                                                        onError={(e) => {
                                                            e.target.style.display = 'none';
                                                            e.target.nextSibling.style.display = 'inline';
                                                        }}
                                                    />

                                                </div>
                                                <h5 className="fw-bold text-dark mb-1">Favicon</h5>
                                                <p className="text-muted small mb-3">
                                                    Icono que aparece en la pestaña del navegador
                                                </p>
                                            </div>

                                            {/* Input de archivo oculto */}
                                            <input
                                                type="file"
                                                id="faviconUpload"
                                                accept=".ico,.png"
                                                onChange={handleFaviconUpload}
                                                style={{ display: 'none' }}
                                            />

                                            {/* Botón de subida */}
                                            <div className="d-grid">
                                                <button
                                                    className="btn btn-outline-primary btn-lg rounded-pill"
                                                    type="button"
                                                    onClick={() => document.getElementById('faviconUpload').click()}
                                                >
                                                    <i className="fas fa-cloud-upload-alt me-2"></i>
                                                    Subir Favicon
                                                </button>
                                            </div>

                                            {faviconFile && (
                                                <div className="mt-2 text-center">
                                                    <small className="text-success">
                                                        <i className="fas fa-check me-1"></i>
                                                        {faviconFile.name}
                                                    </small>
                                                </div>
                                            )}

                                            <div className="mt-3">
                                                <small className="text-muted">
                                                    <i className="fas fa-info-circle me-1"></i>
                                                    Recomendado: 32x32px, formato .ico o .png
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Sección Logo */}
                                    <div className="col-md-6">
                                        <div
                                            className="border rounded-3 p-4 h-100"
                                            style={{ background: 'linear-gradient(145deg, #fff8f0 0%, #f4e6d9 100%)' }}
                                        >
                                            <div className="text-center mb-3">
                                                <div
                                                    className="bg-white rounded-3 d-inline-flex align-items-center justify-content-center shadow-sm mb-3"
                                                    style={{ width: '120px', height: '80px' }}
                                                >
                                                    <div className="text-center">
                                                        <img
                                                            src={logoPrevieUrl}
                                                            alt="Favicon actual"
                                                            style={{ width: '64px', height: '32px' }}
                                                            onError={(e) => {
                                                                e.target.style.display = 'none';
                                                                e.target.nextSibling.style.display = 'inline';
                                                            }}
                                                        />
                                                    </div>
                                                </div>
                                                <h5 className="fw-bold text-dark mb-1">Logo Principal</h5>
                                                <p className="text-muted small mb-3">
                                                    Logo que aparece en la aplicación
                                                </p>
                                            </div>

                                            {/* Input de archivo oculto */}
                                            <input
                                                type="file"
                                                id="logoUpload"
                                                accept=".png,.svg,.jpg,.jpeg"
                                                onChange={handleLogoUpload}
                                                style={{ display: 'none' }}
                                            />

                                            {/* Botón de subida */}
                                            <div className="d-grid">
                                                <button
                                                    className="btn btn-outline-warning btn-lg rounded-pill"
                                                    type="button"
                                                    onClick={() => document.getElementById('logoUpload').click()}
                                                >
                                                    <i className="fas fa-cloud-upload-alt me-2"></i>
                                                    Subir Logo
                                                </button>
                                            </div>

                                            {logoFile && (
                                                <div className="mt-2 text-center">
                                                    <small className="text-success">
                                                        <i className="fas fa-check me-1"></i>
                                                        {logoFile.name}
                                                    </small>
                                                </div>
                                            )}

                                            <div className="mt-3">
                                                <small className="text-muted">
                                                    <i className="fas fa-info-circle me-1"></i>
                                                    Recomendado: 300x100px, formato .png o .svg
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {/* Botones de Acción */}
                                <div className="mt-4 pt-3 border-top">
                                    <div className="d-flex justify-content-end gap-2">
                                        <button
                                            className="btn btn-success rounded-pill px-4"
                                            onClick={handleSaveChanges}
                                        >
                                            <i className="fas fa-save me-2"></i>
                                            Guardar Cambios
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
