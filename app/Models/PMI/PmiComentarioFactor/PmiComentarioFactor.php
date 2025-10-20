<?php

namespace App\Models\PMI\PmiComentarioFactor;

use App\Models\FactorCritico;
use App\Models\Pmi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PmiComentarioFactor extends Model {
    use HasFactory;
    // Relacion con el factor critico del comentario
    public function factor(): BelongsTo {
        return $this->belongsTo(FactorCritico::class,'factor_id');
    }
    // Relacion con el pmi que contiene el factor critico
    public function pmi(): BelongsTo {
        return $this->belongsTo(Pmi::class,'pmi_id');
    }
    // Relacion con el usuario que hizo el comentario
    public function autor(): BelongsTo {
        return $this->belongsTo(User ::class,'autor_id');
    }
}
