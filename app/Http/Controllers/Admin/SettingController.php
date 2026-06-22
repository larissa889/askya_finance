<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SettingController extends Controller
{
    /**
     * Affiche la page des paramètres
     */
    public function index()
    {
        // Données fictives pour le prototype
        $settings = [
            'entreprise_nom' => 'Askya Finance',
            'entreprise_adresse' => '123 Rue du Commerce, Abidjan',
            'entreprise_telephone' => '+225 27 00 00 00 00',
            'entreprise_email' => 'contact@askya-finance.com',
            'langue' => 'fr',
            'fuseau_horaire' => 'Africa/Abidjan',
            'devise' => 'XOF',
            'double_auth' => false
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Met à jour les paramètres
     */
    public function update(Request $request)
    {
        $request->validate([
            'entreprise_nom' => ['required', 'string', 'max:255'],
            'entreprise_adresse' => ['nullable', 'string', 'max:255'],
            'entreprise_telephone' => ['nullable', 'string', 'max:50'],
            'entreprise_email' => ['nullable', 'email', 'max:255'],
            'langue' => ['required', 'string', 'in:fr,en'],
            'fuseau_horaire' => ['required', 'string'],
            'devise' => ['required', 'string', 'max:10'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Vérification du mot de passe actuel si changement de mot de passe
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, auth()->user()->password)) {
                return back()->withErrors([
                    'current_password' => 'Le mot de passe actuel est incorrect.',
                ]);
            }

            auth()->user()->update([
                'password' => Hash::make($request->new_password)
            ]);
        }

        // Simulation de la sauvegarde des paramètres
        // En production, ces données seraient stockées en base de données

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès.');
    }
}
