<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InternCertificate;
use App\Models\CertificateProgram;
use App\Models\ProgressUpdate;
use Illuminate\Support\Facades\Auth;

class InternDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated intern
        $user = Auth::user();
        
        // Load all necessary relationships
        $intern = User::with([
            'certificates.certificate.provider',
            'certificates.progress',
            'certificates.certificate.courses',
            'progressUpdates.course',
        ])->findOrFail($user->id);
        
        // Get the certificates that the intern has started
        $activeCertificates = $intern->certificates;
        
        // Calculate progress for each certificate
        $certificatesWithProgress = $activeCertificates->map(function($internCertificate) use ($intern) {
            // Get all courses for this certificate
            $courses = $internCertificate->certificate->courses;
            $totalCourses = $courses->count();
            
            // Count completed courses
            $completedCourses = 0;
            $courseProgress = [];
            
            foreach($courses as $course) {
                // Find progress update for this course
                $progressUpdate = $intern->progressUpdates
                    ->where('certificate_id', $internCertificate->certificate_id)
                    ->where('course_id', $course->id)
                    ->sortByDesc('created_at')
                    ->first();
                
                $isCompleted = $progressUpdate && $progressUpdate->is_completed;
                if($isCompleted) {
                    $completedCourses++;
                }
                
                // Store course progress data
                $courseProgress[] = [
                    'course' => $course,
                    'progress' => $progressUpdate,
                    'is_completed' => $isCompleted
                ];
            }
            
            // Calculate percentage
            $progressPercentage = $totalCourses > 0 ? round(($completedCourses / $totalCourses) * 100) : 0;
            
            // Get latest certificate progress
            $latestProgress = $internCertificate->progress->sortByDesc('created_at')->first();
            
            return [
                'intern_certificate' => $internCertificate,
                'certificate' => $internCertificate->certificate,
                'provider' => $internCertificate->certificate->provider ?? null,
                'progress_percentage' => $progressPercentage,
                'completed_courses' => $completedCourses,
                'total_courses' => $totalCourses,
                'course_progress' => $courseProgress,
                'latest_certificate_progress' => $latestProgress,
                'started_at' => $internCertificate->started_at,
                'completed_at' => $internCertificate->completed_at,
                'exam_status' => $internCertificate->exam_status
            ];
        });
        
        // Sort certificates by progress percentage (descending)
        $certificatesWithProgress = $certificatesWithProgress->sortByDesc('progress_percentage')->values();
        
        // Calculate overall progress
        $totalCompletedCourses = $certificatesWithProgress->sum('completed_courses');
        $totalCourses = $certificatesWithProgress->sum('total_courses');
        $overallProgress = $totalCourses > 0 ? round(($totalCompletedCourses / $totalCourses) * 100) : 0;
        
        // Get recent progress updates (last 5)
        $recentProgressUpdates = $intern->progressUpdates()
            ->with(['course', 'certificate'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('intern.dashboard', compact(
            'intern',
            'certificatesWithProgress',
            'overallProgress',
            'totalCompletedCourses',
            'totalCourses',
            'recentProgressUpdates'
        ));
    }
}