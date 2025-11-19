
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
                <div class="flex-grow-1 text-center mx-2">
                    <span class="fw-semibold text-truncate d-inline-block" style={{ maxWidth: '60vw' }} title={institutionName}>
                        {institutionName}
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


