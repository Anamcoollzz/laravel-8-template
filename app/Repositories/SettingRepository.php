<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends Repository
{

    /**
     * construct function
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Setting();
    }

    /**
     * get application name
     *
     * @return Setting
     */
    public static function applicationName()
    {
        return Setting::firstOrCreate(['key' => 'application_name'], ['value' => 'Laravel 8 Admin Template']);
    }

    /**
     * update application name
     *
     * @return int
     */
    public function updateApplicationName(string $applicationName)
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
        return Setting::firstOrCreate(['key' => 'company_name'], ['value' => 'Dummy Company Name']);
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
        return Setting::firstOrCreate(['key' => 'since'], ['value' => '2021']);
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
        return Setting::firstOrCreate(['key' => 'application_version'], ['value' => '1.0.0']);
    }

    /**
     * get application skin
     *
     * @return Setting
     */
    public static function skin()
    {
        return Setting::firstOrCreate(['key' => 'skin'], ['value' => 'red']);
    }

    /**
     * get skins app
     *
     * @return array
     */
    public function getSkins()
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
}
