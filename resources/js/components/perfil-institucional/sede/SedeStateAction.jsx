import { h } from 'preact';
import { useState } from 'preact/hooks';

const TEXTAREA_LIMIT = 1000;
const countCharacters = (value) => Array.from(String(value ?? '').replace(/\r\n|\r|\n/g, '\r\n')).length;

export default function SedeStateAction({
    stateSlug = 'abierta',
    actionUrl = '#',
    csrfToken = '',
    sedeId = '',
    sedeName = 'sede',
    openOnLoad = false,
    oldObservation = '',
    validationErrors = {},
}) {
    const [isOpen, setIsOpen] = useState(openOnLoad);
    const [observation, setObservation] = useState(oldObservation);
    const isClosing = stateSlug === 'abierta';
    const nextState = isClosing ? 'cerrada' : 'abierta';
    const actionLabel = isClosing ? 'Cerrar sede' : 'Abrir sede';

    return (
        <>
            <button
                type="button"
                className="border bg-blue-500 text-white p-2 rounded-pill btn-sm"
                onClick={() => setIsOpen(true)}
            >
                <i className={`fas ${isClosing ? 'fa-lock' : 'fa-lock-open'} me-1`} />
                {actionLabel}
            </button>

            {isOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-3">
                    <div className="w-full max-w-xl rounded-xl bg-white p-4 shadow-xl">
                        <div className="mb-3 flex items-center justify-between">
                            <h2 className="mb-0 text-lg font-semibold text-custom-primary">
                                {actionLabel}: {sedeName}
                            </h2>
                            <button type="button" className="btn-close" aria-label="Cerrar" onClick={() => setIsOpen(false)} />
                        </div>

                        <p>
                            Para {isClosing ? 'cerrar' : 'abrir'} esta sede, adjunta el acto administrativo y registra una observación.
                        </p>

                        <form action={actionUrl} method="POST" encType="multipart/form-data">
                            <input type="hidden" name="_token" value={csrfToken} />
                            <input type="hidden" name="_sede_id" value={sedeId} />
                            <input type="hidden" name="state_slug" value={nextState} />

                            <div className="mb-3">
                                <label className="block text-sm mb-2 ml-4" htmlFor={`state-act-${sedeId}`}>
                                    Acto administrativo (PDF) <span className="text-danger">*</span>
                                </label>
                                <input
                                    id={`state-act-${sedeId}`}
                                    type="file"
                                    name="administrative_act_file"
                                    accept="application/pdf,.pdf"
                                    required
                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                />
                                {validationErrors.administrativeActFile && (
                                    <small className="text-danger">{validationErrors.administrativeActFile}</small>
                                )}
                            </div>

                            <div className="mb-3">
                                <label className="block text-sm mb-2 ml-4" htmlFor={`state-observation-${sedeId}`}>
                                    Observación <span className="text-danger">*</span>
                                </label>
                                <textarea
                                    id={`state-observation-${sedeId}`}
                                    name="observation"
                                    className="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-xl"
                                    rows="3"
                                    maxLength={TEXTAREA_LIMIT}
                                    required
                                    value={observation}
                                    onInput={(event) => setObservation(event.currentTarget.value)}
                                />
                                <small className={validationErrors.observation ? 'text-danger' : 'text-muted'}>
                                    {countCharacters(observation)} / {TEXTAREA_LIMIT} caracteres
                                    {validationErrors.observation && ` — ${validationErrors.observation}`}
                                </small>
                            </div>

                            {validationErrors.stateSlug && <div className="alert alert-danger">{validationErrors.stateSlug}</div>}

                            <div className="flex justify-end gap-2">
                                <button type="button" className="btn btn-outline-secondary" onClick={() => setIsOpen(false)}>
                                    Cancelar
                                </button>
                                <button type="submit" className="border bg-blue-500 text-white p-2 rounded-pill">
                                    Confirmar {isClosing ? 'cierre' : 'apertura'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </>
    );
}
