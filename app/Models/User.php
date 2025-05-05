<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable
{
    use Notifiable , HasFactory;

    protected $fillable = [
        'first_name', 'last_name','email', 'password',  'role_id', 'assigned_mentor_id'
    ];

    public function mentees()
    {
        return $this->hasMany(User::class, 'assigned_mentor_id');
    }
    
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
    
    public function progressUpdates(): HasMany
    {
        return $this->hasMany(ProgressUpdate::class, 'intern_id');
    }
}