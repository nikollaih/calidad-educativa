<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PamIndicador extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'pam_indicadores';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'meta_id',
        'text'
    ];

    /**
     * Relationship with Meta
     */
    public function meta() {
        return $this->belongsTo(PamMeta::class, 'meta_id');
    }

    public function acciones() {
        return $this->hasMany(PamAccion::class, 'indicador_id');
    }
}