<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProgressUpdate extends Model
{
    use HasFactory;
    protected $fillable = [
        'intern_id',
        'certificate_id',
        'course_id',
        'is_completed',
        'comment',
        'proof_url',
        'updated_by_mentor',
        'completed_at'
    ];

    public function intern()
    {
        return $this->belongsTo(User::class, 'intern_id');
    }

    public function certificate()
    {
        return $this->belongsTo(CertificateProgram::class, 'certificate_id');
    }

    public function course()
    {
        return $this->belongsTo(CertificateCourse::class, 'course_id');
    }
}