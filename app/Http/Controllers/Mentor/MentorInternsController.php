<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Mail\InternFlagEmail;
use App\Mail\InternNudgeEmail;
use App\Mail\MentoringSessionScheduled;
use App\Models\InternFlag;
use App\Models\InternNudge;
use App\Models\MentoringSession;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;
use Storage;
use App\Mail\MentorToInternEmail;
use App\Mail\MentorToInternCopy;
class MentorInternsController extends Controller
{
    /**
     * Show detailed view of a specific intern
     */
    public function show($id)
    {
        $mentor = Auth::user();

        // Ensure the intern is assigned to this mentor
        $intern = User::where('id', $id)
            ->where('assigned_mentor_id', $mentor->id)
            ->with([
                'certificates.certificate.provider',
                'certificates.progress',
                'certificates.certificate.courses',
                'progressUpdates.course',
                'onboardingSteps.step',
                'mentor',
                'role',
            ])
            ->firstOrFail();

        // Get certificates with progress percentage
        $certificates = [];

        foreach ($intern->certificates as $internCertificate) {
            $totalCourses = $internCertificate->certificate->courses->count();
            $completedCourses = $intern->progressUpdates
                ->where('certificate_id', $internCertificate->certificate_id)
                ->where('is_completed', true)
                ->count();

            $progressPercentage = $totalCourses > 0 ? round(($completedCourses / $totalCourses) * 100) : 0;

            $certificates[] = [
                'intern_certificate' => $internCertificate,
                'certificate' => $internCertificate->certificate,
                'progress_percentage' => $progressPercentage,
                'completed_courses' => $completedCourses,
                'total_courses' => $totalCourses
            ];
        }
        // Get flag details - check if the intern is currently flagged by this mentor
        $currentFlag = InternFlag::where('intern_id', $id)
            ->where('mentor_id', Auth::id())
            ->where('status', '!=', 'cleared')
            ->orderBy('flagged_at', 'desc')
            ->first();

        // Get history of nudges for this intern by this mentor
        $nudges = InternNudge::where('intern_id', $id)
            ->where('mentor_id', Auth::id())
            ->orderBy('nudged_at', 'desc')
            ->get();
        // Get recent progress updates
        $recentProgressUpdates = $intern->progressUpdates()
            ->with(['course', 'certificate'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate onboarding progress
        $completedOnboardingSteps = $intern->onboardingSteps->where('is_completed', true)->count();
        $totalOnboardingSteps = $intern->onboardingSteps->count();
        $onboardingProgress = $totalOnboardingSteps > 0 ? round(($completedOnboardingSteps / $totalOnboardingSteps) * 100) : 0;

        return view('mentor.interns.show', compact(
            'mentor',
            'intern',
            'certificates',
            'recentProgressUpdates',
            'completedOnboardingSteps',
            'totalOnboardingSteps',
            'onboardingProgress',
            'currentFlag',
            'nudges'
        ));
    }


    /**
     * Store a newly created mentoring session
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $intern  The intern ID from the route
     * @return \Illuminate\Http\Response
     */
    public function storeSession(Request $request, $intern)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'session_date' => 'required|date|after_or_equal:today',
            'session_time' => 'required',
            'duration' => 'required|integer|min:15|max:180',
            'agenda' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
            'meeting_link' => 'nullable|url',
            'intern_notified' => 'sometimes|boolean',
        ]);

        // Add mentor ID and intern ID to the validated data
        $validated['mentor_id'] = Auth::id();
        $validated['intern_id'] = $intern; // Use the route parameter

        // Create the session
        $session = MentoringSession::create($validated);

        // Send notification email if requested
        if ($request->boolean('intern_notified')) {
            $internUser = User::findOrFail($intern);

            // Generate ICS file
            $icsContent = $this->generateIcsContent($session, $internUser);
            $icsFileName = 'session_' . $session->id . '_' . time() . '.ics';
            $icsPath = 'ics_files/' . $icsFileName;

            // Store ICS file
            Storage::disk('public')->put($icsPath, $icsContent);
            $session->update([
                'ics_file' => $icsPath,
                'intern_notified' => true
            ]);

            // Send the email with ICS attachment
            Mail::to($internUser->email)
                ->send(new MentoringSessionScheduled($session, $internUser));
        }

        return redirect()->route('mentor.interns.show', $intern)
            ->with('success', 'Mentoring session scheduled successfully!');
    }

    /**
     * Generate ICS calendar content
     *
     * @param MentoringSession $session
     * @param User $intern
     * @return string
     */
    private function generateIcsContent($session, $intern)
    {
        // Create unique identifier for the event
        $uid = md5($session->id . $session->created_at->timestamp);

        // Get mentor info
        $mentor = User::find($session->mentor_id);

        // Format start and end time
        $startDateTime = Carbon::parse($session->session_date . ' ' . $session->session_time);
        $endDateTime = $startDateTime->copy()->addMinutes((int) $session->duration);

        $startUTC = $startDateTime->format('Ymd\THis\Z');
        $endUTC = $endDateTime->format('Ymd\THis\Z');
        $now = Carbon::now()->format('Ymd\THis\Z');

        // Build description with meeting link if available
        $description = $session->agenda ?? "Mentoring session with {$mentor->first_name} {$mentor->last_name}";
        if ($session->meeting_link) {
            $description .= "\n\nJoin the meeting: " . $session->meeting_link;
        }

        // Clean up description for ICS format
        $description = $this->cleanStringForIcs($description);

        // Build ICS content
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//Our Internship Program//Mentoring Sessions//EN\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:REQUEST\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:{$uid}\r\n";
        $ics .= "DTSTAMP:{$now}\r\n";
        $ics .= "DTSTART:{$startUTC}\r\n";
        $ics .= "DTEND:{$endUTC}\r\n";
        $ics .= "SUMMARY:{$session->title}\r\n";
        $ics .= "DESCRIPTION:{$description}\r\n";

        // Add location if meeting link exists
        if ($session->meeting_link) {
            $ics .= "LOCATION:{$session->meeting_link}\r\n";
        }

        $ics .= "ORGANIZER;CN={$mentor->first_name} {$mentor->last_name}:mailto:{$mentor->email}\r\n";
        $ics .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN={$intern->first_name} {$intern->last_name}:mailto:{$intern->email}\r\n";
        $ics .= "STATUS:CONFIRMED\r\n";
        $ics .= "SEQUENCE:0\r\n";
        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";

        return $ics;
    }

    /**
     * Clean string for ICS format
     *
     * @param string $string
     * @return string
     */
    private function cleanStringForIcs($string)
    {
        // Remove line breaks and replace with \n
        $string = str_replace(["\r\n", "\n", "\r"], "\\n", $string);

        // Remove other special characters
        $string = preg_replace('/[,;]/', ' ', $string);

        return $string;
    }


    /**
     * Send an email to an intern
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request, $id)
    {
        $intern = User::findOrFail($id);

        // Verify this mentor is assigned to this intern
        if ($intern->assigned_mentor_id !== Auth::id()) {
            return redirect()->route('mentor.interns.index')
                ->with('error', 'You do not have permission to email this intern.');
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'copy_me' => 'sometimes|boolean',
        ]);

        // Get mentor information
        $mentor = Auth::user();

        try {
            // Send email to intern
            Mail::to($intern->email)
                ->send(new MentorToInternEmail($mentor, $intern, $request->subject, $request->message));

            // Send copy to mentor if requested
            if ($request->boolean('copy_me')) {
                Mail::to($mentor->email)
                    ->send(new MentorToInternCopy($mentor, $intern, $request->subject, $request->message));
            }


            return redirect()->route('mentor.interns.show', $intern->id)
                ->with('success', 'Email sent successfully to ' . $intern->email);

        } catch (\Exception $e) {
            return redirect()->route('mentor.interns.show', $intern->id)
                ->with('error', 'Error sending email: ' . $e->getMessage());
        }
    }
    /**
     * Send a nudge to an inactive intern
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nudgeIntern(Request $request, $id)
    {
        $intern = User::findOrFail($id);

        // Verify this mentor is assigned to this intern
        if ($intern->assigned_mentor_id !== Auth::id()) {
            return redirect()->route('mentor.interns.index')
                ->with('error', 'You do not have permission to nudge this intern.');
        }

        $request->validate([
            'message' => 'required|string|min:10',
        ]);

        try {
            // Create the nudge record
            $nudge = InternNudge::create([
                'mentor_id' => Auth::id(),
                'intern_id' => $intern->id,
                'message' => $request->message,
                'nudged_at' => now(),
                'email_sent' => true
            ]);

            // Send the nudge email
            Mail::to($intern->email)
                ->send(new InternNudgeEmail($nudge));

            return redirect()->route('mentor.interns.show', $intern->id)
                ->with('success', 'Nudge sent to ' . $intern->first_name . ' ' . $intern->last_name);

        } catch (\Exception $e) {
            return redirect()->route('mentor.interns.show', $intern->id)
                ->with('error', 'Error sending nudge: ' . $e->getMessage());
        }
    }

    /**
     * Flag an inactive intern
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function flagIntern(Request $request, $id)
    {
        $intern = User::findOrFail($id);

        // Verify this mentor is assigned to this intern
        if ($intern->assigned_mentor_id !== Auth::id()) {
            return redirect()->route('mentor.interns.index')
                ->with('error', 'You do not have permission to flag this intern.');
        }

        $request->validate([
            'reason' => 'required|string|min:10',
            'send_email' => 'sometimes|boolean',
        ]);

        try {
            // Create the flag record
            $flag = InternFlag::create([
                'mentor_id' => Auth::id(),
                'intern_id' => $intern->id,
                'reason' => $request->reason,
                'status' => 'pending',
                'email_sent' => $request->boolean('send_email'),
                'flagged_at' => now()
            ]);

            // Send the flag email if requested
            if ($request->boolean('send_email')) {
                Mail::to($intern->email)
                    ->send(new InternFlagEmail($flag));
            }

            return redirect()->route('mentor.interns.show', $intern->id)
                ->with('success', 'Intern has been flagged for review by administrators.');

        } catch (\Exception $e) {
            return redirect()->route('mentor.interns.show', $intern->id)
                ->with('error', 'Error flagging intern: ' . $e->getMessage());
        }
    }
}
