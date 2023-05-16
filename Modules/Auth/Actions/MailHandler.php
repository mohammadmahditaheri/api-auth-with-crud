<?php

namespace Modules\Auth\Actions;

use Modules\Auth\Contracts\Actions\MailHandlerInterface;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Models\User;
use Modules\Auth\Services\SendRegistrationSecret\SendRegistrationSecretContext;
use Modules\Auth\Services\SendRegistrationSecret\Strategies\ConcreteStrategy;

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

    private function makeMailContext(): SendRegistrationSecretContext
    {
        return match (config('mail.default')) {
            // different strategies
            default => new SendRegistrationSecretContext(new ConcreteStrategy())
        };
    }

    private function initSecret(): void
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
