// src/ui/CBackButton.jsx
import { h } from 'preact';
const CBackButton = ({ to = -1, label = 'Volver' }) => {
    const handleClick = () => {
        if (typeof to === 'number') {
            window.history.go(to);
        } else {
            window.history.go(to);
        }
    };

    return (
        <div class="container pt-3">
            <button
                type="button"
                className="btn btn-outline-primary d-flex align-items-center gap-2"
                onClick={handleClick}
            >
                <i className="fa fa-arrow-left" aria-hidden="true"></i>
                {label}
            </button>
        </div>
    );
};

export default CBackButton;
