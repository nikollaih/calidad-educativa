
import { h } from 'preact';
import CBackButton from '@/components/shared/CBackButton.jsx';

const CInstitutionNavigations = ({
    backUrl = '',
    detailUrl = '',
    peiUrl = '',
    autevaluacionUrl = '',
    pmiUrl = '',
    proyectosTransversalesUrl = '',
    institutionName = '',
}) => {
    const getBtnClass = (url, baseClass) => {
        // Si la url es "#", usamos btn-baseClass (sólido)
        // Si no, usamos btn-outline-baseClass
        return url === '#'
            ? `btn btn-${baseClass} btn-sm`
            : `btn btn-outline-${baseClass} btn-sm`;
    };

    return (
        <div class="d-flex align-items-center justify-content-between container">
            <CBackButton
                to={backUrl}
                label="Volver"
                isContainer={false}
            />
            {institutionName && (
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


