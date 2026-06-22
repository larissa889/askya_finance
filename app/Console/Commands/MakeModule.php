<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name : The name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module directory structure with routing and provider templates';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name      = ucfirst($this->argument('name'));
        $lowerName = strtolower($name);
        $modulePath = app_path("Modules/{$name}");

        if (File::isDirectory($modulePath)) {
            $this->error("Module {$name} already exists!");
            return 1;
        }

        // 1. Create directory structure
        $directories = [
            $modulePath,
            "{$modulePath}/Controllers",
            "{$modulePath}/Models",
            "{$modulePath}/Requests",
            "{$modulePath}/Services",
            "{$modulePath}/Routes",
            "{$modulePath}/Repositories",
            "{$modulePath}/Providers",
        ];

        foreach ($directories as $dir) {
            File::makeDirectory($dir, 0755, true, true);
        }

        // 2. Create Module ServiceProvider
        $providerContent = <<<PROVIDER
<?php

namespace App\Modules\\{$name}\Providers;

use Illuminate\Support\ServiceProvider;

class {$name}ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind repositories or services here
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
PROVIDER;

        File::put("{$modulePath}/Providers/{$name}ServiceProvider.php", $providerContent);

        // 3. Create Module Routes file
        $routeContent = <<<ROUTE
<?php

use Illuminate\Support\Facades\Route;

// Define {$name} module routes here

ROUTE;

        File::put("{$modulePath}/Routes/api.php", $routeContent);

        // 4. Create the routes/modules/ bridge file
        $bridgeDir = base_path('routes/modules');
        if (!File::isDirectory($bridgeDir)) {
            File::makeDirectory($bridgeDir, 0755, true);
        }

        $bridgeContent = <<<BRIDGE
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('{$lowerName}')->group(function () {
    require base_path('app/Modules/{$name}/Routes/api.php');
});

BRIDGE;

        File::put("{$bridgeDir}/{$lowerName}.php", $bridgeContent);

        // 5. Add .gitkeep to empty directories so they are tracked by Git
        $emptyDirs = ['Controllers', 'Models', 'Requests', 'Services', 'Repositories'];
        foreach ($emptyDirs as $subDir) {
            File::put("{$modulePath}/{$subDir}/.gitkeep", '');
        }

        $this->info("✓ Module [{$name}] created successfully at app/Modules/{$name}/");
        $this->line("  → Service Provider : app/Modules/{$name}/Providers/{$name}ServiceProvider.php");
        $this->line("  → Routes File      : app/Modules/{$name}/Routes/api.php");
        $this->line("  → Bridge Route     : routes/modules/{$lowerName}.php");

        return 0;
    }
}
