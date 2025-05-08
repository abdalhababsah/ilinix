<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateProgress extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'intern_certificate_id',
        'study_status',
        'notes',
        'voucher_requested_at',
        'exam_date',
        'updated_by_mentor'
    ];
    
    protected $casts = [
        'voucher_requested_at' => 'datetime',
        'exam_date' => 'datetime',
        'updated_by_mentor' => 'boolean'
    ];
    
    public function internCertificate()
    {
        return $this->belongsTo(InternCertificate::class, 'intern_certificate_id');
    }
    
    // This was missing and causing the error
    public function course()
    {
        // Assuming this links to CertificateCourse somehow
        // This needs to be defined correctly based on your DB structure
        return $this->belongsTo(CertificateCourse::class, 'course_id');
    }
}