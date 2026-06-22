<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $modulesRoutePath = base_path('routes/modules');

        if (File::isDirectory($modulesRoutePath)) {
            $files = File::files($modulesRoutePath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'php') {
                    Route::middleware('api')
                        ->prefix('api')
                        ->group($file->getPathname());
                }
            }
        }
    }
}
