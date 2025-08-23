<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use DB;

class MaintenanceModeCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('APP_INSTALLED') === true || env('CODE_VERIFIED') === true) {
            $maintenanceMode = DB::table('settings')->where('key', 'enable_maintainance_mode')->value('value');
            
            if ($maintenanceMode == 1) {
                return response()->view('welcome', [], 503);
            }
        }
        return $next($request);
    }
}
