<?php

namespace Modules\Auth\Actions;

use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Contracts\Services\MailSecretHandler\MailHandlerInterface;
use Modules\Auth\Models\User;
use Modules\Auth\Services\MailSecret\SendMailContext;
use Modules\Auth\Services\MailSecret\Strategies\ConcreteSendMailStrategy;

class MailHandler implements MailHandlerInterface
{
    private string|null $secret = null;

    public function __construct(private UserRepositoryInterface $repository)
    {
        $this->initSecret();
    }

    public function handle(User $user): bool
    {
        // add secret code to database
        $this->repository->addSecret($this->secret(), $user);

        // concrete context
        $context = $this->makeMailContext();

        // send email
        return $context->send($user->email, $this->secret());
    }

    private function makeMailContext(): SendMailContext
    {
        return match (config('mail.default')) {
            // different strategies
            default => new SendMailContext(new ConcreteSendMailStrategy())
        };
    }

    public function initSecret(): void
    {
        $minimum = 100000;
        $maximum = 999999;

        $this->secret = rand($minimum, $maximum);
    }

    /**
     * @inheritDoc
     */
    public function secret(): string
    {
        if ($this->secret === null) {
            $this->initSecret();
        }

        return $this->secret;
    }
}