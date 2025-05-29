<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PamMeta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'pam_metas';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'objetivo_strategico_id',
        'text'
    ];

    /**
     * Relationship with Objetivo Estratégico
     */
    public function objetivoEstrategico() {
        return $this->belongsTo(PamObjetivoEstrategico::class, 'objetivo_strategico_id');
    }

    public function indicadores() {
        return $this->hasMany(PamIndicador::class, 'meta_id');
    }
}