<?php
namespace App\Http\Requests;

use App\Http\Requests\Concerns\AuthorizesControllerActions;
use Illuminate\Foundation\Http\FormRequest;

class SedeRequest extends FormRequest {
    use AuthorizesControllerActions;

    /**
     * Mapeo de métodos a permisos y roles
     */
    protected function authorizationMap(): array {
        return [
            'store,create' => [
                'permissions' => ['s-institucion-crear'],
                'roles' => ['rector'],
            ],
            'update,edit' => [
                'permissions' => ['s-institucion-editar'],
                'roles' => ['rector'],
            ],
            'destroy' => [
                'permissions' => ['s-institucion-eliminar'],
                'roles' => ['rector'],
            ],
            'index' => [
                'permissions' => ['s-institucion-ver'],
                'roles' => ['rector'],
            ],
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

            if ($user->hasRole('rector')) {
                $query->where('rector_id', $user->id);
            }

            return $query;
        };
    }
}
