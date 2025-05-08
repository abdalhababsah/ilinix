<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnboardingStep extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'description', 
        'resource_link', 
        'step_order'
    ];
    
    // Relationship with users through UserOnboardingStep
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_onboarding_steps')
                    ->withPivot('is_completed', 'completed_at');
    }
    
    // Get all user-onboarding step relationships
    public function userOnboardingSteps()
    {
        return $this->hasMany(UserOnboardingStep::class);
    }
    
    // Get completion rate of this step across all interns
    public function getCompletionRateAttribute()
    {
        if($this->userOnboardingSteps->count() === 0) {
            return 0;
        }
        
        $completedCount = $this->userOnboardingSteps->where('is_completed', true)->count();
        return round(($completedCount / $this->userOnboardingSteps->count()) * 100);
    }
}