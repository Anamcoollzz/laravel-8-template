<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * user var
     *
     * @var User
     */
    public User $user;

    /**
     * isVerificationCode var
     *
     * @var bool
     */
    private bool $isVerificationCode;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param bool $isVerificationCode
     * @return void
     */
    public function __construct(User $user, bool $isVerificationCode)
    {
        $this->user = $user;
        $this->isVerificationCode = $isVerificationCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Verifikasi Akun'))->view('stisla.emails.verification-account', [
            'isVerificationCode' => $this->isVerificationCode
        ]);
    }
}
