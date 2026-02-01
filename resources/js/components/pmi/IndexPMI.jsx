import { h } from 'preact';
import {useEffect, useMemo, useState} from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';
import CAddButton from "@/components/layout/components/buttons/CAddButton.jsx";
import auth from "@utils/auth.js";
import CTableActionButton from "@/components/layout/components/buttons/CTableActionButton.jsx";
import { useRef } from 'preact/hooks';

export default function IndexPMI({
    agregarUrl,
    institucionId = undefined,
    pmisPaginated = {},
    csrfToken = '',
}) {
    const [pmis, setPmis] = useState([]);
    const [modalComentarios, setModalComentarios] = useState({
        open: false,
        comentarios: [],
        pmiId: null,
    });
    const formRef = useRef(null);
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
        horas = horas % 12 || 12;
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
    const marcarComoResuelto = (comentarioId, pmiId) => {
        if (!comentarioId) return;

        const confirmar = window.confirm(
            '¿Estás seguro de que deseas marcar como resuelto este comentario?'
        );
        if (!confirmar) return;

        // Crear formulario dinámico
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pmi/validacion/${pmiId}/marcar-resuelto/${comentarioId}`;
        // Token CSRF
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);

        // Agregar el formulario al DOM temporalmente
        document.body.appendChild(form);

        // Enviar formulario (HTML request)
        form.submit();
    };

    /** Agrupar comentarios por factor_id */
    const agruparPorFactor = (comentarios) => {
        return comentarios.reduce((acc, c) => {
            if (!acc[c.factor_id]) acc[c.factor_id] = [];
            acc[c.factor_id].push(c);
            return acc;
        }, {});
    };
    // Verificar permisos y roles
    const permissions = useMemo(() => ({
        canCreateAutoevaluacion: auth.can('s-institucion-editar') ||
            auth.hasRole('rector'),
        canEdit: auth.can('s-institucion-editar') ||
            auth.hasRole('rector') ||
            auth.can('s-autoevaluacion-calificar-gestion_directiva') ||
            auth.can('s-autoevaluacion-calificar-gestion_academica') ||
            auth.can('s-autoevaluacion-calificar-gestion_admin_financi') ||
            auth.can('s-autoevaluacion-calificar-gestion_comunidad')
        ,
        canValidate: auth.can('s-institucion-editar') ||
            auth.hasRole('rector'),
        canEditResoults: auth.can('s-institucion-editar') ||
            auth.hasRole('rector'),
    }), []);
    return (
        <div className="!border border-custom-blue-light rounded-md mt-3">
            <div className="card">
                <h1 className="p-2 px-3 text-custom-primary">Planes de mejoramiento institucional</h1>
                <div className="card-body">
                    <div className="col-md-12">
                        {permissions.canEdit &&
                            <CAddButton onClick={handleAgregarClick}/>
                        }

                        {/* Tabla principal (puedes mantenerla igual o reemplazarla después) */}
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
                                    <td>
                                        {pmi.anio_inicio} - {pmi.anio_fin}
                                    </td>
                                    <td>{formatFecha(pmi.created_at)}</td>
                                    <td>{pmi.descripcion}</td>
                                    <td>{pmi.estado}</td>
                                    <td class="d-flex gap-1">
                                        {permissions.canEdit &&
                                            <CTableActionButton
                                                title={'Ver detalles'}
                                                route={`/${institucionId}/pmi/${pmi.id}`}
                                                iconClass={'fa-regular fa-eye'}
                                                hoverIconColor={'text-custom-primary'}
                                            />
                                        }
                                        {permissions.canEdit && pmi.estado == 'Aprobado' && (
                                            <CTableActionButton
                                                title={'Gestionar'}
                                                route={`/${institucionId}/pmi/${pmi.id}`}
                                                iconClass={'fa-solid fa-bars-progress'}
                                                hoverIconColor={'text-custom-primary'}
                                            />
                                        )}

                                        {permissions.canEdit && pmi.estado === 'Proceso' && (
                                            <>
                                                <CTableActionButton
                                                    title={'Editar'}
                                                    route={`/${institucionId}/pmi/${pmi.id}/edit`}
                                                    iconClass={'fa fa-pencil'}
                                                    hoverIconColor={'text-custom-primary'}
                                                />
                                                <form
                                                    ref={formRef}
                                                    action={`/${institucionId}/pmi/${pmi.id}/presentar`}
                                                    method="POST"
                                                    style={{display: 'none'}}
                                                >
                                                    <input type="hidden" name="_token" value={csrfToken}/>
                                                </form>
                                                <CTableActionButton
                                                    title={'Enviar a SED'}
                                                    iconClass={'fa fa-paper-plane'}
                                                    hoverIconColor={'text-custom-primary'}
                                                    onClick={() => formRef.current?.submit()}
                                                />
                                                {pmi.comentarios?.filter((c) => c.estado === 'activo')
                                                    ?.length > 0 && (
                                                    <CTableActionButton
                                                        title={'Ver comentarios'}
                                                        onClick={() =>
                                                            abrirModalComentarios(pmi.comentarios, pmi.id)
                                                        }
                                                        iconClass={'fa-regular fa-comment'}
                                                        hoverIconColor={'text-custom-primary'}
                                                    />
                                                )}
                                            </>
                                        )}
                                    </td>
                                </tr>
                            ))}
                            </tbody>
                        </table>

                        <CPagination pagination={pmisPaginated}/>

                        {/* Modal con cards de comentarios */}
                        {modalComentarios.open && (
                            <div class="modal d-block" style={{backgroundColor: 'rgba(0,0,0,0.5)'}}>
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Comentarios del PMI</h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                onClick={cerrarModalComentarios}
                                            ></button>
                                        </div>

                                        <div
                                            class="modal-body"
                                            style={{
                                                maxHeight: '70vh',
                                                overflowY: 'auto',
                                                paddingRight: '0.5rem',
                                            }}
                                        >
                                            {Object.entries(agruparPorFactor(modalComentarios.comentarios)).map(
                                                ([factorId, comentarios]) => {
                                                    const [mostrarTodos, setMostrarTodos] = useState(false);

                                                    // 1️⃣ Ordenar los comentarios por id descendente (más grande primero)
                                                    const comentariosOrdenados = [...comentarios].sort(
                                                        (a, b) => b.id - a.id
                                                    );

                                                    // 2️⃣ Buscar el primer comentario activo (el de id más grande con estado 'activo')
                                                    const primerComentario =
                                                        comentariosOrdenados.find(
                                                            (c) => c.estado === 'activo'
                                                        ) || comentariosOrdenados[0];

                                                    // 3️⃣ Filtrar los restantes (excluyendo el primero mostrado)
                                                    const restantes = comentariosOrdenados.filter(
                                                        (c) => c.id !== primerComentario.id
                                                    );

                                                    return (
                                                        <div class="card mb-3 shadow-sm" key={factorId}>
                                                            <div class="card-body">
                                                                {/* Enlace al detalle del Factor */}
                                                                <h7 class="card-title d-flex justify-content-between align-items-start">
                                                                    <div class="d-flex flex-col align-items-center gap-2">
                                                                        <div class=" gap-2">
                                                                            <strong>Estado: </strong>
                                                                            {primerComentario.estado}
                                                                        </div>
                                                                    </div>

                                                                    <div class="d-flex align-items-center gap-2">
                                                                        {/* Botón para ir al factor crítico */}
                                                                        <a
                                                                            href={`/${institucionId}/pmi/${modalComentarios.pmiId}/edit/factor-critico/${primerComentario.factor.id}`}
                                                                            class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1"
                                                                            title="Ir al factor crítico"
                                                                            target="_blank"
                                                                            style={{
                                                                                transition:
                                                                                    'all 0.2s ease-in-out',
                                                                            }}
                                                                        >
                                                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                                            Ir al factor
                                                                        </a>

                                                                        {/* Botón para marcar como resuelto */}
                                                                        {primerComentario.estado ==
                                                                            'activo' && (
                                                                                <button
                                                                                    class="btn btn-outline-success btn-sm d-flex align-items-center gap-1"
                                                                                    title="Marcar comentario como resuelto"
                                                                                    onClick={() =>
                                                                                        marcarComoResuelto(
                                                                                            primerComentario.id,
                                                                                            primerComentario.pmi_id
                                                                                        )
                                                                                    }
                                                                                >
                                                                                    <i class="fa-solid fa-check"></i>
                                                                                    Marcar como resuelto
                                                                                </button>
                                                                            )}
                                                                    </div>
                                                                </h7>
                                                                <div>
                                                                    <strong>Comentario:</strong>{' '}
                                                                    {primerComentario.comentario}
                                                                </div>
                                                                <div class="card-text">
                                                                    <p class="mb-1">
                                                                        <strong>Factor crítico:</strong>{' '}
                                                                        {primerComentario.factor.descripcion}
                                                                    </p>
                                                                    <small class="text-muted">
                                                                        Por {primerComentario.autor.name} —{' '}
                                                                        {formatFecha(
                                                                            primerComentario.created_at
                                                                        )}
                                                                    </small>
                                                                </div>

                                                                {/* Mostrar más comentarios */}
                                                                {restantes.length > 0 && (
                                                                    <div class="mt-3">
                                                                        <button
                                                                            class="btn btn-outline-secondary btn-sm"
                                                                            type="button"
                                                                            onClick={() =>
                                                                                setMostrarTodos(!mostrarTodos)
                                                                            }
                                                                        >
                                                                            {mostrarTodos
                                                                                ? 'Ocultar otros comentarios'
                                                                                : `Ver ${restantes.length} más`}
                                                                        </button>

                                                                        {mostrarTodos && (
                                                                            <div class="mt-2 ps-3 border-start">
                                                                                {restantes.map((r) => (
                                                                                    <div
                                                                                        key={r.id}
                                                                                        class="mb-2 border-bottom pb-2"
                                                                                    >
                                                                                        <p class="mb-1">
                                                                                            {r.comentario}
                                                                                        </p>
                                                                                        <small class="text-muted">
                                                                                            Por {r.autor.name} —{' '}
                                                                                            {formatFecha(
                                                                                                r.created_at
                                                                                            )}
                                                                                        </small>
                                                                                        {'       '}
                                                                                        <small class="text-muted">
                                                                                            Estado {r.estado}
                                                                                        </small>
                                                                                    </div>
                                                                                ))}
                                                                            </div>
                                                                        )}
                                                                    </div>
                                                                )}
                                                            </div>
                                                        </div>
                                                    );
                                                }
                                            )}
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" onClick={cerrarModalComentarios}>
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
            );
            }
