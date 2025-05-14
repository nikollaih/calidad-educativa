import { h } from 'preact';
import { useEffect, useState } from "preact/hooks";

export default function AutoevaluacionResultados({
                                                     fortalezas = {},
                                                     oportunidadesMejora = {},
                                                     gestiones = []
                                                 }) {
    const [gruposPorGestion, setGruposPorGestion] = useState({});

    useEffect(() => {
        console.log("Datos:", { oportunidadesMejora, gestiones, fortalezas });

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

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Fortalezas y debilidades</h2>
            <table class="table table-bordered">
                <thead class="bg-light">
                <tr>
                    <th class="text-center">Gestión</th>
                    <th class="text-center">Fortalezas</th>
                    <th class="text-center">Oportunidades de Mejoramiento</th>
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
                            {Object.keys(getOportunidadesMejora(gestion.nombre)).length > 0 ? (
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

                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
}
