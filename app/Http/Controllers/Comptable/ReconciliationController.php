<?php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Bank;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReconciliationController extends Controller
{
    public function index()
    {
        $banks = Bank::active()->get();
        return view('comptable.reconciliation.index', compact('banks'));
    }

    public function reconcile(Request $request)
    {
        $request->validate([
            'bank_id' => ['required', 'exists:banks,id'],
            'statement_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $bank = Bank::findOrFail($request->bank_id);
        $file = $request->file('statement_file');
        
        // Open file and read lines
        $handle = fopen($file->getRealPath(), 'r');
        if (!$handle) {
            return redirect()->back()->with('error', 'Impossible de lire le fichier de relevé.');
        }

        // Headers expected: date, reference, description, amount, type (credit/debit)
        $header = fgetcsv($handle, 1000, ',');
        $csvRecords = [];
        
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($data) >= 4) {
                // Map headers to fields
                $csvRecords[] = [
                    'date' => trim($data[0] ?? ''),
                    'reference' => trim($data[1] ?? ''),
                    'description' => trim($data[2] ?? ''),
                    'amount' => (float) str_replace([' ', ','], '', $data[3] ?? '0'),
                    'type' => strtolower(trim($data[4] ?? 'credit')),
                ];
            }
        }
        fclose($handle);

        $results = [];
        $matchedTxIds = [];
        $discrepancyCount = 0;
        $matchedCount = 0;

        foreach ($csvRecords as $record) {
            // Find transaction matching by reference
            $tx = Transaction::where('reference', $record['reference'])->first();
            
            if ($tx) {
                $matchedTxIds[] = $tx->id;
                $diff = abs((float)$tx->amount - $record['amount']);
                
                if ($diff < 0.01) {
                    $status = 'matched';
                    $matchedCount++;
                } else {
                    $status = 'discrepancy';
                    $discrepancyCount++;
                }

                $results[] = [
                    'bank_record' => $record,
                    'db_record' => [
                        'reference' => $tx->reference,
                        'client' => $tx->client_name,
                        'amount' => $tx->amount,
                        'date' => $tx->transaction_date ? $tx->transaction_date->format('Y-m-d') : $tx->created_at->format('Y-m-d'),
                    ],
                    'status' => $status,
                    'notes' => $status === 'discrepancy' ? "Écart de montant: Relevé (" . number_format($record['amount'], 0) . ") vs Syst. (" . number_format($tx->amount, 0) . ")" : "Correspondance exacte.",
                ];
            } else {
                // Try matching by amount and date (within a 2 day window)
                $dateObj = null;
                try {
                    $dateObj = Carbon::parse($record['date']);
                } catch (\Exception $e) {}

                $query = Transaction::where('amount', $record['amount']);
                if ($dateObj) {
                    $query->whereBetween('created_at', [$dateObj->copy()->subDays(2), $dateObj->copy()->addDays(2)]);
                }
                
                $fuzzyTx = $query->first();

                if ($fuzzyTx) {
                    $matchedTxIds[] = $fuzzyTx->id;
                    $results[] = [
                        'bank_record' => $record,
                        'db_record' => [
                            'reference' => $fuzzyTx->reference,
                            'client' => $fuzzyTx->client_name,
                            'amount' => $fuzzyTx->amount,
                            'date' => $fuzzyTx->created_at->format('Y-m-d'),
                        ],
                        'status' => 'partial_matched',
                        'notes' => "Correspondance approximative par montant et date. Réf. Syst: " . $fuzzyTx->reference,
                    ];
                    $matchedCount++;
                } else {
                    $results[] = [
                        'bank_record' => $record,
                        'db_record' => null,
                        'status' => 'missing_in_db',
                        'notes' => "Opération non trouvée dans le système Askya.",
                    ];
                    $discrepancyCount++;
                }
            }
        }

        // Find system transactions not in the statement
        $unmatchedSystemTxs = Transaction::whereNotIn('id', $matchedTxIds)
            ->where('status', 'reconciled')
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();

        return view('comptable.reconciliation.results', compact('bank', 'results', 'unmatchedSystemTxs', 'matchedCount', 'discrepancyCount'));
    }
}
