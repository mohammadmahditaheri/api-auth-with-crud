<?php

namespace Modules\Auth\Actions;

use JetBrains\PhpStorm\ArrayShape;
use Modules\Auth\Contracts\Actions\SendResetSecretHandlerInterface;
use Modules\Auth\Contracts\Repositories\ResetPasswordRepoInterface;
use Modules\Auth\Services\SendResetSecret\SendResetSecretContext;
use Modules\Auth\Services\SendResetSecret\Strategies\ConcreteStrategy;

class SendResetSecretHandler implements SendResetSecretHandlerInterface
{
    private string|null $secret = null;
    const RESET_SECRET_EXPIRES_AFTER_IN_MINUTES = 20;

    public function __construct(private ResetPasswordRepoInterface $resetSecretRepository)
    {
        $this->initSecret();
    }

    private function initSecret(): void
    {
        $minimum = 100000000;
        $maximum = 999999999;

        $this->secret = rand($minimum, $maximum);
    }

    /**
     * hydrate the concrete context for action
     *
     * @return SendResetSecretContext
     */
    private function context(): SendResetSecretContext
    {
        return match (config('auth.reset_notifier_strategy')) {
            // TODO: add more concrete strategies
            default => new SendResetSecretContext(new ConcreteStrategy())
        };
    }

    /**
     * main method
     *
     * @inheritDoc
     */
    public function handle(string $email): bool
    {
        // create reset secret model in database
        $this->resetSecretRepository->create(
            $this->assembleFields($email)
        );

        // concrete context
        $context = $this->context();

        // send email
        return $context->send($email, $this->secret());
    }

    #[ArrayShape(['email' => "string", 'secret' => "string", 'secret_expires_at' => "\Illuminate\Support\Carbon"])]
    private function assembleFields(string $email): array
    {
        return [
            'email' => $email,
            'secret' => $this->secret(),
            'secret_expires_at' => now()->addMinutes(self::RESET_SECRET_EXPIRES_AFTER_IN_MINUTES),
        ];
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
