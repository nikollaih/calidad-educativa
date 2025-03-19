<?php

namespace App\Models\Traits;

use App\Models\RedSocial;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Relacion con redes sociales
 */
trait RedSocialMorphRelacion {

    /**
     * Obtener todas las redes sociales
     */
    public function redesSociales(): MorphMany {
        return $this->morphMany(RedSocial::class, 'socializable');
    }

    /**
     * Obtiene una red social
     */
    public function redSocial(): MorphOne {
        return $this->morphOne(RedSocial::class, 'socializable');
    }
}

