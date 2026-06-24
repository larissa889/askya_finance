<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Service;
use App\Models\Transaction;
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
        
        // Vérifier que l'utilisateur a une agence
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }
        
        // Récupérer l'agence du caissier
        $agency = $user->agency;
        
        // Récupérer les services actifs de l'agence du caissier
        $services = $agency->activeServices()->get();
        
        $caissier = [
            'nom' => $user->name,
            'email' => $user->email,
            'photo' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=128',
            'agence' => $agency->name
        ];

        // Récupérer la caisse active du caissier
        $cashRegister = \App\Models\CashRegister::where('assigned_to', $user->id)
            ->where('agency_id', $agency->id)
            ->where('status', 'open')
            ->first();

        $today = now()->startOfDay();

        // Calculer les statistiques réelles pour l'agence du caissier
        $statistiques = [
            'transactions_jour' => Transaction::where('agency_id', $agency->id)
                ->where('created_by', $user->id)
                ->whereDate('created_at', '>=', $today)
                ->count(),
            'montant_encaisse' => Transaction::where('agency_id', $agency->id)
                ->where('created_by', $user->id)
                ->whereDate('created_at', '>=', $today)
                ->where('status', 'reconciled')
                ->sum('amount'),
            'transactions_attente' => Transaction::where('agency_id', $agency->id)
                ->where('created_by', $user->id)
                ->where('status', 'recorded')
                ->count(),
            'transactions_annulees' => Transaction::where('agency_id', $agency->id)
                ->where('created_by', $user->id)
                ->where('status', 'discrepancy')
                ->count()
        ];

        // Récupérer les transactions réelles du caissier
        $transactions = Transaction::where('agency_id', $agency->id)
            ->where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($transaction) {
                $statutView = 'en_attente';
                if ($transaction->status === 'reconciled') {
                    $statutView = 'validée';
                } elseif ($transaction->status === 'discrepancy') {
                    $statutView = 'annulée';
                }

                return [
                    'reference' => $transaction->reference,
                    'client' => $transaction->client_name,
                    'montant' => $transaction->amount,
                    'type' => $transaction->type === 'deposit' ? 'Dépôt' : ($transaction->type === 'withdraw' ? 'Retrait' : ($transaction->type === 'transfer' ? 'Transfert' : 'Paiement')),
                    'date' => $transaction->created_at->format('d/m/Y H:i'),
                    'statut' => $statutView
                ];
            });

        // Calculer les encaissements et décaissements réels pour la caisse physique
        $encaissements = Transaction::where('agency_id', $agency->id)
            ->where('created_by', $user->id)
            ->whereDate('created_at', '>=', $today)
            ->whereIn('type', ['deposit', 'transfer'])
            ->sum('amount');

        $decaissements = Transaction::where('agency_id', $agency->id)
            ->where('created_by', $user->id)
            ->whereDate('created_at', '>=', $today)
            ->whereIn('type', ['withdraw', 'payment'])
            ->sum('amount');

        $ouvertureCaisse = $cashRegister ? $cashRegister->balance : 0;

        $caisse = [
            'ouverture' => $ouvertureCaisse,
            'encaissements' => $encaissements,
            'decaissements' => $decaissements,
            'solde' => $ouvertureCaisse + $encaissements - $decaissements
        ];

        $notifications = [
            [
                'message' => 'Bienvenue sur votre espace de travail',
                'heure' => 'À l\'instant',
                'type' => 'success'
            ]
        ];

        return view('caissier.dashboard', compact(
            'caissier',
            'services',
            'statistiques',
            'transactions',
            'caisse',
            'notifications'
        ));
    }
}
