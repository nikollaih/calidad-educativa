import { h } from 'preact';
import { useState, useEffect } from 'preact/hooks';

const CreateMetaPMI = ({ agregarUrl = '', csrfToken = '' }) => {
    // Estado para la meta
    const [meta, setMeta] = useState({
        descripcion: '',
        unidad_medida: '',
        valor_requerido: ''
    });

    // Estado para los indicadores
    const [indicadores, setIndicadores] = useState([
        {
            descripcion: '',
            actividades: [{
                descripcion: '',
                peso: 100 // Por defecto 100% si solo hay una actividad
            }]
        }
    ]);

    // Validar suma de pesos
    const [pesoValido, setPesoValido] = useState(true);

    // Verificar que la suma de pesos sea 100% para cada indicador
    useEffect(() => {
        const valid = indicadores.every(indicador => {
            const totalPeso = indicador.actividades.reduce((sum, act) => sum + (Number(act.peso) || 0), 0);
            return totalPeso === 100;
        });
        setPesoValido(valid);
    }, [indicadores]);

    useEffect(() => {
        console.log(indicadores);
    },[indicadores]);

    // Manejar cambios en los campos de la meta
    const handleMetaChange = (e) => {
        const { name, value } = e.target;
        setMeta(prev => ({
            ...prev,
            [name]: value
        }));
    };

    // Manejar cambios en los indicadores
    const handleIndicadorChange = (index, e) => {
        const { name, value } = e.target;
        const newIndicadores = [...indicadores];
        newIndicadores[index] = {
            ...newIndicadores[index],
            [name]: value
        };
        setIndicadores(newIndicadores);
    };

    // Manejar cambios en las actividades
    const handleActividadChange = (indicadorIndex, actividadIndex, e) => {
        const { name, value } = e.target;
        const newIndicadores = [...indicadores];

        if (name === 'peso') {
            // Validar que el peso sea un número entre 0 y 100
            const pesoValue = Math.min(100, Math.max(0, Number(value) || 0));
            newIndicadores[indicadorIndex].actividades[actividadIndex][name] = pesoValue;
        } else {
            newIndicadores[indicadorIndex].actividades[actividadIndex][name] = value;
        }

        setIndicadores(newIndicadores);
    };

    // Calcular el peso restante para un indicador
    const calcularPesoRestante = (indicadorIndex, actividadIndex) => {
        const indicador = indicadores[indicadorIndex];
        const totalAsignado = indicador.actividades.reduce((sum, act, idx) => {
            return idx === actividadIndex ? sum : sum + (Number(act.peso) || 0)
        }, 0);
        return 100 - totalAsignado;
    };

    // Agregar nuevo indicador
    const addIndicador = () => {
        setIndicadores(prev => [
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

    // Eliminar indicador
    const removeIndicador = (index) => {
        if (indicadores.length > 1) {
            setIndicadores(prev => prev.filter((_, i) => i !== index));
        }
    };

    // Agregar actividad a un indicador
    const addActividad = (indicadorIndex) => {
        const newIndicadores = [...indicadores];
        const pesoRestante = calcularPesoRestante(indicadorIndex, -1);
        const nuevoPeso = pesoRestante > 0 ? pesoRestante : 0;

        newIndicadores[indicadorIndex].actividades.push({
            descripcion: '',
            peso: nuevoPeso
        });

        // Ajustar pesos existentes si es necesario
        if (pesoRestante <= 0) {
            const actividades = newIndicadores[indicadorIndex].actividades;
            const factor = 100 / (actividades.length);
            actividades.forEach(act => {
                act.peso = Math.round(factor * 10) / 10; // Redondear a 1 decimal
            });
        }

        setIndicadores(newIndicadores);
    };

    // Eliminar actividad de un indicador
    const removeActividad = (indicadorIndex, actividadIndex) => {
        const newIndicadores = [...indicadores];
        if (newIndicadores[indicadorIndex].actividades.length > 1) {
            // Eliminar la actividad
            newIndicadores[indicadorIndex].actividades = newIndicadores[indicadorIndex]
                .actividades.filter((_, i) => i !== actividadIndex);

            // Redistribuir el peso si solo queda una actividad
            if (newIndicadores[indicadorIndex].actividades.length === 1) {
                newIndicadores[indicadorIndex].actividades[0].peso = 100;
            }

            setIndicadores(newIndicadores);
        }
    };

    return (
        <div className="container py-4">
            <form method="POST" action={agregarUrl}>
                <input type="hidden" name="_token" value={csrfToken} />
                {indicadores.map((indicador, i) => (
                    <div key={i} style={{ display: 'none'}}>
                                <input
                                    type="hidden"
                                    name={`indicadores[${i}][descripcion]`}
                                    value={indicador.descripcion}
                                    onChange={(e) => handleIndicadorChange(i, e)}
                                    className="form-control"
                                />
                            {indicador.actividades.map((actividad, j) => (
                                <div key={j}>
                                            <input
                                                type="hidden"
                                                name={`indicadores[${i}][actividades][${j}][descripcion]`}
                                                value={actividad.descripcion}
                                                onChange={(e) => handleActividadChange(i, j, e)}
                                                className="form-control"
                                            />
                                            <input
                                                type="hidden"
                                                name={`indicadores[${i}][actividades][${j}][peso]`}
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

                <h3 className="mb-4">Crear Nueva Meta PMI</h3>

                {/* Sección de la Meta */}
                <div className="card mb-4">
                    <div className="card-header">
                        <h5>Información de la Meta</h5>
                    </div>
                    <div className="card-body">
                        <div className="mb-3">
                            <label htmlFor="descripcion" className="form-label">Descripción*</label>
                            <textarea
                                id="descripcion"
                                className="form-control"
                                name="descripcion"
                                value={meta.descripcion}
                                onChange={handleMetaChange}
                                required
                            />
                        </div>

                        <div className="row">
                            <div className="col-md-6 mb-3">
                                <label htmlFor="unidad_medida" className="form-label">Unidad de Medida*</label>
                                <input
                                    type="text"
                                    id="unidad_medida"
                                    className="form-control"
                                    name="unidad_medida"
                                    value={meta.unidad_medida}
                                    onChange={handleMetaChange}
                                    required
                                />
                            </div>

                            <div className="col-md-6 mb-3">
                                <label htmlFor="valor_requerido" className="form-label">Valor Requerido*</label>
                                <input
                                    type="number"
                                    id="valor_requerido"
                                    className="form-control"
                                    name="valor_requerido"
                                    value={meta.valor_requerido}
                                    onChange={handleMetaChange}
                                    required
                                />
                            </div>
                        </div>
                    </div>
                </div>

                {/* Sección de Indicadores */}
                <div className="card mb-4">
                    <div className="card-header d-flex justify-content-between align-items-center">
                        <h5>Indicadores</h5>
                        <button type="button" className="btn btn-sm btn-primary" onClick={addIndicador}>
                            Agregar Indicador
                        </button>
                    </div>
                    <div className="card-body">
                        {indicadores.map((indicador, i) => {
                            const totalPeso = indicador.actividades.reduce((sum, act) => sum + (Number(act.peso) || 0), 0);
                            const pesoValidoIndicador = totalPeso === 100;

                            return (
                                <div key={i} className="mb-4 border-bottom pb-3">
                                    <div className="d-flex justify-content-between align-items-center mb-2">
                                        <h6>Indicador #{i + 1}</h6>
                                        <button
                                            type="button"
                                            className="btn btn-sm btn-danger"
                                            onClick={() => removeIndicador(i)}
                                            disabled={indicadores.length <= 1}
                                        >
                                            Eliminar
                                        </button>
                                    </div>

                                    <div className="mb-3">
                                        <label htmlFor={`indicador-desc-${i}`} className="form-label">Descripción*</label>
                                        <textarea
                                            id={`indicador-desc-${i}`}
                                            className="form-control"
                                            name="descripcion"
                                            value={indicador.descripcion}
                                            onChange={(e) => handleIndicadorChange(i, e)}
                                            required
                                        />
                                    </div>

                                    {/* Actividades del indicador */}
                                    <div className="ps-3">
                                        <div className="d-flex justify-content-between align-items-center mb-3">
                                            <h6>Actividades</h6>
                                            <div className={`badge ${pesoValidoIndicador ? 'bg-success' : 'bg-danger'}`}>
                                                Peso total: {totalPeso}%
                                            </div>
                                        </div>

                                        {indicador.actividades.map((actividad, j) => {
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
                                                            disabled={indicador.actividades.length <= 1}
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
                                                                {j === indicador.actividades.length - 1 ? (
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
                        La suma de los pesos de las actividades debe ser exactamente 100% para cada indicador.
                    </div>
                )}

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

export default CreateMetaPMI;
