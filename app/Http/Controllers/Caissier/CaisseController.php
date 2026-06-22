<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaisseController extends Controller
{
    /**
     * Affiche l'état de la caisse du caissier
     */
    public function index()
    {
        $user = Auth::user();
        
        $caisse = [
            'ouverture' => 500000,
            'encaissements' => 1250000,
            'decaissements' => 300000,
            'solde' => 1450000,
            'date_ouverture' => '21/06/2024 08:00',
            'caissier' => $user->name
        ];

        $mouvements = [
            [
                'reference' => 'MVT-001',
                'type' => 'encaissement',
                'montant' => 50000,
                'description' => 'Envoi MoneyGram - Marie Kouassi',
                'date' => '21/06/2024 10:30'
            ],
            [
                'reference' => 'MVT-002',
                'type' => 'encaissement',
                'montant' => 150000,
                'description' => 'Réception Western Union - Paul Yao',
                'date' => '21/06/2024 11:15'
            ],
            [
                'reference' => 'MVT-003',
                'type' => 'decaissement',
                'montant' => 300000,
                'description' => 'Retrait pour client',
                'date' => '21/06/2024 14:00'
            ],
            [
                'reference' => 'MVT-004',
                'type' => 'encaissement',
                'montant' => 75000,
                'description' => 'Envoi Ria - Awa Diop',
                'date' => '21/06/2024 15:00'
            ]
        ];

        return view('caissier.caisse.index', compact('caisse', 'mouvements'));
    }

    /**
     * Ouvre la caisse
     */
    public function ouvrir(Request $request)
    {
        $request->validate([
            'montant_ouverture' => ['required', 'numeric', 'min:0'],
        ]);

        // Simulation de l'ouverture de caisse
        // En production, cette donnée serait stockée en base de données

        return redirect()->route('caissier.caisse.index')
            ->with('success', 'Caisse ouverte avec succès.');
    }

    /**
     * Ferme la caisse
     */
    public function fermer(Request $request)
    {
        // Simulation de la fermeture de caisse
        // En production, cette donnée serait stockée en base de données

        return redirect()->route('caissier.caisse.index')
            ->with('success', 'Caisse fermée avec succès.');
    }
}
