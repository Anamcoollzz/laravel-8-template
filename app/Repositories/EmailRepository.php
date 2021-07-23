<?php

namespace App\Repositories;

class EmailRepository
{

    public static function emailProvider()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_provider'],
            ['value' => 'mailtrap']
        )->value;
    }

    public static function fromAddress()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_from_address'],
            ['value' => 'hairulanam21@gmail.com']
        )->value;
    }

    public static function fromName()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_from_name'],
            ['value' => 'Superadmin ' . session('_app_name')]
        )->value;
    }

    // START MAILTRAP
    public static function mailtrapHost()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_host'],
            ['value' => 'smtp.mailtrap.io']
        )->value;
    }

    public static function mailtrapPort()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_port'],
            ['value' => '2525']
        )->value;
    }

    public static function mailtrapUsername()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_username'],
            ['value' => '809d58dfa23ade']
        )->value;
    }

    public static function mailtrapPassword()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_password'],
            ['value' => 'e9d1aa54a61db1']
        )->value;
    }

    public static function mailtrapEncryption()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_encryption'],
            ['value' => 'tls']
        )->value;
    }
    // END MAILTRAP

    // START SMTP BIASA
    public static function smtpHost()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_host'],
            ['value' => 'smtp.mailtrap.io']
        )->value;
    }

    public static function smtpPort()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_port'],
            ['value' => '2525']
        )->value;
    }

    public static function smtpUsername()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_username'],
            ['value' => '809d58dfa23ade']
        )->value;
    }

    public static function smtpPassword()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_password'],
            ['value' => 'e9d1aa54a61db1']
        )->value;
    }

    public static function smtpEncryption()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_encryption'],
            ['value' => 'tls']
        )->value;
    }
    // END SMTP BIASA

    // START MAILGUN
    public static function mailgunDomain()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_mailgun_domain'],
            ['value' => 'test']
        )->value;
    }

    public static function mailgunApiKey()
    {
        return \App\Models\Setting::firstOrCreate(
            ['key' => 'mail_mailgun_api_key'],
            ['value' => 'test']
        )->value;
    }
    // END MAILGUN
}
