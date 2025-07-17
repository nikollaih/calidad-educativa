import React, { useState } from 'react';

const CreatePMI = ({ autoevaluacionesDisponibles = [] }) => {
    const [selectedId, setSelectedId] = useState('');
    const [anioInicio, setAnioInicio] = useState('');
    const [anioFin, setAnioFin] = useState('');

    const selected = autoevaluacionesDisponibles.find((a) => a.id === parseInt(selectedId));
    const currentYear = new Date().getFullYear();

    const aniosInicio = Array.from({ length: 11 }, (_, i) => currentYear - i); // actual hasta 10 atrás
    const aniosFin = Array.from({ length: 11 }, (_, i) => currentYear + i); // actual hasta 10 adelante

    return (
        <div className="container py-4">
            <h2 className="mb-4">Seleccione una autoevaluación para realizar el PMI</h2>

            <select
                className="form-select mb-4"
                value={selectedId}
                onChange={(e) => setSelectedId(e.target.value)}
            >
                <option value="">-- Selecciona una autoevaluación --</option>
                {autoevaluacionesDisponibles.map((a) => (
                    <option key={a.id} value={a.id}>
                        {a.anio_vigencia} - {a.alias_estado}
                    </option>
                ))}
            </select>

            {selected && (
                <div className="card mb-4">
                    <div className="card-body">
                        <h5 className="card-title">Detalles de la autoevaluación #{selected.id}</h5>
                        <p className="card-text">
                            <strong>Año de Vigencia:</strong> {selected.anio_vigencia} <br />
                            <strong>Estado:</strong> {selected.alias_estado} <br />
                            <strong>Factores criticos</strong>
                            <ul>
                                <li>
                                    Gestión Directiva - Direccionamiento estratégico - Es necesario revisar el factor de indice comercial
                                </li>
                                <li>
                                    Gestión Académica - Diseño pedagógico - tercero
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
            )}

            <h4 className="mb-2">Seleccionar años de ejecución del PMI</h4>
            <div className="row mb-4">
                <div className="col">
                    <label htmlFor="anioInicio" className="form-label">Año de inicio</label>
                    <select
                        id="anioInicio"
                        className="form-select"
                        value={anioInicio}
                        onChange={(e) => setAnioInicio(e.target.value)}
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
                        value={anioFin}
                        onChange={(e) => setAnioFin(e.target.value)}
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
        </div>
    );
};

export default CreatePMI;

