<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Affiche le tableau de bord des rapports
     */
    public function index()
    {
        // Données fictives pour le prototype
        $statistiques = [
            'total_transactions' => 1247,
            'montant_total' => 45800000,
            'nombre_caissiers' => 42,
            'nombre_superviseurs' => 18,
            'nombre_comptables' => 12,
            'nombre_admins' => 4
        ];

        // Données pour les graphiques
        $transactions_par_mois = [
            'Janvier' => 850,
            'Février' => 920,
            'Mars' => 1100,
            'Avril' => 980,
            'Mai' => 1050,
            'Juin' => 1247
        ];

        $transactions_par_statut = [
            'validée' => 950,
            'en_attente' => 220,
            'annulée' => 77
        ];

        $utilisateurs_par_role = [
            'caissiers' => 42,
            'superviseurs' => 18,
            'comptables' => 12,
            'admins' => 4
        ];

        return view('admin.reports.index', compact(
            'statistiques',
            'transactions_par_mois',
            'transactions_par_statut',
            'utilisateurs_par_role'
        ));
    }
}
