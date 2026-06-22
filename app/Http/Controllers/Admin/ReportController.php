<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\CashClose;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Affiche le tableau de bord des rapports
     */
    public function index(Request $request)
    {
        $period = $request->period ?? 'daily';
        $startDate = $request->start_date ?? now()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();
        $agencyId = $request->agency_id;

        // Calculer les statistiques selon la période
        $statistics = $this->calculateStatistics($period, $startDate, $endDate, $agencyId);
        
        // Données pour les graphiques
        $transactionsByPeriod = $this->getTransactionsByPeriod($period, $startDate, $endDate, $agencyId);
        $transactionsByStatus = $this->getTransactionsByStatus($period, $startDate, $endDate, $agencyId);
        $transactionsByService = $this->getTransactionsByService($period, $startDate, $endDate, $agencyId);
        
        $agencies = Agency::all();

        return view('admin.reports.index', compact(
            'statistics',
            'transactionsByPeriod',
            'transactionsByStatus',
            'transactionsByService',
            'agencies',
            'period',
            'startDate',
            'endDate',
            'agencyId'
        ));
    }

    /**
     * Génère un rapport détaillé
     */
    public function generate(Request $request)
    {
        $period = $request->period;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $agencyId = $request->agency_id;

        $reportData = $this->generateDetailedReport($period, $startDate, $endDate, $agencyId);

        return response()->json($reportData);
    }

    /**
     * Calcule les statistiques selon la période
     */
    private function calculateStatistics($period, $startDate, $endDate, $agencyId)
    {
        $query = Transaction::where('is_historical', false);

        if ($agencyId) {
            $query->where('agency_id', $agencyId);
        }

        switch ($period) {
            case 'daily':
                $query->whereDate('transaction_date', $startDate);
                break;
            case 'weekly':
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
                break;
            case 'monthly':
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)))
                      ->whereMonth('transaction_date', date('m', strtotime($startDate)));
                break;
            case 'yearly':
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)));
                break;
            default:
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $transactions = $query->get();

        return [
            'total_transactions' => $transactions->count(),
            'total_amount' => $transactions->sum('amount'),
            'total_fees' => $transactions->sum('fees'),
            'total_revenue' => $transactions->sum('total'),
            'validated_transactions' => $transactions->where('status', 'validated')->count(),
            'pending_transactions' => $transactions->where('status', 'pending')->count(),
            'rejected_transactions' => $transactions->where('status', 'rejected')->count(),
        ];
    }

    /**
     * Récupère les transactions par période
     */
    private function getTransactionsByPeriod($period, $startDate, $endDate, $agencyId)
    {
        $query = Transaction::where('is_historical', false);

        if ($agencyId) {
            $query->where('agency_id', $agencyId);
        }

        switch ($period) {
            case 'daily':
                // Transactions par heure
                $query->whereDate('transaction_date', $startDate)
                      ->selectRaw('HOUR(transaction_time) as period, COUNT(*) as count, SUM(amount) as amount')
                      ->groupBy('period')
                      ->orderBy('period');
                break;
            case 'weekly':
                // Transactions par jour
                $query->whereBetween('transaction_date', [$startDate, $endDate])
                      ->selectRaw('DATE(transaction_date) as period, COUNT(*) as count, SUM(amount) as amount')
                      ->groupBy('period')
                      ->orderBy('period');
                break;
            case 'monthly':
                // Transactions par jour du mois
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)))
                      ->whereMonth('transaction_date', date('m', strtotime($startDate)))
                      ->selectRaw('DAY(transaction_date) as period, COUNT(*) as count, SUM(amount) as amount')
                      ->groupBy('period')
                      ->orderBy('period');
                break;
            case 'yearly':
                // Transactions par mois
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)))
                      ->selectRaw('MONTH(transaction_date) as period, COUNT(*) as count, SUM(amount) as amount')
                      ->groupBy('period')
                      ->orderBy('period');
                break;
            default:
                $query->whereBetween('transaction_date', [$startDate, $endDate])
                      ->selectRaw('DATE(transaction_date) as period, COUNT(*) as count, SUM(amount) as amount')
                      ->groupBy('period')
                      ->orderBy('period');
        }

        return $query->get();
    }

    /**
     * Récupère les transactions par statut
     */
    private function getTransactionsByStatus($period, $startDate, $endDate, $agencyId)
    {
        $query = Transaction::where('is_historical', false);

        if ($agencyId) {
            $query->where('agency_id', $agencyId);
        }

        switch ($period) {
            case 'daily':
                $query->whereDate('transaction_date', $startDate);
                break;
            case 'weekly':
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
                break;
            case 'monthly':
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)))
                      ->whereMonth('transaction_date', date('m', strtotime($startDate)));
                break;
            case 'yearly':
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)));
                break;
            default:
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        return $query->selectRaw('status, COUNT(*) as count, SUM(amount) as amount')
                    ->groupBy('status')
                    ->get();
    }

    /**
     * Récupère les transactions par service
     */
    private function getTransactionsByService($period, $startDate, $endDate, $agencyId)
    {
        $query = Transaction::with('service')->where('is_historical', false);

        if ($agencyId) {
            $query->where('agency_id', $agencyId);
        }

        switch ($period) {
            case 'daily':
                $query->whereDate('transaction_date', $startDate);
                break;
            case 'weekly':
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
                break;
            case 'monthly':
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)))
                      ->whereMonth('transaction_date', date('m', strtotime($startDate)));
                break;
            case 'yearly':
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)));
                break;
            default:
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        return $query->selectRaw('service_id, COUNT(*) as count, SUM(amount) as amount')
                    ->groupBy('service_id')
                    ->get();
    }

    /**
     * Génère un rapport détaillé
     */
    private function generateDetailedReport($period, $startDate, $endDate, $agencyId)
    {
        $query = Transaction::with(['agency', 'service', 'operationType', 'user'])
                           ->where('is_historical', false);

        if ($agencyId) {
            $query->where('agency_id', $agencyId);
        }

        switch ($period) {
            case 'daily':
                $query->whereDate('transaction_date', $startDate);
                break;
            case 'weekly':
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
                break;
            case 'monthly':
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)))
                      ->whereMonth('transaction_date', date('m', strtotime($startDate)));
                break;
            case 'yearly':
                $query->whereYear('transaction_date', date('Y', strtotime($startDate)));
                break;
            default:
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
                             ->orderBy('transaction_time', 'desc')
                             ->get();

        return [
            'transactions' => $transactions,
            'statistics' => $this->calculateStatistics($period, $startDate, $endDate, $agencyId),
            'period' => $period,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    /**
     * Exporte le rapport en PDF
     */
    public function exportPdf(Request $request)
    {
        $period = $request->period;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $agencyId = $request->agency_id;

        $reportData = $this->generateDetailedReport($period, $startDate, $endDate, $agencyId);

        // Pour l'instant, retourner une vue HTML qui peut être convertie en PDF
        // En production, utiliser dompdf ou un autre package
        return view('admin.reports.pdf', compact('reportData', 'period', 'startDate', 'endDate'));
    }

    /**
     * Exporte le rapport en Excel
     */
    public function exportExcel(Request $request)
    {
        $period = $request->period;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $agencyId = $request->agency_id;

        $reportData = $this->generateDetailedReport($period, $startDate, $endDate, $agencyId);

        // Pour l'instant, retourner une vue HTML qui peut être convertie en Excel
        // En production, utiliser Laravel Excel ou un autre package
        return view('admin.reports.excel', compact('reportData', 'period', 'startDate', 'endDate'));
    }
}
