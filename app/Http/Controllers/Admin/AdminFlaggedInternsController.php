<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternFlag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminFlaggedInternsController extends Controller
{
    /**
     * Display a listing of flagged interns.
     */
    public function index(Request $request)
    {
        $query = InternFlag::with(['intern', 'mentor', 'reviewer']);
        
        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } 
        // Filter by intern name if provided
        if ($request->filled('intern_name')) {
            $query->whereHas('intern', function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->intern_name . '%')
                  ->orWhere('last_name', 'like', '%' . $request->intern_name . '%');
            });
        }
        
        // Filter by mentor name if provided
        if ($request->filled('mentor_name')) {
            $query->whereHas('mentor', function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->mentor_name . '%')
                  ->orWhere('last_name', 'like', '%' . $request->mentor_name . '%');
            });
        }
        
        // Sort by flag date (newest first by default)
        $query->orderBy('flagged_at', $request->input('direction', 'desc'));
        
        $flags = $query->paginate(15)->withQueryString();
        
        // Get counts for different statuses
        $counts = [
            'pending' => InternFlag::where('status', 'pending')->count(),
            'reviewed' => InternFlag::where('status', 'reviewed')->count(),
            'cleared' => InternFlag::where('status', 'cleared')->count(),
            'escalated' => InternFlag::where('status', 'escalated')->count(),
        ];
        
        return view('admin.flagged-interns.index', compact('flags', 'counts'));
    }
    
    /**
     * Show details of a specific flagged intern.
     */
    public function show($id)
    {
        $flag = InternFlag::with(['intern', 'mentor', 'reviewer'])->findOrFail($id);
        
        // Get the intern's full profile
        $intern = User::with([
            'certificates.certificate.provider',
            'certificates.progress',
            'progressUpdates.course',
            'progressUpdates.certificate',
            'onboardingSteps.step',
            'mentor',
            'role',
            'nudges' => function($q) {
                $q->orderBy('nudged_at', 'desc');
            },
            'flags' => function($q) {
                $q->orderBy('flagged_at', 'desc');
            }
        ])->findOrFail($flag->intern_id);
        
        return view('admin.flagged-interns.show', compact('flag', 'intern'));
    }
    
    /**
     * Update the status of a flagged intern.
     */
    public function updateStatus(Request $request, $id)
    {
        $flag = InternFlag::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,reviewed,cleared,escalated',
            'review_notes' => 'required|string|min:10',
        ]);
        
        $flag->update([
            'status' => $request->status,
            'review_notes' => $request->review_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        
        return redirect()->route('admin.flagged-interns.index')
            ->with('success', 'Flag status updated successfully.');
    }
}