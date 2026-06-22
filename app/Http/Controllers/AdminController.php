<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord de l'administrateur
     */
    public function dashboard()
    {
        // Données statiques pour le prototype
        $admin = [
            'nom' => 'Administrateur',
            'email' => 'admin@askya-finance.com',
            'photo' => 'https://ui-avatars.com/api/?name=Admin&background=0F172A&color=fff&size=128'
        ];

        $statistiques = [
            'total_utilisateurs' => 156,
            'caissiers_actifs' => 42,
            'transactions_jour' => 1247,
            'volume_financier' => 45800000
        ];

        $utilisateurs = [
            [
                'id' => 1,
                'nom' => 'Jean Dupont',
                'role' => 'caissier',
                'email' => 'jean.dupont@askya-finance.com',
                'statut' => 'actif',
                'date_creation' => '15/06/2024'
            ],
            [
                'id' => 2,
                'nom' => 'Marie Kouassi',
                'role' => 'superviseur',
                'email' => 'marie.kouassi@askya-finance.com',
                'statut' => 'actif',
                'date_creation' => '10/06/2024'
            ],
            [
                'id' => 3,
                'nom' => 'Paul Yao',
                'role' => 'comptable',
                'email' => 'paul.yao@askya-finance.com',
                'statut' => 'actif',
                'date_creation' => '08/06/2024'
            ],
            [
                'id' => 4,
                'nom' => 'Awa Diop',
                'role' => 'caissier',
                'email' => 'awa.diop@askya-finance.com',
                'statut' => 'inactif',
                'date_creation' => '05/06/2024'
            ],
            [
                'id' => 5,
                'nom' => 'Kofi Mensah',
                'role' => 'caissier',
                'email' => 'kofi.mensah@askya-finance.com',
                'statut' => 'actif',
                'date_creation' => '01/06/2024'
            ]
        ];

        $activites = [
            [
                'type' => 'connexion',
                'message' => 'Jean Dupont s\'est connecté',
                'heure' => 'Il y a 5 min',
                'icone' => 'fa-sign-in-alt'
            ],
            [
                'type' => 'creation',
                'message' => 'Nouveau compte créé : Awa Diop',
                'heure' => 'Il y a 15 min',
                'icone' => 'fa-user-plus'
            ],
            [
                'type' => 'transaction',
                'message' => 'Transaction TRX-2024-1247 validée',
                'heure' => 'Il y a 30 min',
                'icone' => 'fa-check-circle'
            ],
            [
                'type' => 'admin',
                'message' => 'Paramètres système mis à jour',
                'heure' => 'Il y a 1 heure',
                'icone' => 'fa-cog'
            ],
            [
                'type' => 'connexion',
                'message' => 'Marie Kouassi s\'est connectée',
                'heure' => 'Il y a 2 heures',
                'icone' => 'fa-sign-in-alt'
            ]
        ];

        return view('admin.dashboard', compact(
            'admin',
            'statistiques',
            'utilisateurs',
            'activites'
        ));
    }
}
