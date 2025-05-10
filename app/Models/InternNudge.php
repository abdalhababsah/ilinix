<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternNudge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mentor_id',
        'intern_id',
        'message',
        'nudged_at',
        'email_sent',
        'response_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nudged_at' => 'datetime',
        'response_at' => 'datetime',
        'email_sent' => 'boolean',
    ];

    /**
     * Get the mentor that created the nudge.
     */
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Get the intern that was nudged.
     */
    public function intern()
    {
        return $this->belongsTo(User::class, 'intern_id');
    }
}