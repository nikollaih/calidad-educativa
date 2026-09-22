<?php
namespace App\Http\Requests;

use App\Http\Requests\Concerns\AuthorizesControllerActions;
use Illuminate\Foundation\Http\FormRequest;

class InstitucionRequest extends FormRequest {
    use AuthorizesControllerActions;

    /**
     * Mapeo de métodos a permisos y roles
     */
    protected function authorizationMap(): array {
        return [
            'usuariosInstitucionByRector' => [
                'roles' => ['rector']
            ],
            'store' => [
                'permissions' => ['s-institucion-crear'],
                'roles' => ['rector'],
            ],
            'update' => [
                'permissions' => ['s-institucion-editar'],
                'roles' => ['rector'],
            ],
            'destroy' => [
                'permissions' => ['s-institucion-eliminar'],
                'roles' => ['rector'],
            ],
            'autoevaluacionesVer,autoevaluaciones'=> [
                'permissions' => [
                    's-institucion-editar',
                    's-autoevaluacion-calificar-gestion_directiva',
                    's-autoevaluacion-calificar-gestion_academica',
                    's-autoevaluacion-calificar-gestion_admin_financi',
                    's-autoevaluacion-calificar-gestion_comunidad'
                 ],
                'roles' => ['rector'],
            ],
            'index' => [
                'permissions' => ['s-institucion-ver','s-institucion-pertenecer_una'],
                'roles' => ['rector'],
            ],
            'autoevaluacionesCrear,autoevaluacionesEditar,autoevaluacionesAlmacenar,autoevaluacionesAlmacenarActualizacion' => [
                'permissions' => [
                    's-institucion-editar',
                    's-autoevaluacion-calificar-gestion_directiva',
                    's-autoevaluacion-calificar-gestion_academica',
                    's-autoevaluacion-calificar-gestion_admin_financi',
                    's-autoevaluacion-calificar-gestion_comunidad',
                ],
                'roles' => ['rector'],
            ]
        ];
    }

    public function rules(): array {
        return [
            'municipio_id' => ['nullable', 'integer'],
        ];
    }

    public function filters(): callable {
        $user = $this->user();
        $municipioId = $this->query('municipio_id');

        return function ($query) use ($user, $municipioId) {
            if ($municipioId) {
                $query->where('municipio_id', $municipioId);
            }
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
