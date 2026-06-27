<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\CashRegister;
use App\Models\SupplyRequest;
use App\Models\Agency;
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
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }

        $today = now()->startOfDay();
        
        $statistiques = [
            'total_jour' => Transaction::where('agency_id', $user->agency_id)->whereDate('created_at', '>=', $today)->count(),
            'en_attente' => Transaction::where('agency_id', $user->agency_id)->where('status', 'recorded')->count(),
            'validées' => Transaction::where('agency_id', $user->agency_id)->where('status', 'reconciled')->count(),
            'rejetées' => Transaction::where('agency_id', $user->agency_id)->where('status', 'discrepancy')->count()
        ];

        $transactions_en_attente = Transaction::where('agency_id', $user->agency_id)
            ->where('status', 'recorded')
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
        $user = Auth::user();
        $transaction = Transaction::where('agency_id', $user->agency_id)->findOrFail($id);
        
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
        $user = Auth::user();
        $request->validate([
            'commentaire' => ['required', 'string', 'max:500']
        ]);

        $transaction = Transaction::where('agency_id', $user->agency_id)->findOrFail($id);
        
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
        $user = Auth::user();
        $t = Transaction::where('agency_id', $user->agency_id)
            ->with(['createdBy', 'service', 'operationType'])
            ->findOrFail($id);
        
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
        $user = Auth::user();
        $search = $request->input('search');
        $statut = $request->input('statut');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        $query = Transaction::where('agency_id', $user->agency_id)->with(['createdBy', 'service']);

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
        $user = Auth::user();
        $transactions_en_attente = Transaction::where('agency_id', $user->agency_id)
            ->where('status', 'recorded')
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
     * Affiche la liste des caissiers de l'agence
     */
    public function cashiers()
    {
        $user = Auth::user();
        $cashiers = User::where('agency_id', $user->agency_id)
            ->where('role', 'caissier')
            ->with(['cashRegisters'])
            ->get();
            
        return view('superviseur.cashiers.index', compact('cashiers'));
    }

    /**
     * Affiche l'activité d'un caissier spécifique
     */
    public function cashierActivity($id)
    {
        $user = Auth::user();
        $cashier = User::where('agency_id', $user->agency_id)
            ->where('role', 'caissier')
            ->findOrFail($id);

        $transactions = Transaction::where('created_by', $cashier->id)
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();

        return view('superviseur.cashiers.activity', compact('cashier', 'transactions'));
    }

    /**
     * Affiche les demandes d'approvisionnement en attente pour l'agence
     */
    public function supplies()
    {
        $user = Auth::user();
        
        // Pendings where destination agency is the supervisor's agency
        $pendingSupplies = SupplyRequest::where('agency_destination_id', $user->agency_id)
            ->where('status', 'pending')
            ->with(['createdBy', 'serviceSource', 'serviceDestination', 'cashRegisterSource', 'cashRegisterDestination'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('superviseur.supplies.index', compact('pendingSupplies'));
    }

    /**
     * Valide une demande d'approvisionnement
     */
    public function validerSupply(Request $request, $id)
    {
        $user = Auth::user();
        $supply = SupplyRequest::where('agency_destination_id', $user->agency_id)
            ->where('status', 'pending')
            ->findOrFail($id);

        // Perform balance adjustment
        $destReg = $supply->cashRegisterDestination;
        $srcReg = $supply->cashRegisterSource;

        if ($supply->type === 'agency') {
            // Inter-agency: debit source register, credit destination register
            if ($srcReg) {
                if ($srcReg->balance < $supply->amount) {
                    return redirect()->back()->with('error', 'Le solde de l\'agence source est insuffisant pour valider cet approvisionnement.');
                }
                $srcReg->balance -= $supply->amount;
                $srcReg->save();
            }
            if ($destReg) {
                $destReg->balance += $supply->amount;
                $destReg->save();
            }
        } elseif ($supply->type === 'central' && $srcReg && $destReg) {
            // Reversement: debit cashier (source), credit main (dest)
            if ($srcReg->balance < $supply->amount) {
                return redirect()->back()->with('error', 'Le solde du caissier est insuffisant pour valider ce reversement.');
            }
            $srcReg->balance -= $supply->amount;
            $srcReg->save();
            
            $destReg->balance += $supply->amount;
            $destReg->save();
        } else {
            // Client supply or simple product supply: credit cashier
            if ($destReg) {
                $destReg->balance += $supply->amount;
                $destReg->save();
            }
        }

        $supply->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);

        return redirect()->route('superviseur.supplies.index')
            ->with('success', 'Demande d\'approvisionnement validée.');
    }

    /**
     * Rejette une demande d'approvisionnement
     */
    public function rejeterSupply(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:255'],
        ]);

        $supply = SupplyRequest::where('agency_destination_id', $user->agency_id)
            ->where('status', 'pending')
            ->findOrFail($id);

        $supply->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('superviseur.supplies.index')
            ->with('success', 'Demande d\'approvisionnement rejetée.');
    }

    /**
     * Affiche les dettes et opérations inter-agences
     */
    public function interAgencies()
    {
        $user = Auth::user();
        
        // Debts from other agencies to us: where we are agency_source
        $debtsToUs = SupplyRequest::where('agency_source_id', $user->agency_id)
            ->where('type', 'agency')
            ->where('status', 'approved')
            ->with(['agencyDestination', 'createdBy'])
            ->get();
            
        // Debts we owe to other agencies: where we are agency_destination
        $debtsWeOwe = SupplyRequest::where('agency_destination_id', $user->agency_id)
            ->where('type', 'agency')
            ->where('status', 'approved')
            ->with(['agencySource', 'createdBy'])
            ->get();

        return view('superviseur.inter_agencies.index', compact('debtsToUs', 'debtsWeOwe'));
    }

    /**
     * Affiche les rapports de l'agence
     */
    public function reports()
    {
        $user = Auth::user();
        $today = now()->startOfDay();
        
        $statistiques = [
            'total_jour' => Transaction::where('agency_id', $user->agency_id)->whereDate('created_at', '>=', $today)->count(),
            'validations' => Transaction::where('agency_id', $user->agency_id)->where('status', 'reconciled')->whereDate('reconciled_at', '>=', $today)->count(),
            'rejets' => Transaction::where('agency_id', $user->agency_id)->where('status', 'discrepancy')->whereDate('reconciled_at', '>=', $today)->count(),
            'montant_total' => Transaction::where('agency_id', $user->agency_id)->where('status', 'reconciled')->whereDate('reconciled_at', '>=', $today)->sum('amount')
        ];

        // Regrouper par jour sur les 7 derniers jours
        $days = collect();
        $data = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days->push($date->translatedFormat('l'));
            
            $count = Transaction::where('agency_id', $user->agency_id)->whereDate('created_at', $date->toDateString())->count();
            $data->push($count);
        }

        $transactions_par_jour = [
            'labels' => $days->toArray(),
            'data' => $data->toArray()
        ];

        $transactions_par_statut = [
            'labels' => ['Validées', 'En attente', 'Rejetées'],
            'data' => [
                Transaction::where('agency_id', $user->agency_id)->where('status', 'reconciled')->count(),
                Transaction::where('agency_id', $user->agency_id)->where('status', 'recorded')->count(),
                Transaction::where('agency_id', $user->agency_id)->where('status', 'discrepancy')->count()
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

        return redirect()->route('superviseur.profile.index')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
