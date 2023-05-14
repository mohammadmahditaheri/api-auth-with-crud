<?php

namespace Modules\Auth\Contracts\Services\MailSecret;

interface SendMailStrategyInterface
{
    public function send(string $email, string $code): bool;
}
