<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['id', 'en', 'ar'];

        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            $locale = $request->getPreferredLanguage($supportedLocales);
            if (!$locale) {
                $locale = config('app.locale', 'id');
            }
            Session::put('locale', $locale);
        }

        App::setLocale($locale);
        \Carbon\Carbon::setLocale($locale);

        return $next($request);
    }
}
