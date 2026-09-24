<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Seguridad\Role\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasRoles;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    /**
     * Alias para relaciones polimorficas
     */
    public function getMorphClass() {
        return 'user';
    }
    public function  institucion () {
        return $this->hasOne(Institucion::class,'rector_id');
    }
    /**
     * Relación muchos a muchos con instituciones
     */
    public function instituciones(): BelongsToMany {
        return $this->belongsToMany(Institucion::class, 'institucion_user', 'user_id', 'institucion_id')
            ->withPivot( 'is_active')
            ->withTimestamps();
    }
    public function roles(): BelongsToMany {
        return $this->morphToMany(
            Role::class,            // Modelo relacionado
            'model',                // Nombre de la relación polimórfica (model_type y model_id)
            'model_has_roles',      // Tabla pivote
            'model_id',             // Clave foránea del modelo actual
            'role_id'               // Clave foránea del modelo relacionado
        );
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}
