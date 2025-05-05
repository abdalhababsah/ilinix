<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class MentorAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public User $intern;

    public function __construct(User $intern)
    {
        $this->intern = $intern;
    }

    public function build()
    {
        return $this
            ->subject("You’ve Been Assigned a New Intern")
            ->view('emails.mentor_assigned')
            ->with(['intern' => $this->intern]);
    }
}