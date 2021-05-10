<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ViewShare
{
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
            view()->share('_application_name', \App\Repositories\SettingRepository::applicationName());
            view()->share('_company_name', \App\Repositories\SettingRepository::companyName());
            view()->share('_since', \App\Repositories\SettingRepository::since());
            view()->share('_application_version', \App\Repositories\SettingRepository::applicationVersion());
            view()->share('_skin', \App\Repositories\SettingRepository::skin());
        }
        return $next($request);
    }
}
