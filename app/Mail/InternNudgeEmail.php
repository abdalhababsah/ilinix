<?php

namespace App\Mail;

use App\Models\User;
use App\Models\InternNudge;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InternNudgeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The nudge instance.
     *
     * @var \App\Models\InternNudge
     */
    public $nudge;

    /**
     * The mentor user instance.
     *
     * @var \App\Models\User
     */
    public $mentor;

    /**
     * The intern user instance.
     *
     * @var \App\Models\User
     */
    public $intern;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\InternNudge  $nudge
     * @return void
     */
    public function __construct(InternNudge $nudge)
    {
        $this->nudge = $nudge;
        $this->mentor = $nudge->mentor;
        $this->intern = $nudge->intern;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.intern_nudge')
                   ->subject('Activity Reminder - Please Update Your Progress')
                   ->with([
                       'inactivityDays' => now()->diffInDays($this->nudge->nudged_at),
                       'messageBody' => $this->nudge->message,
                       'subjectLine' => 'Activity Reminder - Please Update Your Progress'
                   ]);
    }
}