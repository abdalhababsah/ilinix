<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MentorEmailCopy extends Mailable
{
    use Queueable, SerializesModels;

    public string $originalRecipient;
    public string $subjectLine;
    public string $messageBody;

    /**
     * @param  string  $originalRecipient
     * @param  string  $subjectLine
     * @param  string  $messageBody
     */
    public function __construct(string $originalRecipient, string $subjectLine, string $messageBody)
    {
        $this->originalRecipient = $originalRecipient;
        $this->subjectLine       = $subjectLine;
        $this->messageBody       = $messageBody;
    }

    public function build()
    {
        return $this
            ->subject("Copy: " . $this->subjectLine)
            ->view('emails.mentor_email_copy')
            ->with([
                'originalRecipient' => $this->originalRecipient,
                'subjectLine'       => $this->subjectLine,
                'messageBody'       => $this->messageBody,
            ]);
    }
}