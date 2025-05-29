<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PamPlanDesarrollo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pam_plan_desarrollo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pam_componente_id',
        'proceso',
        'subproceso',
        'meta'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // Puedes agregar casts si necesitas convertir algún campo
    ];

    /**
     * Relationships
     */
    public function componente()
    {
        return $this->belongsTo(PamHasComponente::class, 'pam_componente_id');
    }
}