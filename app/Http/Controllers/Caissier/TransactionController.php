<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use App\Models\OperationType;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Affiche la liste des transactions du caissier
     */
    public function index()
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a une agence
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }
        
        // Récupérer les transactions réelles du caissier
        $transactions = Transaction::where('agency_id', $user->agency_id)
            ->where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('caissier.transactions.index', compact('transactions'));
    }

    /**
     * Affiche le formulaire de création de transaction
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a une agence
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }
        
        // Récupérer les services de l'agence du caissier
        $services = $user->agency->activeServices()->get();
        
        // Récupérer le service sélectionné si fourni
        $selectedServiceCode = $request->query('service');
        $selectedService = null;
        $operationTypes = collect();
        
        if ($selectedServiceCode) {
            $selectedService = Service::where('code', $selectedServiceCode)->first();
            if ($selectedService) {
                // Vérifier que le service est disponible pour l'agence
                $agencyServices = $user->agency->activeServices()->pluck('services.id')->toArray();
                if (in_array($selectedService->id, $agencyServices)) {
                    $operationTypes = OperationType::where('service_id', $selectedService->id)
                        ->active()
                        ->get();
                }
            }
        }
        
        // Récupérer le type d'opération sélectionné si fourni
        $selectedOperationTypeCode = $request->query('operation_type');
        $selectedOperationType = null;
        
        if ($selectedOperationTypeCode && $selectedService) {
            $selectedOperationType = OperationType::where('code', $selectedOperationTypeCode)
                ->where('service_id', $selectedService->id)
                ->first();
        }

        return view('caissier.transactions.create', compact(
            'services',
            'selectedService',
            'operationTypes',
            'selectedOperationType'
        ));
    }

    /**
     * Enregistre une nouvelle transaction
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a une agence
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }
        
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'operation_type_id' => ['required', 'exists:operation_types,id'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:20'],
            'client_id_number' => ['nullable', 'string', 'max:50'],
            'type' => ['required', 'in:deposit,withdraw,transfer,payment'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'fees' => ['required', 'numeric', 'min:0'],
            'commission' => ['nullable', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'transaction_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string'],
            'receipt' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ]);

        // Vérifier que le service est disponible pour l'agence
        $agencyServices = $user->agency->activeServices()->pluck('id')->toArray();
        if (!in_array($request->service_id, $agencyServices)) {
            abort(403, 'Ce service n\'est pas disponible pour votre agence.');
        }

        // Gérer l'upload du reçu
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('receipts', $fileName, 'public');
            $receiptPath = 'receipts/' . $fileName;
        }

        // Combiner date et heure pour créer transaction_date
        $transactionDateTime = \Carbon\Carbon::parse($request->transaction_date . ' ' . $request->transaction_time);

        // Créer la transaction
        $transaction = Transaction::create([
            'agency_id' => $user->agency_id,
            'service_id' => $request->service_id,
            'operation_type_id' => $request->operation_type_id,
            'created_by' => $user->id,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'client_id_number' => $request->client_id_number,
            'type' => $request->type,
            'amount' => $request->amount,
            'fees' => $request->fees,
            'transaction_date' => $transactionDateTime,
            'notes' => $request->notes,
            'receipt_path' => $receiptPath,
            'status' => 'recorded',
        ]);

        return redirect()->route('caissier.transactions.index')
            ->with('success', 'Transaction ' . $transaction->reference . ' créée avec succès.');
    }

    /**
     * Affiche les détails d'une transaction
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a une agence
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }
        
        // Récupérer la transaction
        $transaction = Transaction::where('id', $id)
            ->where('agency_id', $user->agency_id)
            ->where('created_by', $user->id)
            ->firstOrFail();

        return view('caissier.transactions.show', compact('transaction'));
    }
}
