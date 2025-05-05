<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateProgram;
use App\Models\CertificateProgress;
use App\Models\InternCertificate;
use App\Models\ProgressUpdate;
use App\Models\Provider;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(){
        // User statistics
        $totalInterns = User::where('role_id', 3)->count();
        $totalMentors = User::where('role_id', 2)->count();
        $activeInterns = User::where('role_id', 3)->where('status', 'active')->count();
        $completedInterns = User::where('role_id', 3)->where('status', 'completed')->count();
        $inactiveInterns = User::where('role_id', 3)->where('status', 'inactive')->count();
        $unassignedInterns = User::where('role_id', 3)->whereNull('assigned_mentor_id')->count();
        $newInternsThisMonth = User::where('role_id', 3)
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        // Certificate statistics
        $totalCertificates = CertificateProgram::count();
        $totalCertificateAssignments = InternCertificate::count();
        $passedExams = InternCertificate::where('exam_status', 'passed')->count();
        $failedExams = InternCertificate::where('exam_status', 'failed')->count();
        $scheduledExams = InternCertificate::where('exam_status', 'scheduled')->count();
        $notTakenExams = InternCertificate::where('exam_status', 'not_taken')->count();
        $completedCertificates = InternCertificate::whereNotNull('completed_at')->count();
        
        // Progress statistics
        $totalProgressUpdates = ProgressUpdate::count();
        $progressUpdatesThisWeek = ProgressUpdate::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $completedCourses = ProgressUpdate::where('is_completed', true)->count();
        
        // Certificate progress by status
        $certProgressByStatus = CertificateProgress::select('study_status', DB::raw('count(*) as total'))
            ->groupBy('study_status')
            ->get()
            ->pluck('total', 'study_status')
            ->toArray();
        
        // Provider statistics
        $providerStats = Provider::withCount('certificates')->get();
        
        // Voucher statistics
        $availableVouchers = Voucher::where('used', false)->count();
        $usedVouchers = Voucher::where('used', true)->count();
        
        // Recent activity
        $recentProgressUpdates = ProgressUpdate::with(['intern', 'certificate', 'course'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        $recentCertificateProgress = CertificateProgress::with(['internCertificate.user', 'internCertificate.certificate'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Monthly stats for charts
        $monthlySignups = User::where('role_id', 3)
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();
            
        $monthlyCertificatesCompleted = InternCertificate::whereNotNull('completed_at')
            ->where('completed_at', '>=', Carbon::now()->subMonths(6))
            ->select(DB::raw('MONTH(completed_at) as month'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('MONTH(completed_at)'))
            ->orderBy('month')
            ->get();
            
        $topCertificates = InternCertificate::select('certificate_id', DB::raw('count(*) as assignments'))
            ->groupBy('certificate_id')
            ->orderByDesc('assignments')
            ->with('certificate')
            ->take(5)
            ->get();
            
        // Chart data for certification status
        $certificationStatusData = [
            'notTaken' => $notTakenExams,
            'scheduled' => $scheduledExams,
            'passed' => $passedExams,
            'failed' => $failedExams
        ];
            
        return view('admin.dashboard', compact(
            'totalInterns', 'totalMentors', 'activeInterns', 'completedInterns', 
            'inactiveInterns', 'unassignedInterns', 'newInternsThisMonth',
            'totalCertificates', 'totalCertificateAssignments', 'passedExams', 
            'failedExams', 'scheduledExams', 'completedCertificates',
            'totalProgressUpdates', 'progressUpdatesThisWeek', 'completedCourses',
            'certProgressByStatus', 'providerStats', 'availableVouchers', 'usedVouchers',
            'recentProgressUpdates', 'recentCertificateProgress',
            'monthlySignups', 'monthlyCertificatesCompleted', 'topCertificates',
            'certificationStatusData'
        ));
    }
}