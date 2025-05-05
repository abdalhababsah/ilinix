<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateCourse extends Model
{
    protected $fillable = [
        'certificate_program_id', 'title', 'description', 'resource_link',
        'estimated_minutes', 'step_order','digital_link', 
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(CertificateProgram::class);
    }
}