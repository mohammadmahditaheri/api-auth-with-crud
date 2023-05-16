<?php

namespace Modules\Auth\Services\SendResetSecret;

use Modules\Auth\Contracts\Services\SendResetSecret\SendResetSecretStrategyInterface;

class SendResetSecretContext
{
    public function __construct(private SendResetSecretStrategyInterface $strategy)
    {
    }

    /**
     * Do send the secret code to user via email
     */
    public function send(string $email, string $code): bool
    {
        return $this->strategy->send($email, $code);
    }
}
