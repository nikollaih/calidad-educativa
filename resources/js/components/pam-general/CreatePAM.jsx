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
        <div className="col-md-12 bg-white rounded-xl !border border-custom-blue-light py-3 mt-4">
            <div className={'p-3'}>
                <form method="POST" action={createUrl}>
                    <input type="hidden" name="_token" value={csrfToken}/>
                    <h5 className="mb-2">Ingresa una descripción del PAM</h5>
                    <textarea
                        className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl mb-2"
                        type="text"
                        name="pam[descripcion]"
                    ></textarea>
                    <h5 className="mb-2">Seleccionar años de ejecución del PAM <span className="text-danger">*</span>
                    </h5>
                    <div className="row mb-4">
                        <div className="col">
                            <label htmlFor="anioInicio" className="block text-sm mb-2 ml-4">Año de inicio</label>
                            <select
                                id="anioInicio"
                                className="w-full !border border-custom-blue-dark rounded-xl"
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
                            <label htmlFor="anioFin" className="block text-sm mb-2 ml-4">Año de fin</label>
                            <select
                                id="anioFin"
                                className="w-full !border border-custom-blue-dark rounded-xl"
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
                    <button className="border bg-blue-500  text-white p-2 rounded-pill">
                        Crear PAM
                    </button>
                </form>
            </div>
        </div>
    );
};

export default CreatePAM;

