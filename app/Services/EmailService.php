<?php

namespace App\Services;

use App\Mail\TestingMail;
use App\Models\User;
use App\Repositories\EmailRepository;
use Illuminate\Support\Facades\Mail;

class EmailService
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $mail_provider     = EmailRepository::emailProvider();
        $mail_from_address = EmailRepository::fromAddress();
        $mail_from_name    = EmailRepository::fromName();
        if ($mail_provider === 'smtp') {
            $mail_host         = EmailRepository::smtpHost();
            $mail_port         = EmailRepository::smtpPort();
            $mail_username     = EmailRepository::smtpUsername();
            $mail_password     = EmailRepository::smtpPassword();
            $mail_encryption   = EmailRepository::smtpEncryption();
        } else if ($mail_provider === 'mailtrap') {
            $mail_host         = EmailRepository::mailtrapHost();
            $mail_port         = EmailRepository::mailtrapPort();
            $mail_username     = EmailRepository::mailtrapUsername();
            $mail_password     = EmailRepository::mailtrapPassword();
            $mail_encryption   = EmailRepository::mailtrapEncryption();
        } else {
        }
        config(['mail.from.address' => $mail_from_address]);
        config(['mail.from.name' => $mail_from_name]);
        if ($mail_provider === 'smtp' || $mail_provider === 'mailtrap') {
            config(['mail.default' => 'smtp']);
            config(['mail.mailers.smtp' => [
                'transport'  => 'smtp',
                'host'       => $mail_host,
                'port'       => $mail_port,
                'encryption' => $mail_encryption,
                'username'   => $mail_username,
                'password'   => $mail_password,
                'timeout'    => null,
                'auth_mode'  => null,
            ]]);
        } else if ($mail_provider === 'mailgun') {
            $domain = EmailRepository::mailgunDomain();
            $apiKey = EmailRepository::mailgunApiKey();
            config(['mail.default' => 'mailgun']);
            config([
                'services.mailgun' => [
                    'domain'   => $domain,
                    'secret'   => $apiKey,
                    'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
                ]
            ]);
        }
    }

    /**
     * forgot password
     *
     * @param User $user
     * @return void
     */
    public function forgotPassword(User $user)
    {
        Mail::to($user->email)->send(new \App\Mail\ForgotPasswordMail($user));
    }

    /**
     * verification account
     *
     * @param User $user
     * @return void
     */
    public function verifyAccount(User $user)
    {
        Mail::to($user->email)->send(new \App\Mail\VerificationAccountMail($user));
    }

    /**
     * testing email
     *
     * @param string $to
     * @param string $text
     * @return void
     */
    public function testing(string $to, string $text)
    {
        Mail::to($to)->send(new TestingMail($text));
    }
}
