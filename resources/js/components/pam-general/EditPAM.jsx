// Importa las dependencias necesarias de Preact
import { useState, useEffect } from 'preact/hooks';

// Define el componente EditPAM
// Recibe las props:
// - csrfToken: Token CSRF para seguridad
// - pamData: Objeto con los datos actuales del PAM a editar
const EditPAM = ({ csrfToken = '', pamData = {} }) => {
    // Estados para los campos del formulario
    const [consecutivo, setConsecutivo] = useState(pamData.consecutivo || '');
    const [descripcion, setDescripcion] = useState(pamData.descripcion || '');
    const [anioInicio, setAnioInicio] = useState(pamData.anio_inicio || '');
    const [anioFin, setAnioFin] = useState(pamData.anio_fin || '');

    // Obtiene el año actual para generar el rango de años
    const currentYear = new Date().getFullYear();
    // Genera un rango de 11 años: 5 años antes del actual, el actual y 5 años después
    const aniosRango = Array.from({ length: 11 }, (_, i) => currentYear - 5 + i);

    // useEffect para asegurar que los estados se actualicen si pamData cambia (ej. al cargar el componente con nuevos datos)
    useEffect(() => {
        setConsecutivo(pamData.consecutivo || '');
        setDescripcion(pamData.descripcion || '');
        setAnioInicio(pamData.anio_inicio || '');
        setAnioFin(pamData.anio_fin || '');
    }, [pamData]);

    return (
        <div className="container py-4">
            {/* Formulario que apunta a la URL de actualización y usa el método POST (simulando PUT/PATCH) */}
            <form method="POST" action={`/pams/${pamData.id}`} className="mb-4">
                {/* Campo oculto para el token CSRF */}
                <input type="hidden" name="_token" value={csrfToken} />
                {/* Campo oculto para simular el método PUT (necesario para Laravel u otros frameworks) */}
                <input type="hidden" name="_method" value="PUT" />

                <h5 className="mb-2">Consecutivo del PAM</h5>
                <input
                    class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill mb-2"
                    type="text"
                    name="pam[consecutivo]"
                    value={consecutivo}
                    onChange={(e) => setConsecutivo(e.target.value)}
                />
                <h5 className="mb-2">Descripción del PAM</h5>
                <textarea
                    class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill mb-2"
                    name="pam[descripcion]"
                    value={descripcion}
                    onChange={(e) => setDescripcion(e.target.value)}
                ></textarea>
                <h5 className="mb-2">Seleccionar años de ejecución del PAM<span className="text-danger">*</span></h5>
                <div className="row mb-4">
                    <div className="col">
                        <label htmlFor="anioInicio" className="block text-sm mb-2 ml-4">Año de inicio</label>
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
                        <label htmlFor="anioFin" className="block text-sm mb-2 ml-4">Año de fin</label>
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
                <button className="btn btn-primary">
                    Actualizar PAM
                </button>
            </form>
        </div>
    );
};

export default EditPAM;
