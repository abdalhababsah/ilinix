<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CertificateCourse extends Model
{
    use HasFactory;
    protected $fillable = [
        'certificate_program_id', 'title', 'description', 'resource_link',
        'estimated_minutes', 'step_order','digital_link', 
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(CertificateProgram::class);
    }
}