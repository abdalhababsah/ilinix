<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentoringSession extends Model
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
        'title',
        'session_date',
        'session_time',
        'duration',
        'agenda',
        'status',
        'notes',
        'completed_at',
        'intern_notified',
        'meeting_link',
        'ics_file'
    ];

protected $casts = [
    'duration' => 'integer',
    'intern_notified' => 'boolean',
];
    /**
     * Get the mentor that owns the session.
     */
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Get the intern that owns the session.
     */
    public function intern()
    {
        return $this->belongsTo(User::class, 'intern_id');
    }
}