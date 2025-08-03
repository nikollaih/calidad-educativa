import { h } from 'preact';
import { useEffect, useState } from "preact/hooks";

export default function AutoevaluacionResultados({
                                                     fortalezas = {},
                                                     oportunidadesMejora = {},
                                                     gestiones = [],
                                                     autoevaluacionId = -1,
                                                     csrfToken = '',
                                                     sincronizarUrl = '#',
                                                     factoresCriticosPorDefecto = [],
                                                     puedeEditar = false,
                                                 }) {
    const [gruposPorGestion, setGruposPorGestion] = useState({});
    const [factoresCriticos, setFactoresCriticos] = useState(factoresCriticosPorDefecto);

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

    const actualizarFactor = (index, campo, valor) => {
        setFactoresCriticos(prev => {
            const actualizados = [...prev];

            // Opcional: Validar que el índice esté dentro del rango
            if (index < 0 || index >= actualizados.length) return prev;


            // Clonar y actualizar el objeto
            actualizados[index] = {
                ...actualizados[index],
                [campo]: valor
            };

            return actualizados;
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
    // Función para obtener las fortalezas de una gestión específica
    const getFortalezas = (gestionNombre) => {
        const fortalezasPorGrupo = {};

        // Verificar si hay fortalezas para esta gestión
        if (fortalezas[gestionNombre] && fortalezas[gestionNombre].length > 0) {
            fortalezas[gestionNombre].forEach(grupo => {
                if (!fortalezasPorGrupo[grupo.nombre]) {
                    fortalezasPorGrupo[grupo.nombre] = [];
                }

                // Si el grupo tiene calificaciones específicas, agregarlas
                if (grupo.calificaciones && grupo.calificaciones.length > 0) {
                    grupo.calificaciones.forEach(calificacion => {
                        fortalezasPorGrupo[grupo.nombre].push(calificacion.nombre);
                    });
                } else {
                    // Si no tiene calificaciones específicas, mostrar como grupo general
                    fortalezasPorGrupo[grupo.nombre].push(`Promedio: ${grupo.promedio}`);
                }
            });
        }

        return fortalezasPorGrupo;
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
    // Función para verificar si hay fortalezas
    const tieneFortalezas = (gestionNombre) => {
        const fortalezasData = getFortalezas(gestionNombre);
        return Object.values(fortalezasData).some(
            calificaciones => calificaciones.length > 0
        );
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
                            {tieneFortalezas(gestion.nombre) ? (
                                <div>
                                    {Object.entries(getFortalezas(gestion.nombre)).map(([grupoNombre, calificaciones]) =>
                                            calificaciones.length > 0 && (
                                                <div key={grupoNombre} className="mb-3">
                                                    <strong className="block mb-1">{grupoNombre}:</strong>
                                                    <ul className="pl-6 list-disc">
                                                        {calificaciones.map((calificacion, index) => (
                                                            <li key={index}>{calificacion}</li>
                                                        ))}
                                                    </ul>
                                                </div>
                                            )
                                    )}
                                </div>
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
                                                    <ul className="pl-6 list-disc">
                                                        {calificaciones.map((calificacion, index) => (
                                                            <li key={index}>{calificacion}</li>
                                                        ))}
                                                    </ul>
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

                                    {factoresCriticos.map((factor, index) =>
                                        factor.calificacion_indice.startsWith(gestion.indice) && (
                                                <div key={index} className="mb-3 border p-3 rounded bg-light">
                                                    <div className="fw-bold mb-2 text-primary">
                                                        {factor.calificacion.indice} - {factor.calificacion.nombre}
                                                    </div>

                                                    <textarea
                                                        className="form-control mb-2"
                                                        placeholder="Descripción del factor"
                                                        value={factor.descripcion}
                                                        rows={5}
                                                        disabled={true}
                                                    />

                                                    <select
                                                        className="form-select"
                                                        disabled={!puedeEditar}
                                                        style={{
                                                            backgroundColor:
                                                                factor.valor === 3 ? "#f8d7da" :
                                                                    factor.valor === 4 ? "#dc3545" :
                                                                        factor.valor === 5 ? "#a71d2a" : "#ffffff",
                                                            color: factor.valor >= 4 ? "#ffffff" : "#000000"
                                                        }}
                                                        value={factor.valor}
                                                        onChange={(e) => actualizarFactor(index, 'valor', parseInt(e.target.value))}
                                                    >
                                                        <option value={1}>1 - Poco Urgente</option>
                                                        <option value={2}>2 - Menor Impacto</option>
                                                        <option value={3}>3 - Tendencia a Agravarse</option>
                                                        <option value={4}>4 - Mayor Impacto</option>
                                                        <option value={5}>5 - Muy Urgente</option>
                                                    </select>
                                                </div>

                                            )
                                    )
                                    }
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
                {factoresCriticos.map((factor, factorIndex) => (
                        <div key={`${factorIndex}`}>
                            <input type="hidden" name={`factores[${factorIndex}][descripcion]`} value={factor.descripcion} />
                            <input type="hidden" name={`factores[${factorIndex}][valor]`} value={factor.valor} />
                            <input type="hidden" name={`factores[${factorIndex}][autoevaluacion_id]`} value={autoevaluacionId} />
                            <input type="hidden" name={`factores[${factorIndex}][calificacion_indice]`} value={factor.calificacion_indice} />
                        </div>
                    ))}
                {puedeEditar && (
                    <button type="submit" className="btn btn-success mt-4">
                        Guardar factores críticos
                    </button>
                )}


            </form>
        </div>
    );
}
