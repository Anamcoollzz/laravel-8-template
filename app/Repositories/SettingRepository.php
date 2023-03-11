<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Helpers\StringHelper;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class SettingRepository
{

    /**
     * get all data
     *
     * @return Collection
     */
    public static function all()
    {
        $data = Setting::all();
        return $data;
    }

    /**
     * get all key encrypted
     *
     * @return array
     */
    public static function getEncryptedKeys()
    {
        $encrypts = [
            'google_captcha_secret',
            'google_captcha_site_key',
            'sso_google_client_id',
            'sso_google_client_secret',
            'sso_google_redirect',
            'sso_facebook_client_id',
            'sso_facebook_client_secret',
            'sso_facebook_redirect',
            'sso_twitter_client_id',
            'sso_twitter_client_secret',
            'sso_twitter_redirect',
            'sso_github_client_id',
            'sso_github_client_secret',
            'sso_github_redirect',
        ];
        return $encrypts;
    }

    /**
     * update data by key
     *
     * @param array $data
     * @param string $key
     * @return Model
     */
    public static function updateByKey(array $data, string $key)
    {
        $model = Setting::where('key', $key);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return 0;
    }

    /**
     * get setting formatted
     *
     * @return array
     */
    public static function settings()
    {
        $data = [];
        foreach (static::all() as $d) {
            $data['_' . $d->key] = $d->value;
            if ($d->key === 'application_name') {
                $data['_app_name'] = $d->value;
                $data['_app_name_mobile'] = \App\Helpers\StringHelper::acronym($d->value, 2);
            } else if ($d->key === 'logo') {
                $data['_logo_url'] = SettingRepository::logoUrl($d->value);
            } else if ($d->key === 'stisla_skin') {
                $data['_skin'] = $d->value;
            } else if ($d->key === 'stisla_bg_login') {
                $data['_stisla_bg_login_url'] = $data['_stisla_bg_login'] = SettingRepository::loginBgUrl($d->value);
            } else if ($d->key === 'stisla_sidebar_mini') {
                $data['_sidebar_mini'] = $d->value;
            } else if ($d->key === 'application_version') {
                $data['_version '] = $d->value;
            }
        }
        return $data;
    }

    /**
     * get application name
     *
     * @return Setting
     */
    public static function applicationName()
    {
        return Setting::firstOrCreate(['key' => 'application_name'], ['value' => 'Laravel 8 Admin Template'])->value;
    }

    /**
     * get application name
     *
     * @return Setting
     */
    public static function appName()
    {
        return static::applicationName();
    }

    /**
     * update application name
     *
     * @return int
     */
    public static function updateApplicationName(string $applicationName)
    {
        return Setting::where(['key' => 'application_name'])->update(['value' => $applicationName]);
    }

    /**
     * get company name
     *
     * @return Setting
     */
    public static function companyName()
    {
        return Setting::firstOrCreate(['key' => 'company_name'], ['value' => 'Dummy Company Name'])->value;
    }

    /**
     * update company name
     *
     * @return int
     */
    public function updateCompanyName(string $companyName)
    {
        return Setting::where(['key' => 'company_name'])->update(['value' => $companyName]);
    }

    /**
     * get since
     *
     * @return Setting
     */
    public static function since()
    {
        return Setting::firstOrCreate(['key' => 'since'], ['value' => '2021'])->value;
    }

    /**
     * update since
     *
     * @return int
     */
    public function updatesince(string $since)
    {
        return Setting::where(['key' => 'since'])->update(['value' => $since]);
    }

    /**
     * get application version
     *
     * @return Setting
     */
    public static function applicationVersion()
    {
        return Setting::firstOrCreate(['key' => 'application_version'], ['value' => '1.0.0'])->value;
    }

    /**
     * get application skin
     *
     * @return Setting
     */
    public static function skin()
    {
        return Setting::firstOrCreate(['key' => 'skin'], ['value' => 'red'])->value;
    }

    /**
     * get application stisla skin
     *
     * @return Setting
     */
    public static function stislaSkin()
    {
        return Setting::firstOrCreate(['key' => 'stisla_skin'], ['value' => 'style'])->value;
    }

    /**
     * get skins app
     *
     * @return array
     */
    public static function getSkins()
    {
        return [
            "red",
            "pink",
            "purple",
            "deep-purple",
            "indigo",
            "blue",
            "light-blue",
            "cyan",
            "teal",
            "green",
            "light-green",
            "lime",
            "yellow",
            "amber",
            "orange",
            "deep-orange",
            "brown",
            "grey",
            "blue-grey",
            "black",
        ];
    }

    /**
     * get stisla skins app
     *
     * @return array
     */
    public static function getStislaSkins()
    {
        return [
            "style"  => "default",
            "brown"  => "brown",
            "purple" => "purple",
            "red"    => "red",
            "indigo" => "indigo",
            "yellow" => "yellow",
            "orange" => "orange",
            "pink"   => "pink",
            "citron" => "citron",
        ];
    }

    /**
     * get logo url
     *
     * @param string|null $path
     * @return string
     */
    public static function logoUrl($logo = null)
    {
        if (config('app.template') === 'stisla') {
            if (is_null($logo))
                $logo = Setting::where('key', 'logo')->first()->value;
            if ($logo) {
                if (StringHelper::isUrl($logo)) {
                    return $logo;
                }
                if (Storage::exists('public/settings/' . $logo)) {
                    return asset('storage/settings/' . $logo);
                } else {
                    $logo = null;
                }
            }
        }
        if (is_null($logo)) {
            return asset('images/logo.png');
        }
    }

    /**
     * get login bg url
     *
     * @param string|null $bgLogin
     * @return string
     */
    public static function loginBgUrl($bgLogin = null)
    {
        if (TEMPLATE === STISLA) {
            if (is_null($bgLogin))
                $bgLogin =  Setting::where('key', 'stisla_bg_login')->first()->value;
            if (StringHelper::isUrl($bgLogin)) {
                return $bgLogin;
            }
            if ($bgLogin) {
                if (Storage::exists('public/settings/' . $bgLogin)) {
                    return asset('storage/settings/' . $bgLogin);
                } else {
                    $bgLogin = null;
                }
            }
        }
        if (is_null($bgLogin)) {
            return asset('stisla/assets/img/unsplash/eberhard-grossgasteiger-1207565-unsplash.jpg');
        }
    }

    /**
     * loginMustVerified
     *
     * @return bool
     */
    public static function loginMustVerified()
    {
        return ((int) Setting::firstOrCreate(['key' => 'is_login_must_verified'], ['value' => 0])->value) === 1;
    }

    /**
     * isActiveRegisterPage
     *
     * @return bool
     */
    public static function isActiveRegisterPage()
    {
        return ((int) Setting::firstOrCreate(['key' => 'is_active_register_page'], ['value' => 0])->value) === 1;
    }

    /**
     * isForgotPasswordSendToEmail
     *
     * @return bool
     */
    public static function isForgotPasswordSendToEmail()
    {
        return ((int) Setting::firstOrCreate(['key' => 'is_forgot_password_send_to_email'], ['value' => 0])->value) === 1;
    }

    /**
     * loginTemplate
     *
     * @return string
     */
    public static function stislaLoginTemplate()
    {
        return Setting::firstOrCreate(['key' => 'stisla_login_template'], ['value' => 'default'])->value;
    }

    /**
     * metaDescription
     *
     * @return string
     */
    public static function metaDescription()
    {
        return Setting::firstOrCreate(
            ['key' => 'meta_description'],
            ['value' => 'PT Anam Maju Pantang Mundur']
        )->value;
    }

    /**
     * metaKeywords
     *
     * @return string
     */
    public static function metaKeywords()
    {
        return Setting::firstOrCreate(
            ['key' => 'meta_keywords'],
            ['value' => 'Sistem Informasi, Pemrograman, Github, PHP, Laravel, Stisla, Heroku, CBT, Ujian Online']
        )->value;
    }

    /**
     * metaAuthor
     *
     * @return string
     */
    public static function metaAuthor()
    {
        return Setting::firstOrCreate(
            ['key' => 'meta_author'],
            ['value' => 'Hairul Anam']
        )->value;
    }

    /**
     * developerName
     *
     * @return string
     */
    public static function developerName()
    {
        return Setting::firstOrCreate(
            ['key' => 'developer_name'],
            ['value' => 'Hairul Anam']
        )->value;
    }

    /**
     * developerWhatsapp
     *
     * @return string
     */
    public static function developerWhatsapp()
    {
        return Setting::firstOrCreate(
            ['key' => 'developer_whatsapp'],
            ['value' => '6285322778935']
        )->value;
    }

    /**
     * favicon
     *
     * @return string
     */
    public static function favicon()
    {
        return Setting::firstOrCreate(
            ['key' => 'favicon'],
            ['value' => 'http://127.0.0.1:8001/favicon.ico']
        )->value;
    }

    /**
     * city
     *
     * @return string
     */
    public static function city()
    {
        return Setting::firstOrCreate(
            ['key' => 'city'],
            ['value' => 'Jember']
        )->value;
    }

    /**
     * country
     *
     * @return string
     */
    public static function country()
    {
        return Setting::firstOrCreate(
            ['key' => 'country'],
            ['value' => 'Indonesia']
        )->value;
    }

    /**
     * stislaSidebarMini
     *
     * @return bool
     */
    public static function stislaSidebarMini()
    {
        return ((int)Setting::firstOrCreate(['key' => 'stisla_sidebar_mini'], ['value' => '0'])->value) === 1;
    }

    /**
     * isGoogleCaptchaLogin
     *
     * @return bool
     */
    public static function isGoogleCaptchaLogin()
    {
        if (config('captcha.secret') === 'default_secret') return false;
        return ((int)Setting::firstOrCreate(['key' => 'is_google_captcha_login'], ['value' => '0'])->value) === 1;
    }

    /**
     * isGoogleCaptchaRegister
     *
     * @return bool
     */
    public static function isGoogleCaptchaRegister()
    {
        if (config('captcha.secret') === 'default_secret') return false;
        return ((int)Setting::firstOrCreate(['key' => 'is_google_captcha_register'], ['value' => '0'])->value) === 1;
    }

    /**
     * isGoogleCaptchaForgotPassword
     *
     * @return bool
     */
    public static function isGoogleCaptchaForgotPassword()
    {
        if (config('captcha.secret') === 'default_secret') return false;
        return ((int)Setting::firstOrCreate(['key' => 'is_google_captcha_forgot_password'], ['value' => '0'])->value) === 1;
    }

    /**
     * isGoogleCaptchaResetPassword
     *
     * @return bool
     */
    public static function isGoogleCaptchaResetPassword()
    {
        if (config('captcha.secret') === 'default_secret') return false;
        return ((int)Setting::firstOrCreate(['key' => 'is_google_captcha_reset_password'], ['value' => '0'])->value) === 1;
    }

    /**
     * googleCaptchaSiteKey
     *
     * @return string
     */
    public static function googleCaptchaSiteKey()
    {
        $siteKey = Setting::where(['key' => 'google_captcha_site_key'])->first()->value ?? null;
        if ($siteKey)
            return decrypt($siteKey);
        return null;
    }

    /**
     * googleCaptchaSecret
     *
     * @return string
     */
    public static function googleCaptchaSecret()
    {
        $secret = Setting::where(['key' => 'google_captcha_secret'])->first()->value ?? null;
        if ($secret)
            return decrypt($secret);
        return null;
    }

    /**
     * isLoginWithGoogle
     *
     * @return bool
     */
    public function isLoginWithGoogle()
    {
        return ((int)Setting::firstOrCreate(['key' => 'is_login_with_google'], ['value' => '1'])->value) === 1;
    }

    /**
     * isLoginWithFacebook
     *
     * @return bool
     */
    public function isLoginWithFacebook()
    {
        return ((int)Setting::firstOrCreate(['key' => 'is_login_with_facebook'], ['value' => '1'])->value) === 1;
    }

    /**
     * isLoginWithTwitter
     *
     * @return bool
     */
    public function isLoginWithTwitter()
    {
        return ((int)Setting::firstOrCreate(['key' => 'is_login_with_twitter'], ['value' => '1'])->value) === 1;
    }

    /**
     * isLoginWithGithub
     *
     * @return bool
     */
    public function isLoginWithGithub()
    {
        return ((int)Setting::firstOrCreate(['key' => 'is_login_with_github'], ['value' => '1'])->value) === 1;
    }

    /**
     * isRegisterWithFacebook
     *
     * @return bool
     */
    public function isRegisterWithFacebook()
    {
        return ((int)Setting::firstOrCreate(['key' => 'is_register_with_facebook'], ['value' => '1'])->value) === 1;
    }

    /**
     * isRegisterWithGoogle
     *
     * @return bool
     */
    public function isRegisterWithGoogle()
    {
        return ((int)Setting::firstOrCreate(['key' => 'is_register_with_google'], ['value' => '1'])->value) === 1;
    }

    /**
     * isRegisterWithTwitter
     *
     * @return bool
     */
    public function isRegisterWithTwitter()
    {
        return ((int)Setting::firstOrCreate(['key' => 'is_register_with_twitter'], ['value' => '1'])->value) === 1;
    }

    /**
     * isRegisterWithGithub
     *
     * @return bool
     */
    public function isRegisterWithGithub()
    {
        return ((int)Setting::firstOrCreate(['key' => 'is_register_with_github'], ['value' => '1'])->value) === 1;
    }
}
