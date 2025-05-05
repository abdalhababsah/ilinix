<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CertificateProgram extends Model
{
    protected $fillable = ['title', 'provider_id', 'level','image_path', 'type', 'description'];

    public function courses(): HasMany
    {
        return $this->hasMany(CertificateCourse::class);
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}