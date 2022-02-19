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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        $setting = Setting::where('key', 'mail_from_name')->first();
        if (!$setting) {
            $appName = SettingRepository::appName();
            $setting = Setting::create([
                'key' => 'mail_from_name',
                'value' => 'Superadmin ' . $appName,
            ]);
        }
        return $setting->value;
    }

    // START MAILTRAP
    /**
     * mailtrapHost
     *
     * @return string
     */
    public static function mailtrapHost()
    {
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
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
        return Setting::firstOrCreate(
            ['key' => 'mail_mailgun_api_key'],
            ['value' => 'test']
        )->value;
    }
    // END MAILGUN
}
