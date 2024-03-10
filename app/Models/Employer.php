<?php

namespace App\Models;

use App\Models\Interfaces\SenderInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employer extends Authenticatable implements MustVerifyEmail, JWTSubject, SenderInterface
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'sector_id', 'description', 'site_url', 'email', 'email_verified_at', 'password'];

    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return ['email' => $this->getAttribute('email')];
    }

    public function getSendEmailVerificationNotificationRoute(): string
    {
        return 'employer.verification.verify';
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(EmployerJob::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
