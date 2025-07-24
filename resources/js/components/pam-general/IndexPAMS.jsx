// Importa h para JSX en Preact y los hooks necesarios.
import { h } from 'preact';
import Swal from 'sweetalert2';
import { useEffect, useState } from "preact/hooks";

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

    const deleteRow = async (id, index) => {
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
    // Renderiza el JSX del componente.
    return (
        <div class="container mt-4">
            <h2 class="mb-4">LISTADO DE PAMS</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar nuevo registro
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th>CONSECUTIVO</th>
                        <th>VIGENCIA</th>
                        <th>FECHA DE CREACIÓN</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    {pams.length > 0 ? (
                        pams.map((pam) => (
                            <tr key={pam.id}>
                                <td>{pam.consecutivo}</td>
                                <td>{pam.anio_inicio} - {pam.anio_fin}</td>
                                <td>{formatFecha(pam.created_at)}</td>
                                <td>
                                    <a href={`/pams/${pam.id}/edit`} className="btn btn-warning btn-sm me-2" >
                                        Editar
                                    </a>

                                    <a href={`/pam/${pam.id}/index`} className="btn btn-primary btn-sm me-2" >
                                        Registros
                                    </a>
                                    
                                    <button 
                                        className="btn btn-sm btn-danger"
                                        onClick={() => deleteRow(pam.id)}
                                        title="Eliminar PAM"
                                    >
                                    Eliminar
                                    </button>
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
            {pamsPaginated.links && pamsPaginated.links.length > 3 && (
                <nav>
                    <ul class="pagination">
                        {pamsPaginated.links.map((link, index) => (
                            <li
                                key={index}
                                class={`page-item ${link.active ? 'active' : ''} ${!link.url ? 'disabled' : ''}`}
                            >
                                <a
                                    class="page-link"
                                    href={link.url || '#'}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                    onClick={(e) => { if (!link.url) e.preventDefault(); }}
                                >
                                </a>
                            </li>
                        ))}
                    </ul>
                </nav>
            )}
        </div>
    );
}