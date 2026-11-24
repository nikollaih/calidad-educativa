<?php
namespace App\Http\Requests\PMI;

use App\Http\Requests\Concerns\AuthorizesControllerActions;
use Illuminate\Foundation\Http\FormRequest;

class PMIRequest extends FormRequest {
    use AuthorizesControllerActions;

    /**
     * Mapeo de métodos a permisos y roles
     */
    protected function authorizationMap(): array {
        return [
            'index' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'actividadesByPmi' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'create' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'store' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'edit' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'presentarPmi' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'exportarPmi' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'exportarCumplimientoPmi' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'exportarSintesisPmi' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'exportarEvaluacionPmi' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'editFactorCritico' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'pmiEliminarComentario' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'pmiMarcarComentarioResuelto' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'storeActividadAvance' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'show' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'avancesActividadByActividadId' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
            'actualizarFactorCritico' => [
                'roles' => ['rector', 'super_admin'],
                'permissions' => ['s-pmi-gestionar'],
            ],
        ];
    }

    public function rules(): array {
        return [
        ];
    }

    public function filters(): callable {
        $user = $this->user();

        return function ($query) use ($user, $municipioId) {
            // Valida jerarquicamente, primero si es un rector, en caso contrario valida si tiene
            // permiso de pertenecer a una institucion, en ambos casos aplica el filtro
            if ($user->hasRole('rector')) {
                $query->where('rector_id', $user->id);
            } else if ($user->hasPermissionTo('s-institucion-pertenecer_una')) {
                $query->whereHas('users', function ($q) use ($user) {
                    $q->where('users.id', $user->id)
                    ->where('institucion_user.is_active', true);
                });
            }
            return $query;
        };
    }
}
