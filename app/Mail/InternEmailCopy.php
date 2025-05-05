<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InternEmailCopy extends Mailable
{
    use Queueable, SerializesModels;

    public string $originalRecipient;
    public string $subjectLine;
    public string $bodyMessage;

    public function __construct(string $originalRecipient, string $subjectLine, string $bodyMessage)
    {
        $this->originalRecipient = $originalRecipient;
        $this->subjectLine       = $subjectLine;
        $this->bodyMessage       = $bodyMessage;
    }

    public function build()
    {
        return $this
            ->subject("Copy: " . $this->subjectLine)
            ->view('emails.intern_email_copy')
            ->with([
                'recipient'  => $this->originalRecipient,
                'messageBody'=> $this->bodyMessage,
            ]);
    }
}