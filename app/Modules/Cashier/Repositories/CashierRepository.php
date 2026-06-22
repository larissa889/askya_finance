<?php

namespace App\Modules\Cashier\Repositories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CashierRepository
{
    /**
     * Get today's summary stats for a cashier's agency.
     */
    public function getDashboardStats(User $cashier): array
    {
        $agencyId  = $cashier->agency_id;
        $todayDate = now()->toDateString();

        $baseQuery = Transaction::where('agency_id', $agencyId)
            ->whereDate('created_at', $todayDate);

        $totalCollected = (clone $baseQuery)
            ->where('transaction_type', 'receive')
            ->where('status', 'completed')
            ->sum('amount');

        $totalPaid = (clone $baseQuery)
            ->where('transaction_type', 'send')
            ->where('status', 'completed')
            ->sum('amount');

        $transactionsCount = (clone $baseQuery)->count();

        return [
            'today_total_collected'    => (float) $totalCollected,
            'today_total_paid'         => (float) $totalPaid,
            'today_transactions_count' => $transactionsCount,
        ];
    }

    /**
     * Get the last 10 transactions for the cashier's agency.
     */
    public function getRecentTransactions(User $cashier): Collection
    {
        return Transaction::with(['cashier:id,name'])
            ->where('agency_id', $cashier->agency_id)
            ->latest()
            ->limit(10)
            ->get();
    }

    /**
     * Get paginated transactions for the cashier's agency, with optional filters.
     */
    public function getTransactions(User $cashier, array $filters = []): LengthAwarePaginator
    {
        $query = Transaction::with(['cashier:id,name'])
            ->where('agency_id', $cashier->agency_id)
            ->latest();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['transaction_type'])) {
            $query->where('transaction_type', $filters['transaction_type']);
        }

        if (!empty($filters['service_type'])) {
            $query->where('service_type', $filters['service_type']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->paginate(20);
    }

    /**
     * Find a transaction by ID, scoped to the cashier's agency.
     */
    public function findTransaction(int $id, User $cashier): ?Transaction
    {
        return Transaction::with(['cashier:id,name', 'agency:id,name,code'])
            ->where('agency_id', $cashier->agency_id)
            ->find($id);
    }

    /**
     * Create a new transaction.
     */
    public function createTransaction(array $data): Transaction
    {
        return Transaction::create($data);
    }

    /**
     * Search clients by name or phone within the cashier's agency history.
     */
    public function searchClients(User $cashier, string $query): Collection
    {
        return Transaction::where('agency_id', $cashier->agency_id)
            ->where(function ($q) use ($query) {
                $q->where('client_name', 'like', "%{$query}%")
                  ->orWhere('phone_number', 'like', "%{$query}%");
            })
            ->select('client_name', 'phone_number')
            ->distinct()
            ->limit(20)
            ->get();
    }
}
