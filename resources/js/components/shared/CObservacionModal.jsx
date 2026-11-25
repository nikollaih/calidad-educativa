// src/ui/CObservacionModal.jsx
import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';
import CTooltip from '@/components/shared/CTooltip.jsx';

const CObservacionModal = ({
    label = 'Modificar observación',
    value = '',
    onSave,
    notaId,
    title = 'Observación / Evidencia',
    help = 'Registra la evidencia u observación que respalda la calificación seleccionada. Este texto se guardará junto con la nota.',
    maxLength = 400,
    buttonClass = 'border bg-blue-500 text-white p-2 rounded-pill w-full',
}) => {
    const [open, setOpen] = useState(false);
    const [draft, setDraft] = useState(value || '');

    const tieneObservacion = Boolean(value && value.trim());
    const buttonLabel = tieneObservacion ? 'Editar observación' : 'Agregar observación';
    const tooltipLabel = tieneObservacion ? value : 'Sin observación registrada';

    useEffect(() => {
        setDraft(value || '');
    }, [notaId]);

    useEffect(() => {
        if (open) {
            setDraft(value || '');
        }
    }, [open, value]);

    const handleSave = () => {
        if (typeof onSave === 'function') {
            onSave(draft);
        }
        setOpen(false);
    };

    const handleClose = () => {
        setOpen(false);
    };

    return (
        <>
            {notaId && (
                <>
                    <input type="hidden" name={`notas[${notaId}][nota_calificacion_id]`} value={notaId} />
                    <input type="hidden" name={`notas[${notaId}][evidencia]`} value={draft} />
                </>
            )}
            <CTooltip label={tooltipLabel}>
                <button
                    type="button"
                    className={buttonClass}
                    onClick={() => {
                        setDraft(value || '');
                        setOpen(true);
                    }}
                    aria-label={buttonLabel}
                >
                    {buttonLabel}
                </button>
            </CTooltip>

            {open && (
                <div
                    onClick={handleClose}
                    style={{
                        position: 'fixed',
                        top: 0,
                        left: 0,
                        width: '100vw',
                        height: '100vh',
                        backgroundColor: 'rgba(0, 0, 0, 0.5)',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        zIndex: 2000,
                        padding: '16px',
                        boxSizing: 'border-box',
                    }}
                >
                    <div
                        onClick={(e) => e.stopPropagation()}
                        style={{
                            backgroundColor: '#fff',
                            borderRadius: '10px',
                            width: 'min(560px, 90vw)',
                            maxHeight: '80vh',
                            overflow: 'auto',
                            boxShadow: '0 10px 30px rgba(0,0,0,0.3)',
                            boxSizing: 'border-box',
                        }}
                    >
                        <div style={{ padding: '16px 20px', borderBottom: '1px solid #e9ecef' }}>
                            <h5 style={{ margin: 0, fontWeight: 'bold' }}>{title}</h5>
                        </div>
                        <div style={{ padding: '20px', textAlign: 'center' }}>
                            <p
                                className="text-muted"
                                style={{ fontSize: '13px', marginBottom: '12px' }}
                            >
                                {help}
                            </p>
                            <textarea
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                rows="4"
                                maxLength={maxLength}
                                style={{ margin: '0 auto' }}
                                value={draft}
                                onInput={(e) => setDraft(e.target.value)}
                            />
                        </div>
                        <div
                            style={{
                                padding: '16px 20px',
                                borderTop: '1px solid #e9ecef',
                                display: 'flex',
                                justifyContent: 'flex-end',
                                gap: '8px',
                            }}
                        >
                            <button
                                type="button"
                                className="border bg-gray-200 text-gray-700 p-2 rounded-pill"
                                onClick={handleClose}
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                className="border bg-blue-500 text-white p-2 rounded-pill"
                                onClick={handleSave}
                            >
                                Guardar observación
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
};

export default CObservacionModal;