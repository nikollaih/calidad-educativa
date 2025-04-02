<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalOfferLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'document_id'
    ];

    public function children()
    {
        return $this->hasMany(EducationalOfferLevel::class, 'parent_id')->with('children');
    }
    public function parent()
    {
        return $this->belongsTo(EducationalOfferLevel::class, 'parent_id');
    }
    /**
     * Atributo virtual para obtener el nombre y los nombres de los padres.
     */
    public function getFullHierarchyAttribute()
    {
        $names = [];
        $current = $this;

        while ($current) {
            $names[] = $current->name;
            $current = $current->parent;
        }

        return implode(' → ',$names);
    }

    public function sedeEducationalOffers()
    {
        return $this->belongsToMany(SedeEducationalOffer::class, 'level_sede_educationals', 'educational_level_id', 'sede_educational_offer_id')
            ->withPivot('educational_shedule_id')
            ->withTimestamps();
    }

    public function schedules()
    {
        return $this->hasMany(EducationalOfferSchedule::class, 'educational_level_id');
    }

    public function schedule()
    {
        return $this->belongsToMany(EducationalOfferSchedule::class, 'level_sede_educationals', 'educational_level_id', 'educational_shedule_id');
    }

    public function anexo()
    {
        return $this->belongsTo(Adjunto::class, 'document_id');
    }
}
