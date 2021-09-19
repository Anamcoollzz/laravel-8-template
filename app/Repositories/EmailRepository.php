<?php

namespace App\Repositories;

use App\Models\Setting;

class EmailRepository
{

    /**
     * emailProvider
     *
     * @return string
     */
    public static function emailProvider()
    {
        return session('_mail_provider') ?? Setting::firstOrCreate(
            ['key' => 'mail_provider'],
            ['value' => 'mailtrap']
        )->value;
    }

    /**
     * fromAddress
     *
     * @return string
     */
    public static function fromAddress()
    {
        return session('_mail_from_address') ?? Setting::firstOrCreate(
            ['key' => 'mail_from_address'],
            ['value' => 'hairulanam21@gmail.com']
        )->value;
    }

    /**
     * fromName
     *
     * @return string
     */
    public static function fromName()
    {
        return session('_mail_from_name') ?? Setting::firstOrCreate(
            ['key' => 'mail_from_name'],
            ['value' => 'Superadmin ' . session('_app_name')]
        )->value;
    }

    // START MAILTRAP
    /**
     * mailtrapHost
     *
     * @return string
     */
    public static function mailtrapHost()
    {
        return session('_mail_mailtrap_host') ?? Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_host'],
            ['value' => 'smtp.mailtrap.io']
        )->value;
    }

    /**
     * mailtrapPort
     *
     * @return string
     */
    public static function mailtrapPort()
    {
        return session('_mail_mailtrap_port') ?? Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_port'],
            ['value' => '2525']
        )->value;
    }

    /**
     * mailtrapUsername
     *
     * @return string
     */
    public static function mailtrapUsername()
    {
        return session('_mail_mailtrap_username') ?? Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_username'],
            ['value' => '809d58dfa23ade']
        )->value;
    }

    /**
     * mailtrapPassword
     *
     * @return string
     */
    public static function mailtrapPassword()
    {
        return session('_mail_mailtrap_password') ?? Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_password'],
            ['value' => 'e9d1aa54a61db1']
        )->value;
    }

    /**
     * mailtrapEncryption
     *
     * @return string
     */
    public static function mailtrapEncryption()
    {
        return session('_mail_mailtrap_encryption') ?? Setting::firstOrCreate(
            ['key' => 'mail_mailtrap_encryption'],
            ['value' => 'tls']
        )->value;
    }
    // END MAILTRAP

    // START SMTP BIASA
    /**
     * smtpHost
     *
     * @return string
     */
    public static function smtpHost()
    {
        return session('_mail_host') ?? Setting::firstOrCreate(
            ['key' => 'mail_host'],
            ['value' => 'smtp.mailtrap.io']
        )->value;
    }

    /**
     * smtpPort
     *
     * @return string
     */
    public static function smtpPort()
    {
        return session('_mail_port') ?? Setting::firstOrCreate(
            ['key' => 'mail_port'],
            ['value' => '2525']
        )->value;
    }

    /**
     * smtpUsername
     *
     * @return string
     */
    public static function smtpUsername()
    {
        return session('_mail_username') ?? Setting::firstOrCreate(
            ['key' => 'mail_username'],
            ['value' => '809d58dfa23ade']
        )->value;
    }

    /**
     * smtpPassword
     *
     * @return string
     */
    public static function smtpPassword()
    {
        return session('_mail_password') ?? Setting::firstOrCreate(
            ['key' => 'mail_password'],
            ['value' => 'e9d1aa54a61db1']
        )->value;
    }

    /**
     * smtpEncryption
     *
     * @return string
     */
    public static function smtpEncryption()
    {
        return session('_mail_encryption') ?? Setting::firstOrCreate(
            ['key' => 'mail_encryption'],
            ['value' => 'tls']
        )->value;
    }
    // END SMTP BIASA

    // START MAILGUN
    /**
     * mailgunDomain
     *
     * @return string
     */
    public static function mailgunDomain()
    {
        return session('_mail_mailgun_domain') ?? Setting::firstOrCreate(
            ['key' => 'mail_mailgun_domain'],
            ['value' => 'test']
        )->value;
    }

    /**
     * mailgunApiKey
     *
     * @return string
     */
    public static function mailgunApiKey()
    {
        return session('_mail_mailgun_api_key') ?? Setting::firstOrCreate(
            ['key' => 'mail_mailgun_api_key'],
            ['value' => 'test']
        )->value;
    }
    // END MAILGUN
}
