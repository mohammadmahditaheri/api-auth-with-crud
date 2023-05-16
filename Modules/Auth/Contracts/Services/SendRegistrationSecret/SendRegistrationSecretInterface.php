<?php

namespace Modules\Auth\Contracts\Services\SendRegistrationSecret;

interface SendRegistrationSecretInterface
{
    public function send(string $email, string $code): bool;
}
