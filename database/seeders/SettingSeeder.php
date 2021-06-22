<?php

namespace Database\Seeders;

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
        DB::table('settings')->insert($settings);
    }
}
