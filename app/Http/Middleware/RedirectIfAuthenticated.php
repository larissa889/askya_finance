<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Si l'utilisateur accède directement à /login, ne pas rediriger
                // Permettre aux utilisateurs connectés de voir la page de login
                if ($request->is('login') || $request->route()->named('login')) {
                    return $next($request);
                }
                
                // Redirection selon le rôle de l'utilisateur pour les autres routes
                $user = Auth::guard($guard)->user();
                
                if ($user && $user->role) {
                    $role = $user->role->value;
                    
                    return match($role) {
                        'caissier' => redirect()->route('caissier.dashboard'),
                        'admin' => redirect()->route('admin.dashboard'),
                        'superviseur' => redirect()->route('superviseur.dashboard'),
                        'comptable' => redirect()->route('comptable.dashboard'),
                        default => redirect()->route('caissier.dashboard'),
                    };
                }
                
                // Fallback vers le dashboard caissier si pas de rôle
                return redirect()->route('caissier.dashboard');
            }
        }

        return $next($request);
    }
}
