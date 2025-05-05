<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CertificateProgram extends Model

{
    use HasFactory;
    protected $fillable = ['title', 'provider_id', 'level','image_path', 'type', 'description'];

    public function courses()   
    {
        return $this->hasMany(CertificateCourse::class);
    }
    
    public function provider()  
    {
        return $this->belongsTo(Provider::class);
    }
}