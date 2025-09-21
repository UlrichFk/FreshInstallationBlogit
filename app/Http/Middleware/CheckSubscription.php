<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Vous devez être connecté pour accéder à ce contenu.',
                    'requires_login' => true
                ], 401);
            }
            
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à ce contenu.');
        }

        if (!$user->hasActiveSubscription()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Vous devez avoir un abonnement actif pour accéder à ce contenu.',
                    'requires_subscription' => true
                ], 403);
            }
            
            return redirect()->route('membership.plans')->with('error', 'Vous devez avoir un abonnement actif pour accéder à ce contenu.');
        }

        return $next($request);
    }
} 