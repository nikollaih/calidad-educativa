import React, { useEffect } from 'react';
import {useState} from "preact/hooks";

const FactoresCriticosTable = (pmi2 = {}) => {
    const [pmi, setPmi] = useState(pmi2.pmi);
    /* Datos de ejemplo basados en el JSON proporcionado
    const pmi = {
        "id": 6,
        "descripcion": "test",
        "anio_inicio": "2022",
        "anio_fin": "2027",
        "factores_criticos": [
            {
                "id": 7,
                "descripcion": "Es neceario abordar el gobierno escolar",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 7,
                    "nombre": "Gobierno escolar",
                    "indice": "1.3",
                    "padre": {
                        "id": 1,
                        "nombre": "GESTIÓN DIRECTIVA",
                        "indice": "1"
                    }
                }
            },
            {
                "id": 8,
                "descripcion": "Falta una clara guia para la contingencia del consejo academico",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 7,
                    "nombre": "Gobierno escolar",
                    "indice": "1.3",
                    "padre": {
                        "id": 1,
                        "nombre": "GESTIÓN DIRECTIVA",
                        "indice": "1"
                    }
                }
            },
            {
                "id": 10,
                "descripcion": "Es necesario revisar el factor de indice comercial",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 5,
                    "nombre": "Direccionamiento estratégico",
                    "indice": "1.1",
                    "padre": {
                        "id": 1,
                        "nombre": "GESTIÓN DIRECTIVA",
                        "indice": "1"
                    }
                }
            },
            {
                "id": 11,
                "descripcion": "Las alianzas deben ser mas productivas, actualmente se tienen porcentajes de %15",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 10,
                    "nombre": "Relaciones con el entorno",
                    "indice": "1.6",
                    "padre": {
                        "id": 1,
                        "nombre": "GESTIÓN DIRECTIVA",
                        "indice": "1"
                    }
                }
            },
            {
                "id": 12,
                "descripcion": "Hay muy poca cultura institucional, falta politica de mision vision y diversidad cultural",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 8,
                    "nombre": "Cultura institucional",
                    "indice": "1.4",
                    "padre": {
                        "id": 1,
                        "nombre": "GESTIÓN DIRECTIVA",
                        "indice": "1"
                    }
                }
            },
            {
                "id": 9,
                "descripcion": "tercero,",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 11,
                    "nombre": "Diseño pedagógico",
                    "indice": "2.1",
                    "padre": {
                        "id": 2,
                        "nombre": "GESTIÓN ACADÉMICA",
                        "indice": "2"
                    }
                }
            },
            {
                "id": 13,
                "descripcion": "Las capacitaciones no están supliendo las necesidades de conocimiento",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 18,
                    "nombre": "Talento humano",
                    "indice": "3.4",
                    "padre": {
                        "id": 3,
                        "nombre": "GESTIÓN ADMINISTRATIVA Y FINANCIERA",
                        "indice": "3"
                    }
                }
            },
            {
                "id": 14,
                "descripcion": "Hay fondos sin declarar y poco proceso de documentación",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 16,
                    "nombre": "Administración de la planta física y de los recursos",
                    "indice": "3.2",
                    "padre": {
                        "id": 3,
                        "nombre": "GESTIÓN ADMINISTRATIVA Y FINANCIERA",
                        "indice": "3"
                    }
                }
            },
            {
                "id": 15,
                "descripcion": "No se están tomando las debidas prevenciones en instalaciones fisicas que pueden ocasionar lesiones",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 23,
                    "nombre": "Prevención de riesgos",
                    "indice": "4.4",
                    "padre": {
                        "id": 4,
                        "nombre": "GESTIÓN DE LA COMUNIDAD",
                        "indice": "4"
                    }
                }
            },
            {
                "id": 16,
                "descripcion": "No hay rampas ni sistemas de acceso",
                "valor": 5,
                "grupo_calificacion": {
                    "id": 20,
                    "nombre": "Accesibilidad",
                    "indice": "4.1",
                    "padre": {
                        "id": 4,
                        "nombre": "GESTIÓN DE LA COMUNIDAD",
                        "indice": "4"
                    }
                }
            }
        ]
    };
*/
    useEffect(() => {
        console.log(pmi);
    }, []);

    // Agrupar los datos correctamente
    const groupedData = {};

    pmi.factores_criticos?.forEach((fc) => {
        const gestion = fc.grupo_calificacion?.padre?.nombre || 'Sin gestión';
        const componente = fc.grupo_calificacion?.nombre || 'Sin componente';

        if (!groupedData[gestion]) groupedData[gestion] = {};
        if (!groupedData[gestion][componente]) groupedData[gestion][componente] = [];

        groupedData[gestion][componente].push(fc);
    });

    // Crear las filas de la tabla con la lógica de fusión correcta
    const renderTableRows = () => {
        const rows = [];

        Object.entries(groupedData).forEach(([gestion, componentes]) => {
            const gestionRowSpan = Object.values(componentes).reduce(
                (sum, factores) => sum + factores.length,
                0
            );

            let isFirstRowOfGestion = true;

            Object.entries(componentes).forEach(([componente, factores]) => {
                const componenteRowSpan = factores.length;

                factores.forEach((fc, factorIndex) => {
                    rows.push(
                        <tr key={fc.id}>
                            {isFirstRowOfGestion && (
                                <td
                                    rowSpan={gestionRowSpan}
                                    className="align-middle bg-light fw-bold border-end"
                                    style={{ verticalAlign: 'middle' }}
                                >
                                    {gestion}
                                </td>
                            )}
                            {factorIndex === 0 && (
                                <td
                                    rowSpan={componenteRowSpan}
                                    className="align-middle border-end"
                                    style={{ verticalAlign: 'middle' }}
                                >
                                    <div class="d-flex">
                                        <small className="text-muted px-1">
                                            {fc.grupo_calificacion?.indice}
                                        </small>
                                        <div className="fw-semibold text-primary">
                                            {componente} aegis
                                        </div>
                                    </div>
                                </td>
                            )}
                            <td className="p-3">
                                {fc.descripcion || (
                                    <span className="text-muted fst-italic">
                                        Sin descripción
                                    </span>
                                )}
                            </td>
                        </tr>
                    );

                    // Solo marcar como false después de la primera fila
                    if (isFirstRowOfGestion) {
                        isFirstRowOfGestion = false;
                    }
                });
            });
        });

        return rows;
    };

    return (
        <div className="container-fluid mt-4">
            <div className="card shadow-sm">
                <div className="card-header  text-black">
                    <h5 className="mb-0">Plan de mejoramiento institucional
                    </h5>
                    <small>Período: {pmi.anio_inicio} - {pmi.anio_fin}</small>
                </div>
                <div className="card-body p-0">
                    <div className="table-responsive">
                        <table className="table table-bordered table-hover mb-0">
                            <thead className="table-dark">
                            <tr>
                                <th style={{ width: '25%' }} className="text-center">
                                    Gestión
                                </th>
                                <th style={{ width: '30%' }} className="text-center">
                                    Componente
                                </th>
                                <th style={{ width: '45%' }} className="text-center">
                                    Factor Crítico
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {renderTableRows()}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div className="card-footer text-muted small">
                    Total de factores críticos: {pmi.factores_criticos?.length || 0}
                </div>
            </div>
        </div>
    );
};

export default FactoresCriticosTable;
