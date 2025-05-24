<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnboardingStep;
use App\Models\UserOnboardingStep;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Display the onboarding wizard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all onboarding steps ordered by step_order (admin-defined order)
        $allSteps = OnboardingStep::orderBy('step_order')->get();
        
        // If no steps exist, redirect to dashboard
        if ($allSteps->isEmpty()) {
            return redirect()->route('intern.dashboard');
        }
        
        // Get the user's onboarding steps
        $userSteps = $user->onboardingSteps;
        
        // Create user onboarding steps for any missing steps
        foreach ($allSteps as $step) {
            $existingStep = $userSteps->where('onboarding_step_id', $step->id)->first();
            
            if (!$existingStep) {
                UserOnboardingStep::create([
                    'user_id' => $user->id,
                    'onboarding_step_id' => $step->id,
                    'is_completed' => false,
                    'completed_at' => null
                ]);
            }
        }
        
        // Refresh user steps and order them by the step's step_order (not by onboarding_step_id)
        $userSteps = $user->onboardingSteps()
            ->with('step')
            ->join('onboarding_steps', 'user_onboarding_steps.onboarding_step_id', '=', 'onboarding_steps.id')
            ->orderBy('onboarding_steps.step_order')
            ->select('user_onboarding_steps.*')
            ->get();
        
        // Load the step relationship for each user step
        $userSteps->load('step');
        
        // Get the current active step (first incomplete step, or last step if all complete)
        $activeStep = $userSteps->firstWhere('is_completed', false);
        
        // If all steps are completed, get the last step
        if (!$activeStep && $userSteps->isNotEmpty()) {
            $activeStep = $userSteps->last();
        }
        
        // Calculate progress percentage
        $completedSteps = $userSteps->where('is_completed', true)->count();
        $totalSteps = $userSteps->count();
        $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
        
        return view('intern.onboarding', compact('userSteps', 'activeStep', 'progressPercentage'));
    }
    
    
    /**
     * Mark a step as completed (AJAX)
     */
    public function completeStep(Request $request)
    {
        $request->validate([
            'step_id' => 'required|exists:onboarding_steps,id'
        ]);
        
        $user = Auth::user();
        $stepId = $request->step_id;
        
        // Find or create the user onboarding step
        $userStep = UserOnboardingStep::firstOrCreate(
            ['user_id' => $user->id, 'onboarding_step_id' => $stepId],
            ['is_completed' => false, 'completed_at' => null]
        );
        
        // Only update if not already completed
        if (!$userStep->is_completed) {
            $userStep->markCompleted();
        }
        
        // Get next step if available
        $nextStep = UserOnboardingStep::where('user_id', $user->id)
            ->where('onboarding_step_id', '>', $stepId)
            ->orderBy('onboarding_step_id')
            ->with('step')
            ->first();
            
        // Refresh user steps
        $userSteps = $user->onboardingSteps()->with('step')->orderBy('onboarding_step_id')->get();
        $completedSteps = $userSteps->where('is_completed', true)->count();
        $totalSteps = $userSteps->count();
        $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
        
        // Check if all steps are completed
        $allCompleted = $completedSteps === $totalSteps;
        
        return response()->json([
            'success' => true,
            'step_id' => $stepId,
            'next_step' => $nextStep ? [
                'id' => $nextStep->step->id,
                'title' => $nextStep->step->title,
                'description' => $nextStep->step->description,
                'resource_link' => $nextStep->step->resource_link
            ] : null,
            'progress_percentage' => $progressPercentage,
            'all_completed' => $allCompleted
        ]);
    }
    
    /**
     * Skip a step (mark as completed without actually completing it)
     */
    public function skipStep(Request $request)
    {
        $request->validate([
            'step_id' => 'required|exists:onboarding_steps,id'
        ]);
        
        $user = Auth::user();
        $stepId = $request->step_id;
        
        // Find or create the user onboarding step
        $userStep = UserOnboardingStep::firstOrCreate(
            ['user_id' => $user->id, 'onboarding_step_id' => $stepId],
            ['is_completed' => false, 'completed_at' => null]
        );
        
        // Mark as completed
        $userStep->markCompleted();
        
        // Get next step if available
        $nextStep = UserOnboardingStep::where('user_id', $user->id)
            ->where('onboarding_step_id', '>', $stepId)
            ->orderBy('onboarding_step_id')
            ->with('step')
            ->first();
            
        // Refresh user steps
        $userSteps = $user->onboardingSteps()->with('step')->orderBy('onboarding_step_id')->get();
        $completedSteps = $userSteps->where('is_completed', true)->count();
        $totalSteps = $userSteps->count();
        $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
        
        // Check if all steps are completed
        $allCompleted = $completedSteps === $totalSteps;
        
        return response()->json([
            'success' => true,
            'step_id' => $stepId,
            'next_step' => $nextStep ? [
                'id' => $nextStep->step->id,
                'title' => $nextStep->step->title,
                'description' => $nextStep->step->description,
                'resource_link' => $nextStep->step->resource_link
            ] : null,
            'progress_percentage' => $progressPercentage,
            'all_completed' => $allCompleted
        ]);
    }
    
    /**
     * Finalize onboarding and redirect to dashboard
     */
    public function finalize()
    {
        $user = Auth::user();
        $userSteps = $user->onboardingSteps;
        
        // Check if all steps are completed
        $allCompleted = $userSteps->where('is_completed', false)->isEmpty();
        
        if ($allCompleted) {
            return redirect()->route('intern.dashboard')
                ->with('success', 'Onboarding completed successfully! Welcome to the platform.');
        }
        
        // If not all steps are completed, redirect back to onboarding
        return redirect()->route('intern.onboarding')
            ->with('error', 'Please complete all onboarding steps before proceeding.');
    }
}