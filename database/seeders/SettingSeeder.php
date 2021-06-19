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
        Setting::create([
            'key'       => 'year',
            'value'     => '2020',
        ]);
        Setting::create([
            'key'       => 'company_name',
            'value'     => 'PT Anam Techno',
        ]);
        Setting::create([
            'key'       => 'app_description',
            'value'     => 'Ini hanyalah sistem biasa',
        ]);
        Setting::create([
            'key'       => 'city',
            'value'     => 'Jember',
        ]);
        Setting::create([
            'key'       => 'country',
            'value'     => 'Indonesia',
        ]);
        Setting::create([
            'key'       => 'logo',
            'value'     => url('img/logo.png'),
        ]);
        Setting::create([
            'key'       => 'favicon',
            'value'     => url('stisla/assets/img/favicon.ico'),
        ]);

        // stisla
        Setting::create([
            'key'       => 'stisla_bg_login',
            'value'     => asset('img/pantai.jpg'),
        ]);
        Setting::create([
            'key'       => 'stisla_bg_home',
            'value'     => asset('img/bg_selamat_datang.jpg'),
        ]);
        Setting::create([
            'key'       => 'stisla_sidebar_mini',
            'value'     => '0',
        ]);
        Setting::create([
            'key'       => 'stisla_skin',
            'value'     => 'style',
        ]);

        // meta
        Setting::create([
            'key'               => 'meta_description',
            'value'             => 'PT Anam Maju Pantang Mundur',
        ]);
        Setting::create([
            'key'               => 'meta_keywords',
            'value'             => 'Sistem Informasi, Pemrograman, Github, PHP, Laravel, Stisla, Heroku, CBT, Ujian Online',
        ]);
        Setting::create([
            'key'               => 'meta_author',
            'value'             => 'Hairul Anam',
        ]);
    }
}
