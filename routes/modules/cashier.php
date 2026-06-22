<?php

use App\Modules\Cashier\Controllers\CashierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Cashier Module Routes
|--------------------------------------------------------------------------
| All routes here are automatically loaded by RouteServiceProvider
| under the `api` middleware group and `/api` prefix.
|
| Full URLs:
|   GET  /api/cashier/dashboard
|   GET  /api/cashier/transactions
|   POST /api/cashier/transactions
|   GET  /api/cashier/transactions/{id}
|   GET  /api/cashier/clients/search
|
| Protected by: auth:sanctum + role:caissier
|--------------------------------------------------------------------------
*/

Route::prefix('cashier')
    ->middleware(['auth:sanctum', 'role:caissier'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [CashierController::class, 'dashboard'])
            ->name('cashier.dashboard');

        // Transactions
        Route::get('/transactions', [CashierController::class, 'index'])
            ->name('cashier.transactions.index');

        Route::post('/transactions', [CashierController::class, 'store'])
            ->name('cashier.transactions.store');

        Route::get('/transactions/{id}', [CashierController::class, 'show'])
            ->name('cashier.transactions.show')
            ->where('id', '[0-9]+');

        // Client search
        Route::get('/clients/search', [CashierController::class, 'searchClients'])
            ->name('cashier.clients.search');
    });
