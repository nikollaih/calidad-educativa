// resources/js/utils/auth.js

/**
 * Utilidad para acceder a la información de autenticación
 * cargada desde el backend (Spatie Permissions)
 */
export const auth = {
    /**
     * Obtiene el usuario autenticado
     */
    user() {
        return window.auth?.user || null;
    },

    /**
     * Obtiene todos los permisos del usuario
     */
    permissions() {
        return window.auth?.permissions || [];
    },

    /**
     * Obtiene todos los roles del usuario
     */
    roles() {
        return window.auth?.roles || [];
    },

    /**
     * Verifica si el usuario tiene un permiso específico
     * @param {string} permission - Nombre del permiso
     */
    can(permission) {
        return this.permissions().includes(permission);
    },

    /**
     * Verifica si el usuario tiene alguno de los permisos
     * @param {string[]} permissions - Array de nombres de permisos
     */
    canAny(permissions) {
        return permissions.some(permission => this.can(permission));
    },

    /**
     * Verifica si el usuario tiene todos los permisos
     * @param {string[]} permissions - Array de nombres de permisos
     */
    canAll(permissions) {
        return permissions.every(permission => this.can(permission));
    },

    /**
     * Verifica si el usuario tiene un rol específico
     * @param {string} role - Nombre del rol
     */
    hasRole(role) {
        return this.roles().includes(role);
    },

    /**
     * Verifica si el usuario tiene alguno de los roles
     * @param {string[]} roles - Array de nombres de roles
     */
    hasAnyRole(roles) {
        return roles.some(role => this.hasRole(role));
    },

    /**
     * Verifica si el usuario tiene todos los roles
     * @param {string[]} roles - Array de nombres de roles
     */
    hasAllRoles(roles) {
        return roles.every(role => this.hasRole(role));
    },

    /**
     * Verifica si el usuario está autenticado
     */
    check() {
        return this.user() !== null;
    },

    /**
     * Verifica si el usuario es guest (no autenticado)
     */
    guest() {
        return !this.check();
    }
};

export default auth;
