import { h, render } from 'preact';
import { useEffect } from 'preact/hooks';
import CBackButton from '@/components/shared/CBackButton.jsx';

const CInstitutionNavigations = ({
                                     backUrl = '',
                                     detailUrl = '',
                                     peiUrl = '',
                                     autevaluacionUrl = '',
                                     pmiUrl = '',
                                     proyectosTransversalesUrl = '',
                                     institutionName = '',
                                     mountToNavbar = true, // Nueva prop para controlar si se monta en el navbar
                                 }) => {
    const getBtnClass = (url, baseClass) => {
        // Si la url es "#", usamos btn-baseClass (sólido)
        // Si no, usamos btn-outline-baseClass
        return url === '#'
            ? `btn btn-${baseClass} btn-sm`
            : `btn btn-outline-${baseClass} btn-sm`;
    };

    // Hook para montar el nombre de la institución en el navbar
    useEffect(() => {
        if (mountToNavbar && institutionName) {
            const targetElement = document.getElementById('navbar-item-1');

            if (targetElement) {
                // Crear el contenido para el navbar
                const navbarContent = (
                    <div className="d-flex justify-content-center px-2">
                        <span
                            className="text-uppercase fw-bold text-primary"
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

                // Renderizar en el navbar
                render(navbarContent, targetElement);
            }

            // Cleanup: limpiar el navbar cuando el componente se desmonte
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
        <div class="d-flex align-items-center justify-content-between container">
        <CBackButton
                to={backUrl}
                label="Volver"
                isContainer={false}
            />
            {!mountToNavbar && institutionName && (
                <div class="flex-grow-1 d-flex justify-content-center px-2">
                    <span
                        class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill border shadow-sm"
                        style={{ background: 'linear-gradient(90deg, #f8f9fa 0%, #eef5ff 100%)', borderColor: 'rgba(13,110,253,.25)' }}
                    >
                        <span
                            class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                            style={{ width: '28px', height: '28px' }}
                        >
                            <i class="fas fa-school text-white"></i>
                        </span>
                        <span
                            class="fw-semibold text-truncate"
                            style={{ maxWidth: '50vw', fontSize: '0.95rem', letterSpacing: '0.2px' }}
                            title={institutionName}
                        >
                            {institutionName}
                        </span>
                    </span>
                </div>
            )}
            <div class="d-flex gap-2">
                <a href={detailUrl} class={getBtnClass(detailUrl, 'primary')}>
                    Perfil
                </a>
                <a href={peiUrl} class={getBtnClass(peiUrl, 'success')}>
                    PEI
                </a>
                <a href={autevaluacionUrl} class={getBtnClass(autevaluacionUrl, 'info')}>
                    Autoevaluación
                </a>
                <a href={pmiUrl} class={getBtnClass(pmiUrl, 'secondary')}>
                    PMI
                </a>
                <a
                    href={proyectosTransversalesUrl}
                    class={getBtnClass(proyectosTransversalesUrl, 'warning')}
                >
                    PPT
                </a>
            </div>
        </div>
    );
};

export default CInstitutionNavigations;
