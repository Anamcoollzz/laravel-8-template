<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
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
        return $this->subject(__('Atur Ulang Kata Sandi'))->view('stisla.emails.forgot-password', [
            'isVerificationCode' => $this->isVerificationCode
        ]);
    }
}
