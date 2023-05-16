<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Actions\SendResetSecretHandler;
use Modules\Auth\Contracts\Actions\SendResetSecretHandlerInterface;

class SendResetSecretHandlerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            SendResetSecretHandlerInterface::class,
            SendResetSecretHandler::class
        );
    }
}
