<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserOnboardingStep extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'onboarding_step_id',
        'is_completed',
        'completed_at'
    ];
    
    public $timestamps = false;
    
    // Relationship with OnboardingStep
    public function step()
    {
        return $this->belongsTo(OnboardingStep::class, 'onboarding_step_id');
    }
    
    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Mark step as completed
    public function markCompleted()
    {
        $this->is_completed = true;
        $this->completed_at = now();
        $this->save();
        
        return $this;
    }
    
    // Mark step as incomplete
    public function markIncomplete()
    {
        $this->is_completed = false;
        $this->completed_at = null;
        $this->save();
        
        return $this;
    }
}