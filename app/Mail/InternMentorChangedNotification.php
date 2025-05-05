<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class InternMentorChangedNotification extends Mailable
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
            ->subject("Your Mentor Has Been Updated")
            ->view('emails.intern_mentor_changed')
            ->with(['intern' => $this->intern]);
    }
}