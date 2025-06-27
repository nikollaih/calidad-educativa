<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PamRow extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pam_rows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pam_id',
        'user_id',
        'proceso',
        'subproceso',
        'meta_plan_desarrollo',
        'objetivo_estrategico',
        'meta',
        'indicador',
        'accion',
        'recursos',
        'fecha_inicio',
        'fecha_final',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pam_id' => 'integer',
        'user_id' => 'integer',
        'proceso' => 'string',
        'subproceso' => 'string',
        'meta_plan_desarrollo' => 'string',
        'objetivo_estrategico' => 'string',
        'meta' => 'string',
        'indicador' => 'string',
        'accion' => 'string',
        'recursos' => 'string',
        'fecha_inicio' => 'datetime',
        'fecha_final' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    /**
     * Relación con el usuario creador
     */
    public function responsable() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Relación con el pam
     */
    public function pamParent() {
        return $this->belongsTo(Pam::class, 'pam_id');
    }
}