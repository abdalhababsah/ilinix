<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateProgress extends Model
{
    protected $fillable = [
        'intern_certificate_id', 'study_status', 'notes',
        'voucher_requested_at', 'exam_date', 'updated_by_mentor'
    ];
}