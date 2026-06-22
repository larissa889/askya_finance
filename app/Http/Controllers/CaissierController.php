<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaissierController extends Controller
{
    /**
     * Affiche le tableau de bord du caissier
     */
    public function dashboard()
    {
        // Utiliser l'utilisateur authentifié
        $user = Auth::user();
        
        $caissier = [
            'nom' => $user->name,
            'email' => $user->email,
            'photo' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=128'
        ];

        $statistiques = [
            'transactions_jour' => 24,
            'montant_encaisse' => 1250000,
            'transactions_attente' => 5,
            'transactions_annulees' => 2
        ];

        $transactions = [
            [
                'reference' => 'TRX-2024-001',
                'client' => 'Marie Kouassi',
                'montant' => 50000,
                'type' => 'Envoi',
                'date' => '21/06/2024 10:30',
                'statut' => 'validée'
            ],
            [
                'reference' => 'TRX-2024-002',
                'client' => 'Paul Yao',
                'montant' => 150000,
                'type' => 'Réception',
                'date' => '21/06/2024 11:15',
                'statut' => 'en_attente'
            ],
            [
                'reference' => 'TRX-2024-003',
                'client' => 'Awa Diop',
                'montant' => 75000,
                'type' => 'Envoi',
                'date' => '21/06/2024 12:00',
                'statut' => 'validée'
            ],
            [
                'reference' => 'TRX-2024-004',
                'client' => 'Kofi Mensah',
                'montant' => 200000,
                'type' => 'Réception',
                'date' => '21/06/2024 14:30',
                'statut' => 'annulée'
            ],
            [
                'reference' => 'TRX-2024-005',
                'client' => 'Fatou Sow',
                'montant' => 100000,
                'type' => 'Envoi',
                'date' => '21/06/2024 15:45',
                'statut' => 'validée'
            ]
        ];

        $caisse = [
            'ouverture' => 500000,
            'encaissements' => 1250000,
            'decaissements' => 300000,
            'solde' => 1450000
        ];

        $notifications = [
            [
                'message' => 'Nouvelle transaction de Marie Kouassi',
                'heure' => 'Il y a 5 min',
                'type' => 'success'
            ],
            [
                'message' => 'Transaction TRX-2024-004 annulée',
                'heure' => 'Il y a 15 min',
                'type' => 'danger'
            ],
            [
                'message' => 'Rappel: Fermeture de caisse à 18h',
                'heure' => 'Il y a 1 heure',
                'type' => 'warning'
            ]
        ];

        return view('caissier.dashboard', compact(
            'caissier',
            'statistiques',
            'transactions',
            'caisse',
            'notifications'
        ));
    }
}
