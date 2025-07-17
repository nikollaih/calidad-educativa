import { h } from 'preact';


export default function IndexPMI({ agregarUrl, pmis = [], csrfToken = '',}) {
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
            <h2 class="mb-4">Planes de mejoramiento institucional</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar plan de mejoramiento institucional
            </button>

            <table class="table">
                <thead>
                <tr>
                    <th>Años Vigencia</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                {pmis.map((pmi) => (
                    <tr key={pmi.id}>
                        <td>{pmi.rango_vigencia}</td>
                        <td>{pmi.alias_estado}</td>
                        <td>{formatFecha(pmi.created_at)}</td>
                        <td>
                            <a
                                href={`/institutional_profile/institution/${pmi.id}/autoevaluaciones-ver`}
                                className="btn btn-primary btn-sm me-2"
                            >
                                Ver detalles
                            </a>

                            {/* Mostrar Editar solo si no está en VALIDACION */}
                            {pmi.alias_estado !== "VALIDACION" && (
                                <a
                                    href={`/institutional_profile/institution/${pmi.id}/autoevaluaciones-editar`}
                                    className="btn btn-warning btn-sm me-2"
                                >
                                    Editar
                                </a>
                            )}
                        </td>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
}
