// src/ui/CTooltip.jsx
import { h } from 'preact';
import { useState } from 'preact/hooks';

const CTooltip = ({ children, label = 'Tooltip', position = 'top' }) => {
    const [visible, setVisible] = useState(false);

    const positionStyles = {
        top: {
            bottom: '100%',
            left: '50%',
            transform: 'translateX(-50%) translateY(-8px)',
            marginBottom: '4px'
        },
        bottom: {
            top: '100%',
            left: '50%',
            transform: 'translateX(-50%) translateY(8px)',
            marginTop: '4px'
        },
        left: {
            right: '100%',
            top: '50%',
            transform: 'translateY(-50%) translateX(-8px)',
            marginRight: '4px'
        },
        right: {
            left: '100%',
            top: '50%',
            transform: 'translateY(-50%) translateX(8px)',
            marginLeft: '4px'
        }
    };

    return (
        <div
            style={{
                position: 'relative',
                display: 'inline-block',
                width: 'fit-content'
            }}
            onMouseEnter={() => setVisible(true)}
            onMouseLeave={() => setVisible(false)}
        >
            {children}

            {visible && (
                <div
                    style={{
                        position: 'absolute',
                        backgroundColor: '#333',
                        color: '#fff',
                        padding: '6px 12px',
                        borderRadius: '4px',
                        fontSize: '14px',
                        whiteSpace: 'nowrap',
                        pointerEvents: 'none',
                        zIndex: 1000,
                        ...positionStyles[position]
                    }}
                >
                    {label}
                    <div
                        style={{
                            position: 'absolute',
                            width: 0,
                            height: 0,
                            borderStyle: 'solid',
                            ...(position === 'top' && {
                                bottom: '-4px',
                                left: '50%',
                                transform: 'translateX(-50%)',
                                borderWidth: '4px 4px 0 4px',
                                borderColor: '#333 transparent transparent transparent'
                            }),
                            ...(position === 'bottom' && {
                                top: '-4px',
                                left: '50%',
                                transform: 'translateX(-50%)',
                                borderWidth: '0 4px 4px 4px',
                                borderColor: 'transparent transparent #333 transparent'
                            }),
                            ...(position === 'left' && {
                                right: '-4px',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                borderWidth: '4px 0 4px 4px',
                                borderColor: 'transparent transparent transparent #333'
                            }),
                            ...(position === 'right' && {
                                left: '-4px',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                borderWidth: '4px 4px 4px 0',
                                borderColor: 'transparent #333 transparent transparent'
                            })
                        }}
                    />
                </div>
            )}
        </div>
    );
};
export default CTooltip;
