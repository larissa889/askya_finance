<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComptableController extends Controller
{
    /**
     * Affiche le tableau de bord du comptable
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $statistiques = [
            'a_regler' => 8500000,
            'compenses' => 12500000,
            'solde_global' => 4000000,
            'operations' => 67
        ];

        $compensations = [
            [
                'id' => 1,
                'reference' => 'COMP-2024-001',
                'agence_source' => 'Agence Centre',
                'agence_dest' => 'Agence Nord',
                'montant' => 500000,
                'statut' => 'en_attente',
                'date' => '21/06/2024 10:30'
            ],
            [
                'id' => 2,
                'reference' => 'COMP-2024-002',
                'agence_source' => 'Agence Sud',
                'agence_dest' => 'Agence Est',
                'montant' => 750000,
                'statut' => 'paye',
                'date' => '21/06/2024 11:15'
            ],
            [
                'id' => 3,
                'reference' => 'COMP-2024-003',
                'agence_source' => 'Agence Ouest',
                'agence_dest' => 'Agence Centre',
                'montant' => 1200000,
                'statut' => 'valide',
                'date' => '21/06/2024 12:00'
            ],
            [
                'id' => 4,
                'reference' => 'COMP-2024-004',
                'agence_source' => 'Agence Nord',
                'agence_dest' => 'Agence Sud',
                'montant' => 300000,
                'statut' => 'en_attente',
                'date' => '21/06/2024 14:30'
            ],
            [
                'id' => 5,
                'reference' => 'COMP-2024-005',
                'agence_source' => 'Agence Est',
                'agence_dest' => 'Agence Ouest',
                'montant' => 600000,
                'statut' => 'paye',
                'date' => '21/06/2024 15:45'
            ]
        ];

        return view('comptable.dashboard', compact(
            'statistiques',
            'compensations'
        ));
    }

    /**
     * Valide une compensation
     */
    public function validerCompensation(Request $request, $id)
    {
        // Simulation de validation
        // En production, mettre à jour en base de données
        
        return redirect()->route('comptable.dashboard')
            ->with('success', 'Compensation validée avec succès.');
    }

    /**
     * Marque une compensation comme payée
     */
    public function marquerPaye(Request $request, $id)
    {
        // Simulation de marquage
        // En production, mettre à jour en base de données
        
        return redirect()->route('comptable.dashboard')
            ->with('success', 'Compensation marquée comme payée.');
    }

    /**
     * Génère un rapport financier
     */
    public function genererRapport(Request $request)
    {
        // Simulation de génération de rapport
        // En production, générer PDF/Excel
        
        return redirect()->route('comptable.dashboard')
            ->with('success', 'Rapport financier généré avec succès.');
    }

    /**
     * Exporte les données
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'pdf');
        
        // Simulation d'export
        // En production, générer fichier selon format
        
        return redirect()->route('comptable.dashboard')
            ->with('success', 'Export ' . strtoupper($format) . ' généré avec succès.');
    }

    /**
     * Affiche toutes les compensations
     */
    public function compensations(Request $request)
    {
        $search = $request->input('search');
        $statut = $request->input('statut');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        $compensations = [
            [
                'id' => 1,
                'reference' => 'COMP-2024-001',
                'transaction' => 'TRX-2024-001',
                'agence_source' => 'Abidjan',
                'agence_destination' => 'Bamako',
                'montant' => 50000,
                'statut' => 'validée',
                'date' => '21/06/2024 10:30'
            ],
            [
                'id' => 2,
                'reference' => 'COMP-2024-002',
                'transaction' => 'TRX-2024-002',
                'agence_source' => 'Bamako',
                'agence_destination' => 'Ouagadougou',
                'montant' => 150000,
                'statut' => 'en_attente',
                'date' => '21/06/2024 11:15'
            ],
            [
                'id' => 3,
                'reference' => 'COMP-2024-003',
                'transaction' => 'TRX-2024-003',
                'agence_source' => 'Ouagadougou',
                'agence_destination' => 'Lomé',
                'montant' => 75000,
                'statut' => 'payée',
                'date' => '21/06/2024 12:00'
            ],
            [
                'id' => 4,
                'reference' => 'COMP-2024-004',
                'transaction' => 'TRX-2024-004',
                'agence_source' => 'Lomé',
                'agence_destination' => 'Abidjan',
                'montant' => 200000,
                'statut' => 'validée',
                'date' => '21/06/2024 14:30'
            ],
            [
                'id' => 5,
                'reference' => 'COMP-2024-005',
                'transaction' => 'TRX-2024-005',
                'agence_source' => 'Abidjan',
                'agence_destination' => 'Dakar',
                'montant' => 100000,
                'statut' => 'en_attente',
                'date' => '21/06/2024 15:45'
            ]
        ];

        return view('comptable.compensations.index', compact(
            'compensations',
            'search',
            'statut',
            'date_debut',
            'date_fin'
        ));
    }

    /**
     * Affiche les détails d'une compensation
     */
    public function showCompensation($id)
    {
        $compensation = [
            'id' => 1,
            'reference' => 'COMP-2024-001',
            'transaction' => 'TRX-2024-001',
            'agence_source' => 'Abidjan',
            'agence_destination' => 'Bamako',
            'montant' => 50000,
            'frais' => 2500,
            'total' => 52500,
            'statut' => 'validée',
            'date' => '21/06/2024 10:30'
        ];

        return view('comptable.compensations.show', compact('compensation'));
    }

    /**
     * Affiche le solde
     */
    public function solde(Request $request)
    {
        $search = $request->input('search');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        $solde_info = [
            'solde_actuel' => 5750000,
            'total_credits' => 12500000,
            'total_debits' => 6750000,
            'solde_disponible' => 5750000,
            'derniere_maj' => '21/06/2024 18:00'
        ];

        $operations = [
            [
                'id' => 1,
                'reference' => 'OP-2024-001',
                'description' => 'Envoi Ria - Abidjan vers Bamako',
                'credit' => 50000,
                'debit' => 0,
                'solde_apres' => 5800000,
                'date' => '21/06/2024 10:30'
            ],
            [
                'id' => 2,
                'reference' => 'OP-2024-002',
                'description' => 'Réception MoneyGram - Bamako vers Ouagadougou',
                'credit' => 150000,
                'debit' => 0,
                'solde_apres' => 5950000,
                'date' => '21/06/2024 11:15'
            ],
            [
                'id' => 3,
                'reference' => 'OP-2024-003',
                'description' => 'Paiement compensation - COMP-2024-003',
                'credit' => 0,
                'debit' => 75000,
                'solde_apres' => 5875000,
                'date' => '21/06/2024 12:00'
            ],
            [
                'id' => 4,
                'reference' => 'OP-2024-004',
                'description' => 'Envoi Western Union - Lomé vers Abidjan',
                'credit' => 200000,
                'debit' => 0,
                'solde_apres' => 6075000,
                'date' => '21/06/2024 14:30'
            ],
            [
                'id' => 5,
                'reference' => 'OP-2024-005',
                'description' => 'Frais de service - Ria',
                'credit' => 0,
                'debit' => 325000,
                'solde_apres' => 5750000,
                'date' => '21/06/2024 15:45'
            ]
        ];

        return view('comptable.solde.index', compact(
            'solde_info',
            'operations',
            'search',
            'date_debut',
            'date_fin'
        ));
    }

    /**
     * Affiche les rapports financiers
     */
    public function financialReports()
    {
        $statistiques = [
            'total_compensations' => 125,
            'total_credits' => 12500000,
            'total_debits' => 6750000,
            'solde_global' => 5750000
        ];

        $evolution_solde = [
            'labels' => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
            'data' => [4500000, 4800000, 5200000, 5100000, 5500000, 5600000, 5750000]
        ];

        $compensations_periode = [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            'data' => [85, 92, 78, 105, 98, 125]
        ];

        $repartition_operations = [
            'labels' => ['Crédits', 'Débits'],
            'data' => [12500000, 6750000]
        ];

        return view('comptable.reports.index', compact(
            'statistiques',
            'evolution_solde',
            'compensations_periode',
            'repartition_operations'
        ));
    }

    /**
     * Affiche le profil du comptable
     */
    public function profile()
    {
        $user = Auth::user();

        return view('comptable.profile.index', compact('user'));
    }

    /**
     * Met à jour le profil du comptable
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

        return redirect()->route('comptable.profile.index')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
