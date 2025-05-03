<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'first_name', 'password',  'role_id', 'assigned_mentor_id'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_mentor_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(InternCertificate::class);
    }

    public function onboardingSteps(): HasMany
    {
        return $this->hasMany(UserOnboardingStep::class);
    }
}