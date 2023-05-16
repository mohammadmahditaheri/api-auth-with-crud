<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Contracts\Repositories\ResetPasswordRepoInterface;
use Modules\Auth\Repositories\ResetPasswordRepo;

class ResetPasswordRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ResetPasswordRepoInterface::class,
            ResetPasswordRepo::class
        );
    }
}
