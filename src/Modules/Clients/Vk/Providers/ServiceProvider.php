<?php

namespace Modules\Clients\Vk\Providers;

use Illuminate\Support\ServiceProvider as AppServiceProvider;

class ServiceProvider extends AppServiceProvider
{
    protected string $moduleName = 'Vk';
    protected string $moduleNameLower = 'vk';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
