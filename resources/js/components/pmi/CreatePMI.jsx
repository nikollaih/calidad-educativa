import React, { useState } from 'react';
import {useEffect} from "preact/hooks";
import {h} from "preact";

const CreatePMI = ({createUrl='', csrfToken='', autoevaluacionesDisponibles = [] }) => {
    const [selectedId, setSelectedId] = useState('');
    const [anioInicio, setAnioInicio] = useState('');
    const [anioFin, setAnioFin] = useState('');

    const selected = autoevaluacionesDisponibles.find((a) => a.id === parseInt(selectedId));
    const currentYear = new Date().getFullYear();

    const aniosInicio = Array.from({ length: 11 }, (_, i) => currentYear - i); // actual hasta 10 atrás
    const aniosFin = Array.from({ length: 11 }, (_, i) => currentYear + i); // actual hasta 10 adelante

    return (
        <div className="container py-4">
            <form method="POST" action={createUrl}>
                <input type="hidden" name="_token" value={csrfToken} />
                <h5 className="mb-2">Seleccione una autoevaluación para realizar el PMI<span
                    className="text-danger">*</span></h5>
                <select
                    className="form-select mb-4"
                name="pmi[autoevaluacion_id]"
                value={selectedId}
                onChange={(e) => setSelectedId(e.target.value)}
                required
                >
                    <option value="">-- Selecciona una autoevaluación --</option>
                    {autoevaluacionesDisponibles.map((a) => (
                        <option key={a.id} value={a.id}>
                            {a.anio_vigencia} - {a.alias_estado}
                        </option>
                    ))}
                </select>
                <h5 className="mb-2">Ingresa una descripción del PMI</h5>
                <textarea
                    class="form-control mb-2"
                    type="text"
                    name="pmi[descripcion]"
                ></textarea>
                <h5 className="mb-2">Seleccionar años de ejecución del PMI<span className="text-danger">*</span></h5>
                <div className="row mb-4">
                    <div className="col">
                        <label htmlFor="anioInicio" className="form-label">Año de inicio</label>
                        <select
                            id="anioInicio"
                            className="form-select"
                            name="pmi[anio_inicio]"
                            value={anioInicio}
                            onChange={(e) => setAnioInicio(e.target.value)}
                            required
                        >
                            <option value="">-- Selecciona año inicio --</option>
                            {aniosInicio.map((y) => (
                                <option key={y} value={y}>{y}</option>
                            ))}
                        </select>
                    </div>
                    <div className="col">
                        <label htmlFor="anioFin" className="form-label">Año de fin</label>
                        <select
                            id="anioFin"
                            className="form-select"
                            name="pmi[anio_fin]"
                            value={anioFin}
                            onChange={(e) => setAnioFin(e.target.value)}
                            required
                        >
                            <option value="">-- Selecciona año fin --</option>
                            {aniosFin.map((y) => (
                                <option key={y} value={y}>{y}</option>
                            ))}
                        </select>
                    </div>
                </div>
                <button className="btn btn-success">
                    Crear PMI
                </button>
            </form>
        </div>
    );
};

export default CreatePMI;

