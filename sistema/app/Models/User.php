<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['role_id', 'name', 'dni', 'phone', 'tuition', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Comprueba si el usuario tiene alguno de los roles indicados.
    public function hasRole(string ...$roles): bool
    {
        return $this->role()->whereIn('name', $roles)->exists();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // la contraseña se encripta sola al guardar
        ];
    }

    // Un usuario pertenece a un rol
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Un usuario registra muchas ventas
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
