import { useState, useRef, useEffect } from 'preact/hooks';

const CActionsDropdown = ({ text, icon, children }) => {
    const [open, setOpen] = useState(false);
    const ref = useRef(null);

    useEffect(() => {
        const handler = (e) => {
            if (ref.current && !ref.current.contains(e.target)) setOpen(false);
        };
        document.addEventListener('mousedown', handler);
        return () => document.removeEventListener('mousedown', handler);
    }, []);

    return (
        <div class="relative inline-block" ref={ref}>
            {/* Trigger button */}
            <button
                onClick={() => setOpen(!open)}
                class="inline-flex items-center gap-2 px-2 py-1 bg-white text-custom-blue-light text-sm font-medium !border border-custom-blue-light rounded-full transition-colors"
            >
                {icon && <i class={icon} />}
                {text}
            </button>

            {/* Dropdown menu */}
            {open && (
                <div class="absolute right-0 z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                    <div class="py-1" onClick={() => setOpen(false)}>
                        {children}
                    </div>
                </div>
            )}
        </div>
    );
};

export default CActionsDropdown;
