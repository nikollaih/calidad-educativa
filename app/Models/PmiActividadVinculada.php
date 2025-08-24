<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;

class PmiActividadVinculada extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'peso',
        'accumulated',
        'responsables',
        'recursos',
        'fecha_inicio',
        'fecha_fin',
        'meta_id',
        'afecta_indicador',
    ];
    protected $casts = [
        'afecta_indicador' => 'boolean',
    ];
    public function meta(){
        return $this->belongsTo(PmiMetaVinculada::class,'meta_id');
    }
}
