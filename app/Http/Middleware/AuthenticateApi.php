<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiToken = $request->header('api-token');
        
        if (!$apiToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token d\'API manquant',
            ], 401);
        }

        $user = \Helpers::validateAuthToken($apiToken);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token d\'API invalide',
            ], 401);
        }

        // Ajouter l'utilisateur à la requête pour compatibilité
        $request->userAuthData = $user;
        
        return $next($request);
    }
}
