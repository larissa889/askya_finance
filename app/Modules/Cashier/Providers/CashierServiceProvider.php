<?php

namespace App\Modules\Cashier\Providers;

use App\Modules\Cashier\Repositories\CashierRepository;
use App\Modules\Cashier\Services\CashierService;
use App\Services\AuditLogService;
use Illuminate\Support\ServiceProvider;

class CashierServiceProvider extends ServiceProvider
{
    /**
     * Register the module's services and repositories.
     */
    public function register(): void
    {
        // Repository is a concrete class — bind it as singleton for performance
        $this->app->singleton(CashierRepository::class);

        // Service depends on repository + audit log — inject automatically
        $this->app->singleton(CashierService::class, function ($app) {
            return new CashierService(
                $app->make(CashierRepository::class),
                $app->make(AuditLogService::class),
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
