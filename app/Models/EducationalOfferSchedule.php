<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalOfferSchedule extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'schedule',
        'document_id',
        'level_sede_educational_id',
        'notes',
        'hora_inicio',
        'hora_fin',
    ];
    public function anexo (){
        return $this->belongsTo(Adjunto::class,'document_id');
    }

    public function levelSedeEducational() {
        return $this->belongsTo(LevelSedeEducational::class, 'level_sede_educationals');
    }
}
