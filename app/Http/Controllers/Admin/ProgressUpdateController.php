<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgressUpdate;
use App\Models\User;
use App\Models\CertificateProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgressUpdateController extends Controller
{
    /**
     * Display a listing of the progress updates.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ProgressUpdate::query();
        
        // Filter by intern if specified
        if ($request->filled('intern_id')) {
            $query->where('intern_id', $request->intern_id);
        }
        
        // Filter by certificate if specified
        if ($request->filled('certificate_id')) {
            $query->where('certificate_id', $request->certificate_id);
        }
        
        // Filter by completion status
        if ($request->filled('is_completed')) {
            $query->where('is_completed', $request->is_completed);
        }
        
        // Date range filtering
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', $request->input('direction', 'desc'));
        
        // Include relationships
        $query->with(['intern', 'certificate']);
        
        $progressUpdates = $query->paginate(15)->appends($request->all());
        
        $interns = User::where('role_id', 3)->orderBy('first_name')->get();
        $certificates = CertificateProgram::orderBy('name')->get();
        
        return view('admin.progress-updates.index', compact('progressUpdates', 'interns', 'certificates'));
    }

    /**
     * Show the form for creating a new progress update.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $interns = User::where('role_id', 3)->orderBy('first_name')->get();
        $certificates = CertificateProgram::orderBy('name')->get();
        
        return view('admin.progress-updates.create', compact('interns', 'certificates'));
    }

    /**
     * Store a newly created progress update in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'intern_id' => 'required|exists:users,id',
            'certificate_id' => 'required|exists:certificate_programs,id',
            'course_id' => 'nullable|string|max:100',
            'is_completed' => 'boolean',
            'comment' => 'required|string',
            'proof_url' => 'nullable|url|max:255',
            'updated_by_mentor' => 'boolean',
        ]);
        
        // Set defaults for optional fields
        $validated['is_completed'] = $request->has('is_completed') ? true : false;
        $validated['updated_by_mentor'] = $request->has('updated_by_mentor') ? true : false;
        $validated['completed_at'] = $validated['is_completed'] ? now() : null;
        
        // Create the progress update
        $progressUpdate = ProgressUpdate::create($validated);
        
        // Get the redirect URL
        $redirectUrl = $request->input('redirect_url', route('admin.progress-updates.index'));
        
        // Add success message
        $message = 'Progress update added successfully.';
        if ($validated['is_completed']) {
            $message = 'Course marked as completed successfully.';
        }
        
        return redirect($redirectUrl)->with('success', $message);
    }

    /**
     * Display the specified progress update.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $progressUpdate = ProgressUpdate::with(['intern', 'certificate'])->findOrFail($id);
        
        return view('admin.progress-updates.show', compact('progressUpdate'));
    }

    /**
     * Show the form for editing the specified progress update.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $progressUpdate = ProgressUpdate::findOrFail($id);
        $interns = User::where('role_id', 3)->orderBy('first_name')->get();
        $certificates = CertificateProgram::orderBy('name')->get();
        
        return view('admin.progress-updates.edit', compact('progressUpdate', 'interns', 'certificates'));
    }

    /**
     * Update the specified progress update in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $progressUpdate = ProgressUpdate::findOrFail($id);
        
        $validated = $request->validate([
            'intern_id' => 'required|exists:users,id',
            'certificate_id' => 'required|exists:certificate_programs,id',
            'course_id' => 'nullable|string|max:100',
            'is_completed' => 'boolean',
            'comment' => 'required|string',
            'proof_url' => 'nullable|url|max:255',
            'updated_by_mentor' => 'boolean',
        ]);
        
        // Set defaults for optional fields
        $validated['is_completed'] = $request->has('is_completed') ? true : false;
        $validated['updated_by_mentor'] = $request->has('updated_by_mentor') ? true : false;
        
        // Only update completed_at if is_completed changed
        if ($validated['is_completed'] && !$progressUpdate->is_completed) {
            $validated['completed_at'] = now();
        } elseif (!$validated['is_completed'] && $progressUpdate->is_completed) {
            $validated['completed_at'] = null;
        }
        
        // Update the progress update
        $progressUpdate->update($validated);
        
        // Get the redirect URL
        $redirectUrl = $request->input('redirect_url', route('admin.progress-updates.index'));
        
        return redirect($redirectUrl)->with('success', 'Progress update modified successfully.');
    }

    /**
     * Remove the specified progress update from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $progressUpdate = ProgressUpdate::findOrFail($id);
        $progressUpdate->delete();
        
        return redirect()->route('admin.progress-updates.index')
            ->with('success', 'Progress update deleted successfully.');
    }

    /**
     * Get progress updates for a specific intern and certificate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUpdates(Request $request)
    {
        $request->validate([
            'intern_id' => 'required|exists:users,id',
            'certificate_id' => 'required|exists:certificate_programs,id',
        ]);
        
        $updates = ProgressUpdate::where('intern_id', $request->intern_id)
            ->where('certificate_id', $request->certificate_id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'updates' => $updates,
        ]);
    }
    
    /**
     * Get progress summary for an intern.
     *
     * @param  int  $internId
     * @return \Illuminate\Http\Response
     */
    public function getInternSummary($internId)
    {
        $intern = User::with(['certificates.certificate', 'certificates.progress'])->findOrFail($internId);
        
        $summary = [];
        
        foreach ($intern->certificates as $internCertificate) {
            $certificate = $internCertificate->certificate;
            
            if (!$certificate) {
                continue;
            }
            
            $progressUpdates = $internCertificate->progress ?? collect();
            $completedUpdates = $progressUpdates->where('is_completed', true)->count();
            $totalUpdates = $progressUpdates->count();
            
            $summary[] = [
                'certificate_id' => $certificate->id,
                'certificate_name' => $certificate->name,
                'provider_name' => $certificate->provider->name ?? 'Unknown Provider',
                'started_at' => $internCertificate->started_at,
                'completed_at' => $internCertificate->completed_at,
                'exam_status' => $internCertificate->exam_status,
                'progress_count' => $totalUpdates,
                'completed_count' => $completedUpdates,
                'progress_percentage' => $totalUpdates > 0 ? round(($completedUpdates / $totalUpdates) * 100) : 0,
                'last_update' => $progressUpdates->sortByDesc('created_at')->first(),
            ];
        }
        
        return response()->json([
            'success' => true,
            'intern' => [
                'id' => $intern->id,
                'name' => $intern->first_name . ' ' . $intern->last_name,
                'email' => $intern->email,
            ],
            'summary' => $summary,
        ]);
    }
}