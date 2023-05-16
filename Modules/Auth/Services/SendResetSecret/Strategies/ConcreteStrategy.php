<?php

namespace Modules\Auth\Services\SendResetSecret\Strategies;

use Modules\Auth\Contracts\Services\SendResetSecret\SendResetSecretStrategyInterface;

class ConcreteStrategy implements SendResetSecretStrategyInterface
{
    /**
     * @inheritDoc
     */
    public function send(string $email, string $code): bool
    {
        try {
            // TODO: implement concrete send mail here

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
