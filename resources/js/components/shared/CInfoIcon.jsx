// src/ui/CInfoIcon.jsx
import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';

const CInfoIcon = ({
    title = '',
    content = '',
    iconClass = 'fas fa-info-circle',
    className = '',
    iconColor = 'text-primary',
    modalWidth = 'min(640px, 90vw)',
}) => {
    const [open, setOpen] = useState(false);

    useEffect(() => {
        if (!open) return;
        const handleKeyDown = (event) => {
            if (event.key === 'Escape') setOpen(false);
        };
        document.addEventListener('keydown', handleKeyDown);
        // Bloquear scroll del body mientras el modal está abierto
        const previousOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        return () => {
            document.removeEventListener('keydown', handleKeyDown);
            document.body.style.overflow = previousOverflow;
        };
    }, [open]);

    const body = content && content.trim() !== '' ? content : 'Sin información adicional.';

    return (
        <button
            type="button"
            className={`c-info-icon ${className}`}
            style={{ display: 'inline-block', marginRight: '6px', verticalAlign: 'middle', cursor: 'pointer', border: 'none', background: 'transparent', padding: 0 }}
            onClick={(e) => {
                e.preventDefault();
                e.stopPropagation();
                setOpen(true);
            }}
            aria-label={title || 'Información'}
        >
            <i className={`${iconClass} ${iconColor}`} style={{ fontSize: '0.9rem' }} aria-hidden="true" />

            {open && (
                <div
                    onClick={() => setOpen(false)}
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
                            color: '#212529',
                            borderRadius: '10px',
                            width: modalWidth,
                            maxWidth: '90vw',
                            maxHeight: '80vh',
                            overflow: 'auto',
                            boxShadow: '0 10px 30px rgba(0,0,0,0.3)',
                            boxSizing: 'border-box',
                        }}
                    >
                        <div
                            style={{
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'space-between',
                                padding: '16px 20px',
                                borderBottom: '1px solid #e9ecef',
                            }}
                        >
                            <h5 style={{ margin: 0, fontSize: '1.1rem', fontWeight: 'bold' }}>
                                {title && title.trim() !== '' ? title : 'Información'}
                            </h5>
                            <button
                                type="button"
                                onClick={() => setOpen(false)}
                                aria-label="Cerrar"
                                style={{
                                    border: 'none',
                                    background: 'transparent',
                                    fontSize: '1.4rem',
                                    lineHeight: 1,
                                    cursor: 'pointer',
                                    color: '#6c757d',
                                }}
                            >
                                ×
                            </button>
                        </div>
                        <div style={{ padding: '20px', fontSize: '14px', lineHeight: 1.6, whiteSpace: 'pre-wrap' }}>
                            {body}
                        </div>
                    </div>
                </div>
            )}
        </button>
    );
};

export default CInfoIcon;