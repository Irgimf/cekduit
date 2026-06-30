<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otpCode, public string $purpose = 'verifikasi akun')
    {
    }

    public function build()
    {
        return $this->subject('Kode OTP CekDuit')
            ->view('emails.otp');
    }
}