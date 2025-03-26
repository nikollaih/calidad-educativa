<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sede extends Model
{
    use HasFactory, SoftDeletes;
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
    public function titularidadSede (){
        return $this->hasOne(TitularidadSede::class,'sede_id');
    }
    public function steamClassroom (){
        return $this->hasOne(SteamClassroom::class,'sede_id');
    }
    public function inventories (){
        return $this->hasMany(Inventory::class,'sede_id');
    }
        /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_new_school'      => 'boolean',
    ];


}
