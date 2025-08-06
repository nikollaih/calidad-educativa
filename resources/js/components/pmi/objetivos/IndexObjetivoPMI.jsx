import { h } from 'preact';
import {useEffect, useState} from "preact/hooks";


export default function IndexObjetivoPMI({ agregarUrl, objetivosPaginated = {}, csrfToken = '',}) {
    const [objetivos, setObjetivos] = useState([]);

    useEffect(()=>{
        setObjetivos(objetivosPaginated.data);
    },[]);
    const handleAgregarClick = () => {
        window.location.href = agregarUrl;
    };
    return (
        <div class="container mt-4">
            <h2 class="mb-4">Objetivos del PMI</h2>
            <button class="btn btn-primary mb-3" onClick={handleAgregarClick}>
                Agregar un objetivo de PMI
            </button>

            <table class="table">
                <thead>
                <tr>
                    <th>DESCRIPCION</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                {objetivos.map((objetivo) => (
                    <tr key={objetivo.id}>
                        <td>{objetivo.descripcion}</td>
                        <td>
                            <a
                                href={`/objetivo-pmi/${objetivo.id}/edit`}
                                className="btn btn-primary btn-sm me-2"
                            >
                                Ver detalles
                            </a>

                            <a
                                href={`/objetivo-pmi/${objetivo.id}/edit`}
                                className="btn btn-warning btn-sm me-2"
                            >
                                Editar
                            </a>

                        </td>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
}
