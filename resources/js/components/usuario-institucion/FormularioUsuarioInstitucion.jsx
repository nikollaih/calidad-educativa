import { useEffect, useState } from 'preact/hooks';
import Select from 'react-select';
import CNewPasswordInput from "@/components/shared/CNewPasswordInput.jsx";

export default function FormularioUsuario({ roles, institutionsWithoutRector,institutions, storeUrl, indexUrl, user }) {
    const [selectedRoles, setSelectedRoles] = useState([]);
    const handleRolesChange = (selected) => {
        setSelectedRoles(selected || []);
    };
    useEffect(() => {
        if (user?.roles?.length) {
            const mappedRoles = user.roles.map(role => ({
                value: role.name,
                label: role.name_translated,
                permissions: role.permissions
            }));
            setSelectedRoles(mappedRoles);
        }
    }, [user]);
    return (
        <div class="col-md-12">
            <div class="!border border-custom-blue-light rounded-lg bg-white p-3">
                <h1 class="text-custom-blue-dark">{Boolean(user) ? 'Edición de usuarios' : 'Crear Usuario'}</h1>
                <div class="card-body">
                    <div class="col-md-12">
                        <form action={storeUrl} method="POST">
                            {/* CSRF */}
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').content} />
                            {/* Si hay usuario, simula PATCH */}
                            {user && (
                                <input type="hidden" name="_method" value="PATCH" />
                            )}
                            {/* Contenedor grid con 1 columna en móvil y 2 en pantallas medianas+ */}
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {/* Nombre */}
                                <div className="mb-3">
                                    <label htmlFor="name" className="block text-xs  mb-2 ml-4">
                                        NOMBRE
                                    </label>
                                    <input
                                        value={user?.name}
                                        type="text"
                                        name="name"
                                        className="w-full px-3 py-2 !border border-custom-blue-dark rounded-pill focus:outline-none focus:ring-1 focus:ring-custom-blue-dark  focus:border-transparent"
                                        required
                                    />
                                </div>

                                {/* Email */}
                                <div className="mb-3">
                                    <label htmlFor="email" className="block text-xs mb-2 ml-4">
                                        EMAIL
                                    </label>
                                    <input
                                        value={user?.email}
                                        type="email"
                                        name="email"
                                        className="w-full px-3 py-2 !border border-custom-blue-dark rounded-pill focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent"
                                        required
                                    />
                                </div>

                                {/* Contraseña */}
                                <div className="mb-3">
                                    <label htmlFor="password" className="block text-xs mb-2 ml-4">
                                        CONTRASEÑA
                                    </label>
                                    <CNewPasswordInput
                                        name="password"
                                        isRequired={!user}
                                        minLength={8}
                                        maxLength={40}
                                        className="w-full px-3 py-2 !border border-custom-blue-dark rounded-pill focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent"
                                    />
                                </div>

                                {/* Confirmar contraseña */}
                                <div className="mb-3">
                                    <label htmlFor="password_confirmation" className="block text-xs mb-2 ml-4">CONFIRMAR CONTRASEÑA</label>
                                    <CNewPasswordInput
                                        name="password_confirmation"
                                        isRequired={!user}
                                        minLength={8}
                                        maxLength={40}
                                        className="w-full px-3 py-2 !border border-custom-blue-dark rounded-pill focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent"
                                    />
                                </div>
                                {/* Roles (react-select multiple) */}
                                <div class="mb-3">
                                    <label class="block text-xs mb-2 ml-4">ROLES</label>
                                    <div className="!border border-custom-blue-dark rounded-pill px-2">
                                    <Select
                                        isMulti
                                        name="roles[]"
                                        value={selectedRoles}
                                        options={roles.map(role => ({
                                            value: role.name,
                                            label: role.name_translated,
                                            permissions: role.permissions
                                        }))}
                                        styles={{
                                            control: (base, state) => ({
                                                ...base,
                                                border: 'none',
                                                boxShadow: 'none',
                                                borderRadius: '50px', // rounded-pill
                                                minHeight: '38px',
                                                '&:hover': {
                                                    border: 'none',
                                                },
                                            }),
                                            valueContainer: (base) => ({
                                                ...base,
                                                padding: '2px 12px',
                                            }),
                                            multiValue: (base) => ({
                                                ...base,
                                                borderRadius: '9999px',
                                            }),
                                        }}
                                        className="!border-0  border-custom-blue-dark rounded-pill"
                                        classNamePrefix="select"
                                        placeholder="Selecciona uno o varios roles..."
                                        onChange={handleRolesChange}
                                    />
                                    </div>
                                </div>
                            </div>
                            <div class={"flex w-full justify-end gap-1"}>
                                {/* Botones */}
                                <button type="submit" className="px-3 py-2 bg-custom-blue-dark text-white rounded-pill"><i class="fa-regular fa-floppy-disk px-1"></i>Guardar</button>
                                <a href={indexUrl} className="px-3 py-2 bg-custom-blue-dark text-white rounded-pill "><i class="fa-solid fa-xmark px-1"></i>Cancelar</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}
