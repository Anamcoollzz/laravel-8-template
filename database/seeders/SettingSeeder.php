<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('settings')->truncate();
        $settings = json_decode(file_get_contents(database_path('seeders/data/settings.json')), true);
        // DB::table('settings')->insert($settings);

        foreach ($settings as $setting) {
            if (($setting['is_url'] ?? false) === true) {
                Setting::create([
                    'key' => $setting['key'],
                    'value' => url($setting['value'])
                ]);
            } else {
                if ($setting['key'] === 'google_captcha_secret' || $setting['key'] === 'google_captcha_site_key') {
                    Setting::create([
                        'key' => $setting['key'],
                        'value' => encrypt($setting['value']),
                    ]);
                } else {
                    Setting::create([
                        'key' => $setting['key'],
                        'value' => $setting['value']
                    ]);
                }
            }
        }
    }
}
