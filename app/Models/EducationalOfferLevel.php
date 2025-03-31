<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalOfferLevel extends Model
{
    use HasFactory;


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

}
