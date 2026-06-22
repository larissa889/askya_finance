<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Affiche la liste des transactions
     */
    public function index(Request $request)
    {
        // Données fictives pour le prototype
        $transactions = [
            [
                'id' => 1,
                'reference' => 'TRX-2024-0001',
                'type' => 'MoneyGram',
                'montant' => 50000,
                'client' => 'Jean Kouassi',
                'caissier' => 'Marie Diop',
                'statut' => 'validée',
                'date' => '21/06/2024 14:30'
            ],
            [
                'id' => 2,
                'reference' => 'TRX-2024-0002',
                'type' => 'Western Union',
                'montant' => 75000,
                'client' => 'Awa Mensah',
                'caissier' => 'Paul Yao',
                'statut' => 'en_attente',
                'date' => '21/06/2024 14:15'
            ],
            [
                'id' => 3,
                'reference' => 'TRX-2024-0003',
                'type' => 'Orange Money',
                'montant' => 25000,
                'client' => 'Kofi Asante',
                'caissier' => 'Marie Diop',
                'statut' => 'validée',
                'date' => '21/06/2024 13:45'
            ],
            [
                'id' => 4,
                'reference' => 'TRX-2024-0004',
                'type' => 'Ria',
                'montant' => 100000,
                'client' => 'Fatou Diallo',
                'caissier' => 'Jean Dupont',
                'statut' => 'annulée',
                'date' => '21/06/2024 12:30'
            ],
            [
                'id' => 5,
                'reference' => 'TRX-2024-0005',
                'type' => 'MoneyGram',
                'montant' => 150000,
                'client' => 'Abdou Ndiaye',
                'caissier' => 'Paul Yao',
                'statut' => 'validée',
                'date' => '21/06/2024 11:20'
            ],
            [
                'id' => 6,
                'reference' => 'TRX-2024-0006',
                'type' => 'Western Union',
                'montant' => 80000,
                'client' => 'Sylvie Koné',
                'caissier' => 'Marie Diop',
                'statut' => 'en_attente',
                'date' => '21/06/2024 10:50'
            ],
            [
                'id' => 7,
                'reference' => 'TRX-2024-0007',
                'type' => 'Orange Money',
                'montant' => 35000,
                'client' => 'Moussa Touré',
                'caissier' => 'Jean Dupont',
                'statut' => 'validée',
                'date' => '21/06/2024 09:40'
            ],
            [
                'id' => 8,
                'reference' => 'TRX-2024-0008',
                'type' => 'Ria',
                'montant' => 60000,
                'client' => 'Aminata Camara',
                'caissier' => 'Paul Yao',
                'statut' => 'validée',
                'date' => '21/06/2024 08:30'
            ]
        ];

        // Filtres (à implémenter avec la base de données)
        $search = $request->input('search');
        $statut = $request->input('statut');
        $caissier = $request->input('caissier');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        return view('admin.transactions.index', compact(
            'transactions',
            'search',
            'statut',
            'caissier',
            'date_debut',
            'date_fin'
        ));
    }

    /**
     * Affiche les détails d'une transaction
     */
    public function show($id)
    {
        // Données fictives pour le prototype
        $transaction = [
            'id' => 1,
            'reference' => 'TRX-2024-0001',
            'type' => 'MoneyGram',
            'montant' => 50000,
            'frais' => 2500,
            'total' => 52500,
            'client' => 'Jean Kouassi',
            'client_telephone' => '+225 07 00 00 00 00',
            'client_email' => 'jean.kouassi@email.com',
            'caissier' => 'Marie Diop',
            'statut' => 'validée',
            'date_creation' => '21/06/2024 14:30',
            'date_validation' => '21/06/2024 14:32',
            'notes' => 'Transaction effectuée sans incident'
        ];

        return view('admin.transactions.show', compact('transaction'));
    }
}
