import { h } from 'preact';
import { useEffect, useState } from "preact/hooks";
import CPagination from '@/components/shared/CPagination.jsx';
import CAddButton from "@/components/layout/components/buttons/CAddButton.jsx";
import CTableActionButton from "@/components/layout/components/buttons/CTableActionButton.jsx";

export default function IndexObjetivoPMI({ agregarUrl, objetivosPaginated = {}, csrfToken = '', canEditParametros = false }) {
    const [objetivos, setObjetivos] = useState([]);

    useEffect(() => {
        setObjetivos(objetivosPaginated.data);
    }, []);
    const handleAgregarClick = () => {
        window.location.href = agregarUrl;
    };
    return (
        <div class="col-md-12 bg-white rounded-xl !border border-custom-blue-light py-3">
            <div class={'p-3'}>
                <h2 class="mb-4 text-custom-blue-dark">Objetivos del PMI</h2>
                {canEditParametros && (
                    <CAddButton
                    onClick={handleAgregarClick}
                    />
                )}

                <table class="table">
                    <thead>
                        <tr>
                            <th>DESCRIPCIÓN</th>
                            {canEditParametros && <th>ACCIONES</th>}
                        </tr>
                    </thead>
                    <tbody>
                        {objetivos.map((objetivo) => (
                            <tr key={objetivo.id}>
                                <td>{objetivo.descripcion}</td>
                                {canEditParametros && (
                                    <td>
                                        <CTableActionButton
                                            title={'Ver detalles'}
                                            route={`/objetivo-pmi/${objetivo.id}`}
                                            iconClass={'fas fa-eye'}
                                            hoverIconColor={'text-custom-primary'}
                                        />
                                        <CTableActionButton
                                            title={'Editar'}
                                            route={`/objetivo-pmi/${objetivo.id}/edit`}
                                            iconClass={'fas fa-edit'}
                                            hoverIconColor={'text-custom-primary'}
                                        />
                                    </td>
                                )}
                            </tr>
                        ))}
                    </tbody>
                </table>
                <CPagination pagination={objetivosPaginated} />
            </div>
        </div>
    );
}
