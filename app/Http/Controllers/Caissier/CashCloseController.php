<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use App\Models\CashClose;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashCloseController extends Controller
{
    /**
     * Affiche la liste des clôtures de caisse du caissier
     */
    public function index()
    {
        $user = Auth::user();
        $cashCloses = CashClose::where('user_id', $user->id)
            ->where('is_historical', false)
            ->orderBy('close_date', 'desc')
            ->get();

        return view('caissier.cash-closes.index', compact('cashCloses'));
    }

    /**
     * Affiche le formulaire de clôture de caisse
     */
    public function create()
    {
        $user = Auth::user();
        $agency = $user->agency;
        $today = now()->toDateString();
        
        // Vérifier si une clôture existe déjà pour aujourd'hui
        $existingClose = CashClose::where('agency_id', $agency->id)
            ->where('user_id', $user->id)
            ->where('close_date', $today)
            ->where('is_historical', false)
            ->first();

        if ($existingClose) {
            return redirect()->route('caissier.cash-closes.show', $existingClose->id)
                ->with('info', 'Une clôture de caisse existe déjà pour aujourd\'hui.');
        }

        // Récupérer les transactions du jour
        $transactions = Transaction::where('agency_id', $agency->id)
            ->where('user_id', $user->id)
            ->whereDate('transaction_date', $today)
            ->where('is_historical', false)
            ->get();

        // Calculer les totaux pour la prévisualisation
        $preview = $this->calculateCashCloseData($agency, $transactions);

        return view('caissier.cash-closes.create', compact('agency', 'transactions', 'preview'));
    }

    /**
     * Enregistre une nouvelle clôture de caisse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $agency = $user->agency;
        $today = now()->toDateString();

        DB::beginTransaction();

        try {
            // Récupérer les transactions du jour
            $transactions = Transaction::where('agency_id', $agency->id)
                ->where('user_id', $user->id)
                ->whereDate('transaction_date', $today)
                ->where('is_historical', false)
                ->get();

            // Calculer les données de la clôture
            $data = $this->calculateCashCloseData($agency, $transactions);

            // Créer la clôture de caisse
            $cashClose = CashClose::create([
                'agency_id' => $agency->id,
                'user_id' => $user->id,
                'close_date' => $today,
                'account_initial_balance' => $data['account_initial_balance'],
                'account_provisioning' => $data['account_provisioning'],
                'account_payments' => $data['account_payments'],
                'account_deposits' => $data['account_deposits'],
                'account_outputs' => $data['account_outputs'],
                'account_variance' => $data['account_variance'],
                'account_final_balance' => $data['account_final_balance'],
                'cash_initial_balance' => $data['cash_initial_balance'],
                'cash_provisioning' => $data['cash_provisioning'],
                'cash_deposits' => $data['cash_deposits'],
                'cash_payments' => $data['cash_payments'],
                'cash_outputs' => $data['cash_outputs'],
                'cash_variance' => $data['cash_variance'],
                'cash_final_balance' => $data['cash_final_balance'],
                'transaction_count' => $transactions->count(),
                'status' => 'pending',
                'observations' => $request->observations,
                'is_historical' => false,
            ]);

            DB::commit();

            return redirect()->route('caissier.cash-closes.show', $cashClose->id)
                ->with('success', 'Clôture de caisse créée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erreur lors de la création de la clôture: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'une clôture de caisse
     */
    public function show($id)
    {
        $cashClose = CashClose::findOrFail($id);
        
        // Vérifier les permissions
        if (!Auth::user()->can('view', $cashClose)) {
            abort(403);
        }

        $transactions = Transaction::where('agency_id', $cashClose->agency_id)
            ->where('user_id', $cashClose->user_id)
            ->whereDate('transaction_date', $cashClose->close_date)
            ->where('is_historical', $cashClose->is_historical)
            ->get();

        return view('caissier.cash-closes.show', compact('cashClose', 'transactions'));
    }

    /**
     * Calcule les données de la clôture de caisse
     */
    private function calculateCashCloseData($agency, $transactions)
    {
        // Solde initial (solde de l'agence avant les transactions du jour)
        $accountInitialBalance = $agency->electronic_balance;
        $cashInitialBalance = $agency->cash_balance;

        // Calculer les totaux selon les types d'opérations
        $accountProvisioning = 0;
        $accountPayments = 0;
        $accountDeposits = 0;
        $accountOutputs = 0;

        $cashProvisioning = 0;
        $cashDeposits = 0;
        $cashPayments = 0;
        $cashOutputs = 0;

        foreach ($transactions as $transaction) {
            $operationName = strtolower($transaction->operationType->name);

            // Opérations de monnaie électronique
            if (in_array($operationName, ['cash in', 'dépôt'])) {
                $cashDeposits += $transaction->total;
                $accountPayments += $transaction->amount;
            } elseif (in_array($operationName, ['cash out', 'retrait'])) {
                $cashPayments += $transaction->amount;
                $accountDeposits += $transaction->amount;
            }
            // Opérations de transfert d'argent
            elseif (in_array($operationName, ['envoi'])) {
                $cashDeposits += $transaction->total;
            } elseif (in_array($operationName, ['paiement'])) {
                $cashPayments += $transaction->amount;
            }
        }

        // Calculer les soldes finaux et les écarts
        $accountFinalBalance = $accountInitialBalance + $accountProvisioning - $accountPayments + $accountDeposits - $accountOutputs;
        $accountVariance = 0; // À calculer selon les règles métier

        $cashFinalBalance = $cashInitialBalance + $cashProvisioning + $cashDeposits - $cashPayments - $cashOutputs;
        $cashVariance = 0; // À calculer selon les règles métier

        return [
            'account_initial_balance' => $accountInitialBalance,
            'account_provisioning' => $accountProvisioning,
            'account_payments' => $accountPayments,
            'account_deposits' => $accountDeposits,
            'account_outputs' => $accountOutputs,
            'account_variance' => $accountVariance,
            'account_final_balance' => $accountFinalBalance,
            'cash_initial_balance' => $cashInitialBalance,
            'cash_provisioning' => $cashProvisioning,
            'cash_deposits' => $cashDeposits,
            'cash_payments' => $cashPayments,
            'cash_outputs' => $cashOutputs,
            'cash_variance' => $cashVariance,
            'cash_final_balance' => $cashFinalBalance,
        ];
    }
}
