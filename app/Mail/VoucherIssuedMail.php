<?php
namespace App\Mail;

use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    public function build()
    {
        return $this->subject('You Have Received a New Voucher')
                    ->view('emails.voucher-issued');
    }
}