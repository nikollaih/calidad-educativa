import { h } from 'preact';

export default function AutoevaluacionCrear() {
    // Asegura que el id coincida con el del contenedor en el Blade
    const container = document.getElementById('autoevaluacion-crear');
    const agregarUrl = container?.dataset?.agregarUrl || '#';
    const gruposData = container?.dataset?.gruposCalificaciones;
    const gruposCalificaciones = gruposData ? JSON.parse(gruposData) : [];

    const handleAgregarClick = () => {
        window.location.href = agregarUrl;
    };

    return (
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Agregar Autoevaluación</h2>
            </div>

            <div class="row">
                {gruposCalificaciones.map((grupo) => (
                    <div class="col-md-12 mb-4" key={grupo.id}>
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <strong>{grupo.nombre}</strong>
                            </div>
                            <div class="card-body">
                                {grupo.calificaciones?.length > 0 && (
                                    <>
                                        <h6 class="text-muted">Calificaciones</h6>
                                        <ul class="list-group mb-3">
                                            {grupo.calificaciones.map((calificacion) => (
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center"
                                                    key={calificacion.id}
                                                >
                                                    {calificacion.nombre}
                                                    <span class="badge bg-secondary">
                                                        {calificacion.valor ?? 'N/A'}
                                                    </span>
                                                </li>
                                            ))}
                                        </ul>
                                    </>
                                )}

                                {grupo.hijos?.length > 0 && (
                                    <div>
                                        {grupo.hijos.map((hijo) => (
                                            <div class="mb-3" key={hijo.id}>
                                                <div class="fw-bold">{hijo.nombre}</div>
                                                {hijo.calificaciones?.length > 0 ? (
                                                    <ul class="list-group">
                                                        {hijo.calificaciones.map((cal) => (
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center"
                                                                key={cal.id}
                                                            >
                                                                {cal.nombre}
                                                                <span class="badge bg-info text-dark">
                                                                    {cal.notas_calificacion?.length}
                                                                </span>
                                                            </li>
                                                        ))}
                                                    </ul>
                                                ) : (
                                                    <small class="text-muted">Sin calificaciones</small>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
