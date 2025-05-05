<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnboardingStep extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'resource_link', 'step_order'];
    public function UserOnboardingStep()
    {
        return $this->hasMany(UserOnboardingStep::class);
    }
}