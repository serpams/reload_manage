<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Obras;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class User extends Authenticatable  implements FilamentUser, HasTenants, HasName
{
    use HasApiTokens, HasFactory, Notifiable;
    // , HasSuperAdmin;

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

    public function getFilamentName(): string
    {
        return "{$this->name} {$this->name}";
    }

    // public function canAccessFilament(): bool
    // {
    //     return str_ends_with($this->email, '@gmail.com') && $this->hasVerifiedEmail();
    // }
    public function getTenantKey(): string
    {
        return 'obra_id';
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function chirps(): HasMany
    {
        return $this->hasMany(Chirp::class);
    }
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->obras->contains($tenant);
    }
    public function getTenants(Panel $panel): Collection
    {
        return $this->obras;
    }
    public function obras(): BelongsToMany
    {
        return $this->belongsToMany(Obras::class);
    }
    public function ObrasUsers()
    {
        return $this->hasMany(ObrasUsers::class);
    }
}
