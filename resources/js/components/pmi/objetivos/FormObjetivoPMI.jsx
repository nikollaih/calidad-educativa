import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';
import CAutocompleteFromArray from "@/components/shared/CAutocompleteFromArray.jsx";

const CreateObjetivoPMI = ({ agregarUrl = '', csrfToken = '', objetivoExistente = {}, editable = true, factoresCriticos=[], unidadesMedida=[]}) => {
    // Estado para el objetivo
    const [objetivo, setObjetivo] = useState({
        descripcion: '',
        factor_id: "",
        id:undefined
    });

    // Estado para los metaes
    const [metas, setMetas] = useState([
        {
            descripcion: '',
            indicador_id: "",
            actividades: [{
                descripcion: '',
            }]
        }
    ]);


    // Nuevo estado: gestión seleccionada
    const [gestionSeleccionada, setGestionSeleccionada] = useState(null);

    // Sacamos las gestiones únicas desde los factores
    const gestiones = Array.from(
        new Map(
            factoresCriticos.map(f => [f.calificacion.grupo.padre.id, f.calificacion.grupo.padre])
        ).values()
    );

    // Filtrar factores por gestión seleccionada
    const factoresFiltrados = gestionSeleccionada
        ? factoresCriticos.filter(f => f.calificacion.grupo.padre.id === gestionSeleccionada.id)
        : [];

    useEffect(() => {
        if (objetivoExistente){
            setObjetivo({
                id: objetivoExistente.id,
                descripcion: objetivoExistente.descripcion,
                factor_id:  objetivoExistente.factor_id,
            });

            // Si ya hay factor, asignar gestión automáticamente
            const factorExistente = factoresCriticos.find(f => f.id === objetivoExistente.factor_id);
            if (factorExistente) {
                setGestionSeleccionada(factorExistente.calificacion.grupo.padre);
            }

            setMetas(objetivoExistente.metas);
        }
    },[]);
    // Manejar cambios en los campos de la objetivo
    const handleObjetivoChange = (e) => {
        const { name, value } = e.target;
        setObjetivo(prev => ({
            ...prev,
            [name]: value
        }));
    };

    // Manejar cambios en los metas
    const handleMetaChange = (index, e) => {
        const { name, value } = e.target;
        const newMeta = [...metas];
        newMeta[index] = {
            ...newMeta[index],
            [name]: value
        };
        setMetas(newMeta);
    };

    // Manejar cambios en las actividades
    const handleActividadChange = (metaIndex, actividadIndex, e) => {
        const { name, value } = e.target;
        const newMeta = [...metas];

        if (name === 'peso') {
            // Validar que el peso sea un número entre 0 y 100
            const pesoValue = Math.min(100, Math.max(0, Number(value) || 0));
            newMeta[metaIndex].actividades[actividadIndex][name] = pesoValue;
        } else {
            newMeta[metaIndex].actividades[actividadIndex][name] = value;
        }

        setMetas(newMeta);
    };

    // Agregar nuevo meta
    const addMeta = () => {
        setMetas(prev => [
            ...prev,
            {
                descripcion: '',
                actividades: [{
                    descripcion: '',
                }]
            }
        ]);
    };

    // Eliminar meta
    const removeMeta = (index) => {
        if (metas.length > 1) {
            setMetas(prev => prev.filter((_, i) => i !== index));
        }
    };

    return (
        <div className="col-md-12 bg-white rounded-xl !border border-custom-blue-light py-3">
            <div className={'p-3'}>
                <h3 className="mb-4 text-custom-blue-dark">{objetivoExistente ? 'Editar' : 'Crear'} objetivo PMI</h3>

                {/* Sección del objetivo */}
                <div className="card mb-4">
                    <div className="card-header">
                        <h5>Información del objetivo </h5>
                    </div>

                    <div className="card-body">
                        <label className="block text-sm mb-2 ml-4">Gestión*</label>
                        <CAutocompleteFromArray
                            data={gestiones}
                            fieldName={"gestion_id"}
                            initialValue={gestionSeleccionada?.id}
                            orderBy={{ field: 'indice', direction: 'asc' }}
                            searchFields={['nombre', 'indice']}
                            labelFields={['indice','nombre']}
                            onSelect={(gestion) => {
                                setGestionSeleccionada(gestion);
                                // Reiniciar factor si cambia la gestión
                                setObjetivo(prev => ({ ...prev, factor_id: "" }));
                            }}
                        />
                    </div>

                    {gestionSeleccionada && (
                        <div className="card-body">
                            <label className="block text-sm mb-2 ml-4">Factor crítico*</label>
                            <CAutocompleteFromArray
                                key={gestionSeleccionada.id}   // 🔑 fuerza reset al cambiar gestión
                                data={factoresFiltrados}
                                orderBy={{ field: 'indice_calificacion', direction: 'asc' }}
                                fieldName={"factor_id"}
                                initialValue={objetivo.factor_id}
                                searchFields={['descripcion','indice_calificacion']}
                                labelFields={['indice_calificacion','descripcion']}
                                onSelect={(factor) => {
                                    setObjetivo(prev => ({ ...prev, factor_id: factor.id }));
                                }}
                            />
                        </div>
                    )}
                    <div className="card-body">
                        <div className="mb-3">
                            <label htmlFor="descripcion" className="block text-sm mb-2 ml-4">Descripción*</label>
                            <textarea
                                id="descripcion"
                                className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                name="descripcion"
                                value={objetivo.descripcion}
                                onChange={handleObjetivoChange}
                                disabled={!editable}
                                required
                            />
                        </div>
                    </div>
            </div>

                {/* Sección de Meta */}
                <div className="card mb-4">
                    <div className="card-header d-flex justify-content-between align-items-center">
                        <h5>Meta</h5>
                        { editable && (
                            <button type="button" className="btn btn-sm btn-primary" onClick={addMeta}>
                                Agregar Meta
                            </button>
                        )}

                    </div>
                    <div className="card-body">
                        {metas.map((meta, i) => {
                            return (
                                <div key={i} className="mb-4 border-bottom pb-3">
                                    <div className="d-flex justify-content-between align-items-center mb-2">
                                        <h6>Meta #{i + 1}</h6>
                                        { editable && (
                                            <button
                                                type="button"
                                                className="btn btn-sm btn-danger"
                                                onClick={() => removeMeta(i)}
                                                disabled={metas.length <= 1}
                                            >
                                                Eliminar
                                            </button>
                                        )}

                                    </div>

                                    <div className="mb-3">
                                        <label htmlFor={`meta-desc-${i}`} className="block text-sm mb-2 ml-4">Descripción*</label>
                                        <textarea
                                            id={`meta-desc-${i}`}
                                            className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                            name="descripcion"
                                            value={meta.descripcion}
                                            onChange={(e) => handleMetaChange(i, e)}
                                            disabled={!editable}
                                            required
                                        />
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>


                <form method="POST" action={agregarUrl}>
                <input type="hidden" name="_token" value={csrfToken} />
                <input type="hidden" name="id" value={objetivo.id} />
                <input type="hidden" name="descripcion" value={objetivo.descripcion} />
                <input type="hidden" name="factor_id" value={objetivo.factor_id} />

                {metas.map((meta, i) => (
                    <div key={i} style={{ display: 'none'}}>
                        <input
                            type="hidden"
                            name={`metas[${i}][descripcion]`}
                            value={meta.descripcion}
                        />
                        <input
                            type="hidden"
                            name={`metas[${i}][indicador_id]`}
                            value={meta.indicador_id}
                        />
                   </div>
                ))}
                { editable && (
                    <button
                        type="submit"
                        className="btn btn-success"
                    >
                        Guardar Objetivo
                    </button>
                ) }

            </form>
            </div>
        </div>
    );
};

export default CreateObjetivoPMI;
