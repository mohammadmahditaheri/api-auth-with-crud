<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected string $modulePath = 'Modules/Auth/';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(UserRepositoryProvider::class);
        $this->app->register(MailHandlerProvider::class);
        $this->app->register(ResetSecretRepoProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(base_path($this->modulePath . 'Database/Migrations'));
    }
}
