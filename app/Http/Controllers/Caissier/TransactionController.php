<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\OperationType;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Affiche la liste des transactions du caissier
     */
    public function index()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->where('is_historical', false)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('transaction_time', 'desc')
            ->get();

        return view('caissier.transactions.index', compact('transactions'));
    }

    /**
     * Affiche le formulaire de création de transaction
     */
    public function create()
    {
        $user = Auth::user();
        $agency = $user->agency;
        $services = Service::where('is_active', true)->get();
        
        return view('caissier.transactions.create', compact('agency', 'services'));
    }

    /**
     * Récupère les types d'opérations pour un service donné
     */
    public function getOperationTypes(Request $request)
    {
        $serviceId = $request->service_id;
        $operationTypes = OperationType::where('service_id', $serviceId)
            ->where('is_active', true)
            ->get(['id', 'name', 'code']);
        
        return response()->json($operationTypes);
    }

    /**
     * Enregistre une nouvelle transaction
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'operation_type_id' => ['required', 'exists:operation_types,id'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['required', 'string', 'max:20'],
            'client_id_number' => ['nullable', 'string', 'max:50'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'fees' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'in:XOF,EUR,USD'],
            'observations' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        $agency = $user->agency;
        
        DB::beginTransaction();
        
        try {
            // Créer la transaction
            $transaction = Transaction::create([
                'agency_id' => $agency->id,
                'service_id' => $request->service_id,
                'operation_type_id' => $request->operation_type_id,
                'user_id' => $user->id,
                'transaction_date' => now()->toDateString(),
                'transaction_time' => now()->toTimeString(),
                'client_name' => $request->client_name,
                'client_phone' => $request->client_phone,
                'client_id_number' => $request->client_id_number,
                'amount' => $request->amount,
                'fees' => $request->fees,
                'total' => $request->amount + $request->fees,
                'currency' => $request->currency,
                'observations' => $request->observations,
                'status' => 'pending',
                'is_historical' => false,
            ]);

            // Mettre à jour les soldes de l'agence
            $this->updateAgencyBalances($agency, $transaction);

            DB::commit();

            return redirect()->route('caissier.transactions.index')
                ->with('success', 'Transaction ' . $transaction->transaction_number . ' créée avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erreur lors de la création de la transaction: ' . $e->getMessage());
        }
    }

    /**
     * Met à jour les soldes de l'agence après une transaction
     */
    private function updateAgencyBalances(Agency $agency, Transaction $transaction)
    {
        $operationType = $transaction->operationType;
        $operationName = strtolower($operationType->name);
        
        // Déterminer l'impact sur les soldes selon le type d'opération
        $cashImpact = 0;
        $electronicImpact = 0;

        // Opérations de monnaie électronique (Cash In, Cash Out, Dépôt, Retrait)
        if (in_array($operationName, ['cash in', 'dépôt'])) {
            // Le client dépose de l'argent cash, l'agence reçoit du cash
            $cashImpact = $transaction->total;
            $electronicImpact = -$transaction->amount;
        } elseif (in_array($operationName, ['cash out', 'retrait'])) {
            // Le client retire de l'argent cash, l'agence donne du cash
            $cashImpact = -$transaction->total;
            $electronicImpact = $transaction->amount;
        }
        // Opérations de transfert d'argent (Envoi, Paiement)
        elseif (in_array($operationName, ['envoi'])) {
            // Le client envoie de l'argent, l'agence reçoit du cash
            $cashImpact = $transaction->total;
        } elseif (in_array($operationName, ['paiement'])) {
            // Le client reçoit de l'argent, l'agence donne du cash
            $cashImpact = -$transaction->amount;
        }

        // Mettre à jour les soldes
        $agency->updateBalances($cashImpact, $electronicImpact);
    }

    /**
     * Affiche les détails d'une transaction
     */
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Vérifier les permissions
        if (!Auth::user()->can('view', $transaction)) {
            abort(403);
        }

        return view('caissier.transactions.show', compact('transaction'));
    }
}
