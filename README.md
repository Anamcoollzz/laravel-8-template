# Laravel 8 Template With Stisla

[![N|Solid](https://res.cloudinary.com/sistem-informasi/image/upload/c_scale,w_100/v1677141031/logo_srs66z.png)](https://anamapp.my.id)

Free Starter Laravel 8 Template menggunakan [stisla admin dashboard ](https://github.com/stisla/stisla)

Beberapa fitur atau komponen yang ada
[![N|Solid](https://res.cloudinary.com/sistem-informasi/image/upload/v1677142211/Screen_Shot_2023-02-23_at_15.26.27_axnj7a.png)](https://anamapp.my.id)

## Fitur dan komponen

-   Login social media (github, facebook, google, dan twitter) menggunakan library [socialite](https://laravel.com/docs/8.x/socialite)
-   Google captcha
-   Dashboard (widget, log aktivitas terbaru)
-   Profil
    -   Perbarui profil
    -   Perbarui email
    -   Perbarui password
-   Contoh Modul CRUD (Create, Read, Update, Delete) dan Import Excel serta Export (PDF, JSON, Excel)
-   Beberapa contoh menu (tampilan)
-   Log Aktivitas
-   User dan role
    -   Manjemen Role dan permission menggunakan [spatie](https://spatie.be/docs/laravel-permission/v5/introduction)
    -   Manajemen user
-   Notifikasi
-   Log Viewer
-   Manajemen file menggunakan [Unisharp](https://unisharp.github.io/laravel-filemanager/)
-   Pengaturan
    -   Umum
    -   Meta
    -   Tampilan
    -   Email
    -   SSO Login dan Register
    -   Lainnya
-   CRUD Generator (menu nya tersembunyi akses via url saja)
-   Server side export file
-   Service dan repository pattern

## How to install and run

-   `composer install`
-   setup your DB in `.env`
-   `php artisan migrate --seed`
-   [optional] setup google captcha, google login, facebook login, github login, twitter login in `.env`

## Libraries

-   https://demo.getstisla.com/
-   https://spatie.be/docs/laravel-permission/v5/introduction
-   https://laravel.com/docs/8.x/socialite
-   https://unisharp.github.io/laravel-filemanager/
-   https://laravel-excel.com/
-   https://github.com/barryvdh/laravel-dompdf
-   https://datatables.net/
-   https://packagist.org/packages/buzz/laravel-google-captcha

Terima kasih, bisa distar ataupun difork ya guys. Kalau ada request module atau apapun itu, bisa tulis di issue.
Rencana nanti bakal kuupdate ke versi laravel terbaru 9 bahkan 10

https://github.com/Anamcoollzz/laravel-8-template
