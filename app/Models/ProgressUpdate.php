<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressUpdate extends Model
{
    protected $fillable = [
        'intern_id', 'certificate_id', 'course_id',
        'is_completed', 'comment', 'proof_url',
        'updated_by_mentor', 'completed_at'
    ];
}