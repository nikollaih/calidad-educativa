<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeiHistorial extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'pei_historial';

    public $with = ['attachment'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'old_data',
        'new_data',
        'attachment_id',
        'tipo_codificacion',
        'date',
        'observation'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
        'tipo_codificacion' => 'integer',
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    /**
     * Get the parent model (Institucion or other).
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the attached file.
     */
    public function attachment(): BelongsTo
    {
        return $this->belongsTo(Adjunto::class, 'attachment_id');
    }

    /**
     * Scope for filtering by model type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $modelType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfModelType($query, string $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope for filtering by codification type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $tipoCodificacion
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfTipoCodificacion($query, int $tipoCodificacion)
    {
        return $query->where('tipo_codificacion', $tipoCodificacion);
    }
}