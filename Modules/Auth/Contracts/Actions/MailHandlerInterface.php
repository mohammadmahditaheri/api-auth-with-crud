<?php

namespace Modules\Auth\Contracts\Actions;

use Modules\Auth\Models\User;

interface MailHandlerInterface
{
    /**
     * @param User $user
     * @return bool
     */
    public function handle(User $user): bool;

    /**
     * the secret key
     */
    public function secret(): string;
}
