<?php

namespace App\Mail;

use App\Models\User;
use App\Models\InternFlag;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InternFlagEmail extends Mailable 
{
    use Queueable, SerializesModels;

    /**
     * The flag instance.
     *
     * @var \App\Models\InternFlag
     */
    public $flag;

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
     * @param  \App\Models\InternFlag  $flag
     * @return void
     */
    public function __construct(InternFlag $flag)
    {
        $this->flag = $flag;
        $this->mentor = $flag->mentor;
        $this->intern = $flag->intern;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.intern_flag')
                   ->subject('Important: Update Needed on Your Internship Status')
                   ->with([
                       'inactivityDays' => now()->diffInDays($this->flag->flagged_at),
                       'reason' => $this->flag->reason,
                       'subjectLine' => 'Important: Update Needed on Your Internship Status'
                   ]);
    }
}