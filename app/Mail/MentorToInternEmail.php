<?php

namespace App\Mail;

use App\Models\User;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class MentorToInternEmail extends Mailable 
{
    use  SerializesModels;

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
     * The email message body.
     *
     * @var string
     */
    public $messageBody;

    /**
     * The email subject line.
     *
     * @var string
     */
    public $subjectLine;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $mentor
     * @param  \App\Models\User  $intern
     * @param  string  $subject
     * @param  string  $message
     * @return void
     */
    public function __construct(User $mentor, User $intern, $subject, $message)
    {
        $this->mentor = $mentor;
        $this->intern = $intern;
        $this->subjectLine = $subject;
        $this->messageBody = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mentor_to_intern')
                    ->subject($this->subjectLine);
    }
}