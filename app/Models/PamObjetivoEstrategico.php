<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PamObjetivoEstrategico extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pam_objetivo_estrategico';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'pam_componente_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // Add casts if needed for future fields
    ];

    /**
     * Relationships
     */
    public function componente()
    {
        return $this->belongsTo(PamHasComponente::class, 'pam_componente_id');
    }

    public function metas() {
        return $this->hasMany(PamMeta::class, 'objetivo_strategico_id');
    }
}