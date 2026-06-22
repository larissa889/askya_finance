<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Usage in routes: middleware('role:admin,superviseur')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Normalize role value for comparison
        $userRole = $user->role instanceof \BackedEnum
            ? $user->role->value
            : $user->role;

        if (!in_array($userRole, $roles, true)) {
            // Rediriger vers le dashboard approprié selon le rôle de l'utilisateur
            return redirect()->match($userRole, [
                'admin' => route('admin.dashboard'),
                'caissier' => route('caissier.dashboard'),
                'superviseur' => route('superviseur.dashboard'),
                'comptable' => route('comptable.dashboard'),
            ], route('login'));
        }

        return $next($request);
    }
}
