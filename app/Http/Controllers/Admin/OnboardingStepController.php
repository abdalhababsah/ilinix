<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnboardingStep;
use Illuminate\Http\Request;

class OnboardingStepController extends Controller
{
    public function updateStatus(Request $request, OnboardingStep $step)
    {
        $validated = $request->validate(['completed' => 'required|boolean']);
        $step->completed = $validated['completed'];
        $step->completed_at = $validated['completed'] ? now() : null;
        $step->save();

        return response()->json(['success' => true]);
    }
}