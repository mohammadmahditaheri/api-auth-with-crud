<?php

namespace Modules\Auth\Contracts\Services\SendResetSecret;

interface SendResetSecretStrategyInterface
{
    /**
     * send reset secret code to user's email
     *
     * @param string $email
     * @param string $code
     * @return bool
     */
    public function send(string $email, string $code): bool;
}
