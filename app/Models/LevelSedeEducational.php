<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelSedeEducational extends Model
{
    protected $table = 'level_sede_educationals';

    public $timestamps = false;

    protected $fillable = [
        'educational_level_id',
        'sede_id'
    ];

    public function educationalLevel()
    {
        return $this->belongsTo(EducationalOfferLevel::class, 'educational_level_id');
    }

    public function schedules()
    {
        return $this->hasMany(EducationalOfferSchedule::class, 'level_sede_educational_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
}
