import { h } from 'preact';
const CInstitutionNavigations = ({
                         institucionId = -1,
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
                className="btn btn-outline-primary d-flex align-items-center gap-2"
                onClick={handleClick}
            >
                <i className="fa fa-arrow-left" aria-hidden="true"></i>
                {label}
            </button>
        </div>
    );
};

export default CInstitutionNavigations;
