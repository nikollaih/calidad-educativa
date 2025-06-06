import { h } from 'preact';
import { useEffect, useState } from "preact/hooks";

export default function AutoevaluacionResultados({
                                                     fortalezas = {},
                                                     oportunidadesMejora = {},
                                                     gestiones = [],
                                                     autoevaluacionId = -1,
                                                     csrfToken = '',
                                                     sincronizarUrl = '#',
                                                     factoresCriticosExistentes = {},
                                                     puedeEditar = false,
                                                 }) {
    const [gruposPorGestion, setGruposPorGestion] = useState({});
    const [factoresCriticos, setFactoresCriticos] = useState(factoresCriticosExistentes);

    useEffect(() => {

        // Organizar grupos por gestión basado en el índice
        const gruposOrganizados = {};

        Object.keys(oportunidadesMejora).forEach(key => {
            // Si es una gestión principal con grupos
            if (["GESTIÓN DIRECTIVA", "GESTIÓN ACADÉMICA", "GESTIÓN ADMINISTRATIVA Y FINANCIERA", "GESTIÓN DE LA COMUNIDAD"].includes(key)) {
                if (!gruposOrganizados[key]) {
                    gruposOrganizados[key] = [];
                }

                oportunidadesMejora[key].forEach(grupo => {
                    gruposOrganizados[key].push(grupo.nombre);
                });
            }
        });

        setGruposPorGestion(gruposOrganizados);
    }, [oportunidadesMejora]);
    const agregarFactorCritico = (grupoNombre) => {
        setFactoresCriticos(prev => {
            const actuales = prev[grupoNombre] || [];
            return {
                ...prev,
                [grupoNombre]: [...actuales, { texto: '', valor: 1 }]
            };
        });
    };
    const eliminarFactorCritico = (grupoNombre, index) => {
        setFactoresCriticos(prev => {
            const nuevosFactores = [...(prev[grupoNombre] || [])];
            nuevosFactores.splice(index, 1); // Elimina el factor en la posición indicada
            return {
                ...prev,
                [grupoNombre]: nuevosFactores
            };
        });
    };

    const actualizarFactor = (grupoNombre, index, campo, valor) => {
        setFactoresCriticos(prev => {
            const actualizados = [...(prev[grupoNombre] || [])];
            actualizados[index][campo] = valor;
            return {
                ...prev,
                [grupoNombre]: actualizados
            };
        });
    };

    const obtenerDescripcionValor = (valor) => {
        const descripciones = {
            1: "Poco urgente",
            2: "Menor impacto",
            3: "Tendencia agravarse",
            4: "Mayor impacto",
            5: "Muy urgente"
        };
        return descripciones[valor] || "Null";
    };

    // Función para encontrar las oportunidades de mejora para una gestión específica
    const getOportunidadesMejora = (gestionNombre) => {
        const oportunidadesPorGrupo = {};

        // Añadir grupos principales con promedio bajo
        if (oportunidadesMejora[gestionNombre]) {
            oportunidadesMejora[gestionNombre].forEach(grupo => {
                // Identificar el grupo como un grupo principal con promedio bajo
                if (!oportunidadesPorGrupo[grupo.nombre]) {
                    oportunidadesPorGrupo[grupo.nombre] = [];
                }
            });
        }

        // Buscar calificaciones específicas que pertenecen a esta gestión
        Object.keys(oportunidadesMejora).forEach(key => {
            if (key.startsWith("Calificaciones específicas")) {
                const grupoNombre = key.replace("Calificaciones específicas - ", "");

                // Verifica si este grupo pertenece a la gestión actual según nuestro mapeo
                if (
                    gruposPorGestion[gestionNombre] &&
                    gruposPorGestion[gestionNombre].includes(grupoNombre)
                ) {
                    if (!oportunidadesPorGrupo[grupoNombre]) {
                        oportunidadesPorGrupo[grupoNombre] = [];
                    }

                    oportunidadesMejora[key].forEach(calificacion => {
                        oportunidadesPorGrupo[grupoNombre].push(calificacion.nombre);
                    });
                }
            }
        });

        return oportunidadesPorGrupo;
    };

    // Función para verificar si hay oportunidades de mejoramiento
    const tieneOportunidadesMejoramiento = (gestionNombre) => {
        const oportunidades = getOportunidadesMejora(gestionNombre);
        // Verificar si hay al menos un grupo con calificaciones
        return Object.values(oportunidades).some(
            calificaciones => calificaciones.length > 0
        );
    };

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Fortalezas y debilidades</h2>
            <table class="table table-bordered">
                <thead class="bg-light">
                <tr>
                    <th className="text-center" style={{width: "10%"}}  >Gestión</th>
                    <th className="text-center" style={{width: "25%"}}>Fortalezas</th>
                    <th className="text-center" style={{width: "25%"}}>Oportunidades de Mejoramiento</th>
                    <th className="text-center" style={{width: "40%"}}>Factores críticos</th>
                </tr>
                </thead>
                <tbody>
                {gestiones.map(gestion => (
                    <tr key={gestion.id}>
                        <td class="align-middle font-medium">{gestion.nombre}</td>
                        <td>
                            {fortalezas[gestion.nombre] && fortalezas[gestion.nombre].length > 0 ? (
                                <ul class="list-disc pl-5 mb-0">
                                    {fortalezas[gestion.nombre].map((fortaleza, index) => (
                                        <li key={index} class="mb-1">{fortaleza}</li>
                                    ))}
                                </ul>
                            ) : (
                                <span class="text-gray-500">No se encontraron fortalezas</span>
                            )}
                        </td>
                        <td>
                            {tieneOportunidadesMejoramiento(gestion.nombre)  ? (
                                <div>
                                    {Object.entries(getOportunidadesMejora(gestion.nombre)).map(([grupoNombre, calificaciones]) =>
                                            calificaciones.length > 0 && (
                                                <div key={grupoNombre} className="mb-3">
                                                    <strong className="block mb-1">{grupoNombre}:</strong>
                                                    <p className="pl-4 mb-0">{calificaciones.join(' - ')}</p>
                                                </div>
                                            )
                                    )}
                                </div>
                            ) : (
                                <span className="text-gray-500">No se encontraron oportunidades de mejora</span>
                            )}
                        </td>
                        <td>
                            {tieneOportunidadesMejoramiento(gestion.nombre)  ? (
                                <div>
                                    {Object.entries(getOportunidadesMejora(gestion.nombre)).map(([grupoNombre, calificaciones]) =>
                                            calificaciones.length > 0 && (
                                                <div key={grupoNombre} className="mb-4 border p-2 rounded">
                                                    <strong className="d-block mb-1">{grupoNombre}</strong>
                                                    {puedeEditar && (
                                                        <button
                                                            className="btn btn-sm btn-primary mt-2 my-2"
                                                            onClick={() => agregarFactorCritico(grupoNombre)}
                                                        >
                                                            Agregar Factor Crítico
                                                        </button>
                                                    )}

                                                    {/* Mostrar factores críticos existentes */}
                                                    {(factoresCriticos[grupoNombre] || []).map((factor, index) => (
                                                        <div key={index} className="mb-2 border p-2 rounded bg-light">
                                                            <textarea
                                                                className="form-control mb-1"
                                                                placeholder="Descripción del factor"
                                                                value={factor.texto}
                                                                onInput={(e) => actualizarFactor(grupoNombre, index, 'texto', e.target.value)}
                                                                rows={3}
                                                                disabled={!puedeEditar}
                                                            />

                                                            <select
                                                                className="form-select mb-1"
                                                                disabled={!puedeEditar}
                                                                style={{
                                                                    backgroundColor:
                                                                        factor.valor === 3 ? "#f8d7da" :
                                                                            factor.valor === 4 ? "#dc3545" :
                                                                                factor.valor === 5 ? "#a71d2a" : "#ffffff",
                                                                    color: factor.valor >= 4 ? "#ffffff" : "#000000"
                                                                }}
                                                                value={factor.valor}
                                                                onChange={(e) => actualizarFactor(grupoNombre, index, 'valor', parseInt(e.target.value))}
                                                            >
                                                                <option value={1}>1 - Poco Urgente</option>
                                                                <option value={2}>2 - Menor Impacto</option>
                                                                <option value={3}>3 - Tendencia a Agravarse</option>
                                                                <option value={4}>4 - Mayor Impacto</option>
                                                                <option value={5}>5 - Muy Urgente</option>
                                                            </select>


                                                            <div className="d-flex flex-column justify-content-center">
                                                                {puedeEditar && (
                                                                    <button
                                                                        className="btn btn-sm btn-danger"
                                                                        onClick={() => eliminarFactorCritico(grupoNombre, index)}
                                                                    >
                                                                        Eliminar
                                                                    </button>
                                                                )}
                                                            </div>
                                                        </div>
                                                    ))}
                                                </div>
                                            )
                                    )}
                                </div>
                            ) : (
                                <span className="text-gray-500">No se encontraron oportunidades de mejora</span>
                            )}
                        </td>


                    </tr>
                ))}
                </tbody>
            </table>
            <form method="POST" action={sincronizarUrl}>
                <input type="hidden" name="_token" value={csrfToken} />
                {Object.entries(factoresCriticos).map(([grupoNombre, factores], grupoIndex) =>
                    factores.map((factor, factorIndex) => (
                        <div key={`${grupoNombre}-${factorIndex}`}>
                            <input type="hidden" name={`factores[${grupoNombre}][${factorIndex}][descripcion]`} value={factor.texto} />
                            <input type="hidden" name={`factores[${grupoNombre}][${factorIndex}][valor]`} value={factor.valor} />
                            <input type="hidden" name={`factores[${grupoNombre}][${factorIndex}][autoevaluacion_id]`} value={autoevaluacionId} />
                        </div>
                    ))
                )}
                {puedeEditar && (
                    <button type="submit" className="btn btn-success mt-4">
                        Guardar factores críticos
                    </button>
                )}


            </form>
        </div>
    );
}
