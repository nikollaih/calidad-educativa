import { h } from 'preact';
import { useRef } from 'preact/hooks';
import CPagination from '@/components/shared/CPagination.jsx';
import auth from '@/utilidades/auth';
import {useMemo} from "preact/hooks";
import CAddButton from "@/components/layout/components/buttons/CAddButton.jsx";
import CTableActionButton from "@/components/layout/components/buttons/CTableActionButton.jsx";

export default function Lista({ agregarUrl, autoevaluaciones, csrfToken = '',}) {
    const formRef = useRef(null);
    const handleAgregarClick = () => {
        window.location.href = agregarUrl;
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
        <div className="!border border-custom-blue-light rounded-md mt-3">
            <div className="card">
                <h1 class="p-2 px-3 text-custom-primary">Auto Evaluación</h1>
                <div className="card-body">
                    <div className="col-md-12">
                        {permissions.canCreateAutoevaluacion &&
                            <CAddButton route={agregarUrl}/>
                        }
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
                            {autoevaluaciones.data.map((evaluacion) => (
                                <tr key={evaluacion.id}>
                                    <td>{evaluacion.anio_vigencia}</td>
                                    <td>{evaluacion.alias_estado}</td>
                                    <td>{formatFecha(evaluacion.created_at)}</td>
                                    <td>
                                        {permissions.canEdit &&
                                            <CTableActionButton
                                                route={`/institutional_profile/institution/${evaluacion.id}/autoevaluaciones-ver`}
                                                iconClass={'fa-regular fa-eye'}
                                                hoverIconColor={'text-custom-primary'}
                                            />
                                        }
                                        {permissions.canEditResoults &&
                                            <CTableActionButton
                                                route={`/institutional_profile/institution/${evaluacion.id}/fort_deb`}
                                                iconClass={'fa-solid fa-square-poll-horizontal'}
                                                hoverIconColor={'text-custom-primary'}
                                            />
                                        }
                                        {/* Mostrar Editar solo si no está en VALIDACION */}
                                        {permissions.canEdit && evaluacion.alias_estado !== "VALIDACION" && (
                                            <CTableActionButton
                                                route={`/institutional_profile/institution/${evaluacion.id}/autoevaluaciones-editar`}
                                                iconClass={'fa fa-pencil'}
                                                hoverIconColor={'text-custom-primary'}
                                            />
                                        )}
                                        {permissions.canValidate && evaluacion.alias_estado === "PROCESO" && (
                                            <>
                                                <form
                                                    ref={formRef}
                                                    action={`/institutional_profile/institution/${evaluacion.id}/autoevaluaciones-validar`}
                                                    method="POST"
                                                    style={{display: 'none'}}
                                                >
                                                    <input type="hidden" name="_token" value={csrfToken}/>
                                                </form>
                                                <CTableActionButton
                                                    iconClass={'fa fa-paper-plane'}
                                                    hoverIconColor={'text-custom-primary'}
                                                    onClick={() => formRef.current?.submit()}
                                                />
                                            </>
                                        )}
                                    </td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                        <CPagination pagination={autoevaluaciones}/>
                    </div>
                </div>
            </div>
                </div>
                );
                }
