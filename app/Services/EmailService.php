<?php

namespace App\Services;

use App\Models\User;
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
        $mail_from_address = \App\Models\Setting::firstOrCreate(['key' => 'mail_from_address',], ['value' => 'hairulanam21@gmail.com'])->value;
        $mail_from_name    = \App\Models\Setting::firstOrCreate(['key' => 'mail_from_name',], ['value' => 'Superadmin ' . session('_app_name')])->value;
        $mail_host         = \App\Models\Setting::firstOrCreate(['key' => 'mail_host',], ['value' => 'smtp.mailtrap.io'])->value;
        $mail_port         = \App\Models\Setting::firstOrCreate(['key' => 'mail_port',], ['value' => '2525'])->value;
        $mail_username     = \App\Models\Setting::firstOrCreate(['key' => 'mail_username',], ['value' => '809d58dfa23ade'])->value;
        $mail_password     = \App\Models\Setting::firstOrCreate(['key' => 'mail_password',], ['value' => 'e9d1aa54a61db1'])->value;
        $mail_encryption   = \App\Models\Setting::firstOrCreate(['key' => 'mail_encryption',], ['value' => 'tls'])->value;
        config(['mail.from.address' => $mail_from_address]);
        config(['mail.from.name' => $mail_from_name]);
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
}
