<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\CashClose;
use App\Models\OperationType;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HistoricalImportController extends Controller
{
    /**
     * Affiche le formulaire d'import
     */
    public function create()
    {
        $agencies = Agency::all();
        $services = Service::all();
        
        return view('admin.historical-import.create', compact('agencies', 'services'));
    }

    /**
     * Traite l'import des transactions historiques
     */
    public function store(Request $request)
    {
        $request->validate([
            'agency_id' => ['required', 'exists:agencies,id'],
            'import_file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('import_file');
            $agency = Agency::findOrFail($request->agency_id);
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // Lire le fichier Excel/CSV
            $transactions = $this->parseImportFile($file);

            $importedCount = 0;
            $errors = [];

            foreach ($transactions as $row) {
                try {
                    // Valider les données de la ligne
                    if (empty($row['client_name']) || empty($row['amount'])) {
                        $errors[] = "Ligne ignorée: données incomplètes";
                        continue;
                    }

                    // Trouver le service et le type d'opération
                    $service = Service::where('name', 'like', '%' . $row['service'] . '%')->first();
                    if (!$service) {
                        $errors[] = "Service non trouvé: " . $row['service'];
                        continue;
                    }

                    $operationType = OperationType::where('service_id', $service->id)
                        ->where('name', 'like', '%' . $row['operation_type'] . '%')
                        ->first();
                    if (!$operationType) {
                        $errors[] = "Type d'opération non trouvé: " . $row['operation_type'];
                        continue;
                    }

                    // Créer la transaction historique
                    $transaction = Transaction::create([
                        'agency_id' => $agency->id,
                        'service_id' => $service->id,
                        'operation_type_id' => $operationType->id,
                        'user_id' => Auth::id(),
                        'transaction_date' => $row['transaction_date'] ?? now()->toDateString(),
                        'transaction_time' => $row['transaction_time'] ?? '00:00:00',
                        'transaction_number' => $row['transaction_number'] ?? $this->generateHistoricalNumber(),
                        'client_name' => $row['client_name'],
                        'client_phone' => $row['client_phone'] ?? null,
                        'client_id_number' => $row['client_id_number'] ?? null,
                        'amount' => $row['amount'],
                        'fees' => $row['fees'] ?? 0,
                        'total' => $row['amount'] + ($row['fees'] ?? 0),
                        'currency' => $row['currency'] ?? 'XOF',
                        'observations' => $row['observations'] ?? null,
                        'status' => 'validated',
                        'validated_by' => Auth::id(),
                        'validated_at' => $row['transaction_date'] ?? now(),
                        'is_historical' => true,
                    ]);

                    $importedCount++;

                } catch (\Exception $e) {
                    $errors[] = "Erreur lors de l'import: " . $e->getMessage();
                }
            }

            // Générer les clôtures de caisse historiques
            $this->generateHistoricalCashCloses($agency, $startDate, $endDate);

            DB::commit();

            return redirect()->route('admin.historical-import.index')
                ->with('success', "Import terminé avec succès. {$importedCount} transactions importées.")
                ->with('errors', $errors);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }

    /**
     * Parse le fichier d'import
     */
    private function parseImportFile($file)
    {
        // Pour l'instant, simuler la lecture d'un fichier
        // En production, utiliser Laravel Excel ou un autre package
        
        return [
            [
                'client_name' => 'Client Test 1',
                'client_phone' => '+226 70 00 00 00',
                'service' => 'Wizall Money',
                'operation_type' => 'Cash In',
                'amount' => 50000,
                'fees' => 2500,
                'currency' => 'XOF',
                'transaction_date' => '2024-01-15',
                'transaction_time' => '10:30:00',
                'transaction_number' => 'HIST-2024-001',
                'observations' => null,
            ],
            [
                'client_name' => 'Client Test 2',
                'client_phone' => '+226 70 00 00 01',
                'service' => 'Orange Money',
                'operation_type' => 'Dépôt',
                'amount' => 100000,
                'fees' => 5000,
                'currency' => 'XOF',
                'transaction_date' => '2024-01-15',
                'transaction_time' => '14:45:00',
                'transaction_number' => 'HIST-2024-002',
                'observations' => null,
            ],
        ];
    }

    /**
     * Génère un numéro de transaction historique
     */
    private function generateHistoricalNumber()
    {
        return 'HIST-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Génère les clôtures de caisse historiques
     */
    private function generateHistoricalCashCloses($agency, $startDate, $endDate)
    {
        $period = new \DatePeriod(
            new \DateTime($startDate),
            new \DateInterval('P1D'),
            new \DateTime($endDate . '+1 day')
        );

        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            
            // Récupérer les transactions historiques de cette date
            $transactions = Transaction::where('agency_id', $agency->id)
                ->whereDate('transaction_date', $dateStr)
                ->where('is_historical', true)
                ->get();

            if ($transactions->isEmpty()) {
                continue;
            }

            // Calculer les données de la clôture
            $data = $this->calculateHistoricalCashCloseData($transactions);

            // Créer la clôture historique
            CashClose::create([
                'agency_id' => $agency->id,
                'user_id' => Auth::id(),
                'close_date' => $dateStr,
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
                'status' => 'validated',
                'validated_by' => Auth::id(),
                'validated_at' => $dateStr,
                'observations' => 'Clôture générée automatiquement lors de l\'import historique',
                'is_historical' => true,
            ]);
        }
    }

    /**
     * Calcule les données de la clôture historique
     */
    private function calculateHistoricalCashCloseData($transactions)
    {
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

            if (in_array($operationName, ['cash in', 'dépôt'])) {
                $cashDeposits += $transaction->total;
                $accountPayments += $transaction->amount;
            } elseif (in_array($operationName, ['cash out', 'retrait'])) {
                $cashPayments += $transaction->amount;
                $accountDeposits += $transaction->amount;
            } elseif (in_array($operationName, ['envoi'])) {
                $cashDeposits += $transaction->total;
            } elseif (in_array($operationName, ['paiement'])) {
                $cashPayments += $transaction->amount;
            }
        }

        return [
            'account_initial_balance' => 0,
            'account_provisioning' => $accountProvisioning,
            'account_payments' => $accountPayments,
            'account_deposits' => $accountDeposits,
            'account_outputs' => $accountOutputs,
            'account_variance' => 0,
            'account_final_balance' => $accountProvisioning - $accountPayments + $accountDeposits - $accountOutputs,
            'cash_initial_balance' => 0,
            'cash_provisioning' => $cashProvisioning,
            'cash_deposits' => $cashDeposits,
            'cash_payments' => $cashPayments,
            'cash_outputs' => $cashOutputs,
            'cash_variance' => 0,
            'cash_final_balance' => $cashProvisioning + $cashDeposits - $cashPayments - $cashOutputs,
        ];
    }

    /**
     * Affiche l'index des imports historiques
     */
    public function index()
    {
        $historicalTransactions = Transaction::where('is_historical', true)
            ->orderBy('transaction_date', 'desc')
            ->paginate(50);

        $historicalCashCloses = CashClose::where('is_historical', true)
            ->orderBy('close_date', 'desc')
            ->paginate(50);

        return view('admin.historical-import.index', compact('historicalTransactions', 'historicalCashCloses'));
    }
}
