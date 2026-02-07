import { useEffect, useState } from 'preact/hooks';
import Select from 'react-select';
import CAutocompleteFromArray from "@/components/shared/CAutocompleteFromArray.jsx";
import CPasswordInput from "@/components/shared/CPasswordInput.jsx";

export default function FormularioUsuario({ roles, institutionsWithoutRector,institutions, storeUrl, indexUrl, user }) {
    const [selectedRoles, setSelectedRoles] = useState([]);
    const [showInstitutionField, setShowInstitutionField] = useState(false);
    const [institucionSelected, setInstitucionSelected] = useState(undefined);
    const [showInstitutionToBelong, setShowInstitutionToBelong] = useState(false);
    const [institucionToBelongSelected, setInstitucionToBelongSelected] = useState(undefined);


    const handleRolesChange = (selected) => {
        setSelectedRoles(selected || []);
        const hasRector = (selected || []).some(role => role.value === 'rector');
        const canBelongToInstitution = ((selected || []).some(role => (role.permissions || []).some(permission => permission.name === 's-institucion-pertenecer_una')));
        setShowInstitutionField(hasRector);
        setShowInstitutionToBelong(canBelongToInstitution);
    };
    useEffect(() => {
        if (user?.roles?.length) {
            const mappedRoles = user.roles.map(role => ({
                value: role.name,
                label: role.name_translated,
                permissions: role.permissions
            }));
            setSelectedRoles(mappedRoles);
            // Si el usuario tiene el rol 'rector', muestra el campo
            const hasRector = mappedRoles.some(r => r.value === 'rector');
            const canBelongsToInstitution = ((mappedRoles || []).some(role => (role.permissions || []).some(permission => permission.name === 's-institucion-pertenecer_una')));
            setShowInstitutionField(hasRector);
            setShowInstitutionToBelong(canBelongsToInstitution);
            if (user?.institucion) {
                setInstitucionSelected(user.institucion.id);
            } else if (user?.instituciones) {
                setInstitucionSelected(user.instituciones?.[0]?.id);
            }
        }
    }, [user]);


    return (
        <div class="col-md-12">
            <div class="card">
                <h1 class="card-header">{Boolean(user) ? 'Edición de usuarios' : 'Crear Usuario'}</h1>
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
                                <label htmlFor="name" class="block text-sm mb-2 ml-4">Nombre</label>
                                <input value={user?.name} type="text" name="name" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" required />
                            </div>

                            {/* Email */}
                            <div class="mb-3">
                                <label htmlFor="email" class="block text-sm mb-2 ml-4">Email</label>
                                <input value={user?.email} type="email" name="email" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" required />
                            </div>

                            {/* Contraseña */}
                            <div class="mb-3">
                                <label htmlFor="password" class="block text-sm mb-2 ml-4">Contraseña</label>
                                <CPasswordInput
                                    name="password"
                                    isRequired={!user}
                                    minLength={8}
                                    maxLength={40}
                                />
                            </div>

                            {/* Confirmar contraseña */}
                            <div class="mb-3">
                                <label htmlFor="password_confirmation" class="block text-sm mb-2 ml-4">Confirmar Contraseña</label>
                                <CPasswordInput
                                    name="password_confirmation"
                                    isRequired={!user}
                                    minLength={8}
                                    maxLength={40}
                                />
                            </div>

                            {/* Roles (react-select multiple) */}
                            <div class="mb-3">
                                <label class="block text-sm mb-2 ml-4">Roles</label>
                                <Select
                                    isMulti
                                    name="roles[]"
                                    value={selectedRoles}
                                    options={roles.map(role => ({
                                        value: role.name,
                                        label: role.name_translated,
                                        permissions: role.permissions
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
                                    <label htmlFor="institucion_id" class="block text-sm mb-2 ml-4">Institución del rector</label>
                                    <CAutocompleteFromArray
                                        key={institucionSelected || 'no-institucion'}
                                        data={institutionsWithoutRector}
                                        fieldName={"institucion_id"}
                                        initialValue={institucionSelected}
                                        orderBy={{ field: 'indice', direction: 'asc' }}
                                        searchFields={['nombre', 'nit']}
                                        labelFields={['nombre', 'nit']}
                                    />
                                </div>
                            )}
                            {!showInstitutionField && showInstitutionToBelong && (
                                <div className="mb-3">
                                    <label htmlFor="institucion_id" className="block text-sm mb-2 ml-4">Institución a la que pertenece</label>
                                    <CAutocompleteFromArray
                                        key={institucionSelected || 'no-institucion'}
                                        data={institutions}
                                        fieldName={"institucion_id"}
                                        initialValue={institucionSelected}
                                        orderBy={{field: 'indice', direction: 'asc'}}
                                        searchFields={['nombre', 'nit']}
                                        labelFields={['nombre', 'nit']}
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
