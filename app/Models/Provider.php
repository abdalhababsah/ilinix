<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Provider extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo'];

    public function certificates(): HasMany
    {
        return $this->hasMany(CertificateProgram::class);
    }
}