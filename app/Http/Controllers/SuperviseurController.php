<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperviseurController extends Controller
{
    /**
     * Affiche le tableau de bord du superviseur
     */
    public function dashboard()
    {
        $today = now()->startOfDay();
        
        $statistiques = [
            'total_jour' => Transaction::whereDate('created_at', '>=', $today)->count(),
            'en_attente' => Transaction::where('status', 'recorded')->count(),
            'validées' => Transaction::where('status', 'reconciled')->count(),
            'rejetées' => Transaction::where('status', 'discrepancy')->count()
        ];

        $transactions_en_attente = Transaction::where('status', 'recorded')
            ->with(['createdBy', 'service'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'reference' => $t->reference,
                    'client' => $t->client_name,
                    'type' => $t->type === 'deposit' ? 'Dépôt' : ($t->type === 'withdraw' ? 'Retrait' : ($t->type === 'transfer' ? 'Transfert' : 'Paiement')),
                    'montant' => $t->amount,
                    'caissier' => $t->createdBy->name,
                    'date' => $t->transaction_date ? $t->transaction_date->format('d/m/Y H:i') : $t->created_at->format('d/m/Y H:i'),
                    'statut' => 'en_attente'
                ];
            });

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
        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'status' => 'reconciled',
            'reconciled_by' => Auth::id(),
            'reconciled_at' => now(),
        ]);
        
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

        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'status' => 'discrepancy',
            'reconciled_by' => Auth::id(),
            'reconciled_at' => now(),
            'reconciliation_notes' => $request->commentaire,
        ]);
        
        return redirect()->route('superviseur.dashboard')
            ->with('success', 'Transaction rejetée avec succès.');
    }

    /**
     * Affiche les détails d'une transaction
     */
    public function showTransaction($id)
    {
        $t = Transaction::with(['createdBy', 'service', 'operationType'])->findOrFail($id);
        
        $statutView = 'en_attente';
        if ($t->status === 'reconciled') {
            $statutView = 'validée';
        } elseif ($t->status === 'discrepancy') {
            $statutView = 'rejetée';
        }

        $transaction = [
            'id' => $t->id,
            'reference' => $t->reference,
            'client' => $t->client_name,
            'telephone' => $t->client_phone ?? 'N/A',
            'type' => $t->type === 'deposit' ? 'Dépôt' : ($t->type === 'withdraw' ? 'Retrait' : ($t->type === 'transfer' ? 'Transfert' : 'Paiement')),
            'montant' => $t->amount,
            'frais' => $t->fees,
            'total' => $t->total,
            'caissier' => $t->createdBy->name,
            'date' => $t->transaction_date ? $t->transaction_date->format('d/m/Y H:i') : $t->created_at->format('d/m/Y H:i'),
            'statut' => $statutView
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

        $query = Transaction::with(['createdBy', 'service']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        if ($statut) {
            $dbStatut = match($statut) {
                'validée' => 'reconciled',
                'en_attente' => 'recorded',
                'rejetée' => 'discrepancy',
                default => null
            };
            if ($dbStatut) {
                $query->where('status', $dbStatut);
            }
        }

        if ($date_debut) {
            $query->whereDate('transaction_date', '>=', $date_debut);
        }

        if ($date_fin) {
            $query->whereDate('transaction_date', '<=', $date_fin);
        }

        $transactionsRaw = $query->orderBy('created_at', 'desc')->get();

        $transactions = $transactionsRaw->map(function ($t) {
            $statutView = 'en_attente';
            if ($t->status === 'reconciled') {
                $statutView = 'validée';
            } elseif ($t->status === 'discrepancy') {
                $statutView = 'rejetée';
            }

            return [
                'id' => $t->id,
                'reference' => $t->reference,
                'client' => $t->client_name,
                'type' => $t->type === 'deposit' ? 'Dépôt' : ($t->type === 'withdraw' ? 'Retrait' : ($t->type === 'transfer' ? 'Transfert' : 'Paiement')),
                'service' => $t->service ? $t->service->name : 'N/A',
                'montant' => $t->amount,
                'caissier' => $t->createdBy->name,
                'statut' => $statutView,
                'date' => $t->transaction_date ? $t->transaction_date->format('d/m/Y H:i') : $t->created_at->format('d/m/Y H:i')
            ];
        });

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
        $transactions_en_attente = Transaction::where('status', 'recorded')
            ->with(['createdBy', 'service'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'reference' => $t->reference,
                    'client' => $t->client_name,
                    'type' => $t->type === 'deposit' ? 'Dépôt' : ($t->type === 'withdraw' ? 'Retrait' : ($t->type === 'transfer' ? 'Transfert' : 'Paiement')),
                    'service' => $t->service ? $t->service->name : 'N/A',
                    'montant' => $t->amount,
                    'frais' => $t->fees,
                    'total' => $t->total,
                    'caissier' => $t->createdBy->name,
                    'date' => $t->transaction_date ? $t->transaction_date->format('d/m/Y H:i') : $t->created_at->format('d/m/Y H:i'),
                    'statut' => 'en_attente'
                ];
            });

        return view('superviseur.validation.index', compact('transactions_en_attente'));
    }

    /**
     * Affiche les rapports
     */
    public function reports()
    {
        $today = now()->startOfDay();
        
        $statistiques = [
            'total_jour' => Transaction::whereDate('created_at', '>=', $today)->count(),
            'validations' => Transaction::where('status', 'reconciled')->whereDate('reconciled_at', '>=', $today)->count(),
            'rejets' => Transaction::where('status', 'discrepancy')->whereDate('reconciled_at', '>=', $today)->count(),
            'montant_total' => Transaction::where('status', 'reconciled')->whereDate('reconciled_at', '>=', $today)->sum('amount')
        ];

        // Regrouper par jour sur les 7 derniers jours
        $days = collect();
        $data = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days->push($date->translatedFormat('l'));
            
            $count = Transaction::whereDate('created_at', $date->toDateString())->count();
            $data->push($count);
        }

        $transactions_par_jour = [
            'labels' => $days->toArray(),
            'data' => $data->toArray()
        ];

        $transactions_par_statut = [
            'labels' => ['Validées', 'En attente', 'Rejetées'],
            'data' => [
                Transaction::where('status', 'reconciled')->count(),
                Transaction::where('status', 'recorded')->count(),
                Transaction::where('status', 'discrepancy')->count()
            ]
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
