import React, { useState, useEffect } from 'react';
import { h } from 'preact';

const CreatePMI = ({ createUrl = '', csrfToken = '', autoevaluacionesDisponibles = [] }) => {
    const [selectedId, setSelectedId] = useState('');
    const [anioInicio, setAnioInicio] = useState('');
    const [anioFin, setAnioFin] = useState('');
    const [aniosFinDisponibles, setAniosFinDisponibles] = useState([]);

    const aniosDisponibles = [...new Set(autoevaluacionesDisponibles.map((a) => a.anio_vigencia))].sort((a, b) => b - a);

    // Al cambiar el año de inicio, actualizar autoevaluación seleccionada y los años de fin disponibles
    useEffect(() => {
        const autoeval = autoevaluacionesDisponibles.find((a) => parseInt(a.anio_vigencia) === parseInt(anioInicio));
        if (autoeval) {
            setSelectedId(autoeval.id.toString());
            // Generar lista de años fin válidos (de anioInicio hasta anioInicio + 3)
            const inicio = parseInt(anioInicio);
            const opcionesFin = Array.from({ length: 4 }, (_, i) => inicio + i);
            setAniosFinDisponibles(opcionesFin);
            if (!opcionesFin.includes(parseInt(anioFin))) {
                setAnioFin(''); // reset si el año fin no es válido
            }
        }
    }, [anioInicio]);

    return (
        <div className="container py-4">
            <form method="POST" action={createUrl}>
                <input type="hidden" name="_token" value={csrfToken} />
                <input type="hidden" name="pmi[autoevaluacion_id]" value={selectedId} />

                <h5 className="mb-2">Seleccionar años de ejecución del PMI <span className="text-danger">*</span></h5>
                <div className="row mb-3">
                    <div className="col">
                        <label htmlFor="anioInicio" className="block text-sm mb-2 ml-4">Año de inicio</label>
                        <select
                            id="anioInicio"
                            className="form-select"
                            name="pmi[anio_inicio]"
                            value={anioInicio}
                            onChange={(e) => setAnioInicio(e.target.value)}
                            required
                        >
                            <option value="">-- Selecciona año inicio --</option>
                            {aniosDisponibles.map((y) => (
                                <option key={y} value={y}>{y}</option>
                            ))}
                        </select>
                    </div>
                    <div className="col">
                        <label htmlFor="anioFin" className="block text-sm mb-2 ml-4">Año de fin</label>
                        <select
                            id="anioFin"
                            className="form-select"
                            name="pmi[anio_fin]"
                            value={anioFin}
                            onChange={(e) => setAnioFin(e.target.value)}
                            required
                        >
                            <option value="">-- Selecciona año fin --</option>
                            {aniosFinDisponibles.map((y) => (
                                <option key={y} value={y}>{y}</option>
                            ))}
                        </select>
                    </div>
                </div>

                <h5 className="mb-2">Ingresa una descripción del PMI</h5>
                <textarea
                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl mb-3"
                    type="text"
                    name="pmi[descripcion]"
                ></textarea>

                <button className="btn btn-success">
                    Crear PMI
                </button>
            </form>
        </div>
    );
};

export default CreatePMI;
