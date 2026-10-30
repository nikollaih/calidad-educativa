import { h } from 'preact';

export default function SedeStateHistory({ events = [] }) {
    if (!events.length) {
        return <div className="alert alert-info mb-0">Esta sede aún no tiene cierres ni aperturas registrados.</div>;
    }

    return (
        <div className="table-responsive">
            <table className="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Movimiento</th>
                        <th>Fecha</th>
                        <th>Acto administrativo</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>
                    {events.map((event, index) => (
                        <tr key={`${event.date}-${index}`}>
                            <td>{event.event}</td>
                            <td>{event.date}</td>
                            <td>
                                {event.documentUrl ? (
                                    <a href={event.documentUrl} target="_blank" rel="noopener noreferrer" className="btn btn-outline-info btn-sm">
                                        <i className="fas fa-file-pdf me-1" />
                                        {event.documentName || 'Ver documento'}
                                    </a>
                                ) : 'Sin documento'}
                            </td>
                            <td className="text-break">{event.observation}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
