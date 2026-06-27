<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use App\Models\AfricardsAccount;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\OperationType;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AfricardsController extends Controller
{
    public function create()
    {
        return view('caissier.africards.create');
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'card_number' => ['required', 'string', 'unique:africards_accounts,card_number'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:20'],
            'client_id_number' => ['nullable', 'string', 'max:50'],
        ]);

        $user = Auth::user();

        AfricardsAccount::create([
            'card_number' => $request->card_number,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'client_id_number' => $request->client_id_number,
            'agency_id' => $user->agency_id,
            'created_by' => $user->id,
            'balance' => 0,
        ]);

        return redirect()->route('caissier.dashboard')
            ->with('success', 'Compte Africards #' . $request->card_number . ' créé avec succès.');
    }

    public function operationForm($type)
    {
        if (!in_array($type, ['deposit', 'withdraw'])) {
            abort(404);
        }

        $accounts = AfricardsAccount::orderBy('client_name')->get();
        return view('caissier.africards.operation', compact('type', 'accounts'));
    }

    public function storeOperation(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:deposit,withdraw'],
            'card_number' => ['required', 'exists:africards_accounts,card_number'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'fees' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        $account = AfricardsAccount::where('card_number', $request->card_number)->firstOrFail();
        
        // Find or create Africards service
        $service = Service::where('code', 'AFRI')->first();
        if (!$service) {
            $service = Service::create([
                'name' => 'Africards',
                'code' => 'AFRI',
                'description' => 'Services Africards',
                'is_active' => true
            ]);
        }

        // Find or create operation type
        $opCode = $request->type === 'deposit' ? 'AFRI_DEP' : 'AFRI_RET';
        $opName = $request->type === 'deposit' ? 'Dépôt Africards' : 'Retrait Africards';
        $operationType = OperationType::where('code', $opCode)->first();
        if (!$operationType) {
            $operationType = OperationType::create([
                'name' => $opName,
                'code' => $opCode,
                'service_id' => $service->id,
                'is_active' => true
            ]);
        }

        // Verify that cashier register is open and check balance for withdrawals
        $register = CashRegister::where('assigned_to', $user->id)
            ->where('agency_id', $user->agency_id)
            ->where('status', 'open')
            ->first();

        if (!$register) {
            return redirect()->back()->withInput()->with('error', 'Votre caisse doit être ouverte pour effectuer des opérations.');
        }

        if ($request->type === 'withdraw' && $account->balance < $request->amount) {
            return redirect()->back()->withInput()->with('error', 'Le solde de la carte Africards est insuffisant.');
        }

        // Update Africards account balance
        if ($request->type === 'deposit') {
            $account->balance += $request->amount;
        } else {
            $account->balance -= $request->amount;
        }
        $account->save();

        // Register the transaction
        $transaction = Transaction::create([
            'agency_id' => $user->agency_id,
            'service_id' => $service->id,
            'operation_type_id' => $operationType->id,
            'created_by' => $user->id,
            'client_name' => $account->client_name,
            'client_phone' => $account->client_phone,
            'client_id_number' => $account->client_id_number,
            'type' => $request->type,
            'amount' => $request->amount,
            'fees' => $request->fees,
            'transaction_date' => now(),
            'notes' => $request->notes ?? ($request->type === 'deposit' ? 'Dépôt sur carte Africards' : 'Retrait depuis carte Africards'),
            'status' => 'recorded', // Goes to recorded, supervisor approves it
        ]);

        return redirect()->route('caissier.dashboard')
            ->with('success', 'Opération Africards enregistrée avec succès. Référence: ' . $transaction->reference);
    }
}
