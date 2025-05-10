<?php

namespace App\Mail;

use App\Models\MentoringSession;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class MentoringSessionScheduled extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The mentoring session instance.
     *
     * @var \App\Models\MentoringSession
     */
    public $session;

    /**
     * The intern User model.
     *
     * @var \App\Models\User
     */
    public $intern;

    /**
     * The mentor User model.
     *
     * @var \App\Models\User
     */
    public $mentor;

    /**
     * The formatted session date and time.
     *
     * @var string
     */
    public $sessionDateTime;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\MentoringSession  $session
     * @param  \App\Models\User  $intern
     * @return void
     */
    public function __construct(MentoringSession $session, User $intern)
    {
        $this->session = $session;
        $this->intern = $intern;
        $this->mentor = User::find($session->mentor_id);
        
        // Format the date and time
        $dateTime = Carbon::parse($session->session_date . ' ' . $session->session_time);
        $this->sessionDateTime = $dateTime->format('l, F j, Y \a\t g:i A');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Generate ICS content directly if it's not stored
        if (!$this->session->ics_file) {
            $icsContent = $this->generateIcsContent();
            
            return $this->subject('Mentoring Session Scheduled: ' . $this->session->title)
                    ->view('emails.mentoring_session')
                    ->attachData($icsContent, 'mentoring_session.ics', [
                        'mime' => 'text/calendar',
                    ]);
        }
        
        // Use stored ICS file if available
        return $this->subject('Mentoring Session Scheduled: ' . $this->session->title)
                ->view('emails.mentoring_session')
                ->attach(storage_path('app/public/' . $this->session->ics_file), [
                    'mime' => 'text/calendar',
                    'as' => 'mentoring_session.ics',
                ]);
    }
    
    /**
     * Generate ICS calendar content
     *
     * @return string
     */
    private function generateIcsContent()
    {
        // Create unique identifier for the event
        $uid = md5($this->session->id . $this->session->created_at->timestamp);
        
        // Format start and end time in UTC
        $startDateTime = Carbon::parse($this->session->session_date . ' ' . $this->session->session_time);
        $endDateTime = $startDateTime->copy()->addMinutes($this->session->duration);
        
        $startUTC = $startDateTime->format('Ymd\THis\Z');
        $endUTC = $endDateTime->format('Ymd\THis\Z');
        $now = Carbon::now()->format('Ymd\THis\Z');
        
        // Build description that includes meeting link if available
        $description = $this->session->agenda ?? "Mentoring session with {$this->mentor->first_name} {$this->mentor->last_name}";
        if ($this->session->meeting_link) {
            $description .= "\n\nJoin the meeting: " . $this->session->meeting_link;
        }
        
        // Clean description for ICS format
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
        $ics .= "SUMMARY:{$this->session->title}\r\n";
        $ics .= "DESCRIPTION:{$description}\r\n";
        
        // Add location if meeting link exists
        if ($this->session->meeting_link) {
            $ics .= "LOCATION:{$this->session->meeting_link}\r\n";
        }
        
        $ics .= "ORGANIZER;CN={$this->mentor->first_name} {$this->mentor->last_name}:mailto:{$this->mentor->email}\r\n";
        $ics .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN={$this->intern->first_name} {$this->intern->last_name}:mailto:{$this->intern->email}\r\n";
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
}