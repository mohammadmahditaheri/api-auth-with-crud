<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Actions\MailHandler;
use Modules\Auth\Contracts\Services\MailSecretHandler\MailHandlerInterface;

class MailHandlerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            MailHandlerInterface::class,
            MailHandler::class
        );
    }
}
