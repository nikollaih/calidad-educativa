// Importa h para JSX en Preact y los hooks necesarios.
import { h } from 'preact';
import Swal from 'sweetalert2';
import { useEffect, useState } from "preact/hooks";
import CPagination from '@/components/shared/CPagination.jsx';

export default function IndexPAMS({ agregarUrl, pamsPaginated = {}, csrfToken = '' }) {
    const [pams, setPams] = useState([]);

    useEffect(() => {
        if (pamsPaginated && Array.isArray(pamsPaginated.data)) {
            setPams(pamsPaginated.data);
        }
    }, [pamsPaginated]);

    const handleAgregarClick = () => {
        window.location.href = agregarUrl;
    };

    const formatFecha = (fechaIso) => {
        if (!fechaIso) {
            return '';
        }
        const fecha = new Date(fechaIso);
        let horas = fecha.getHours();
        const minutos = String(fecha.getMinutes()).padStart(2, '0');
        const ampm = horas >= 12 ? 'PM' : 'AM';

        horas = horas % 12;
        horas = horas ? horas : 12;

        const horaFormateada = `${String(horas).padStart(2, '0')}:${minutos} ${ampm}`;
        const dia = String(fecha.getDate()).padStart(2, '0');
        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
        const anio = fecha.getFullYear();

        return `${dia}/${mes}/${anio} ${horaFormateada}`;
    };

    const deleteRow = async (id) => {
        try {
        const result = await Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        });

        if (result.isConfirmed) {
            // Hacer petición DELETE al servidor
            const response = await fetch(`/pams/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
            });

            if (!response.ok) {
            throw new Error('Error al eliminar el registro');
            }

            // Mostrar notificación de éxito
            await Swal.fire(
            '¡Eliminado!',
            'El registro ha sido eliminado.',
            'success'
            );
            window.location.reload()
        }
        } catch (error) {
            console.error('Error al eliminar:', error);
            Swal.fire(
                'Error',
                'No se pudo eliminar el registro: ' + error.message,
                'error'
            );
        }
    };

    // [MODIFICACIÓN] Nueva función para manejar el clic del botón "Presentar PAM".
    // Muestra un modal de confirmación antes de enviar el formulario.
    const handlePresentarClick = async (id) => {
        try {
            const result = await Swal.fire({
                title: '¿Estás seguro?',
                // [MODIFICACIÓN] Mensaje específico para esta acción.
                text: "Una vez presentado, el estado del PAM no se podrá revertir.",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#6c757d', // Color gris para el botón de cancelar
                confirmButtonText: 'Sí, presentar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            });

            if (result.isConfirmed) {
                // [MODIFICACIÓN] En lugar de un formulario, se realiza una petición POST asíncrona.
                const response = await fetch(`/pams/${id}/presentar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Error al presentar el registro');
                }

                await Swal.fire(
                    '¡Presentado!',
                    'El registro ha sido presentado exitosamente.',
                    'success'
                );
                window.location.reload();
            }
        } catch (error) {
            console.error('Error al presentar:', error);
            Swal.fire(
                'Error',
                'No se pudo presentar el registro: ' + error.message,
                'error'
            );
        }
    };

    // Renderiza el JSX del componente.
    return (
        <div class="container mt-4">
            <h1 class="mb-4">PLAN DE APOYO AL MEJORAMIENTO</h1>
            <h2 class="mb-4">HISTÓRICO</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar nuevo registro
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th>VIGENCIA</th>
                        <th>FECHA DE CREACIÓN</th>
                        <th>ESTADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    {pams.length > 0 ? (
                        pams.map((pam) => (
                            <tr key={pam.id}>
                                <td>{pam.anio_inicio} - {pam.anio_fin}</td>
                                <td>{formatFecha(pam.created_at)}</td>
                                <td>{pam.estado}</td>
                                <td>
                                    <a href={`/pams/${pam.id}/edit`} className="btn btn-warning btn-sm me-2" >
                                        Editar
                                    </a>

                                    <a href={`/pam/${pam.id}/index`} className="btn btn-primary btn-sm me-2" >
                                        Gestionar
                                    </a>

                                    <button
                                        className="btn btn-sm btn-danger me-2" // [MODIFICACIÓN] Agregado margen para separar los botones.
                                        onClick={() => deleteRow(pam.id)}
                                        title="Eliminar PAM"
                                    >
                                        Eliminar
                                    </button>
                                    { Boolean(pam.estado == "Proceso") && (
                                        // Se cambió el tipo de botón a "button" para que no envíe el formulario.
                                        <button
                                            type="button"
                                            className="btn btn-success btn-sm"
                                            onClick={() => handlePresentarClick(pam.id)}
                                            alt="Presentar PAM"
                                        >
                                            Presentar PAM
                                        </button>
                                    )}
                                </td>
                            </tr>
                        ))
                    ) : (
                        <tr>
                            <td colSpan="4" className="text-center">No hay PAMs para mostrar.</td>
                        </tr>
                    )}
                </tbody>
            </table>
            <CPagination  pagination={pamsPaginated} />
        </div>
    );
}
