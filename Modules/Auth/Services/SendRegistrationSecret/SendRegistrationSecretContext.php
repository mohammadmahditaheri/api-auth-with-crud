<?php

namespace Modules\Auth\Services\SendRegistrationSecret;

use Modules\Auth\Contracts\Services\SendRegistrationSecret\SendRegistrationSecretInterface;

class SendRegistrationSecretContext
{
    public function __construct(private SendRegistrationSecretInterface $strategy)
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
