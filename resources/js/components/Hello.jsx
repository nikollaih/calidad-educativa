import { h } from 'preact';

export default function Hello() {
    const container = document.getElementById('autoevaluacion');
    const agregarUrl = container?.dataset?.agregarUrl || '#';

    const handleAgregarClick = () => {
        window.location.href = agregarUrl;
    };

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Autoevaluación</h2>

            <button class="border bg-blue-500  text-white p-2 rounded-pill mb-3" onClick={handleAgregarClick}>
                Agregar Autoevaluación
            </button>

            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>Periodo Evaluado</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>2024</td>
                    <td>Revisada</td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary">
                            Editar
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2025</td>
                    <td>Pendiente de revisión</td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary">
                            Editar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    );
}
