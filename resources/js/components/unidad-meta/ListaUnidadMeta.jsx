import { h } from "preact";
import { useState } from "preact/hooks";
import CPagination from '@/components/shared/CPagination.jsx';

export default function ListaUnidadMeta({
    agregarUrl,
    unidadesMeta,
    csrfToken = "",
    canEditParametros = false,
}) {
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState("agregar"); // 'agregar' o 'editar'
    const [currentUnidadMeta, setCurrentUnidadMeta] = useState(null);
    const [unidadParcial, setDescripcion] = useState(""); // Se convierte en "unidad parcial"
    // Agregado: Estado para la nueva "unidad total"
    const [unidadTotal, setUnidadTotal] = useState("");

    const handleAgregarClick = () => {
        setModalMode("agregar");
        setDescripcion(""); // Limpiar "unidad parcial"
        // Agregado: Limpiar "unidad total"
        setUnidadTotal("");
        setCurrentUnidadMeta(null);
        setShowModal(true);
    };

    const handleEditarClick = (unidadMeta) => {
        setModalMode("editar");
        setDescripcion(unidadMeta.unidad_parcial || "");
        // Agregado: Cargar el valor de "unidad total" al editar
        setUnidadTotal(unidadMeta.unidad_total || "");
        setCurrentUnidadMeta(unidadMeta);
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        // Eliminado: Ya no se usa 'codigo'
        setDescripcion(""); // Limpiar "unidad parcial"
        // Agregado: Limpiar "unidad total"
        setUnidadTotal("");
        setCurrentUnidadMeta(null);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        // Modificado: Validar que ambos campos (unidad parcial y unidad total) no estén vacíos
        if (!unidadParcial.trim() || !unidadTotal.trim()) {
            alert(
                "Por favor, completa ambos campos: Unidad Parcial y Unidad Total."
            );
            return; // Detiene el envío del formulario
        }

        const form = document.createElement("form");
        form.method = "POST";

        const tokenInput = document.createElement("input");
        tokenInput.type = "hidden";
        tokenInput.name = "_token";
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);

        // Input para la descripción (Unidad Parcial)
        const unidadParcialInput = document.createElement("input");
        unidadParcialInput.type = "hidden";
        unidadParcialInput.name = "unidad_parcial";
        unidadParcialInput.value = unidadParcial;
        form.appendChild(unidadParcialInput);

        // Agregado: Input para la unidad total
        const unidadTotalInput = document.createElement("input");
        unidadTotalInput.type = "hidden";
        unidadTotalInput.name = "unidad_total";
        unidadTotalInput.value = unidadTotal;
        form.appendChild(unidadTotalInput);

        if (modalMode === "agregar") {
            form.action = agregarUrl; // Usar la URL de agregar
        } else {
            // Editar unidadMeta existente
            form.action = `/unidades-meta/${currentUnidadMeta.id}`; // Usar la URL de edición
            const methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = "PUT"; // Laravel reconocerá esto como un PUT
            form.appendChild(methodInput);
        }

        document.body.appendChild(form);
        form.submit();
    };

    return (
        <div class="container mt-4">
            <h2 class="mb-4">Indicadores</h2>
            {canEditParametros && (
                <button class="border bg-blue-500  text-white p-2 rounded-pill mb-3" onClick={handleAgregarClick}>
                    Agregar indicador
                </button>
            )}

            <table class="table">
                <thead>
                    <tr>
                        {/* Eliminado: La columna 'Código' */}
                        <th>Unidad parcial</th>
                        <th>Unidad total</th>
                        {canEditParametros && <th>Acciones</th>}
                    </tr>
                </thead>
                <tbody>
                    {unidadesMeta.data.map((unidadMeta) => (
                        <tr key={unidadMeta.id}>
                            {/* Eliminado: La celda 'código' */}
                            <td>{unidadMeta.unidad_parcial}</td>
                            <td>{unidadMeta.unidad_total}</td>
                            {canEditParametros && (
                                <td>
                                    <button
                                        onClick={() =>
                                            handleEditarClick(unidadMeta)
                                        }
                                        className="border bg-blue-500  text-white p-2 rounded-pill btn-sm me-2"
                                    >
                                        Editar
                                    </button>
                                    <form
                                        action={`/unidades-meta/${unidadMeta.id}`}
                                        method="POST"
                                        style={{ display: "inline" }}
                                        onSubmit={(e) => {
                                            if (
                                                !confirm(
                                                    "¿Estás seguro de que quieres eliminar esta unidad de meta?"
                                                )
                                            ) {
                                                e.preventDefault();
                                            }
                                        }}
                                    >
                                        <input
                                            type="hidden"
                                            name="_token"
                                            value={csrfToken}
                                        />
                                        <input
                                            type="hidden"
                                            name="_method"
                                            value="DELETE"
                                        />
                                        <button
                                            type="submit"
                                            className="border bg-blue-500  text-white p-2 rounded-pill btn-sm"
                                        >
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            )}
                        </tr>
                    ))}
                </tbody>
            </table>

            <CPagination pagination={unidadesMeta} />
            {/* Modal */}
            {showModal && canEditParametros && (
                <div
                    class="modal d-block"
                    style={{ backgroundColor: "rgba(0,0,0,0.5)" }}
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {modalMode === "agregar"
                                        ? "Agregar unidad de meta"
                                        : "Editar unidad de meta"}
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    onClick={handleCloseModal}
                                ></button>
                            </div>
                            <form onSubmit={handleSubmit}>
                                <div class="modal-body">
                                    {/* Agregado: Campo para Unidad Parcial (era 'unidadParcial') */}
                                    <div class="mb-3">
                                        <label
                                            for="unidadParcial"
                                            class="block text-sm mb-2 ml-4"
                                        >
                                            Unidad parcial{" "}
                                            <span className="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <textarea
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                            id="unidadParcial"
                                            value={unidadParcial}
                                            onInput={(e) =>
                                                setDescripcion(e.target.value)
                                            }
                                            required
                                            rows="3"
                                        ></textarea>
                                    </div>

                                    {/* Agregado: Nuevo campo para Unidad Total */}
                                    <div class="mb-3">
                                        <label
                                            for="unidadTotal"
                                            class="block text-sm mb-2 ml-4"
                                        >
                                            Unidad total{" "}
                                            <span className="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <textarea
                                            class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                            id="unidadTotal"
                                            value={unidadTotal}
                                            onInput={(e) =>
                                                setUnidadTotal(e.target.value)
                                            }
                                            required
                                            rows="3"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="border bg-blue-500  text-white p-2 rounded-pill"
                                        onClick={handleCloseModal}
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        class="border bg-blue-500  text-white p-2 rounded-pill"
                                        // Modificado: Deshabilitar si ambos campos están vacíos
                                        disabled={
                                            !unidadParcial.trim() ||
                                            !unidadTotal.trim()
                                        }
                                    >
                                        {modalMode === "agregar"
                                            ? "Agregar"
                                            : "Guardar Cambios"}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
