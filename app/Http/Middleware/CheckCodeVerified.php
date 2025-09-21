<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

class CheckCodeVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Contournement de la vérification de licence - TOUJOURS ACCEPTER
        $envPath = base_path('.env');
        
        // Si le fichier .env existe, on s'assure que CODE_VERIFIED=true
        if (File::exists($envPath)) {
            $envContent = File::get($envPath);
            
            // Si CODE_VERIFIED n'est pas défini ou est false, on le met à true
            if (strpos($envContent, 'CODE_VERIFIED=') === false || 
                strpos($envContent, 'CODE_VERIFIED=false') !== false ||
                strpos($envContent, 'CODE_VERIFIED=""') !== false) {
                
                if (strpos($envContent, 'CODE_VERIFIED=') !== false) {
                    $envContent = preg_replace(
                        '/CODE_VERIFIED=.*/',
                        'CODE_VERIFIED=true',
                        $envContent
                    );
                } else {
                    $envContent .= "\nCODE_VERIFIED=true";
                }
                
                File::put($envPath, $envContent);
                
                // Log de l'auto-activation
                \Log::info('License auto-activated by middleware', [
                    'url' => $request->fullUrl(),
                    'user_agent' => $request->userAgent(),
                    'ip' => $request->ip(),
                    'timestamp' => now()
                ]);
            }
        }
        
        // Toujours autoriser l'accès
        return $next($request);
    }
}
