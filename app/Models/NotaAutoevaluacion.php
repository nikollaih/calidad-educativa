<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaAutoevaluacion extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'nota_autoevaluacions';

    // Clave primaria compuesta: para que no trate de usar un solo id
    public $incrementing = false;
    protected $primaryKey = ['autoevaluacion_id', 'nota_calificacion_id'];

    // Atributos que se pueden asignar en masa
    protected $fillable = [
        'autoevaluacion_id',
        'nota_calificacion_id',
        'evidencia',
    ];

    // Relaciones

    public function autoevaluacion()
    {
        return $this->belongsTo(Autoevaluacion::class, 'autoevaluacion_id');
    }

    public function notaCalificacion()
    {
        return $this->belongsTo(NotaCalificacion::class, 'nota_calificacion_id');
    }
}
