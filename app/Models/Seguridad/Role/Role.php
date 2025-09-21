<?php

namespace App\Models\Seguridad\Role;

use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Role as BaseRole;
/**
 * Representa un rol dentro del sistema.
 * @package App\Models\Seguridad\Role
 * @version Sept 21, 2025, 12:56:00 pm -05
 * @property \Illuminate\Database\Eloquent\Collection               $permissions
 * @property string $name
 * @property string $guard_name
 */
class Role extends BaseRole {
    /**
     * Atributos que se añaden automáticamente al JSON.
     *
     * @var array<int, string>
     */
    protected $appends = ['name_translated'];

    /**
     * Traducción del nombre del rol.
     *
     * @return string
     */
    public function getNameTranslatedAttribute(): string {
        $key = "roles.{$this->name}";

        // Si existe traducción, la retorna; de lo contrario, devuelve el name original
        return Lang::has($key) ? __($key) : $this->name;
    }
}

