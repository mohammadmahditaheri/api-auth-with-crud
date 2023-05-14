<?php

namespace Modules\Auth\Services\MailSecret\Strategies;

use Exception;
use Modules\Auth\Contracts\Services\MailSecret\SendMailStrategyInterface;

class ConcreteSendMailStrategy implements SendMailStrategyInterface
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
