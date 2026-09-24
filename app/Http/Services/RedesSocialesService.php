<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;

class RedesSocialesService {
    // Permite almacenar un adjunto
    public function syncRedesSociales(Array $redesSociales, Model $modelo ) {
        $ids = [];
        // Recorre los registros
        foreach ($redesSociales as $key => $redSocial) {
            if (!is_array($redSocial) || empty($redSocial) || empty($redSocial['url'])) {
                continue;
            }
            // Syncroniza el registro
            $redSocialCreated = $modelo->redesSociales()->updateOrCreate($redSocial, $redSocial);

            array_push($ids, $redSocialCreated->id);
        }
        // Elimina los sobrantes
        $modelo->redesSociales()->whereNotIn('id', $ids)->delete();

    }
}
