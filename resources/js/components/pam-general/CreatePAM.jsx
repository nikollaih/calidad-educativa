import React, { useState } from 'react';
import {useEffect} from "preact/hooks";
import {h} from "preact";

const CreatePAM = ({createUrl='', csrfToken='' }) => {
    const [selectedId, setSelectedId] = useState('');
    const [anioInicio, setAnioInicio] = useState('');
    const [anioFin, setAnioFin] = useState('');

    const currentYear = new Date().getFullYear();

    const aniosRango = Array.from({ length: 11 }, (_, i) => currentYear - 5 + i);

    return (
        <div className="container py-4">
            <form method="POST" action={createUrl}>
                <input type="hidden" name="_token" value={csrfToken} />
                <h5 className="mb-2">Ingresa una descripción del PAM</h5>
                <textarea
                    class="form-control mb-2"
                    type="text"
                    name="pam[descripcion]"
                ></textarea>
                <h5 className="mb-2">Seleccionar años de ejecución del PAM <span className="text-danger">*</span></h5>
                <div className="row mb-4">
                    <div className="col">
                        <label htmlFor="anioInicio" className="form-label">Año de inicio</label>
                        <select
                            id="anioInicio"
                            className="form-select"
                            name="pam[anio_inicio]"
                            value={anioInicio}
                            onChange={(e) => setAnioInicio(e.target.value)}
                            required
                        >
                            <option value="">-- Selecciona año inicio --</option>
                            {aniosRango.map((y) => (
                                <option key={y} value={y}>{y}</option>
                            ))}
                        </select>
                    </div>
                    <div className="col">
                        <label htmlFor="anioFin" className="form-label">Año de fin</label>
                        <select
                            id="anioFin"
                            className="form-select"
                            name="pam[anio_fin]"
                            value={anioFin}
                            onChange={(e) => setAnioFin(e.target.value)}
                            required
                        >
                            <option value="">-- Selecciona año fin --</option>
                            {aniosRango.map((y) => (
                                <option key={y} value={y}>{y}</option>
                            ))}
                        </select>
                    </div>
                </div>
                <button className="btn btn-success">
                    Crear PAM
                </button>
            </form>
        </div>
    );
};

export default CreatePAM;

