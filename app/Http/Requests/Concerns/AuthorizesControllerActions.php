<?php
namespace App\Http\Requests\Concerns;

use App\Http\Requests\Concerns\Enums\OperatorEnum;

trait AuthorizesControllerActions {
    /**
     * Mapeo de métodos del controlador a permisos y roles
     *
     * @return array
     */
    abstract protected function authorizationMap(): array;

    /**
     * Determina si el usuario está autorizado para esta acción
     *
     * @return bool
     */
    public function authorize(): bool {
        $method = $this->route()->getActionMethod();
        $authMap = $this->normalizeAuthorizationMap();
        $config = $authMap[$method] ?? null;

        // Sin configuración específica = permitir acceso
        if (!$config) {
            return true;
        }

        // Verificar si requiere autenticación
        $requiresAuth = data_get($config, 'requires_auth', true);

        if (!$requiresAuth) {
            return true; // No requiere autenticación
        }

        // Si requiere autenticación pero no está autenticado
        if (!auth()->check()) {
            return false;
        }

        return $this->evaluateAuthorization($this->user(), $config);
    }

    /**
     * Normaliza el authorizationMap para soportar múltiples métodos con la misma configuración
     *
     * @return array
     */
    protected function normalizeAuthorizationMap(): array {
        $normalized = [];

        foreach ($this->authorizationMap() as $key => $config) {
            // Si la key es un array, aplicar la misma configuración a todos los métodos
            if (is_array($key)) {
                foreach ($key as $method) {
                    $normalized[$method] = $config;
                }
            } else {
                $normalized[$key] = $config;
            }
        }

        return $normalized;
    }

    /**
     * Evalúa la autorización basada en permisos y roles
     *
     * @param \App\Models\User $user
     * @param array $config
     * @return bool
     */
    protected function evaluateAuthorization($user, array $config): bool {
        $operator = data_get($config, 'operator', OperatorEnum::Or);

        $hasPermission = $this->checkPermissions($user, $config);
        $hasRole = $this->checkRoles($user, $config);

        return match ($operator) {
            OperatorEnum::And => $hasPermission && $hasRole,
            OperatorEnum::Or => $hasPermission || $hasRole,
            default => $hasPermission || $hasRole,
        };
    }

    /**
     * Verifica si el usuario tiene los permisos requeridos
     *
     * @param \App\Models\User $user
     * @param array $config
     * @return bool
     */
    protected function checkPermissions($user, array $config): bool {
        if (!isset($config['permissions'])) {
            return true;
        }

        return $user->hasAnyPermission($config['permissions']);
    }

    /**
     * Verifica si el usuario tiene los roles requeridos
     *
     * @param \App\Models\User $user
     * @param array $config
     * @return bool
     */
    protected function checkRoles($user, array $config): bool {
        if (!isset($config['roles'])) {
            return true;
        }

        return $user->hasAnyRole($config['roles']);
    }
}
