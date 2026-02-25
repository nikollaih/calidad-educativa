import { h, render } from 'preact';
import { useEffect, useMemo } from 'preact/hooks';
import CBackButton from '@/components/shared/CBackButton.jsx';
import auth from '@/utilidades/auth';

const CInstitutionNavigations = ({
                                     backUrl = '',
                                     detailUrl = '',
                                     peiUrl = '',
                                     autevaluacionUrl = '',
                                     pmiUrl = '',
                                     proyectosTransversalesUrl = '',
                                     institutionName = '',
                                     mountToNavbar = true,
                                 }) => {
    const getBtnClass = (url, baseClass) => {
        return url === '#'
            ? `bg-white py-1 px-3 font-medium text-custom-blue-light hover:text-custom-blue-light`
            : `bg-custom-gray-light font-normal py-1 px-3  text-gray-500 hover:text-custom-blue-light`;
    };
    const Separator = () => (
        <div className="vr"></div>
    );

    // Verificar permisos y roles
    const permissions = useMemo(() => ({
        canViewProfile: auth.can('s-institucion-ver') ||
            auth.hasRole('rector') ||
            auth.can('s-institucion-pertenecer_una'),
        canViewPei: auth.can('s-institucion-editar') || auth.hasRole('rector'),
        canViewAutoevaluacion: auth.can('s-institucion-editar')
                            || auth.hasRole('rector')
                            || auth.can('s-autoevaluacion-calificar-gestion_directiva')
                            || auth.can('s-autoevaluacion-calificar-gestion_academica')
                            || auth.can('s-autoevaluacion-calificar-gestion_admin_financi')
                            || auth.can('s-autoevaluacion-calificar-gestion_comunidad'),
        canViewPmi: auth.can('s-institucion-editar') ||
            auth.can('s-pmi-gestionar') ||
            auth.hasRole('rector'),
        canViewProyectos: auth.can('s-institucion-editar') || auth.hasRole('rector'),
    }), []);

    // Hook para montar el nombre de la institución en el navbar
    useEffect(() => {
        if (mountToNavbar && institutionName) {
            const targetElement = document.getElementById('navbar-item-1');

            if (targetElement) {
                const navbarContent = (
                    <div className="flex justify-center px-2 w-full">
                        <span
                            className="text-uppercase fw-bold text-white"
                            style={{
                                maxWidth: '40vw',
                                fontSize: '1.5rem',
                                letterSpacing: '2px',
                                fontWeight: '700'
                            }}
                            title={institutionName}
                        >
                           Institución Educativa {institutionName}
                        </span>
                    </div>
                );

                render(navbarContent, targetElement);
            }

            return () => {
                const targetElement = document.getElementById('navbar-item-1');
                if (targetElement) {
                    render(null, targetElement);
                    targetElement.innerHTML = '';
                }
            };
        }
    }, [mountToNavbar, institutionName]);

    return (
        <div className="d-flex align-items-center justify-content-between container">
            <CBackButton
                to={backUrl}
                label="Volver"
                isContainer={false}
            />
            {!mountToNavbar && institutionName && (
                <div className="flex-grow-1 d-flex justify-content-center px-2 ">
                    <span
                        className="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill border shadow-sm"
                        style={{
                            background: 'linear-gradient(90deg, #f8f9fa 0%, #eef5ff 100%)',
                            borderColor: 'rgba(13,110,253,.25)'
                        }}
                    >
                        <span
                            className="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                            style={{width: '28px', height: '28px'}}
                        >
                            <i class="fas fa-school text-white"></i>
                        </span>
                        <span
                            className="fw-semibold text-truncate"
                            style={{maxWidth: '50vw', fontSize: '0.95rem', letterSpacing: '0.2px'}}
                            title={institutionName}
                        >
                            {institutionName}
                        </span>
                    </span>
                </div>
            )}
            <div className="d-flex">
                {/* Mostrar botón Perfil solo si tiene permiso */}
                {permissions.canViewProfile && (
                    <>
                        <a href={detailUrl} class={`${getBtnClass(detailUrl, 'primary')}`}>
                            Perfil
                        </a>
                        <Separator/>
                    </>
                )}
                {/* Mostrar botón PEI solo si tiene permiso */}
                {permissions.canViewPei && (
                    <>
                        <Separator/>
                        <a href={peiUrl} class={getBtnClass(peiUrl, 'success')}>
                            PEI
                        </a>
                        <Separator/>
                    </>
                )}

                {/* Mostrar botón Autoevaluación solo si tiene permiso */}
                {permissions.canViewAutoevaluacion && (
                    <>
                        <Separator/>
                        <a href={autevaluacionUrl} class={getBtnClass(autevaluacionUrl, 'info')}>
                            Autoevaluación
                        </a>
                        <Separator/>
                    </>
                )}

                {/* Mostrar botón PMI solo si tiene permiso */}
                {permissions.canViewPmi && (
                    <>
                        <Separator/>
                        <a href={pmiUrl} class={getBtnClass(pmiUrl, 'secondary')}>
                            PMI
                        </a>
                        <Separator/>
                    </>
                )}

                {/* Mostrar botón PPT solo si tiene permiso */}
                {permissions.canViewProyectos && (
                    <>
                        <Separator/>
                        <a
                            href={proyectosTransversalesUrl}
                            class={getBtnClass(proyectosTransversalesUrl, 'warning')}
                        >
                            PPT
                        </a>
                        <Separator/>
                    </>
                )}
            </div>
        </div>
    );
};

export default CInstitutionNavigations;
