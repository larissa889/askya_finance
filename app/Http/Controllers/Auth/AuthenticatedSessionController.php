<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Nettoyer toute URL intended précédente pour éviter les redirections incorrectes
        $request->session()->forget('url.intended');

        // Redirection selon le rôle de l'utilisateur
        $user = Auth::user();
        
        return redirect(match($user->role->value) {
            'caissier' => route('caissier.dashboard'),
            'admin' => route('admin.dashboard'),
            'superviseur' => route('superviseur.dashboard'),
            'comptable' => route('comptable.dashboard'),
            default => route('caissier.dashboard'),
        });
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
