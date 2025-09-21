<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App;
use Config;
use Session;

class CheckSiteLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log pour déboguer
        \Log::info('CheckSiteLanguage middleware executed', [
            'url' => $request->url(),
            'session_locale' => Session::get('site_locale'),
            'cookie_locale' => $request->cookie('site_lang_code'),
            'current_locale' => app()->getLocale()
        ]);
        
        // Check if locale is set in session
        if (Session::has('site_locale') && array_key_exists(Session::get('site_locale'), config('supported_languages'))) {
            $locale = Session::get('site_locale');
            App::setLocale($locale);
            \Log::info('Language set from session', ['locale' => $locale]);
        } 
        // Check if locale is set in cookie
        elseif ($request->cookie('site_lang_code') && array_key_exists($request->cookie('site_lang_code'), config('supported_languages'))) {
            $locale = $request->cookie('site_lang_code');
            App::setLocale($locale);
            \Log::info('Language set from cookie', ['locale' => $locale]);
        }
        // Fallback to default locale
        else {
            $fallbackLocale = config('app.fallback_locale');
            App::setLocale($fallbackLocale);
            \Log::info('Language set to fallback', ['locale' => $fallbackLocale]);
        }
        
        \Log::info('Final locale set', ['locale' => app()->getLocale()]);
        
        return $next($request);
    }
}
