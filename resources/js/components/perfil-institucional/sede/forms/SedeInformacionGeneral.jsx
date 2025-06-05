import { h } from 'preact';
import { useEffect, useRef, useState } from 'preact/hooks';

export default function SedeInformacionGeneral({  sede = {},
                            }) {
    const [tipoSede, setTipoSede] = useState(sede?.parentSede == null ? 'Principal' : 'Adscrita a una principal');

    return (
        <>
        </>
    );
}
