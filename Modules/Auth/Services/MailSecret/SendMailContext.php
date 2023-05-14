<?php

namespace Modules\Auth\Services\MailSecret;

use Modules\Auth\Contracts\Services\MailSecret\SendMailStrategyInterface;

class SendMailContext
{
    public function __construct(private SendMailStrategyInterface $strategy)
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
