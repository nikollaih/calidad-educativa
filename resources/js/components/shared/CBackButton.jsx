// src/ui/CBackButton.jsx
import { h } from 'preact';
const CBackButton = ({
                         to = -1,
                         label = 'Volver',
                         isContainer = true
}) => {
    const handleClick = () => {
        if (typeof to === 'number') {
            window.history.go(to);
        } else {
            window.location.href = to;
        }
    };

    return (
        <div class={isContainer ? 'container' : ' '}>
            <button
                type="button"
                className="d-flex align-items-center gap-2 text-custom-blue-light font-medium"
                onClick={handleClick}
            >
                <i className="fa-solid fa-angle-left" aria-hidden={true}></i>
                {label}
            </button>
        </div>
    );
};

export default CBackButton;
