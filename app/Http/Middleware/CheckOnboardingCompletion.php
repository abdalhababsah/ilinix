<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OnboardingStep;

class CheckOnboardingCompletion
{
    /**
     * Exempt routes that interns can access even if onboarding is not complete
     */
    protected $exemptRoutes = [
        'intern.onboarding',
        'intern.onboarding.complete-step',
        'intern.onboarding.skip-step',
        'intern.logout',
        'login',
        'password.request',
        'password.reset',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and is an intern (role_id = 3)
        if (Auth::check() && Auth::user()->role_id === 3) {
            $user = Auth::user();
            
            // Skip the middleware if the current route is exempt
            $currentRouteName = $request->route()->getName();
            if (in_array($currentRouteName, $this->exemptRoutes)) {
                return $next($request);
            }
            
            // Get all onboarding steps
            $allSteps = OnboardingStep::orderBy('step_order')->get();
            
            // If there are no onboarding steps defined, let them proceed
            if ($allSteps->isEmpty()) {
                return $next($request);
            }
            
            // Get the user's completed onboarding steps
            $userSteps = $user->onboardingSteps;
            
            // Check if all steps are completed
            $allCompleted = true;
            
            foreach ($userSteps as $userStep) {
                if (!$userStep->is_completed) {
                    $allCompleted = false;
                    break;
                }
            }
            
            // If all steps are not completed, or user doesn't have all steps assigned, redirect to onboarding
            if (!$allCompleted || $userSteps->count() !== $allSteps->count()) {
                return redirect()->route('intern.onboarding');
            }
        }

        return $next($request);
    }
}