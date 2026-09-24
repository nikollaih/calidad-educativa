<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GestionDirectiva extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gestion_directiva';

    public $with = [
        'institucion',
        'climaEscolar',
        'culturaInstitucional',
        'direccionamientoEstrategico',
        'gestionEstrategica',
        'gobiernoEscolar',
        'relacionesEntorno'
    ];

    protected $fillable = [
        'institution_id',
        'created_at',
        'updated_at'
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institution_id');
    }
    
    // Relación con GdClimaEscolar (1 a 1)
    public function climaEscolar()
    {
        return $this->hasOne(GdClimaEscolar::class, 'gestion_directiva_id');
    }

    // Relación con GdCulturalInstitutional (1 a 1)
    public function culturaInstitucional()
    {
        return $this->hasOne(GdCulturaInstitucional::class, 'gestion_directiva_id');
    }

    // Relación con GdDirectionamientoEstrategico (1 a 1)
    public function direccionamientoEstrategico()
    {
        return $this->hasOne(GdDireccionamientoEstrategico::class, 'gestion_directiva_id');
    }

    // Relación con GdGestionEstrategica (1 a 1)
    public function gestionEstrategica()
    {
        return $this->hasOne(GdGestionEstrategica::class, 'gestion_directiva_id');
    }

    // Relación con GdGobiernoEscolar (1 a 1)
    public function gobiernoEscolar()
    {
        return $this->hasOne(GdGobiernoEscolar::class, 'gestion_directiva_id');
    }

    // Relación con GdRelacionesEntorno (1 a 1)
    public function relacionesEntorno()
    {
        return $this->hasOne(GdRelacionesEntorno::class, 'gestion_directiva_id');
    }
}