<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PamAccion extends Model
{
    use HasFactory;

    protected $table = 'pam_acciones';

    protected $fillable = [
        'indicador_id',
        'text',
        'estado',
        'fecha_inicio',
        'fecha_final'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_final' => 'date:Y-m-d'
    ];

    protected $appends = [
        'duracion_dias',
        'porcentaje_completado',
        'dias_restantes',
    ];

    /**
     * Relationships
     */
    public function indicador()
    {
        return $this->belongsTo(PamIndicador::class, 'indicador_id');
    }

    public function getDuracionDiasAttribute(): int
    {
        return Carbon::parse($this->fecha_inicio)
            ->diffInDays(Carbon::parse($this->fecha_final));
    }

    public function getPorcentajeCompletadoAttribute(): float
    {
        if ($this->estado) return 100;
        
        $totalDays = $this->duracion_dias;
        $daysPassed = Carbon::parse($this->fecha_inicio)
            ->diffInDays(now());
            
        return min(100, max(0, ($daysPassed / $totalDays) * 100));
    }

    public function getDiasRestantesAttribute(): ?int
    {
        if ($this->estado) return 0;
        
        return Carbon::parse($this->fecha_final)
            ->diffInDays(now(), false) * -1;
    }
}