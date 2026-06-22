<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperviseurController extends Controller
{
    /**
     * Affiche le tableau de bord du superviseur
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $statistiques = [
            'total_jour' => 45,
            'en_attente' => 12,
            'validées' => 28,
            'rejetées' => 5
        ];

        $transactions_en_attente = [
            [
                'id' => 1,
                'reference' => 'TRX-2024-001',
                'client' => 'Marie Kouassi',
                'type' => 'Envoi',
                'montant' => 50000,
                'caissier' => 'Larissa Tiendrebeogo',
                'date' => '21/06/2024 10:30',
                'statut' => 'en_attente'
            ],
            [
                'id' => 2,
                'reference' => 'TRX-2024-002',
                'client' => 'Paul Yao',
                'type' => 'Réception',
                'montant' => 150000,
                'caissier' => 'Larissa Tiendrebeogo',
                'date' => '21/06/2024 11:15',
                'statut' => 'en_attente'
            ],
            [
                'id' => 3,
                'reference' => 'TRX-2024-003',
                'client' => 'Awa Diop',
                'type' => 'Envoi',
                'montant' => 75000,
                'caissier' => 'Jean Dupont',
                'date' => '21/06/2024 12:00',
                'statut' => 'en_attente'
            ],
            [
                'id' => 4,
                'reference' => 'TRX-2024-004',
                'client' => 'Kofi Mensah',
                'type' => 'Réception',
                'montant' => 200000,
                'caissier' => 'Larissa Tiendrebeogo',
                'date' => '21/06/2024 14:30',
                'statut' => 'en_attente'
            ],
            [
                'id' => 5,
                'reference' => 'TRX-2024-005',
                'client' => 'Fatou Sow',
                'type' => 'Envoi',
                'montant' => 100000,
                'caissier' => 'Jean Dupont',
                'date' => '21/06/2024 15:45',
                'statut' => 'en_attente'
            ]
        ];

        return view('superviseur.dashboard', compact(
            'statistiques',
            'transactions_en_attente'
        ));
    }

    /**
     * Valide une transaction
     */
    public function validerTransaction(Request $request, $id)
    {
        // Simulation de validation
        // En production, mettre à jour en base de données
        
        return redirect()->route('superviseur.dashboard')
            ->with('success', 'Transaction validée avec succès.');
    }

    /**
     * Rejette une transaction
     */
    public function rejeterTransaction(Request $request, $id)
    {
        $request->validate([
            'commentaire' => ['required', 'string', 'max:500']
        ]);

        // Simulation de rejet
        // En production, mettre à jour en base de données avec commentaire
        
        return redirect()->route('superviseur.dashboard')
            ->with('success', 'Transaction rejetée avec succès.');
    }

    /**
     * Affiche les détails d'une transaction
     */
    public function showTransaction($id)
    {
        $transaction = [
            'id' => 1,
            'reference' => 'TRX-2024-001',
            'client' => 'Marie Kouassi',
            'telephone' => '+225 07 00 00 00 00',
            'type' => 'Envoi',
            'montant' => 50000,
            'frais' => 2500,
            'total' => 52500,
            'caissier' => 'Larissa Tiendrebeogo',
            'date' => '21/06/2024 10:30',
            'statut' => 'en_attente'
        ];

        return view('superviseur.transaction.show', compact('transaction'));
    }

    /**
     * Affiche toutes les transactions
     */
    public function transactions(Request $request)
    {
        $search = $request->input('search');
        $statut = $request->input('statut');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        $transactions = [
            [
                'id' => 1,
                'reference' => 'TRX-2024-001',
                'client' => 'Marie Kouassi',
                'type' => 'Envoi',
                'service' => 'Ria',
                'montant' => 50000,
                'caissier' => 'Larissa Tiendrebeogo',
                'statut' => 'validée',
                'date' => '21/06/2024 10:30'
            ],
            [
                'id' => 2,
                'reference' => 'TRX-2024-002',
                'client' => 'Paul Yao',
                'type' => 'Réception',
                'service' => 'MoneyGram',
                'montant' => 150000,
                'caissier' => 'Larissa Tiendrebeogo',
                'statut' => 'en_attente',
                'date' => '21/06/2024 11:15'
            ],
            [
                'id' => 3,
                'reference' => 'TRX-2024-003',
                'client' => 'Awa Diop',
                'type' => 'Envoi',
                'service' => 'Western Union',
                'montant' => 75000,
                'caissier' => 'Jean Dupont',
                'statut' => 'validée',
                'date' => '21/06/2024 12:00'
            ],
            [
                'id' => 4,
                'reference' => 'TRX-2024-004',
                'client' => 'Kofi Mensah',
                'type' => 'Réception',
                'service' => 'Ria',
                'montant' => 200000,
                'caissier' => 'Larissa Tiendrebeogo',
                'statut' => 'rejetée',
                'date' => '21/06/2024 14:30'
            ],
            [
                'id' => 5,
                'reference' => 'TRX-2024-005',
                'client' => 'Fatou Sow',
                'type' => 'Envoi',
                'service' => 'MoneyGram',
                'montant' => 100000,
                'caissier' => 'Jean Dupont',
                'statut' => 'validée',
                'date' => '21/06/2024 15:45'
            ]
        ];

        return view('superviseur.transactions.index', compact(
            'transactions',
            'search',
            'statut',
            'date_debut',
            'date_fin'
        ));
    }

    /**
     * Affiche la page de validation des transactions
     */
    public function validation(Request $request)
    {
        $transactions_en_attente = [
            [
                'id' => 1,
                'reference' => 'TRX-2024-001',
                'client' => 'Marie Kouassi',
                'type' => 'Envoi',
                'service' => 'Ria',
                'montant' => 50000,
                'frais' => 2500,
                'total' => 52500,
                'caissier' => 'Larissa Tiendrebeogo',
                'date' => '21/06/2024 10:30',
                'statut' => 'en_attente'
            ],
            [
                'id' => 2,
                'reference' => 'TRX-2024-002',
                'client' => 'Paul Yao',
                'type' => 'Réception',
                'service' => 'MoneyGram',
                'montant' => 150000,
                'frais' => 7500,
                'total' => 157500,
                'caissier' => 'Larissa Tiendrebeogo',
                'date' => '21/06/2024 11:15',
                'statut' => 'en_attente'
            ],
            [
                'id' => 3,
                'reference' => 'TRX-2024-003',
                'client' => 'Awa Diop',
                'type' => 'Envoi',
                'service' => 'Western Union',
                'montant' => 75000,
                'frais' => 3750,
                'total' => 78750,
                'caissier' => 'Jean Dupont',
                'date' => '21/06/2024 12:00',
                'statut' => 'en_attente'
            ]
        ];

        return view('superviseur.validation.index', compact('transactions_en_attente'));
    }

    /**
     * Affiche les rapports
     */
    public function reports()
    {
        $statistiques = [
            'total_jour' => 45,
            'validations' => 28,
            'rejets' => 5,
            'montant_total' => 5750000
        ];

        $transactions_par_jour = [
            'labels' => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
            'data' => [12, 19, 15, 25, 22, 18, 10]
        ];

        $transactions_par_statut = [
            'labels' => ['Validées', 'En attente', 'Rejetées'],
            'data' => [28, 12, 5]
        ];

        return view('superviseur.reports.index', compact(
            'statistiques',
            'transactions_par_jour',
            'transactions_par_statut'
        ));
    }

    /**
     * Affiche le profil du superviseur
     */
    public function profile()
    {
        $user = Auth::user();

        return view('superviseur.profile.index', compact('user'));
    }

    /**
     * Met à jour le profil du superviseur
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed']
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return redirect()->route('superviseur.profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
