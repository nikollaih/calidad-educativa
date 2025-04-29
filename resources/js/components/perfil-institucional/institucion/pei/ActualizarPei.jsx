import { h } from 'preact';
import {useEffect, useState} from 'preact/hooks';

export default function ActualizarPei({ 
    editarUrl = '#',
    institucionId = [],
    institucionData = {},
    csrfToken = '',
}) {
    console.log({
        institucionData: institucionData,
        institucionId: institucionId,
    });
    
    const [activeTab, setActiveTab] = useState(0);
    const [notasSeleccionadas, setNotasSeleccionadas] = useState({});
    const [evidencias, setEvidencias] = useState({});

    const getColorClass = (valor) => {
        switch (valor) {
            case 1: return 'bg-danger';
            case 2: return 'bg-warning';
            case 3: return 'bg-primary';
            case 4: return 'bg-success';
            default: return 'bg-secondary';
        }
    };

    const getCategoria = (valor) => {
        switch (valor) {
            case 1: return 'Existencia';
            case 2: return 'Pertinencia';
            case 3: return 'Apropiación';
            case 4: return 'Mejoramiento';
            default: return 'Null';
        }
    };

    const handleNotaClick = (calId, nota) => {
        setNotasSeleccionadas(prev => {
            const notaActual = prev[calId];
            if (notaActual?.id === nota.id) {
                const newNotas = { ...prev };
                delete newNotas[calId];
                return newNotas;
            }
            return {
                ...prev,
                [calId]: nota
            };
        });
    };

    const handleEvidenciaChange = (calId, e) => {
        setEvidencias(prev => ({
            ...prev,
            [calId]: e
        }));
    };

    return (
      );
}
