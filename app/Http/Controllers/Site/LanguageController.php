<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    /**
     * Change the site language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage(Request $request)
    {
        $language = $request->get('lang');
        
        \Log::info('LanguageController::changeLanguage called', [
            'requested_language' => $language,
            'current_locale' => app()->getLocale(),
            'session_locale' => Session::get('site_locale'),
            'cookie_locale' => $request->cookie('site_lang_code')
        ]);
        
        // Check if the language is supported
        if (array_key_exists($language, Config::get('supported_languages'))) {
            // Set the application locale
            App::setLocale($language);
            
            // Store in session for the site
            Session::put('site_locale', $language);
            
            \Log::info('Language changed successfully', [
                'new_language' => $language,
                'session_set' => Session::get('site_locale'),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            // Create response with cookie
            $response = redirect()->back()->with('success', 'Language changed successfully');
            $response->withCookie(Cookie::make('site_lang_code', $language, 525600)); // 1 year
            
            return $response;
        } else {
            \Log::warning('Invalid language requested', [
                'requested_language' => $language,
                'available_languages' => array_keys(Config::get('supported_languages'))
            ]);
            
            return redirect()->back()->with('error', 'Invalid language selected');
        }
    }
    
    /**
     * Get available languages for the site.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableLanguages()
    {
        $languages = Config::get('supported_languages');
        
        return response()->json([
            'success' => true,
            'languages' => $languages,
            'current_language' => app()->getLocale()
        ]);
    }
}
