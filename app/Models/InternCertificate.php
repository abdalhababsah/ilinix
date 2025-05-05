<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InternCertificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'certificate_id', 'started_at',
        'completed_at', 'exam_status', 'voucher_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function certificate(): BelongsTo
    {
        return $this->belongsTo(CertificateProgram::class);
    }
    
    public function progress()
    {
        return $this->hasMany(CertificateProgress::class, 'intern_certificate_id');
    }
    
}