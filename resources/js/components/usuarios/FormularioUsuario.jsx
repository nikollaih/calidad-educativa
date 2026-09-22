import { useEffect, useState } from 'preact/hooks';
import Select from 'react-select';
import CAutocompleteFromArray from "@/components/shared/CAutocompleteFromArray.jsx";
import CPasswordInput from "@/components/shared/CPasswordInput.jsx";

export default function FormularioUsuario({ roles, institutionsWithoutRector, institutions, storeUrl, indexUrl, user }) {
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
        <div class="col-md-12 bg-white rounded-xl !border border-custom-blue-light">
            <div class="p-3">
                <h1 class="text-custom-blue-dark">{Boolean(user) ? 'Edición de usuarios' : 'Crear Usuario'}</h1>
                <div class="card-body">
                    <form action={storeUrl} method="POST" class="w-full">
                        {/* CSRF */}
                        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').content} />
                        {/* Si hay usuario, simula PATCH */}
                        {user && (
                            <input type="hidden" name="_method" value="PATCH" />
                        )}

                        {/* Grid principal: 1 col en móvil, 2 cols en md+ */}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {/* Nombre */}
                            <div class="mb-3">
                                <label htmlFor="name" class="block text-sm mb-2 ml-4">Nombre</label>
                                <input
                                    value={user?.name}
                                    type="text"
                                    name="name"
                                    class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                    required
                                />
                            </div>

                            {/* Email */}
                            <div class="mb-3">
                                <label htmlFor="email" class="block text-sm mb-2 ml-4">Email</label>
                                <input
                                    value={user?.email}
                                    type="email"
                                    name="email"
                                    class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                                    required
                                />
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

                            {/* Roles — ocupa las 2 columnas */}
                            <div class="mb-3 md:col-span-2">
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
                                    className="!border border-custom-blue-dark rounded-pill p-1"
                                    classNamePrefix="select"
                                    placeholder="Selecciona uno o varios roles..."
                                    onChange={handleRolesChange}
                                />
                            </div>

                            {/* Institución del rector — ocupa las 2 columnas */}
                            {showInstitutionField && (
                                <div class="mb-3 md:col-span-2">
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

                            {/* Institución a la que pertenece — ocupa las 2 columnas */}
                            {!showInstitutionField && showInstitutionToBelong && (
                                <div class="mb-3 md:col-span-2">
                                    <label htmlFor="institucion_id" class="block text-sm mb-2 ml-4">Institución a la que pertenece</label>
                                    <CAutocompleteFromArray
                                        key={institucionSelected || 'no-institucion'}
                                        data={institutions}
                                        fieldName={"institucion_id"}
                                        initialValue={institucionSelected}
                                        orderBy={{ field: 'indice', direction: 'asc' }}
                                        searchFields={['nombre', 'nit']}
                                        labelFields={['nombre', 'nit']}
                                    />
                                </div>
                            )}

                        </div>

                        {/* Botones */}
                        <div class="flex w-full justify-center gap-2 mt-2">
                            <button type="submit" class="border bg-blue-500 text-white p-2 rounded-pill">Guardar</button>
                            <a href={indexUrl} class="border bg-blue-500 text-white p-2 rounded-pill">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
