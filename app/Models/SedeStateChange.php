<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SedeStateChange extends Model {
    use HasFactory;

    protected $fillable = [
        'sede_id',
        'state_slug',
        'administrative_act_id',
        'observation',
    ];

    public function sede() {
        return $this->belongsTo(Sede::class);
    }

    public function administrativeAct() {
        return $this->belongsTo(Adjunto::class, 'administrative_act_id');
    }
}
