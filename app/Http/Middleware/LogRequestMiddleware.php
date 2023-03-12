<?php

namespace App\Http\Middleware;

use App\Models\LogRequest;
use Closure;
use Illuminate\Http\Request;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->path() !== 'serviceworker.js') {
            $generalService = new \App\Services\GeneralService;
            $browser = $generalService->getBrowser();
            LogRequest::create([
                'uri'          => $request->path(),
                'query_string' => $request->getQueryString(),
                'method'       => $request->method(),
                'request_data' => $request->all(),
                'ip'           => $request->ip(),
                'user_agent'   => $request->userAgent(),
                'user_id'      => auth()->check() ? auth()->id() : null,
                'roles'        => auth()->check() ? auth()->user()->roles->pluck('name')->toArray() : [],
                'browser'      => $browser,
                'platform'     => $generalService->getPlatform(),
                'device'       => $generalService->getDevice(),
            ]);
        }

        return $next($request);
    }
}
