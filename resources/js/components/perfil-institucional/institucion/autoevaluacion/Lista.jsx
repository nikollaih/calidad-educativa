import { h } from 'preact';

export default function Hello() {
    const container = document.getElementById('autoevaluacion');
    const agregarUrl = container?.dataset?.agregarUrl || '#';
    const autoevaluacionesData = container?.dataset?.autoevaluaciones;

    const autoevaluaciones = autoevaluacionesData ? JSON.parse(autoevaluacionesData) : [];

    const handleAgregarClick = () => {
        window.location.href = agregarUrl;
    };

    const formatFecha = (fechaIso) => {
        const fecha = new Date(fechaIso);
        let horas = fecha.getHours();
        const minutos = String(fecha.getMinutes()).padStart(2, '0');
        const ampm = horas >= 12 ? 'PM' : 'AM';

        horas = horas % 12;
        horas = horas ? horas : 12; // 0 => 12

        const horaFormateada = `${String(horas).padStart(2, '0')}:${minutos} ${ampm}`;
        const dia = String(fecha.getDate()).padStart(2, '0');
        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
        const anio = fecha.getFullYear();

        return `${horaFormateada} ${dia}/${mes}/${anio}`;
    };

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Autoevaluación</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar Autoevaluación
            </button>

            <table class="table">
                <thead>
                <tr>
                    <th>Año Vigencia</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                {autoevaluaciones.map((evaluacion) => (
                    <tr key={evaluacion.id}>
                        <td>{evaluacion.anio_vigencia}</td>
                        <td>{evaluacion.alias_estado}</td>
                        <td>{formatFecha(evaluacion.created_at)}</td>
                        <td>
                            <a
                                href={`/institution/${evaluacion.institucion_id}/edit`}
                                class="btn btn-warning btn-sm me-2"
                            >
                                Editar
                            </a>
                            <form
                                action={`/institution/${evaluacion.institucion_id}`}
                                method="POST"
                                style={{ display: 'inline' }}
                                onSubmit={(e) => {
                                    if (!confirm('¿Está seguro de eliminar esta institución?')) {
                                        e.preventDefault();
                                    }
                                }}
                            >
                                <input type="hidden" name="_method" value="DELETE" />
                                <input type="hidden" name="_token" value={container?.dataset?.csrf} />
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
}
