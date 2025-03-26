<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalOffer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'has_study_validation_auth',
        'serves_juvenile_justice',
        'national_protection_students',
        'serves_ethnic_population',
        'validation_authorization',
    ];

    /**
     * Relación muchos-a-muchos con EducationalModel
     */
    public function educationalModels()
    {
        return $this->belongsToMany(EducationalModel::class, 'educational_offer_model');
    }
   /**
     * Relación muchos-a-muchos con EducationalModel
     */
    public function validationAuthorizationAdjunto()
    {
        return $this->belongsTo(Adjunto::class, 'validation_authorization');
    }
}
