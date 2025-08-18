import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';
import CAutocompleteFromArray from "@/components/shared/CAutocompleteFromArray.jsx";

const CreateObjetivoPMI = ({ agregarUrl = '', csrfToken = '' , factoresCriticos=[], unidadesMedida=[]}) => {
    // Estado para el objetivo
    const [objetivo, setObjetivo] = useState({
        descripcion: '',
        factor_id: "",
    });

    // Estado para los metaes
    const [metas, setMetas] = useState([
        {
            descripcion: '',
            indicador_id: "",
            actividades: [{
                descripcion: '',
                peso: 100, // Por defecto 100% si solo hay una actividad
                accumulated: 0,
            }]
        }
    ]);

    // Validar suma de pesos
    const [pesoValido, setPesoValido] = useState(true);
    useEffect(()=>{
        console.log(unidadesMedida)
    },[])

    useEffect(() => {
        console.log(objetivo);
    },[objetivo]);

    useEffect(()=>{console.log(metas)},[metas]);

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

    // Calcular el peso restante para un meta
    const calcularPesoRestante = (metaIndex, actividadIndex) => {
        const meta = metas[metaIndex];
        const totalAsignado = meta.actividades.reduce((sum, act, idx) => {
            return idx === actividadIndex ? sum : sum + (Number(act.peso) || 0)
        }, 0);
        return 100 - totalAsignado;
    };

    // Agregar nuevo meta
    const addMeta = () => {
        setMetas(prev => [
            ...prev,
            {
                descripcion: '',
                indicador_id: '',
                actividades: [{
                    descripcion: '',
                    peso: 100
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

    // Agregar actividad a un meta
    const addActividad = (metaIndex) => {
        const newMeta = [...metas];
        newMeta[metaIndex].actividades.push({
            descripcion: '',
        });
        setMetas(newMeta);
    };

    // Eliminar actividad de un meta
    const removeActividad = (metaIndex, actividadIndex) => {
        const newMeta = [...metas];
        if (newMeta[metaIndex].actividades.length > 1) {
            // Eliminar la actividad
            newMeta[metaIndex].actividades = newMeta[metaIndex]
                .actividades.filter((_, i) => i !== actividadIndex);

            setMetas(newMeta);
        }
    };

    return (
        <div className="container py-4">
                <h3 className="mb-4">Crear nuevo objetivo pmi</h3>

                {/* Sección del objetivo */}
                <div className="card mb-4">
                    <div className="card-header">
                        <h5>Información del objetivo </h5>
                    </div>
                    <div className="card-body">
                        <div className="mb-3">
                            <label htmlFor="descripcion" className="form-label">Descripción*</label>
                            <textarea
                                id="descripcion"
                                className="form-control"
                                name="descripcion"
                                value={objetivo.descripcion}
                                onChange={handleObjetivoChange}
                                required
                            />
                        </div>
                    </div>
                    <div className="card-body">
                            <label htmlFor="descripcion" className="form-label">Factor critico asociado al objetivo*</label>
                            <CAutocompleteFromArray
                                data={factoresCriticos}
                                fieldName={"factor_id"}
                                searchFields={['descripcion', 'indice_calificacion']}
                                labelFields={['indice_calificacion', 'descripcion']}
                                onSelect={(factor) => {
                                    setObjetivo(prev => ({
                                        ...prev,
                                        ['factor_id']: factor.id
                                    }));
                                }}
                            />

                </div>
        </div>

    {/* Sección de Meta */
    }
    <div className="card mb-4">
        <div className="card-header d-flex justify-content-between align-items-center">
            <h5>Meta</h5>
            <button type="button" className="btn btn-sm btn-primary" onClick={addMeta}>
            Agregar Meta
                        </button>
                    </div>
                    <div className="card-body">
                        {metas.map((meta, i) => {

                            return (
                                <div key={i} className="mb-4 border-bottom pb-3">
                                    <div className="d-flex justify-content-between align-items-center mb-2">
                                        <h6>Meta #{i + 1}</h6>
                                        <button
                                            type="button"
                                            className="btn btn-sm btn-danger"
                                            onClick={() => removeMeta(i)}
                                            disabled={metas.length <= 1}
                                        >
                                            Eliminar
                                        </button>
                                    </div>

                                    <div className="mb-3">
                                        <label htmlFor={`meta-desc-${i}`} className="form-label">Descripción*</label>
                                        <textarea
                                            id={`meta-desc-${i}`}
                                            className="form-control"
                                            name="descripcion"
                                            value={meta.descripcion}
                                            onChange={(e) => handleMetaChange(i, e)}
                                            required
                                        />
                                    </div>
                                    <div className="row">
                                        <div className="col-md-6 mb-3">
                                            <label htmlFor="unidad_medida" className="form-label">Unidad de Medida*</label>
                                            <CAutocompleteFromArray
                                                data={unidadesMedida}
                                                fieldName={"indicador_id"}
                                                searchFields={['unidad_total', 'unidad_parcial']}
                                                labelFields={['unidad_parcial']}
                                                onSelect={(unidadMedida) => {
                                                    const newMeta = [...metas];
                                                    newMeta[i] = {
                                                        ...newMeta[i],
                                                        ['indicador_id']: unidadMedida.id
                                                    };
                                                    setMetas(newMeta);
                                                }}
                                            />
                                        </div>
                                    </div>


                                    {/* Actividades del meta */}
                                    <div className="ps-3">
                                        <div className="d-flex justify-content-between align-items-center mb-3">
                                            <h6>Actividades</h6>
                                        </div>

                                        {meta.actividades.map((actividad, j) => {
                                            const pesoRestante = calcularPesoRestante(i, j);

                                            return (
                                                <div key={j} className="mb-3 border p-3 rounded">
                                                    <div className="d-flex align-items-center mb-2">
                                                        <label
                                                            htmlFor={`actividad-${i}-${j}`}
                                                            className="form-label me-2"
                                                        >
                                                            Actividad #{j + 1}
                                                        </label>
                                                        <button
                                                            type="button"
                                                            className="btn btn-sm btn-outline-danger ms-auto"
                                                            onClick={() => removeActividad(i, j)}
                                                            disabled={meta.actividades.length <= 1}
                                                        >
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                    <textarea
                                                        id={`actividad-desc-${i}-${j}`}
                                                        className="form-control mb-2"
                                                        name="descripcion"
                                                        value={actividad.descripcion}
                                                        onChange={(e) => handleActividadChange(i, j, e)}
                                                        required
                                                    />
                                                </div>
                                            );
                                        })}

                                        <button
                                            type="button"
                                            className="btn btn-sm btn-outline-primary"
                                            onClick={() => addActividad(i)}
                                        >
                                            Agregar Actividad
                                        </button>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>

            <form method="POST" action={agregarUrl}>
                <input type="hidden" name="_token" value={csrfToken} />
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
                        {meta.actividades.map((actividad, j) => (
                            <div key={j}>
                                <input
                                    type="hidden"
                                    name={`metas[${i}][actividades][${j}][descripcion]`}
                                    value={actividad.descripcion}
                                    className="form-control"
                                />
                            </div>
                        ))}
                    </div>
                ))}
                <input type="hidden" name="descripcion" value={objetivo.descripcion} />
                <input type="hidden" name="factor_id" value={objetivo.factor_id} />
                <button
                    type="submit"
                    className="btn btn-success"
                    disabled={!pesoValido}
                >
                    Guardar Objetivo
                </button>
            </form>
        </div>
    );
};

export default CreateObjetivoPMI;
