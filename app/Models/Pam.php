<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pam extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pam';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'consecutivo',
        'estado'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'estado' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relacion con sedes
    public function sedes() {
        return $this->belongsToMany(Sede::class, 'pam_has_sedes');
    }

    public function componentes() {
        return $this->belongsToMany(PamComponente::class, 'pam_has_componentes')
                    ->using(PamHasComponente::class)
                    ->withPivot([
                        'id',
                        'user_id',
                        'fecha_inicio',
                        'fecha_final'
                    ])
                    ->withTimestamps();
    }
}