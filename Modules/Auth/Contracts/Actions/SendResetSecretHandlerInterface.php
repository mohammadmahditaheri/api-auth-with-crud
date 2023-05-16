<?php

namespace Modules\Auth\Contracts\Actions;

use Modules\Auth\Models\User;

interface SendResetSecretHandlerInterface
{
    /**
     * @param string $email
     * @return bool
     */
    public function handle(string $email): bool;

    /**
     * the secret key
     */
    public function secret(): string;
}
