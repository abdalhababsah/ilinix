<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InternEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $subjectLine;
    public string $bodyMessage;

    /**
     * @param  string  $subjectLine
     * @param  string  $bodyMessage
     */
    public function __construct(string $subjectLine, string $bodyMessage)
    {
        $this->subjectLine  = $subjectLine;
        $this->bodyMessage  = $bodyMessage;
    }

    public function build()
    {
        return $this
            ->subject($this->subjectLine)
            ->view('emails.intern_email')
            ->with([
                'messageBody' => $this->bodyMessage,
            ]);
    }
}