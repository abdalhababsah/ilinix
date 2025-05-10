<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\InternFlag;
use App\Models\InternNudge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\InternCertificate;
use App\Models\CertificateProgress;
use App\Models\Voucher;
use App\Models\CertificateProgram;
use App\Models\ProgressUpdate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MentorDashboardController extends Controller
{
    /**
     * Display the mentor dashboard with assigned interns and their progress
     */
    public function index()
    {
        $mentor = Auth::user();

        // Get all assigned interns with their certificates and progress
        $interns = User::with([
            'certificates.certificate.provider',
            'certificates.progress',
            'certificates.certificate.courses',
            'progressUpdates.course',
            'onboardingSteps.step'
        ])->where('assigned_mentor_id', $mentor->id)
            ->where('role_id', 3)
            ->get();

        // Count total assigned interns
        $totalInterns = $interns->count();

        // Count active interns (those who have logged in within the last 7 days)
        $activeInterns = $interns->where('last_login_at', '>=', now()->subDays(7))->count();

        // Count interns with pending voucher requests
        $pendingVoucherRequests = $this->getPendingVoucherRequests($interns);

        // Count interns who have completed certificates
        $internsWithCompletedCertificates = $interns->filter(function ($intern) {
            return $intern->certificates->where('completed_at', '!=', null)->count() > 0;
        })->count();

        // Get recent progress updates from all interns
        $recentProgressUpdates = ProgressUpdate::whereIn('intern_id', $interns->pluck('id'))
            ->with(['intern', 'course', 'certificate'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get upcoming exams


        // Get interns with no activity in the last 14 days
        $inactiveInterns = $this->getInactiveInterns($interns);

        // Get certificate completion statistics
        $certificateStats = $this->getCertificateStats($interns);

        return view('mentor.dashboard', compact(
            'mentor',
            'interns',
            'totalInterns',
            'activeInterns',
            'pendingVoucherRequests',
            'internsWithCompletedCertificates',
            'recentProgressUpdates',

            'inactiveInterns',
            'certificateStats'
        ));
    }

    /**
     * Get pending voucher requests for all interns
     */
    private function getPendingVoucherRequests($interns)
    {
        $pendingRequests = [];

        foreach ($interns as $intern) {
            foreach ($intern->certificates as $internCertificate) {
                // Get the latest progress record with 'requested_voucher' status
                $voucherRequest = $internCertificate->progress()
                    ->where('study_status', 'requested_voucher')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($voucherRequest) {
                    // Check if a voucher has been issued
                    $voucherIssued = $internCertificate->voucher_id !== null;

                    // If voucher not issued yet, add to pending requests
                    if (!$voucherIssued) {
                        $pendingRequests[] = [
                            'intern' => $intern,
                            'certificate' => $internCertificate->certificate,
                            'requested_at' => $voucherRequest->voucher_requested_at,
                            'intern_certificate_id' => $internCertificate->id
                        ];
                    }
                }
            }
        }

        // Sort by request date (oldest first)
        usort($pendingRequests, function ($a, $b) {
            return $a['requested_at'] <=> $b['requested_at'];
        });

        return $pendingRequests;
    }



    /**
     * Get interns with no activity in the last 14 days
     */
    /**
     * Get a list of inactive interns based on their activity
     * 
     * @param \Illuminate\Database\Eloquent\Collection $interns
     * @param \Carbon\Carbon|null $cutoffDate Optional cutoff date, defaults to 14 days ago
     * @return array Array of inactive interns with their last activity details
     */
    private function getInactiveInterns($interns, $cutoffDate = null)
    {
        $inactiveInterns = [];
        $cutoffDate = $cutoffDate ?: now()->subDays(14);

        foreach ($interns as $intern) {
            // Get the latest progress update for this intern's courses
            $lastProgressUpdate = ProgressUpdate::where('intern_id', $intern->id)
                ->orderBy('created_at', 'desc')
                ->first();

            // Get the latest certificate progress update
            $lastCertificateProgress = CertificateProgress::whereIn(
                'intern_certificate_id',
                $intern->certificates->pluck('id')
            )
                ->orderBy('created_at', 'desc')
                ->first();

            // Determine the latest activity date
            $lastActivityDate = null;
            $lastActivitySource = 'No activity recorded';

            // Check all activity sources and find the most recent
            $activitySources = [
                'Course Progress' => $lastProgressUpdate ? $lastProgressUpdate->created_at : null,
                'Certificate Progress' => $lastCertificateProgress ? $lastCertificateProgress->created_at : null,
                'Last Login' => $intern->last_login_at
            ];

            foreach ($activitySources as $source => $date) {
                if ($date && (!$lastActivityDate || $date->gt($lastActivityDate))) {
                    $lastActivityDate = $date;
                    $lastActivitySource = $source;
                }
            }

            // If no activity or activity is before cutoff date, add to inactive list
            if (!$lastActivityDate || $lastActivityDate->lt($cutoffDate)) {
                $inactiveInterns[] = [
                    'intern' => $intern,
                    'last_activity' => $lastActivityDate,
                    'activity_source' => $lastActivitySource,
                    'inactive_days' => $lastActivityDate ? $lastActivityDate->diffInDays(now()) : 'Never active'
                ];
            }
        }

        return $inactiveInterns;
    }

    /**
     * Get certificate completion statistics
     */
    /**
     * Get certificate completion statistics
     */
    private function getCertificateStats($interns)
    {
        $certStats = [];

        // Get all certificates started by interns
        $certificateIds = $interns->flatMap(function ($intern) {
            return $intern->certificates->pluck('certificate_id');
        })->unique();

        $certificates = CertificateProgram::whereIn('id', $certificateIds)->get();

        foreach ($certificates as $certificate) {
            $totalStarted = 0;
            $completed = 0;
            $inProgress = 0;

            foreach ($interns as $intern) {
                $internCertificate = $intern->certificates
                    ->where('certificate_id', $certificate->id)
                    ->first();

                if ($internCertificate) {
                    $totalStarted++;

                    if ($internCertificate->completed_at) {
                        $completed++;
                    } else {
                        $inProgress++;
                    }
                }
            }

            if ($totalStarted > 0) {
                $certStats[] = [
                    'certificate' => $certificate,
                    'total_started' => $totalStarted,
                    'completed' => $completed,
                    'in_progress' => $inProgress,
                    'completion_rate' => round(($completed / $totalStarted) * 100)
                ];
            }
        }

        return $certStats;
    }

    


}