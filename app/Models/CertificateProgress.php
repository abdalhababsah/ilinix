<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CertificateProgress extends Model
{
    use HasFactory;
    protected $fillable = [
        'intern_certificate_id', 'study_status', 'notes',
        'voucher_requested_at', 'exam_date', 'updated_by_mentor'
    ];
    public function internCertificate()
    {
        return $this->belongsTo(InternCertificate::class, 'intern_certificate_id');
    }

}