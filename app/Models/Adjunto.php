<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Adjunto extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'extension',
        'nombre_completo',
        'ruta',
        'tipo_mime',
        'disco',
    ];
    public function getUrlAttribute()
    {
        return match ($this->disco) {
            'public' => app('url')->to(Storage::url($this->ruta)),
        };
    }
}
