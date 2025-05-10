<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\CertificateProgram;
use App\Models\InternCertificate;
use App\Models\CertificateProgress;
use App\Models\ProgressUpdate;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InternCertificateController extends Controller
{
    /**
     * Display the list of available certificates and user's progress
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all certificate programs
        $availablePrograms = CertificateProgram::with('provider')->get();
        
        // Get certificates the intern has already started/completed
        $internCertificates = InternCertificate::where('user_id', $user->id)
            ->with(['certificate.provider', 'progress'])
            ->get();
        
        // Separate certificates by status
        $startedCertificates = $internCertificates->filter(function ($cert) {
            return $cert->started_at && !$cert->completed_at;
        });
        
        $completedCertificates = $internCertificates->filter(function ($cert) {
            return $cert->completed_at;
        });
        
        // Get certificate IDs that the intern has already started/completed
        $existingCertificateIds = $internCertificates->pluck('certificate_id')->toArray();
        
        // Filter available programs to exclude those already started/completed
        $availablePrograms = $availablePrograms->filter(function ($program) use ($existingCertificateIds) {
            return !in_array($program->id, $existingCertificateIds);
        });
        
        return view('intern.certificates.index', compact(
            'availablePrograms',
            'startedCertificates',
            'completedCertificates'
        ));
    }
    
    /**
     * Show the details of a specific certificate including courses and progress
     */
/**
 * Show the details of a specific certificate including courses and progress
 */
public function show($id)
{
    $user = Auth::user();
    
    $internCertificate = InternCertificate::where('user_id', $user->id)
        ->where('id', $id)
        ->with([
            'certificate.provider',
            'certificate.courses',
            'progress'
        ])
        ->firstOrFail();
    
    // Get progress updates separately and eager load courses
    $progressUpdates = ProgressUpdate::where('intern_id', $user->id)
        ->where('certificate_id', $internCertificate->certificate_id)
        ->with('course')
        ->get();
    
    // Manually attach progress updates to avoid the relationship error
    $internCertificate->setAttribute('progressUpdates', $progressUpdates);
    
    // Get the latest progress status
    $latestProgress = $internCertificate->progress()
        ->latest()
        ->first();
    
    // Calculate percentage complete based on completed courses
    $totalCourses = $internCertificate->certificate->courses->count();
    $completedCourses = $progressUpdates->where('is_completed', true)->count();
    
    $percentComplete = $totalCourses > 0 
        ? round(($completedCourses / $totalCourses) * 100) 
        : 0;
        
    // Check if voucher request already exists - for view to disable button
    $voucherRequestExists = CertificateProgress::where('intern_certificate_id', $internCertificate->id)
        ->where('study_status', 'requested_voucher')
        ->exists();
    
    // Prepare course data for the view to prevent Blade from doing queries
    $coursesWithProgress = [];
    
    foreach ($internCertificate->certificate->courses->sortBy('step_order') as $course) {
        $progressUpdate = $progressUpdates->where('course_id', $course->id)->first();
        
        $courseData = [
            'id' => $course->id,
            'step_order' => $course->step_order,
            'title' => $course->title,
            'description' => $course->description,
            'estimated_minutes' => $course->estimated_minutes,
            'resource_link' => $course->resource_link,
            'digital_link' => $course->digital_link,
            'is_completed' => $progressUpdate ? $progressUpdate->is_completed : false,
            'comment' => $progressUpdate ? $progressUpdate->comment : '',
            'proof_url' => $progressUpdate ? $progressUpdate->proof_url : '',
            'can_update' => $progressUpdate ? !$progressUpdate->is_completed : true
        ];
        
        $coursesWithProgress[] = $courseData;
    }
    
    // Check if all courses are completed (for voucher request eligibility)
    $allCoursesCompleted = $totalCourses > 0 && $completedCourses === $totalCourses;
    
    // Organize progress timeline data
    $progressTimeline = $internCertificate->progress
        ->sortByDesc('created_at')
        ->map(function($progress) {
            // Map status to appropriate icon and badge color
            $iconMap = [
                'in_progress' => 'clock',
                'studying_for_exam' => 'book',
                'requested_voucher' => 'tag',
                'took_exam' => 'file-text',
                'passed' => 'check',
                'failed' => 'close'
            ];
            
            $badgeMap = [
                'in_progress' => 'warning',
                'studying_for_exam' => 'info',
                'requested_voucher' => 'primary',
                'took_exam' => 'secondary',
                'passed' => 'success',
                'failed' => 'danger'
            ];
            
            $statusTextMap = [
                'in_progress' => 'In Progress',
                'studying_for_exam' => 'Studying for Exam',
                'requested_voucher' => 'Voucher Requested',
                'took_exam' => 'Took Exam',
                'passed' => 'Passed Exam',
                'failed' => 'Failed Exam'
            ];
            
            return [
                'id' => $progress->id,
                'icon' => $iconMap[$progress->study_status] ?? 'note',
                'badge_color' => $badgeMap[$progress->study_status] ?? 'secondary',
                'status_text' => $statusTextMap[$progress->study_status] ?? 'Unknown',
                'notes' => $progress->notes,
                'created_at' => $progress->created_at,
                'updated_by_mentor' => $progress->updated_by_mentor,
                'voucher_requested_at' => $progress->voucher_requested_at,
                'exam_date' => $progress->exam_date
            ];
        })
        ->toArray();

    return view('intern.certificates.show', compact(
        'internCertificate',
        'latestProgress',
        'percentComplete',
        'voucherRequestExists',
        'coursesWithProgress',
        'allCoursesCompleted',
        'progressTimeline'
    ));
}
    
    /**
     * Start a new certificate program
     */
    public function start(Request $request)
    {
        $request->validate([
            'certificate_id' => 'required|exists:certificate_programs,id'
        ]);
        
        $user = Auth::user();
        
        // Check if the intern already has this certificate
        $exists = InternCertificate::where('user_id', $user->id)
            ->where('certificate_id', $request->certificate_id)
            ->exists();
            
        if ($exists) {
            return redirect()->route('intern.certificates.index')
                ->with('error', 'You have already started this certificate program.');
        }
        
        try {
            $internCertificate = DB::transaction(function () use ($user, $request) {
                // Create the new intern certificate record
                $internCertificate = InternCertificate::create([
                    'user_id' => $user->id,
                    'certificate_id' => $request->certificate_id,
                    'started_at' => now(),
                    'exam_status' => 'not_taken'
                ]);
                
                // Create initial progress record
                CertificateProgress::create([
                    'intern_certificate_id' => $internCertificate->id,
                    'study_status' => 'in_progress',
                    'notes' => 'Certificate program started',
                    'updated_by_mentor' => false
                ]);
                return $internCertificate;
            });
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('success', 'Certificate program started successfully!');
        } catch (\Exception $e) {
            return redirect()->route('intern.certificates.index')
                ->with('error', 'Failed to start certificate program: ' . $e->getMessage());
        }
    }
    
    /**
     * Update certificate progress and status
     */
    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'study_status' => 'required|in:in_progress,studying_for_exam,requested_voucher,took_exam,passed,failed',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $user = Auth::user();
        
        $internCertificate = InternCertificate::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
        
        // Check if voucher request already exists
        if ($request->study_status === 'requested_voucher') {
            $existingRequest = CertificateProgress::where('intern_certificate_id', $internCertificate->id)
                ->where('study_status', 'requested_voucher')
                ->exists();
                
            if ($existingRequest) {
                return redirect()->route('intern.certificates.show', $internCertificate->id)
                    ->with('error', 'You have already requested a voucher for this certificate.');
            }
        }
        
        try {
            DB::transaction(function () use ($request, $internCertificate) {
                // Create new progress record
                $progress = CertificateProgress::create([
                    'intern_certificate_id' => $internCertificate->id,
                    'study_status' => $request->study_status,
                    'notes' => $request->notes,
                    'updated_by_mentor' => false
                ]);
                
                // Set voucher_requested_at if needed
                if ($request->study_status === 'requested_voucher') {
                    $progress->voucher_requested_at = now();
                    $progress->save();
                }
                
                // Update certificate status based on progress
                if ($request->study_status === 'passed') {
                    $internCertificate->update([
                        'exam_status' => 'passed',
                        'completed_at' => now()
                    ]);
                } elseif ($request->study_status === 'failed') {
                    $internCertificate->update([
                        'exam_status' => 'failed'
                    ]);
                } elseif ($request->study_status === 'took_exam') {
                    $internCertificate->update([
                        'exam_status' => 'scheduled'
                    ]);
                }
            });
            
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('success', 'Progress updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('error', 'Failed to update progress: ' . $e->getMessage());
        }
    }
    
    /**
     * Request a voucher for the certificate exam
     */
    public function requestVoucher(Request $request, $id)
    {
        $user = Auth::user();
    
        $internCertificate = InternCertificate::where('user_id', $user->id)
            ->where('id', $id)
            ->with('certificate.courses')
            ->firstOrFail();
    
        // Check if all courses are completed
        $totalCourses = $internCertificate->certificate->courses->count();
        $completedCourses = ProgressUpdate::where('intern_id', $user->id)
            ->where('certificate_id', $internCertificate->certificate_id)
            ->where('is_completed', true)
            ->count();
    
        if ($completedCourses !== $totalCourses) {
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('error', 'You must complete all courses before requesting a voucher.');
        }
    
        // Check if a voucher request already exists in CertificateProgress
        $existingVoucherRequest = CertificateProgress::where('intern_certificate_id', $internCertificate->id)
            ->where('study_status', 'requested_voucher')
            ->exists();
    
        if ($existingVoucherRequest) {
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('error', 'You have already requested a voucher for this certificate.');
        }
    
        try {
            DB::transaction(function () use ($request, $internCertificate, $user) {
                // Log voucher request in progress table
                CertificateProgress::create([
                    'intern_certificate_id' => $internCertificate->id,
                    'study_status' => 'requested_voucher',
                    'notes' => $request->notes ?? 'Voucher requested for the certificate exam',
                    'voucher_requested_at' => now(),
                    'updated_by_mentor' => false
                ]);
    
                // Optional: notify mentor
                if ($user->assigned_mentor_id) {
                    $mentor = User::find($user->assigned_mentor_id);
                    if ($mentor) {
                        Notification::create([
                            'user_id' => $mentor->id,
                            'title' => 'Voucher Request',
                            'message' => $user->first_name . ' ' . $user->last_name . ' has requested a voucher for ' . $internCertificate->certificate->title . '.'
                        ]);
                    }
                }
            });
    
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('success', 'Voucher requested successfully! Your mentor will be notified.');
    
        } catch (\Exception $e) {
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('error', 'Failed to request voucher: ' . $e->getMessage());
        }
    }
    
/**
 * Update course progress for a certificate
 */
public function updateCourseProgress(Request $request, $id)
{
    $request->validate([
        'course_id' => 'required|exists:certificate_courses,id',
        'is_completed' => 'sometimes',
        'comment' => 'nullable|string|max:500',
        'proof_url' => 'nullable|url'
    ]);
    
    $user = Auth::user();
    
    $internCertificate = InternCertificate::where('user_id', $user->id)
        ->where('id', $id)
        ->firstOrFail();
    
    try {
        // Check if this course already has a progress record
        $existingProgress = ProgressUpdate::where('intern_id', $user->id)
            ->where('certificate_id', $internCertificate->certificate_id)
            ->where('course_id', $request->course_id)
            ->first();
        
        // If the existing record is completed, prevent updating it entirely
        if ($existingProgress && $existingProgress->is_completed) {
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('error', 'Course has already been marked as completed and cannot be updated.');
        }
        
        // Mark as completed can only go from false to true, never back
        $isCompleted = $request->has('is_completed');
        
        if ($existingProgress) {
            // Update existing progress
            $existingProgress->update([
                'is_completed' => $isCompleted,
                'comment' => $request->comment,
                'proof_url' => $request->proof_url,
                'completed_at' => $isCompleted ? now() : null
            ]);
        } else {
            // Create new progress record
            ProgressUpdate::create([
                'intern_id' => $user->id,
                'certificate_id' => $internCertificate->certificate_id,
                'course_id' => $request->course_id,
                'is_completed' => $isCompleted,
                'comment' => $request->comment,
                'proof_url' => $request->proof_url,
                'completed_at' => $isCompleted ? now() : null
            ]);
        }
        
        // Check if all courses are completed
        $completedCoursesCount = ProgressUpdate::where('intern_id', $user->id)
            ->where('certificate_id', $internCertificate->certificate_id)
            ->where('is_completed', true)
            ->count();
            
        $totalCoursesCount = $internCertificate->certificate->courses->count();
        
        // If all courses are completed and no studying_for_exam progress exists, add one
        if ($completedCoursesCount == $totalCoursesCount) {
            $existingStudyingProgress = CertificateProgress::where('intern_certificate_id', $internCertificate->id)
                ->where('study_status', 'studying_for_exam')
                ->exists();
                
            if (!$existingStudyingProgress) {
                // Add a certificate progress entry
                CertificateProgress::create([
                    'intern_certificate_id' => $internCertificate->id,
                    'study_status' => 'studying_for_exam',
                    'notes' => 'All courses completed. Ready for exam preparation.',
                    'updated_by_mentor' => false
                ]);
            }
        }
        
        return redirect()->route('intern.certificates.show', $internCertificate->id)
            ->with('success', 'Course progress updated successfully!');
            
    } catch (\Exception $e) {
        return redirect()->route('intern.certificates.show', $internCertificate->id)
            ->with('error', 'Failed to update course progress: ' . $e->getMessage());
    }
}
    
    /**
     * View all completed certificates (e.g., for printing or sharing)
     */
    public function completedCertificates()
    {
        $user = Auth::user();
        
        $completedCertificates = InternCertificate::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->with(['certificate.provider'])
            ->get();
            
        return view('intern.certificates.completed', compact('completedCertificates'));
    }
    
    /**
     * Get achievement data for dashboard display
     */
    public function achievements()
    {
        $user = Auth::user();
        
        $totalCertificates = InternCertificate::where('user_id', $user->id)->count();
        $completedCertificates = InternCertificate::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();
        $inProgressCertificates = InternCertificate::where('user_id', $user->id)
            ->whereNull('completed_at')
            ->whereNotNull('started_at')
            ->count();
            
        // Get total courses completed
        $coursesCompleted = ProgressUpdate::where('intern_id', $user->id)
            ->where('is_completed', true)
            ->count();
            
        // Get upcoming exams
        $upcomingExams = InternCertificate::where('user_id', $user->id)
            ->where('exam_status', 'scheduled')
            ->with(['certificate'])
            ->get();
            
        $data = [
            'total_certificates' => $totalCertificates,
            'completed_certificates' => $completedCertificates,
            'in_progress_certificates' => $inProgressCertificates,
            'courses_completed' => $coursesCompleted,
            'upcoming_exams' => $upcomingExams,
        ];
        
        return response()->json($data);
    }
    
    /**
     * Set an exam date for a certificate
     */
    public function setExamDate(Request $request, $id)
    {
        $request->validate([
            'exam_date' => 'required|date|after:today',
        ]);
        
        $user = Auth::user();
        
        $internCertificate = InternCertificate::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
            
        try {
            DB::transaction(function () use ($request, $internCertificate) {
                // Update certificate status
                $internCertificate->update([
                    'exam_status' => 'scheduled'
                ]);
                
                // Create progress record for scheduled exam
                CertificateProgress::create([
                    'intern_certificate_id' => $internCertificate->id,
                    'study_status' => 'studying_for_exam',
                    'notes' => 'Exam scheduled for ' . Carbon::parse($request->exam_date)->format('F j, Y'),
                    'exam_date' => Carbon::parse($request->exam_date),
                    'updated_by_mentor' => false
                ]);
            });
            
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('success', 'Exam date set successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('intern.certificates.show', $internCertificate->id)
                ->with('error', 'Failed to set exam date: ' . $e->getMessage());
        }
    }
    
    /**
     * Download or view certificate summary/report
     */
    public function downloadCertificate($id)
    {
        $user = Auth::user();
        
        $internCertificate = InternCertificate::where('user_id', $user->id)
            ->where('id', $id)
            ->whereNotNull('completed_at')
            ->whereNotNull('voucher_id')
            ->where('exam_status', 'passed')
            ->with(['certificate.provider', 'certificate.courses'])
            ->firstOrFail();
            
        // Generate PDF or view for certificate
        $pdf = \PDF::loadView('intern.certificates.certificate-pdf', compact('internCertificate'));
        
        return $pdf->download($internCertificate->certificate->title . '_certificate.pdf');
    }
}