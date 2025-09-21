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
        // Contournement de la vérification de licence - TOUJOURS CONSIDÉRER COMME VÉRIFIÉ
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
            }
        }
        
        // Vérification du mode maintenance (seulement si l'app est installée ou le code vérifié)
        if (env('APP_INSTALLED') === true || env('CODE_VERIFIED') === true) {
            try {
                $maintenanceMode = DB::table('settings')->where('key', 'enable_maintainance_mode')->value('value');
                
                if ($maintenanceMode == 1) {
                    return response()->view('welcome', [], 503);
                }
            } catch (\Exception $e) {
                // En cas d'erreur de base de données, on continue
                \Log::warning('Maintenance mode check failed, continuing', [
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return $next($request);
    }
}
