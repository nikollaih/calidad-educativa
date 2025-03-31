<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SedeEducationalOffer extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sede_id',
        'educational_offer_id',
    ];

    public function educationalLevels()
        {
            return $this->belongsToMany(EducationalOfferLevel::class, 'level_sede_educationals', 'sede_educational_offer_id', 'educational_level_id');
        }
    public function schedule () {
            return $this->hasOne(EducationalOfferSchedule::class,'sede_offer_id');
    }
    public function educationalOffer () {
            return $this->belongsTo(EducationalOffer::class,'educational_offer_id');
    }
}
