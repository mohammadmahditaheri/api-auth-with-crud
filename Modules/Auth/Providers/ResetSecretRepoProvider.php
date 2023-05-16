<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Contracts\Repositories\ResetSecretRepositoryInterface;
use Modules\Auth\Repositories\ResetSecretRepository;

class ResetSecretRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ResetSecretRepositoryInterface::class,
            ResetSecretRepository::class
        );
    }
}
