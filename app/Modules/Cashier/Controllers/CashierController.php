<?php

namespace App\Modules\Cashier\Controllers;

use App\Modules\Cashier\Requests\StoreTransactionRequest;
use App\Modules\Cashier\Services\CashierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CashierController extends Controller
{
    public function __construct(
        private readonly CashierService $service,
    ) {}

    /**
     * GET /api/cashier/dashboard
     * Returns the cashier's personal dashboard summary.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $data = $this->service->getDashboard($request->user());

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * GET /api/cashier/transactions
     * Paginated list of transactions for the cashier's agency.
     * Supports filters: status, transaction_type, service_type, search, date_from, date_to
     */
    public function index(Request $request): JsonResponse
    {
        $filters      = $request->only([
            'status', 'transaction_type', 'service_type',
            'search', 'date_from', 'date_to',
        ]);
        $transactions = $this->service->getTransactions($request->user(), $filters);

        return response()->json([
            'success' => true,
            'data'    => $transactions->items(),
            'meta'    => [
                'current_page' => $transactions->currentPage(),
                'last_page'    => $transactions->lastPage(),
                'per_page'     => $transactions->perPage(),
                'total'        => $transactions->total(),
            ],
        ]);
    }

    /**
     * POST /api/cashier/transactions
     * Create a new transaction.
     */
    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = $this->service->createTransaction(
            $request->user(),
            $request->validated(),
        );

        return response()->json([
            'success' => true,
            'message' => 'Transaction créée avec succès.',
            'data'    => $this->service->formatTransaction($transaction),
        ], 201);
    }

    /**
     * GET /api/cashier/transactions/{id}
     * Show a single transaction (agency-scoped).
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $transaction = $this->service->getTransaction($id, $request->user());

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction introuvable.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->service->formatTransaction($transaction),
        ]);
    }

    /**
     * GET /api/cashier/clients/search?q=...
     * Search clients by name or phone number (within agency history).
     */
    public function searchClients(Request $request): JsonResponse
    {
        $query = $request->string('q')->trim()->toString();

        if (strlen($query) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'La recherche doit contenir au moins 2 caractères.',
            ], 422);
        }

        $clients = $this->service->searchClients($request->user(), $query);

        return response()->json([
            'success' => true,
            'data'    => $clients,
        ]);
    }
}
