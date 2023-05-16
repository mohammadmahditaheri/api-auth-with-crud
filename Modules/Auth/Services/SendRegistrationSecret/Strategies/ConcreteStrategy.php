<?php

namespace Modules\Auth\Services\SendRegistrationSecret\Strategies;

use Exception;
use Modules\Auth\Contracts\Services\SendRegistrationSecret\SendRegistrationSecretInterface;

class ConcreteStrategy implements SendRegistrationSecretInterface
{
    public function send(string $email, string $code): bool
    {
        try {
            // TODO: implement concrete send mail here

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
