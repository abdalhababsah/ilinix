<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MentorEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $subjectLine;
    public string $messageBody;

    /**
     * @param  string  $subjectLine
     * @param  string  $messageBody
     */
    public function __construct(string $subjectLine, string $messageBody)
    {
        $this->subjectLine  = $subjectLine;
        $this->messageBody  = $messageBody;
    }

    public function build()
    {
        return $this
            ->subject($this->subjectLine)
            ->view('emails.mentor_email')
            ->with([
                'subjectLine' => $this->subjectLine,
                'messageBody' => $this->messageBody,
            ]);
    }
}