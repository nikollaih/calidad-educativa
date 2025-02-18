<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaSteam extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aula_steam';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'institucion_educativa_id',
        'descripcion',
        'fuente_financiacion',
        'cantidad',
        'fase'
    ];

    public function institucion_educativa()
    {
        return $this->belongsTo(InstitucionEducativa::class, 'institucion_educativa_id');
    }
}
