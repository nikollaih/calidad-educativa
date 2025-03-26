<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'dane',
        'zone',
        'address',
        'latitude',
        'longitude',
        'is_new_school',
        'institution_id',
        'administrative_act',
        'parent_sede_id',
    ];

    // Relaciones
    public function administrativeAct (){
        return $this->belongsTo(Adjunto::class,'administrative_act');
    }
    //Sede padre
    public function parentSede (){
        return $this->belongsTo(Sede::class,'parent_sede_id');
    }
    public function institution (){
        return $this->belongsTo(Institucion::class,'institution_id');
    }
}
