<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnboardingStep;
use App\Models\User;
use App\Models\UserOnboardingStep;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminOnboardingController extends Controller
{
    /**
     * Display a listing of onboarding steps
     */
    public function index()
    {
        $steps = OnboardingStep::orderBy('step_order')->get();
        $internsCount = User::where('role_id', 3)->count();
        
        return view('admin.onboarding.index', compact('steps', 'internsCount'));
    }
    
    /**
     * Show the form for creating a new step
     */
    public function create()
    {
        return view('admin.onboarding.create');
    }
    
    /**
     * Store a newly created step
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'resource_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,ppt,pptx|max:10240',
            'step_order' => 'nullable|integer|min:1'
        ]);
        
        // Handle file upload if provided
        if ($request->hasFile('resource_file')) {
            $file = $request->file('resource_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('onboarding_resources', $filename, 'public');
            $validated['resource_link'] = $path;
        }
        
        // If no order specified, add to the end
        if (empty($validated['step_order'])) {
            $lastStep = OnboardingStep::orderBy('step_order', 'desc')->first();
            $validated['step_order'] = $lastStep ? $lastStep->step_order + 1 : 1;
        } else {
            // Reorder existing steps if necessary
            $this->reorderSteps($validated['step_order']);
        }
        
        // Create the step
        $step = OnboardingStep::create($validated);
        
        // Create an entry for all existing interns to track their progress with this step
        $interns = User::where('role_id', 3)->get();
        foreach ($interns as $intern) {
            UserOnboardingStep::create([
                'user_id' => $intern->id,
                'onboarding_step_id' => $step->id,
                'is_completed' => false,
                'completed_at' => null
            ]);
        }
        
        return redirect()->route('admin.onboarding.index')
            ->with('success', 'Onboarding step created successfully.');
    }
    
    /**
     * Show the form for editing an existing step
     */
    public function edit($id)
    {
        $step = OnboardingStep::findOrFail($id);
        return view('admin.onboarding.edit', compact('step'));
    }
    
    /**
     * Update the specified step
     */
    public function update(Request $request, $id)
    {
        $step = OnboardingStep::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'resource_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,ppt,pptx|max:10240',
            'step_order' => [
                'nullable',
                'integer',
                'min:1',
                Rule::unique('onboarding_steps')->ignore($step->id)
            ],
            'remove_resource' => 'nullable|boolean'
        ]);
        
        // Handle file upload if provided
        if ($request->hasFile('resource_file')) {
            // Remove old file if exists
            if ($step->resource_link && Storage::disk('public')->exists($step->resource_link)) {
                Storage::disk('public')->delete($step->resource_link);
            }
            
            $file = $request->file('resource_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('onboarding_resources', $filename, 'public');
            $validated['resource_link'] = $path;
        } elseif ($request->boolean('remove_resource')) {
            // Remove existing resource if requested
            if ($step->resource_link && Storage::disk('public')->exists($step->resource_link)) {
                Storage::disk('public')->delete($step->resource_link);
            }
            $validated['resource_link'] = null;
        }
        
        // If order has changed, reorder steps
        if (isset($validated['step_order']) && $validated['step_order'] != $step->step_order) {
            $this->reorderSteps($validated['step_order'], $step->id);
        }
        
        // Remove unnecessary fields
        unset($validated['resource_file']);
        unset($validated['remove_resource']);
        
        // Update the step
        $step->update($validated);
        
        return redirect()->route('admin.onboarding.index')
            ->with('success', 'Onboarding step updated successfully.');
    }
    
    /**
     * Remove the specified step
     */
    public function destroy($id)
    {
        $step = OnboardingStep::findOrFail($id);
        
        // Delete resource file if exists
        if ($step->resource_link && Storage::disk('public')->exists($step->resource_link)) {
            Storage::disk('public')->delete($step->resource_link);
        }
        
        // Delete the step (user steps will be deleted by cascade)
        $step->delete();
        
        // Reorder remaining steps
        $this->normalizeStepOrder();
        
        return redirect()->route('admin.onboarding.index')
            ->with('success', 'Onboarding step deleted successfully.');
    }
    
    /**
     * Update step status for an intern (mark as complete/incomplete)
     */
    public function updateStepStatus(Request $request, $id)
    {
        $userStep = UserOnboardingStep::findOrFail($id);
        
        $request->validate([
            'completed' => 'required|boolean'
        ]);
        
        if ($request->completed) {
            $userStep->is_completed = true;
            $userStep->completed_at = now();
        } else {
            $userStep->is_completed = false;
            $userStep->completed_at = null;
        }
        
        $userStep->save();
        
        return response()->json([
            'success' => true,
            'message' => $request->completed ? 'Step marked as completed.' : 'Step marked as incomplete.'
        ]);
    }
    
    /**
     * Reorder step to specified position and adjust other steps
     */
    private function reorderSteps($newOrder, $stepId = null)
    {
        // Get all steps ordered by their current order
        $steps = OnboardingStep::orderBy('step_order')->get();
        
        // If we're updating an existing step
        if ($stepId) {
            $currentStep = OnboardingStep::find($stepId);
            $currentOrder = $currentStep->step_order;
            
            // If moving down
            if ($newOrder > $currentOrder) {
                OnboardingStep::whereBetween('step_order', [$currentOrder + 1, $newOrder])
                    ->decrement('step_order');
            } 
            // If moving up
            elseif ($newOrder < $currentOrder) {
                OnboardingStep::whereBetween('step_order', [$newOrder, $currentOrder - 1])
                    ->increment('step_order');
            }
        } 
        // If adding a new step at a specific position
        else {
            OnboardingStep::where('step_order', '>=', $newOrder)
                ->increment('step_order');
        }
    }
    
    /**
     * Normalize step order (1, 2, 3...) after deletions or moves
     */
    private function normalizeStepOrder()
    {
        $steps = OnboardingStep::orderBy('step_order')->get();
        
        foreach ($steps as $index => $step) {
            $step->update(['step_order' => $index + 1]);
        }
    }
    
/**
 * Change the order of steps via drag and drop
 */
public function updateOrder(Request $request)
{
    $request->validate([
        'steps' => 'required|array',
        'steps.*' => 'required|exists:onboarding_steps,id'
    ]);
    
    $steps = $request->steps;
    
    // Begin transaction to ensure all updates are done as a unit
    \DB::beginTransaction();
    
    try {
        // First assign temporary orders (using negative numbers to avoid conflicts)
        foreach ($steps as $index => $stepId) {
            OnboardingStep::where('id', $stepId)
                ->update(['step_order' => -($index + 1)]);
        }
        
        // Then update with the actual order
        foreach ($steps as $index => $stepId) {
            OnboardingStep::where('id', $stepId)
                ->update(['step_order' => $index + 1]);
        }
        
        // Commit the transaction
        \DB::commit();
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        // Roll back the transaction if something goes wrong
        \DB::rollBack();
        
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating the order: ' . $e->getMessage()
        ], 500);
    }
}

    
}