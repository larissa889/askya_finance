<?php

namespace App\Modules\Cashier\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Modules\Cashier\Repositories\CashierRepository;
use App\Services\AuditLogService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CashierService
{
    public function __construct(
        private readonly CashierRepository $repository,
        private readonly AuditLogService $auditLog,
    ) {}

    /**
     * Build the full dashboard payload for a cashier.
     */
    public function getDashboard(User $cashier): array
    {
        $stats  = $this->repository->getDashboardStats($cashier);
        $recent = $this->repository->getRecentTransactions($cashier);

        return [
            'cashier_name'             => $cashier->name,
            'cashier_agency'           => $cashier->agency?->name ?? 'N/A',
            'today_total_collected'    => $stats['today_total_collected'],
            'today_total_paid'         => $stats['today_total_paid'],
            'today_transactions_count' => $stats['today_transactions_count'],
            'recent_transactions'      => $recent->map(fn($t) => $this->formatTransaction($t)),
        ];
    }

    /**
     * Get paginated transactions list.
     */
    public function getTransactions(User $cashier, array $filters = []): LengthAwarePaginator
    {
        return $this->repository->getTransactions($cashier, $filters);
    }

    /**
     * Create a new transaction and log the event.
     */
    public function createTransaction(User $cashier, array $data): Transaction
    {
        $data['created_by'] = $cashier->id;
        $data['agency_id']  = $cashier->agency_id;

        $transaction = $this->repository->createTransaction($data);

        $this->auditLog->log(
            event: 'transaction.created',
            description: "Cashier {$cashier->name} created transaction {$transaction->reference}",
            payload: [
                'transaction_id' => $transaction->id,
                'reference'      => $transaction->reference,
                'amount'         => $transaction->amount,
                'service_type'   => $transaction->service_type,
            ],
            userId: $cashier->id,
        );

        return $transaction;
    }

    /**
     * Get a specific transaction, scoped to the cashier's agency.
     */
    public function getTransaction(int $id, User $cashier): ?Transaction
    {
        return $this->repository->findTransaction($id, $cashier);
    }

    /**
     * Search clients by name or phone.
     */
    public function searchClients(User $cashier, string $query): Collection
    {
        return $this->repository->searchClients($cashier, $query);
    }

    /**
     * Format a transaction for API output.
     */
    public function formatTransaction(Transaction $transaction): array
    {
        return [
            'id'               => $transaction->id,
            'reference'        => $transaction->reference,
            'client_name'      => $transaction->client_name,
            'phone_number'     => $transaction->phone_number,
            'service_type'     => $transaction->service_type,
            'transaction_type' => $transaction->transaction_type,
            'amount'           => $transaction->amount,
            'fees'             => $transaction->fees,
            'total'            => $transaction->total,
            'status'           => $transaction->status,
            'cashier'          => $transaction->cashier?->name,
            'created_at'       => $transaction->created_at?->toISOString(),
        ];
    }
}
