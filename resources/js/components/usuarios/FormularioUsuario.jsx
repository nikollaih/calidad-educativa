import { useEffect, useState } from 'preact/hooks';
import Select from 'react-select';
import CAutocompleteFromArray from "@/components/shared/CAutocompleteFromArray.jsx";
import CPasswordInput from "@/components/shared/CPasswordInput.jsx";

export default function FormularioUsuario({ roles, institutionsWithoutRector, storeUrl, indexUrl, user }) {
    const [selectedRoles, setSelectedRoles] = useState([]);
    const [showInstitutionField, setShowInstitutionField] = useState(false);
    const [institucionSelected,setInstitucionSelected] = useState(undefined);

    const handleRolesChange = (selected) => {
        setSelectedRoles(selected || []);
        const hasRector = (selected || []).some(role => role.value === 'rector');
        setShowInstitutionField(hasRector);
    };
    useEffect(() => {
        if (user?.roles?.length) {
            const mappedRoles = user.roles.map(role => ({
                value: role.name,
                label: role.name_translated
            }));
            setSelectedRoles(mappedRoles);
            // Si el usuario tiene el rol 'rector', muestra el campo
            const hasRector = mappedRoles.some(r => r.value === 'rector');
            setShowInstitutionField(hasRector);
            if(user?.institucion){
                setInstitucionSelected(user.institucion.id);
            }
        }
    }, [user]);


    return (
        <div class="col-md-12">
            <div class="card">
                <h1 class="card-header">{Boolean(user) ? 'Edición de usuarios' : 'Crear Usuario' }</h1>
                <div class="card-body">
                    <div class="col-md-12">
                        <form action={storeUrl} method="POST">
                            {/* CSRF */}
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').content} />
                             {/* Si hay usuario, simula PATCH */}
                            {user && (
                                <input type="hidden" name="_method" value="PATCH" />
                            )}

                            {/* Nombre */}
                            <div class="mb-3">
                                <label htmlFor="name" class="form-label">Nombre</label>
                                <input value={user?.name} type="text" name="name" class="form-control" required />
                            </div>

                            {/* Email */}
                            <div class="mb-3">
                                <label htmlFor="email" class="form-label">Email</label>
                                <input value={user?.email} type="email" name="email" class="form-control" required />
                            </div>

                            {/* Contraseña */}
                            <div class="mb-3">
                                <label htmlFor="password" class="form-label">Contraseña</label>
                                <CPasswordInput
                                    name="password"
                                    isRequired={true}
                                    minLength={8}
                                    maxLength={40}
                                    />
                            </div>

                            {/* Confirmar contraseña */}
                            <div class="mb-3">
                                <label htmlFor="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                <CPasswordInput
                                    name="password_confirmation"
                                    isRequired={true}
                                    minLength={8}
                                    maxLength={40}
                                />
                            </div>

                            {/* Roles (react-select multiple) */}
                            <div class="mb-3">
                                <label class="form-label">Roles</label>
                                <Select
                                    isMulti
                                    name="roles[]"
                                    value={selectedRoles}
                                    options={roles.map(role => ({
                                        value: role.name,
                                        label: role.name_translated
                                    }))}
                                    className="basic-multi-select"
                                    classNamePrefix="select"
                                    placeholder="Selecciona uno o varios roles..."
                                    onChange={handleRolesChange}
                                />
                            </div>
                            {/* Campo visible solo si contiene 'rector' */}
                            {showInstitutionField && (
                                <div class="mb-3">
                                    <label htmlFor="institucion_id" class="form-label">Institución del rector</label>
                                    <CAutocompleteFromArray
                                            key={institucionSelected || 'no-institucion'}
                                            data={institutionsWithoutRector}
                                            fieldName={"institucion_id"}
                                            initialValue={institucionSelected}
                                            orderBy={{ field: 'indice', direction: 'asc' }}
                                            searchFields={['nombre', 'nit']}
                                            labelFields={['nombre','nit']}
                                        />
                                </div>
                            )}


                            {/* Botones */}
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <a href={indexUrl} class="btn btn-secondary ms-2">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}
