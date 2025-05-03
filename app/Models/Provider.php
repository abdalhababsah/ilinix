<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    protected $fillable = ['name', 'logo'];

    public function certificates(): HasMany
    {
        return $this->hasMany(CertificateProgram::class);
    }
}