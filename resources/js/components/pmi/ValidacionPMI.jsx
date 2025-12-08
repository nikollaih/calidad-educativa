import { useEffect, useState } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';

export default function IndexPMI({
    agregarUrl,
    institucionId = undefined,
    canManage = false,
    pmisPaginated = {},
    csrfToken = '',
}) {
    const [pmis, setPmis] = useState([]);

    useEffect(() => {
        setPmis(pmisPaginated.data);
    }, []);
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
            <h2 class="mb-4">Planes de mejoramiento institucional pendientes de validar</h2>

            {pmis.length === 0 ? (
                <div className="alert alert-info text-center" role="alert">
                    No hay PMIs para validar.
                </div>
            ) : (
                <>
                    <table className="table">
                        <thead>
                            <tr>
                                <th>Institución</th>
                                <th>Años Vigencia</th>
                                <th>FECHA DE CREACIÓN</th>
                                <th>DESCRIPCIÓN</th>
                                <th>ESTADO</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {pmis.map((pmi) => (
                                <tr key={pmi.id}>
                                    <td>{pmi?.institucion?.nombre}</td>
                                    <td>
                                        {pmi.anio_inicio} - {pmi.anio_fin}
                                    </td>
                                    <td>{formatFecha(pmi.created_at)}</td>
                                    <td>{pmi.descripcion}</td>
                                    <td>{pmi.estado}</td>
                                    <td>
                                        {pmi.estado === 'Presentado' && canManage && (
                                            <a
                                                href={`/pmi/validacion/${pmi.id}`}
                                                className="btn btn-warning btn-sm me-2"
                                            >
                                                Revisar
                                            </a>
                                        )}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <CPagination pagination={pmisPaginated} />
                </>
            )}
        </div>
    );
}
