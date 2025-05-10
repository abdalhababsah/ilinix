<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'last_seen',
        'role_id',
        'assigned_mentor_id'
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


    /**
     * Get all conversations for this user
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    /**
     * Get all messages sent by this user
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**
     * Get this user's status
     */
    public function onlineStatus()
    {
        return $this->hasOne(UserStatus::class);
    }


    /**
     * Get the interns assigned to this mentor
     */
    public function interns()
    {
        return $this->hasMany(User::class, 'assigned_mentor_id');
    }

    /**
     * Check if this user is an admin
     */
    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    /**
     * Check if this user is a mentor
     */
    public function isMentor()
    {
        return $this->role_id === 2;
    }

    /**
     * Check if this user is an intern
     */
    public function isIntern()
    {
        return $this->role_id === 3;
    }

    /**
     * Get full name of user
     */
    public function FullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}