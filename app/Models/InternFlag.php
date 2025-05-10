<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternFlag extends Model
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
        'reason',
        'status',
        'email_sent',
        'reviewed_by',
        'review_notes',
        'reviewed_at',
        'flagged_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'flagged_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'email_sent' => 'boolean',
    ];

    /**
     * Get the mentor that created the flag.
     */
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Get the intern that was flagged.
     */
    public function intern()
    {
        return $this->belongsTo(User::class, 'intern_id');
    }

    /**
     * Get the admin who reviewed the flag.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}