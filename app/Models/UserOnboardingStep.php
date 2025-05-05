<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserOnboardingStep extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'onboarding_step_id', 'is_completed', 'completed_at'];
    public $timestamps = false;

    public function onboardingStep()    
    {
        return $this->belongsTo(OnboardingStep::class);
    }
}
