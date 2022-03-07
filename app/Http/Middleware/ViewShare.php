<?php

namespace App\Http\Middleware;

use App\Repositories\MenuRepository;
use App\Repositories\SettingRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ViewShare
{

    /**
     * menuRepository
     *
     * @var MenuRepository
     */
    private MenuRepository $menuRepository;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->menuRepository = new MenuRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('GET')) {
            // view()->share('_meta_description', SettingRepository::metaDescription());
            // view()->share('_meta_keywords', SettingRepository::metaKeywords());
            // view()->share('_meta_author', SettingRepository::metaAuthor());
            // view()->share('_company_name', SettingRepository::companyName());
            // view()->share('_skin', SettingRepository::stislaSkin());
            // view()->share('_sidebar_mini', SettingRepository::stislaSidebarMini());
            // $_app_name = SettingRepository::applicationName() ?? config('app.name');
            // view()->share('_app_name', $_app_name);
            // view()->share('_developer_name', SettingRepository::developerName());
            // view()->share('_whatsapp_developer', SettingRepository::developerWhatsapp());
            // view()->share('_since', SettingRepository::since());
            // view()->share('_version', SettingRepository::applicationVersion());
            // view()->share('_app_name_mobile', \App\Helpers\StringHelper::acronym($_app_name, 2));
            // view()->share('_favicon', SettingRepository::favicon());
            // view()->share('_logo_url', SettingRepository::logoUrl());
            // view()->share('_city', SettingRepository::city());
            // view()->share('_country', SettingRepository::country());
            // view()->share('_login_bg_url', SettingRepository::loginBgUrl());
            // Session::flush();
            $settings = SettingRepository::settings();
            // dd($settings);
            session($settings);
            foreach ($settings as $key => $value) {
                view()->share($key, $value);
                // if ($setting->key === 'application_name') {
                //     view()->share('_app_name', $setting->value);
                // } else if ($setting->key === 'logo') {
                //     // Session::flush();
                //     view()->share('_logo_url', $value = SettingRepository::logoUrl());
                //     session(['_logo_url' => $value]);
                // } else if ($setting->key === 'stisla_skin') {
                //     view()->share('_skin', $setting->value);
                // } else if ($setting->key === 'stisla_bg_login') {
                //     view()->share('_stisla_bg_login', $value = SettingRepository::loginBgUrl());
                //     session(['_stisla_bg_login' => $value]);
                // }
            }
            $menus = $this->menuRepository->getMenus();
            view()->share('_sidebar_menus', $menus);

            view()->share('_my_notifications', (new \App\Repositories\NotificationRepository)->myUnReadNotif(20));
        }
        return $next($request);
    }
}
