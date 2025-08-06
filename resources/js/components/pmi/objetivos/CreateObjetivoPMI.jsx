import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';

const CreateObjetivoPMI = ({ agregarUrl = '', csrfToken = '' }) => {
    // Estado para el objetivo
    const [objetivo, setObjetivo] = useState({
        descripcion: '',

    });

    // Estado para los metaes
    const [metas, setMetas] = useState([
        {
            descripcion: '',
            unidad_medida: '',
            valor_requerido: '',
            actividades: [{
                descripcion: '',
                peso: 100 // Por defecto 100% si solo hay una actividad
            }]
        }
    ]);

    // Validar suma de pesos
    const [pesoValido, setPesoValido] = useState(true);

    // Verificar que la suma de pesos sea 100% para cada meta
    useEffect(() => {
        const valid = metas.every(meta => {
            const totalPeso = meta.actividades.reduce((sum, act) => sum + (Number(act.peso) || 0), 0);
            return totalPeso === 100;
        });
        setPesoValido(valid);
    }, [metas]);

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
        console.log(index,e,value,name);
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
        const pesoRestante = calcularPesoRestante(metaIndex, -1);
        const nuevoPeso = pesoRestante > 0 ? pesoRestante : 0;

        newMeta[metaIndex].actividades.push({
            descripcion: '',
            peso: nuevoPeso
        });

        // Ajustar pesos existentes si es necesario
        if (pesoRestante <= 0) {
            const actividades = newMeta[metaIndex].actividades;
            const factor = 100 / (actividades.length);
            actividades.forEach(act => {
                act.peso = Math.round(factor * 10) / 10; // Redondear a 1 decimal
            });
        }

        setMetas(newMeta);
    };

    // Eliminar actividad de un meta
    const removeActividad = (metaIndex, actividadIndex) => {
        const newMeta = [...metas];
        if (newMeta[metaIndex].actividades.length > 1) {
            // Eliminar la actividad
            newMeta[metaIndex].actividades = newMeta[metaIndex]
                .actividades.filter((_, i) => i !== actividadIndex);

            // Redistribuir el peso si solo queda una actividad
            if (newMeta[metaIndex].actividades.length === 1) {
                newMeta[metaIndex].actividades[0].peso = 100;
            }

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
                </div>

                {/* Sección de Meta */}
                <div className="card mb-4">
                    <div className="card-header d-flex justify-content-between align-items-center">
                        <h5>Meta</h5>
                        <button type="button" className="btn btn-sm btn-primary" onClick={addMeta}>
                            Agregar Meta
                        </button>
                    </div>
                    <div className="card-body">
                        {metas.map((meta, i) => {
                            const totalPeso = meta.actividades.reduce((sum, act) => sum + (Number(act.peso) || 0), 0);
                            const pesoValidoMeta = totalPeso === 100;

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
                                            <input
                                                type="text"
                                                id={`meta-unid-${i}`}
                                                name="unidad_medida"
                                                className="form-control"
                                                value={meta.unidad_medida}
                                                onChange={(e) => handleMetaChange(i, e)}
                                                required
                                            />
                                        </div>

                                        <div className="col-md-6 mb-3">
                                            <label htmlFor="valor_requerido" className="form-label">Valor Requerido*</label>
                                            <input
                                                type="number"
                                                id={`meta-valor-${i}`}
                                                name="valor_requerido"
                                                className="form-control"
                                                value={meta.valor_requerido}
                                                onChange={(e) => handleMetaChange(i, e)}
                                                required
                                            />
                                        </div>
                                    </div>


                                    {/* Actividades del meta */}
                                    <div className="ps-3">
                                        <div className="d-flex justify-content-between align-items-center mb-3">
                                            <h6>Actividades</h6>
                                            <div className={`badge ${pesoValidoMeta ? 'bg-success' : 'bg-danger'}`}>
                                                Peso total: {totalPeso}%
                                            </div>
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
                                                    <div className="row">
                                                        <div className="col-md-6">
                                                            <label htmlFor={`actividad-peso-${i}-${j}`} className="form-label">
                                                                Peso (%)*
                                                            </label>
                                                            <input
                                                                type="number"
                                                                id={`actividad-peso-${i}-${j}`}
                                                                className="form-control"
                                                                name="peso"
                                                                min="0"
                                                                max="100"
                                                                step="0.1"
                                                                value={actividad.peso}
                                                                onChange={(e) => handleActividadChange(i, j, e)}
                                                                required
                                                            />
                                                        </div>
                                                        <div className="col-md-6 d-flex align-items-end">
                                                            <small className="text-muted">
                                                                {j === meta.actividades.length - 1 ? (
                                                                    <span>Peso restante: {pesoRestante}%</span>
                                                                ) : null}
                                                            </small>
                                                        </div>
                                                    </div>
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

                {!pesoValido && (
                    <div className="alert alert-danger mb-4">
                        <i className="bi bi-exclamation-triangle-fill me-2"></i>
                        La suma de los pesos de las actividades debe ser exactamente 100% para cada meta.
                    </div>
                )}
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
                            name={`metas[${i}][unidad_medida]`}
                            value={meta.unidad_medida}
                        />
                        <input
                            type="hidden"
                            name={`metas[${i}][valor_requerido]`}
                            value={meta.valor_requerido}
                        />
                        {meta.actividades.map((actividad, j) => (
                            <div key={j}>
                                <input
                                    type="hidden"
                                    name={`metas[${i}][actividades][${j}][descripcion]`}
                                    value={actividad.descripcion}
                                    onChange={(e) => handleActividadChange(i, j, e)}
                                    className="form-control"
                                />
                                <input
                                    type="hidden"
                                    name={`metas[${i}][actividades][${j}][peso]`}
                                    value={actividad.peso}
                                    onChange={(e) => handleActividadChange(i, j, e)}
                                    className="form-control"
                                    min="0"
                                    max="100"
                                />
                            </div>
                        ))}
                    </div>
                ))}
                <input type="hidden" name="descripcion" value={objetivo.descripcion} />
                <button
                    type="submit"
                    className="btn btn-success"
                    disabled={!pesoValido}
                >
                    Guardar Meta
                </button>
            </form>
        </div>
    );
};

export default CreateObjetivoPMI;
