<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOnboardingStep extends Model
{
    protected $fillable = ['user_id', 'onboarding_step_id', 'is_completed', 'completed_at'];
    public $timestamps = false;
}