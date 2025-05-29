<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PamHasComponente extends Pivot
{
    protected $table = 'pam_has_componentes';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true; // Porque usas bigIncrements en la migración

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pam_id',
        'componente_id',
        'user_id',
        'fecha_inicio',
        'fecha_final'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_final' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationships
     */
    public function pam() {
        return $this->belongsTo(Pam::class);
    }

    public function componente() {
        return $this->belongsTo(PamComponente::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function objetivosEstrategicos() {
        return $this->hasMany(PamObjetivoEstrategico::class, 'pam_componente_id');
    }
}