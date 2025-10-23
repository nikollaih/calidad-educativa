import { h } from 'preact';
import { useEffect, useState } from "preact/hooks";
import CPagination from '@/components/shared/CPagination.jsx';

export default function IndexPMI({ agregarUrl, institucionId = undefined, pmisPaginated = {}, csrfToken = '', }) {

    const [pmis, setPmis] = useState([]);
    const [modalComentarios, setModalComentarios] = useState({ open: false, comentarios: [], pmiId: null });

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
        horas = horas ? horas : 12;
        const dia = String(fecha.getDate()).padStart(2, '0');
        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
        const anio = fecha.getFullYear();
        return `${horas}:${minutos} ${ampm} ${dia}/${mes}/${anio}`;
    };

    const abrirModalComentarios = (comentarios, pmiId) => {
        setModalComentarios({ open: true, comentarios, pmiId });
    };

    const cerrarModalComentarios = () => {
        setModalComentarios({ open: false, comentarios: [], pmiId: null });
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
                        <th>FECHA DE CREACIÓN</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ESTADO</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {pmis.map((pmi) => (
                        <tr key={pmi.id}>
                            <td>{pmi.anio_inicio} - {pmi.anio_fin}</td>
                            <td>{formatFecha(pmi.created_at)}</td>
                            <td>{pmi.descripcion}</td>
                            <td>{pmi.estado}</td>
                            <td class="d-flex gap-1">
                                <a href={`/${institucionId}/pmi/${pmi.id}/edit`} className="btn btn-primary btn-sm">
                                    Ver detalles
                                </a>
                                <a href={`/${institucionId}/pmi/${pmi.id}/edit`} className="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                {pmi.estado === "Proceso" && (
                                    <>
                                        <form
                                            action={`/${institucionId}/pmi/${pmi.id}/presentar`}
                                            method="POST"
                                            style={{ display: 'inline' }}
                                        >
                                            <input type="hidden" name="_token" value={csrfToken} />
                                            <button type="submit" className="btn btn-success btn-sm">
                                                Enviar a SED
                                            </button>
                                        </form>

                                        {pmi.comentarios?.filter(c => c.estado === 'activo')?.length > 0 && (
                                            <button
                                                class="btn btn-danger btn-sm"
                                                onClick={() => abrirModalComentarios(pmi.comentarios, pmi.id)}
                                            >
                                                Ver comentarios
                                            </button>
                                        )}
                                    </>
                                )}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>

            <CPagination pagination={pmisPaginated} />

            {/* Modal */}
            {modalComentarios.open && (
                <div class="modal d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Comentarios PMI #{modalComentarios.pmiId}</h5>
                                <button type="button" class="btn-close" onClick={cerrarModalComentarios}></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Factor crítico</th>
                                            <th>Comentario</th>
                                            <th>Autor</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {modalComentarios.comentarios.map(c => (
                                            <tr key={c.id}>
                                                <td>{c.factor.descripcion}</td>
                                                <td>{c.comentario}</td>
                                                <td>{c.autor.email}</td>
                                                <td>{formatFecha(c.created_at)}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" onClick={cerrarModalComentarios}>Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}

