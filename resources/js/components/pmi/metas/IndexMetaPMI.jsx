import { h } from 'preact';
import {useEffect, useState} from "preact/hooks";


export default function IndexMetaPMI({ agregarUrl, metasPaginated = {}, csrfToken = '',}) {
    const [metas, setMetas] = useState([]);

    useEffect(()=>{
        setMetas(metasPaginated.data);
    },[]);
    const handleAgregarClick = () => {
        window.location.href = agregarUrl;
    };
    return (
        <div class="container mt-4">
            <h2 class="mb-4">Metas del PMI</h2>
            <button class="border bg-blue-500  text-white p-2 rounded-pill mb-3" onClick={handleAgregarClick}>
                Agregar una meta de PMI
            </button>

            <table class="table">
                <thead>
                <tr>
                    <th>DESCRIPCION</th>
                    <th>UNIDAD DE MEDIDA</th>
                    <th>VALOR REQUERIDO</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                {metas.map((meta) => (
                    <tr key={meta.id}>
                        <td>{meta.descripcion}</td>
                        <td>{meta.unidad_medida}</td>
                        <td>{meta.valor_requerido}</td>
                        <td>
                            <a
                                href={`/metas-pmi/${meta.id}/edit`}
                                className="border bg-blue-500  text-white p-2 rounded-pill btn-sm me-2"
                            >
                                Ver detalles
                            </a>

                            <a
                                href={`/metas-pmi/${meta.id}/edit`}
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
