<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdherent(): bool
    {
        return $this->role === 'adherent';
    }

    public function isCoach(): bool
    {
        return $this->role === 'coach';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function coachProfile(): HasOne
    {
        return $this->hasOne(CoachProfile::class);
    }

    public function adherentProfile(): HasOne
    {
        return $this->hasOne(AdherentProfile::class);
    }

    public function coachAvailabilities(): HasMany
    {
        return $this->hasMany(CoachAvailability::class, 'coach_id');
    }

    public function coachSessions(): HasMany
    {
        return $this->hasMany(CoachingSession::class, 'coach_id');
    }

    public function adherentSessions(): HasMany
    {
        return $this->hasMany(CoachingSession::class, 'adherent_id');
    }
}
